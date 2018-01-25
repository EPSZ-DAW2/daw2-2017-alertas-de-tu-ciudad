<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;




/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-comentarios-form col-md-6 col-md-offset-3">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id')->textInput(['type'=>'number','min'=>0, 'maxlength' => true,'readOnly'=>true]) ?>
    <!--El id de comentario será minimo 0 cuando es un comentario raiz-->
    <?= $form->field($model, 'comentario_id')->textInput(['type'=>'number','min'=>0, 'maxlength' => true]) ?>
    <!-- El id de la alerta será minimo 1-->
    <?= $form->field($model, 'alerta_id')->textInput(['type'=>'number','min'=>1, 'maxlength' => true]) ?>
    <!-- El id de crea usuario será minimo 1-->
    <?= $form->field($model, 'crea_usuario_id')->textInput(['type'=>'number','min'=>1, 'maxlength' => true]) ?>
    <!-- El id del usuario que modifica será 1-->
    <?= $form->field($model, 'modi_usuario_id')->textInput(['type'=>'number','min'=>1, 'maxlength' => true]) ?>

    <!--DateTimePicker para facilitar al usuario la introduccion de la fecha -->
    <?=$form->field($model, 'crea_fecha')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Introduce la hora y la fecha ...'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);?>

    <?=$form->field($model, 'modi_fecha')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Introduce la hora y la fecha ...'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'cerrado')->radioList([
        0 => 'Abierto',
        1 => 'Cerrado',
    ]); ?>

    <?= $form->field($model, 'num_denuncias')->textInput(['type'=>'number','min'=>0, 'maxlength' => true]) ?>

    <?=$form->field($model, 'fecha_denuncia1')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Introduce la hora y la fecha ...'],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]);?>

    <?= $form->field($model, 'bloqueado')->radioList([
        0 => 'Desbloqueado',
        1 => 'Bloqueado',
    ]); ?>

    <?= $form->field($model, 'bloqueo_usuario_id')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'bloqueo_fecha')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Introduce la hora y la fecha ...'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);?>

    <?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
