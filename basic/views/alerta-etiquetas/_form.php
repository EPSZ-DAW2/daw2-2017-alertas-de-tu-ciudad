<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaEtiquetas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-etiquetas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'etiqueta_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
