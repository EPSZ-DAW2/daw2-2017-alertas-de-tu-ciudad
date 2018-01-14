<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-incidencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'crea_fecha')->textInput() ?>

    <?= $form->field($model, 'clase_incidencia_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'destino_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'origen_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comentario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_lectura')->textInput() ?>

    <?= $form->field($model, 'fecha_borrado')->textInput() ?>

    <?= $form->field($model, 'fecha_aceptado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
