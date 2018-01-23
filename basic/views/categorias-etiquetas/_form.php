<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CategoriasSearch;
use app\models\CategoriasEtiquetasSearch;


/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorias-etiquetas-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'categoria_id')->textInput() ?>

    <?= $form->field($model, 'etiqueta_id')->textInput() ?> -->

    <?= $form->field($model, 'categoria_id')->dropdownList(
			CategoriasSearch::arbolCategoriasArray(),
	    	['prompt'=>'Selecciona una categoria']);
	?>

   	<?= $form->field($model, 'etiqueta_id')->dropdownList(
		CategoriasEtiquetasSearch::arbolEtiquetasArray(),
	    	['prompt'=>'Selecciona una etiqueta']);
	

	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
