<?php
use app\models\Logs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'crea_fecha')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'clase_log_id')->dropDownList(Logs::getListaClases())->label("seleccione un tipo de log para filtrar"); ?>

    <?= $form->field($model, 'modulo')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'texto')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Filtrar', ['class' => 'btn btn-primary']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
