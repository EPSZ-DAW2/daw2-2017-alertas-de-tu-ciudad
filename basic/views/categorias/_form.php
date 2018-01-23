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
	
	//Guarda todos los nombres e id de las categorias
  	$nombres=array();
  	$ids=array();
  	foreach ( $dataProvider->getModels() as $key => $value) {
  	 	array_push($nombres,$value['nombre']);
  	 	array_push($ids,$value['id']);
  	}
  	//Combina los id y los nombres en un array asociativo [id=>nombre]
  	$comb=array_combine($ids, $nombres);
?>

<div class="categorias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
       
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6])?>
<!-- ,'vafieldfi=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' -->
    <!-- <?= $form->field($model, 'categoria_id')->widget(AutoComplete::classname(), [
    		'clientOptions' => [
        		'source' => $nombres,
    		],
		]) ?> -->

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
