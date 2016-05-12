<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = 'Search';
$this->params['breadcrumbs'][] = $this->title;

/**
 * @var string $message
 * @var array $search
 * @var array $likes
 * @var string $icon
 */
?>

<div class="row">
    <div class="col-md-12">
        <h3><?= $message ?></h3>
        <?php
        foreach ($search as $searchItem) {
            $repoItem  = (array)$searchItem;
            $repoOwner = (array)$repoItem['owner'];
            ?>
            <div>
                <div class="col-md-12 well">
                    <div class="row">
                        <div class="col-md-4"><h4><?php
                                echo Html::a(
                                    $repoItem['name'],
                                    Url::to(
                                        [
                                            'repo/view',
                                            'owner'    => $repoOwner['login'],
                                            'repoName' => $repoItem['name'],
                                        ]
                                    )
                                );
                                ?></h4></div>
                        <div class="col-md-4"><?= $repoItem['homepage'] ?></div>
                        <div class="col-md-4"><?= $repoOwner['login'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><?= $repoItem['description'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">watchers: <?= $repoItem['watchers'] ?></div>
                        <div class="col-md-4">forks: <?= $repoItem['forks'] ?></div>
                        <div class="col-md-4">
                            <?php
                            $icon = '<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>';

                            foreach ($likes as $repoLike) {
                                if (
                                    ((int)$repoLike['repo_like'] === 1)
                                    && (int)$repoLike['repo_id'] === $repoItem['id']
                                ) {
                                    $icon = '<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>';
                                }
                            }

                            $link = Html::a($icon,
                                Url::to(['like/repo', 'id' => $repoItem['id'],])
                            );
                            echo \Yii::$app->view->renderFile(
                                '@app/views/like/response.php',
                                [
                                    'id'   => 'repo_' . $repoItem['id'],
                                    'link' => $link,
                                ]
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
