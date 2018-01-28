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
    <!--Fecha última modificación del comentario-->
    <?=$form->field($model, 'modi_fecha')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Introduce la hora y la fecha ...'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);?>
    <!--Texto del comentario-->
    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

    <!--El hilo de ese comentario estará abierto en caso de que sea 0 y cerrado en caso de que sea 1-->
    <?= $form->field($model, 'cerrado')->radioList([
        0 => 'Abierto',
        1 => 'Cerrado',
    ]); ?>
    <!--Número de denuncias para cada comentario-->
    <?= $form->field($model, 'num_denuncias')->textInput(['type'=>'number','min'=>0, 'maxlength' => true]) ?>
    <!--fecha de la primera denuncia-->
    <?=$form->field($model, 'fecha_denuncia1')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Introduce la hora y la fecha ...'],
        'pluginOptions' => [
            'autoclose' => true,
        ]
    ]);?>
    <!--El hilo de ese comentario estará desbloqueado en caso de que sea 0 y bloqueado en caso de que sea 1-->
    <?= $form->field($model, 'bloqueado')->radioList([
        0 => 'Desbloqueado',
        1 => 'Bloqueado',
    ]); ?>
    <!--Id del usuario que ha relizado el bloqueo-->
    <?= $form->field($model, 'bloqueo_usuario_id')->textInput(['maxlength' => true]) ?>
    <!--Fecha del bloqueo de comentario-->
    <?=$form->field($model, 'bloqueo_fecha')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Introduce la hora y la fecha ...'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);?>
    <!--Motivo por el cual se ha relaizado el bloqueo de un comentario-->
    <?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
