<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\Repo;
use app\models\User;

/**
 * Class LikeController
 * @package app\controllers
 */
class LikeController extends Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionRepo($id)
    {
        $link = Repo::likeRepo($id);
        return $this->render('response', ['id' => 'repo_'.$id, 'link' => $link]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionUser($id)
    {
        $link = User::likeUser($id);
        return $this->render('response', ['id' => 'user_'.$id, 'link' => $link]);
    }
}
