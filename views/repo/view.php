<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var array $repoData
 * @var array $userLikes
 */
?>

<div class="row">
    <div class="col-md-6">
        <div><h1><?= $repoData['repoInfo']['full_name'] ?></h1></div>
        <div><p>Description: <?= $repoData['repoInfo']['description'] ?></p></div>
        <div>
            watchers: <?= $repoData['repoInfo']['watchers'] ?><br/>
            forks: <?= $repoData['repoInfo']['forks'] ?><br/>
            open issues: <?= $repoData['repoInfo']['open_issues'] ?><br/>
            homepage: <?php
            echo Html::a(
                $repoData['repoInfo']['homepage'],
                Url::to($repoData['repoInfo']['homepage'])
            ); ?>
            <br/>
            GitHub repo: <?php
            echo Html::a(
                $repoData['repoInfo']['html_url'],
                Url::to($repoData['repoInfo']['html_url'])
            ); ?>
            <br/>
            created at: <?= $repoData['repoInfo']['created_at'] ?>
        </div>
    </div>

    <div class="col-md-6">
        <div><h1>Contributors:</h1></div>
        <div>
            <?php
            foreach ($repoData['userInfo'] as $key => $value) {
                ?>
                <div class="row well well-lg">
                    <div class="col-md-6">
                            <?php
                            $userDetails = (array)$value;
                            echo Html::a(
                                $userDetails['login'],
                                Url::to(['repo/user', 'username' => $userDetails['login']])
                            );
                            ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        $icon = '<span class="glyphicon glyphicon-thumbs-up" style="font-size: 36px;" aria-hidden="true"></span>';

                        foreach ($userLikes as $userLike) {
                            if (
                                ((int)$userLike['user_like'] === 1)
                                && (int)$userLike['user_id'] === $userDetails['id']
                            ) {
                                $icon = '<span class="glyphicon glyphicon-thumbs-down" style="font-size: 36px;" aria-hidden="true"></span>';
                            }
                        }

                        $link = Html::a($icon,
                            Url::to(['like/user', 'id' => $userDetails['id'],])
                        );
                        echo \Yii::$app->view->renderFile(
                            '@app/views/like/response.php',
                            [
                                'id'   => 'user_' . $userDetails['id'],
                                'link' => $link,
                            ]
                        );
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
