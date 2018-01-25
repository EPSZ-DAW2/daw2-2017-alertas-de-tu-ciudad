<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;




/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-comentarios-form col-md-10 col-md-offset-1">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id')->textInput(['type'=>'hidden'])->label('')  ?>
    <!--El id de comentario será minimo 0 cuando es un comentario raiz-->
    <!-- <?= $form->field($model, 'comentario_id')->textInput(['type'=>'hidden'])->label('') ?>
    <!-- El id de la alerta será minimo 1-->
    <?= $form->field($model, 'alerta_id')->textInput(['type'=>'hidden'])->label('') ?>
    <!-- El id de crea usuario será minimo 1-->
    <?= $form->field($model, 'crea_usuario_id')->textInput(['type'=>'hidden'])->label('') ?>
    <!-- El id del usuario que modifica será 1-->
    <?= $form->field($model, 'modi_usuario_id')->textInput(['type'=>'hidden'])->label('') ?>

    <!--DateTimePicker para facilitar al usuario la introduccion de la fecha -->
    <?= $form->field($model, 'crea_fecha')->textInput(['type' => 'hidden'])->label('') ?>

    <?=$form->field($model, 'modi_fecha')->textInput(['type' => 'hidden'])->label('') ?>

    <?= $form->field($model, 'texto')->textArea([])->label('Nuevo Comentario') ?>


    <?= $form->field($model, 'cerrado')->textInput(['type' => 'hidden'])->label('') ?>

    <?= $form->field($model, 'num_denuncias')->textInput(['type'=>'hidden'])->label('') ?>

    <?= $form->field($model, 'fecha_denuncia1')->textInput(['type'=>'hidden'])->label('') ?>


    <?= $form->field($model, 'bloqueado')->textInput(['type'=>'hidden'])->label('') ?>

    <?= $form->field($model, 'bloqueo_usuario_id')->textInput([ 'type'=>'hidden'])->label('') ?>

    <?= $form->field($model, 'bloqueo_fecha')->textInput([ 'type'=>'hidden'])->label('') ?>

    <?= $form->field($model, 'bloqueo_notas')->textInput(['type'=>'hidden'])->label('') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
