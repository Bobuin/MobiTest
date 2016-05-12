<?php

namespace app\controllers;

use app\models\User;
use yii;
use yii\web\Controller;
use app\models\Repo;

/**
 * Class RepoController
 * @package app\controllers
 */
class RepoController extends Controller
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
     * @param string $owner
     * @param string $repoName
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \Milo\Github\ApiException
     * @throws \Milo\Github\MissingParameterException
     */
    public function actionView($owner = 'yiisoft', $repoName = 'yii')
    {
        $repoModel = new Repo();
        $repoData  = $repoModel->getRepoInfo($owner, $repoName);

        $userModel = new User();
        $userLikes = $userModel->getLikes($repoData['userInfo']);

        return $this->render('view',
            [
                'repoData'  => $repoData,
                'userLikes' => $userLikes,
            ]
        );
    }

    /**
     * @param string $username
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \Milo\Github\ApiException
     * @throws \Milo\Github\MissingParameterException
     */
    public function actionUser($username)
    {
        $userModel = new User();
        $userData  = $userModel->getUserInfo($username);
        $userLikes = $userModel->getLikes($userData);
        return $this->render(
            'user',
            [
                'userData' => $userData['userInfo'],
                'likes'    => reset($userLikes),
            ]
        );
    }

    /**
     * @return string
     *
     * @throws \yii\base\InvalidParamException
     * @throws \Milo\Github\MissingParameterException
     * @throws \Milo\Github\ApiException
     */
    public function actionSearch()
    {
        $search  = Yii::$app->request->post('search');
        $message = 'Search string is empty!';
        if ($search) {
            $message = 'Results for search term: ' . $search;
        }
        $repo       = new Repo();
        $repoSearch = $repo->searchRepo($search);
        $repoLikes  = $repo->getLikes($repoSearch);
        return $this->render(
            'search',
            [
                'message' => $message,
                'search'  => $repoSearch,
                'likes'   => $repoLikes,
            ]
        );
    }
}
