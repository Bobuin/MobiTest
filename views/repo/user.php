<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var array $userData
 * @var array $likes
 */
?>
<div class="row well">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12"><?= Html::img(
                    $userData['avatar_url'],
                    [
                        'id'     => 'avatar',
                        'alt'    => $userData['login'],
                        'height' => '200',
                        'width'  => '200',
                    ]
                ); ?></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <br/>
                <!-- Like button -->
                <?php
                $icon = '<span class="glyphicon glyphicon-thumbs-up" style="font-size: 36px;" aria-hidden="true"></span>';

                if (
                    ((int)$likes['user_like'] === 1)
                    && (int)$likes['user_id'] === $userData['id']
                ) {
                    $icon = '<span class="glyphicon glyphicon-thumbs-down" style="font-size: 36px;" aria-hidden="true"></span>';
                }

                $link = Html::a($icon, Url::to(['like/user', 'id' => $userData['id'],]));
                echo \Yii::$app->view->renderFile(
                    '@app/views/like/response.php',
                    [
                        'id'   => 'user_' . $userData['id'],
                        'link' => $link,
                    ]
                );
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <h1><?= $userData['name'] ?></h1>
        <p><?= $userData['login'] ?></p>
        <p>Company: <?= $userData['company'] ?></p>
        <p>Blog: <?= Html::a($userData['blog'], Url::to($userData['blog'])); ?></p>
        <p>Followers: <?= $userData['followers'] ?></p>
    </div>
</div>
