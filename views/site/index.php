<?php

use app\widgets\HistoryList\HistoryList;
use app\models\search\HistorySearch;
use yii\web\Request;

$this->title = 'Americor Test site';
$request = \Yii::$app->request;

?>

<div class="site-index">
    <?= HistoryList::widget(['model' => new HistorySearch(), 'request' => $request]) ?>
</div>