<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use Milo\Github\Api;
use Milo\Github\OAuth\Token;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property integer $user_like
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'user_like'], 'integer'],
        ];
    }

    /**
     * @param string $username
     *
     * @return array
     * @throws \Milo\Github\ApiException
     * @throws \Milo\Github\MissingParameterException
     */
    public function getUserInfo($username)
    {
        $api   = new Api;
        $token = new Token(Yii::$app->params['github_token']);
        $api->setToken($token);

        $userRawInfo = $api->get('/users/:username', ['username' => $username]);
        $userInfo    = (array)$api->decode($userRawInfo);

        return ['userInfo' => $userInfo];
    }

    /**
     * @param $users
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getLikes($users)
    {
        $userIds = [];
        foreach ($users as $userItem) {
            $userItemArray = (array)$userItem;
            $userIds[]     = $userItemArray['id'];
        }
        return User::find()
            ->select(['user_id', 'user_like'])
            ->where(['user_id' => $userIds])
            ->asArray()
            ->all();
    }

    /**
     * @param int $userId GitHub user ID
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public static function likeUser($userId)
    {
        $user = User::findOne(['user_id' => $userId]);
        if ($user === null) {
            $user          = new User();
            $user->user_id = $userId;
        }
        $icon = '<span class="glyphicon glyphicon-thumbs-up" style="font-size: 36px;" aria-hidden="true"></span>';
        if ($user->user_like === 0 || $user->user_like === null) {
            $user->user_like = 1;
            $icon            = '<span class="glyphicon glyphicon-thumbs-down" style="font-size: 36px;" aria-hidden="true"></span>';
        } else {
            $user->user_like = 0;
        }
        $user->save();
        return Html::a($icon, Url::to(['like/user', 'id' => $userId,]));
    }
}