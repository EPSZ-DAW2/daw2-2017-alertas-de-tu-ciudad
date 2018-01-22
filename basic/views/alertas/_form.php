<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alerta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_inicio')->textInput() ?>

    <?= $form->field($model, 'duracion_estimada')->textInput() ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'notas_lugar')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'area_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'imagen_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagen_revisada')->textInput() ?>

    <?= $form->field($model, 'categoria_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activada')->textInput() ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <?= $form->field($model, 'terminada')->textInput() ?>

    <?= $form->field($model, 'fecha_terminacion')->textInput() ?>

    <?= $form->field($model, 'notas_terminacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'num_denuncias')->textInput() ?>

    <?= $form->field($model, 'fecha_denuncia1')->textInput() ?>

    <?= $form->field($model, 'bloqueada')->textInput() ?>

    <?= $form->field($model, 'bloqueo_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bloqueo_fecha')->textInput() ?>

    <?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'crea_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crea_fecha')->textInput() ?>

    <?= $form->field($model, 'modi_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modi_fecha')->textInput() ?>

    <?= $form->field($model, 'notas_admin')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
