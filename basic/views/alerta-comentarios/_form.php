<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="alerta-comentarios-form col-md-6 col-md-offset-3">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id')->textInput([
            'type'=>'text',
            'min'=>0,
            'maxlength' => true,
            'readOnly'=>true,
            'placeholder'=>'El id no es modificable']) ?>
    <!--El id de comentario será minimo 0 cuando es un comentario raiz-->
    <?= $form->field($model, 'comentario_id')->textInput([
            'type'=>'text',
            'min'=>0,
            'maxlength' => true
            , 'placeholder'=>'El id del padre no es modificable','readOnly'=>true]) ?>
    <!-- El id de la alerta será minimo 1-->
    <?php
        //Si es de creación entonces dejamos modificar la alerta si es de actualización no
        if(!empty($model->id)) $readOnlyAlertaId = true;
        else $readOnlyAlertaId = false;
    ?>
    <?= $form->field($model, 'alerta_id')->textInput(['type'=>'number',
        'min'=>1,
        'maxlength' => true,
        'readOnly' => $readOnlyAlertaId,

    ]) ?>


    <!--Texto del comentario-->
    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>
    <?php
        if($readOnlyAlertaId){
    ?>
        <!--El hilo de ese comentario estará abierto en caso de que sea 0 y cerrado en caso de que sea 1-->
        <?= $form->field($model, 'cerrado')->radioList([
            0 => 'Abierto',
            1 => 'Cerrado'
        ]); ?>


        <!--El hilo de ese comentario estará desbloqueado en caso de que sea 0 y bloqueado en caso de que sea 1-->
            <?= $form->field($model, 'bloqueado')->radioList([
                0 => 'Desbloqueado',
                1 => 'Bloqueado',

            ]); ?>
            <!--Motivo por el cual se ha relaizado el bloqueo de un comentario-->
            <?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6,

            ]) ?>
    <?php
        }
    ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
