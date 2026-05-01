<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Application $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="application-form">

    <?php $form = ActiveForm::begin(); ?>
        <p>
            <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-primary']) ?>
        </p>

    
        <?= $form->field($model, 'comment')->textarea(['rows' => 5]) 
        ?>
   



        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-outline-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
