<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;




/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-comentarios-form">
    <?php $form = ActiveForm::begin(['action' =>['alerta-comentarios/comentar'], 'method' => 'post',]);
    ?>
    <?= $form->field($model, 'texto')->textArea(['rows'=>'5'])->label('Nuevo Comentario') ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Comentar!'), ['class' =>  'btn btn-success btn-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
