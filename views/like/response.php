<?php

use yii\widgets\Pjax;

/** @var string $link */
Pjax::begin(['id' => $id]);
echo $link;
Pjax::end();
