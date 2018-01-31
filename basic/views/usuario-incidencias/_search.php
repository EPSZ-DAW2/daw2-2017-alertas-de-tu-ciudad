<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidenciaSearch */
/* @var $form yii\widgets\ActiveForm */
/*
$busqueda = Yii::$app->request->get('UsuarioIncidenciaSearch');

$claseIncidencia = $busqueda['clase_incidencia_id'];

$primeraLetra = substr($claseIncidencia, 0, 1); //Obtener la primera letra

echo $primeraLetra;
	
$model->clase_incidencia_id = $primeraLetra;
*/

?>

<div class="usuario-incidencia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'crea_fecha')->hiddenInput()->label(false);?>
	
    <?= $form->field($model, 'clase_incidencia_id');	?>

	<?php /* Html::textInput($model, 'clase_incidencia_id'); */?>

    <?= $form->field($model, 'texto')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'destino_usuario_id')->hiddenInput()->label(false); ?>

    <?php // echo $form->field($model, 'origen_usuario_id') ?>

    <?php // echo $form->field($model, 'alerta_id') ?>

    <?php // echo $form->field($model, 'comentario_id') ?>

    <?php // echo $form->field($model, 'fecha_lectura') ?>

    <?php // echo $form->field($model, 'fecha_borrado') ?>

    <?php // echo $form->field($model, 'fecha_aceptado') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']); ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
