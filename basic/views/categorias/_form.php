<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\jui\Sortable ;
use app\models\Categorias;
use app\controllers\CategoriasController;
use yii\base\Model;


/* @var $this yii\web\View */
/* @var $model app\models\Categorias */
/* @var $form yii\widgets\ActiveForm */
	
	//Guarda todos los nombres e id de las categorias
  	$nombres=array();
  	$ids=array();
  	foreach ( $dataProvider->getModels() as $key => $value) {
  	 	array_push($nombres, $value['nombre']);
  	 	array_push($ids,$value['id']);
  	}
  	//Combina los id y los nombres en un array asociativo [id=>nombre]
  	$comb=array_combine($ids, $nombres);
?>

<div class="categorias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
       
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <!-- <?= $form->field($model, 'categoria_id')->widget(AutoComplete::classname(), [
    		'clientOptions' => [
        		'source' => $nombres,
    		],
		]) ?> --> 

	<?= $form->field($model,'categoria_id')->dropdownList(
			$comb,
	    	['prompt'=>'Selecciona una categoria padre']
		);
	?>  


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
