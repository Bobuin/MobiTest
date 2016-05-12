<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;
use Milo\Github\Api;
use Milo\Github\OAuth\Token;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "repo".
 *
 * @property integer $repo_id
 * @property integer $repo_like
 */
class Repo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repo_id'], 'required'],
            [['repo_id', 'repo_like'], 'integer'],
        ];
    }

    /**
     * @param string $owner
     * @param string $repo
     *
     * @return array
     * @throws \Milo\Github\MissingParameterException
     * @throws \Milo\Github\ApiException
     */
    public function getRepoInfo($owner, $repo)
    {
        $api   = new Api;
        $token = new Token(Yii::$app->params['github_token']);
        $api->setToken($token);

        $repoRawInfo = $api->get('/repos/:owner/:repo',
            [
                'owner' => $owner,
                'repo'  => $repo,
            ]
        );
        $repoInfo    = (array)$api->decode($repoRawInfo);

        $userRawInfo = $api->get('/repos/:owner/:repo/contributors',
            [
                'owner' => $owner,
                'repo'  => $repo,
            ]
        );
        $userInfo    = (array)$api->decode($userRawInfo);

        return [
            'repoInfo' => $repoInfo,
            'userInfo' => $userInfo,
        ];
    }

    /**
     * @param array $repos
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getLikes($repos)
    {
        $repoIds = [];
        foreach ($repos as $repoItem) {
            $repoIds[] = $repoItem->id;
        }
        return Repo::find()
            ->select(['repo_id', 'repo_like'])
            ->where(['repo_id' => $repoIds])
            ->asArray()
            ->all();
    }

    /**
     * @param string $search GitHub repository name to search
     *
     * @return mixed
     * @throws \Milo\Github\ApiException
     * @throws \Milo\Github\MissingParameterException
     */
    public function searchRepo($search)
    {
        $api          = new Api;
        $searchResult = $api->get('/search/repositories?q='
            . str_replace(' ', '+', $search), []);

        $searchResult = (array)$api->decode($searchResult);
        return $searchResult['items'];
    }

    /**
     * @param int $repoId GitHub repository ID
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public static function likeRepo($repoId)
    {
        $repo = Repo::findOne(['repo_id' => $repoId]);
        if ($repo === null) {
            $repo          = new Repo();
            $repo->repo_id = $repoId;
        }
        $icon = '<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>';
        if ($repo->repo_like === 0 || $repo->repo_like === null) {
            $repo->repo_like = 1;
            $icon            = '<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>';
        } else {
            $repo->repo_like = 0;
        }
        $repo->save();
        return Html::a($icon, Url::to(['like/repo', 'id' => $repoId,]));
    }
}
