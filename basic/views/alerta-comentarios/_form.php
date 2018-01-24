<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-comentarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crea_usuario_id')->textInput(['maxlength' => true]) ?>
    <!--DatePicker para facilitar la intro de datos a el usuario-->
    <?= $form->field($model, 'crea_fecha')->widget(\yii\jui\DatePicker::className(), [
        'language' => 'es',
        'dateFormat' => 'dd-MM-yyyy',
    ]) ?>

    <?= $form->field($model, 'modi_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modi_fecha')->widget(\yii\jui\DatePicker::className(), [
        'language' => 'es',
        'dateFormat' => 'dd-MM-yyyy',
    ]) ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comentario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cerrado')->radioList([
        0 => 'Abierto',
        1 => 'Cerrado',
    ]); ?>

    <?= $form->field($model, 'num_denuncias')->textInput() ?>

    <?= $form->field($model, 'fecha_denuncia1')->textInput() ?>

    <?= $form->field($model, 'bloqueado')->radioList([
        0 => 'Abierto',
        1 => 'Cerrado',
    ]); ?>

    <?= $form->field($model, 'bloqueo_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bloqueo_fecha')->textInput() ?>

    <?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
