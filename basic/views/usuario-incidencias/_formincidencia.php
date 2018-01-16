<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-incidencia-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($model, 'crea_fecha')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'clase_incidencia_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'destino_usuario_id')->hiddenInput()->label(false);?>

    <?= $form->field($model, 'origen_usuario_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'alerta_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'comentario_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'fecha_lectura')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'fecha_borrado')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'fecha_aceptado')->hiddenInput()->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
