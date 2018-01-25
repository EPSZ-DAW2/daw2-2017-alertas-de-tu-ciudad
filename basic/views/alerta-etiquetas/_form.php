<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\AlertaEtiquetas;
use app\models\Alerta;
use app\models\Etiquetas;
use app\models\AlertaEtiquetasSearch;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaEtiquetas */
/* @var $form yii\widgets\ActiveForm */

$alertas = Alerta::find()->all();
$etiquetas = Etiquetas::find()->all();

$alertalista=ArrayHelper::map($alertas,'id','titulo');

$etiquetalista=ArrayHelper::map($etiquetas,'id','nombre');
?>

<div class="categorias-etiquetas-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'alerta_id')->textInput() ?>

    <?= $form->field($model, 'etiqueta_id')->textInput() ?> -->

    <?= $form->field($model, 'alerta_id')->dropdownList(
			$alertalista,
	    	['prompt'=>'Selecciona una alerta']);
	?>

   	<?= $form->field($model, 'etiqueta_id')->dropdownList(
		$etiquetalista,
	    	['prompt'=>'Selecciona una etiqueta']);
	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Actualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
