<?php

use yii\bootstrap5\Html;
?>
<div class="card mb-3">
  <div class="card-header">
    Заявка: <?=  $model->id ?> от <?= Yii::$app->formatter->asDatetime($model -> created_id, 'php:d.m.Y H:i:s'); ?>
  </div>
  <div class="card-body">
        <div>
            <span class="fw-bold">Дата начала обучения: </span> <?= Yii::$app->formatter->asDate($model -> date_start, 'php:d.m.y'); ?>
        </div>
        <div>
            <span class="fw-bold">Наименование курса: </span> <?= $model->course->title ?>
        </div>
        <div>
            <span class="fw-bold">Способ оплаты: </span> <?= $model->payType->title ?>
        </div>
        <div>
            <span class="fw-bold">Статус заявки: </span> <?= $model->status->title ?>
        </div>
  </div>
  <div class="d-flex gap-3 m-3">
    <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-primary']); ?>
    <?= $model->status->alias === 'finaly' && !$model?->feedback 
        ? Html::a('Отзыв', ['feedback', 'id' => $model->id], ['class' => 'btn btn-outline-warning'])
        : ''
    ?>
  </div>
</div>