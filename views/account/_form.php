<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Application $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="application-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="w-50">
        <?= $form->field($model, 'date_start')->textInput(['type' => 'date']) ?>
    
        <?= $form->field($model, 'course_id')->dropDownList($courses, ['prompt' => 'Выберете курс']) ?>

        <?= $form->field($model, 'pay_type_id')->dropDownList($payTypes, ['prompt' => 'Выберете способ оплаты']) ?>

        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-outline-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
