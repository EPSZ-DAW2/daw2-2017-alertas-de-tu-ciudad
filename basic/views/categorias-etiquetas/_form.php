<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categorias;
use app\models\CategoriasEtiquetas;
use app\models\Etiquetas;
use app\models\EtiquetasSearch;
use app\models\CategoriasSearch;
use app\models\CategoriasEtiquetasSearch;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorias-etiquetas-form">

	<?php $modelCat = new Categorias();
		  $modelEti = new CategoriasEtiquetas();
	?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoria_id')->dropdownList(
			CategoriasSearch::arbolCategoriasArray(),
	    	['prompt'=>'Selecciona una categoria']);
	?>

   <?= $form->field($model, 'etiqueta_id')->dropdownList(
		CategoriasEtiquetasSearch::arbolEtiquetasArray(),
	    	['prompt'=>'Selecciona una etiqueta']);
	?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>