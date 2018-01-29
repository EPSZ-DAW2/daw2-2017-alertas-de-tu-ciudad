<?php

use yii\helpers\Html;
use yii\base\Model;
use app\controllers\CategoriasController;
use yii\jui\AutoComplete;
use app\models\Categorias;
use app\models\CategoriasSearch;
use yii\jui\Sortable ;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model app\models\Categorias */
/* @var $form yii\widgets\ActiveForm */
	
	
?>

<div class="categorias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
       
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])?>

  	<?= $form->field($model,'categoria_id')->dropdownList(
        CategoriasSearch::arbolCategoriasArray(),
	    	['prompt'=>'Selecciona una categoria padre']
		  );
    ?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
