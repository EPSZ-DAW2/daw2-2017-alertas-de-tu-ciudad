<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-imagen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orden')->textInput() ?>

    <?= $form->field($model, 'imagen_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagen_revisada')->textInput() ?>

    <?= $form->field($model, 'crea_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crea_fecha')->textInput() ?>

    <?= $form->field($model, 'modi_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modi_fecha')->textInput() ?>

    <?= $form->field($model, 'notas_admin')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
