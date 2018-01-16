<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencia */
/* @var $form yii\widgets\ActiveForm */
$deshabilitado=true;
if(Yii::$app->user->identity->id == $model->origen_usuario_id){
	$deshabilitado=false;
}
$destinatario = (Yii::$app->user->identity->id == $model->destino_usuario_id);
?>

<div class="usuario-incidencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'crea_fecha')->textInput(['disabled'=>true])->label('Fecha de creación') ?>

    <?= $form->field($model, 'clase_incidencia_id')->dropDownList($model->getClases(),['disabled'=>true]) ?>
	
    <?= $form->field($model, 'texto')->textarea(['rows' => 6,'disabled'=>$deshabilitado]) ?>

    <?= $form->field($model, 'destino_usuario_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'origen_usuario_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'comentario_id')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'fecha_lectura')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'fecha_borrado')->textInput(['disabled'=>true]) ?>
	<?php if($destinatario){
		echo Html::checkbox('borrar', ($model->fecha_borrado!=null), ['label' => 'Marcar para borrarla, desmarcar para recuperarla']) ;
	}
	 if($model->fecha_aceptado==null && $model->fecha_borrado==null){
		echo Html::checkbox('aceptar', false, ['label' => 'Acepto la gestión de la incidencia']) ;
	}else{
		echo $form->field($model, 'fecha_aceptado')->textInput(['disabled'=>true]);} ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Modificar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
