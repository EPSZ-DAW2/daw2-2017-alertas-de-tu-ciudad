<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Area;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
$areas = Area::find()->all();
$areaslista=ArrayHelper::map($areas,'id','nombre');
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nick')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_nacimiento')->widget(\yii\jui\DatePicker::className(),['language'=>'es', 'dateFormat'=>'yyyy-MM-dd']) ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'area_id')->dropdownList(
			$areaslista,
	    	['prompt'=>'Selecciona un area']); ?>

    <?= $form->field($model, 'rol')->dropdownList(['N'=>'Normal', 'M'=>'Moderador', 'A'=>'Administrador'
		],['prompt'=>'Seleccione una opción...'])?>

    <?= $form->field($model, 'confirmado')->dropdownList([0=>'No confirmado', 1=>'Confirmado'],['prompt'=>'Seleccione una opción...'])?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
