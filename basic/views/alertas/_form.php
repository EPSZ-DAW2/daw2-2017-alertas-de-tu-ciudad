<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\AlertaSearch;
use yii\helpers\ArrayHelper;
use app\models\Categorias;
use app\models\Area;


/* @var $this yii\web\View */
/* @var $model app\models\Alerta */
/* @var $form yii\widgets\ActiveForm */

$categorias = Categorias::find()->all();
$categoriaslista=ArrayHelper::map($categorias,'id','nombre');

$areas = Area::find()->all();
$areaslista=ArrayHelper::map($areas,'id','nombre', 'claseArea');

?>

<div class="alerta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'duracion_estimada')->textInput() ?>

    <?= $form->field($model, 'direccion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'notas_lugar')->textarea(['rows' => 6]) ?>

   <?= $form->field($model, 'area_id')->dropdownList(
			$areaslista,
	    	['prompt'=>'Selecciona un area']);
	?>

    <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'categoria_id')->dropdownList(
			$categoriaslista,
	    	['prompt'=>'Selecciona una categoria']);
	?>

    <?= $form->field($model, 'activada')->checkBox() ?>

    <?= $form->field($model, 'visible')->checkBox() ?>

    <?= $form->field($model, 'fecha_terminacion')->textInput() ?>

    <?= $form->field($model, 'notas_terminacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'notas_admin')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
