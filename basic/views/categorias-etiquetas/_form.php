<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
<<<<<<< HEAD
use app\models\CategoriasSearch;
use app\models\CategoriasEtiquetasSearch;

=======
use app\models\Categorias;
use app\models\CategoriasEtiquetas;
use app\models\Etiquetas;
use app\models\EtiquetasSearch;
use app\models\CategoriasSearch;
use app\models\CategoriasEtiquetasSearch;
>>>>>>> 3b9a4a2234f92815345eb7e44f30aac95b440f2b

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorias-etiquetas-form">

	<?php $modelCat = new Categorias();
		  $modelEti = new CategoriasEtiquetas();
	?>

    <?php $form = ActiveForm::begin(); ?>

<<<<<<< HEAD
    <!-- <?= $form->field($model, 'categoria_id')->textInput() ?>

    <?= $form->field($model, 'etiqueta_id')->textInput() ?> -->

=======
>>>>>>> 3b9a4a2234f92815345eb7e44f30aac95b440f2b
    <?= $form->field($model, 'categoria_id')->dropdownList(
			CategoriasSearch::arbolCategoriasArray(),
	    	['prompt'=>'Selecciona una categoria']);
	?>
<<<<<<< HEAD

   	<?= $form->field($model, 'etiqueta_id')->dropdownList(
		CategoriasEtiquetasSearch::arbolEtiquetasArray(),
	    	['prompt'=>'Selecciona una etiqueta']);
	

	?>
=======

   <?= $form->field($model, 'etiqueta_id')->dropdownList(
		CategoriasEtiquetasSearch::arbolEtiquetasArray(),
	    	['prompt'=>'Selecciona una etiqueta']);
	?> 
>>>>>>> 3b9a4a2234f92815345eb7e44f30aac95b440f2b

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
