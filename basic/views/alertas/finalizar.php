<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Alerta */

$this->title = 'Finalizar Alerta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->terminada]];
$this->params['breadcrumbs'][] = 'Finalizar';
?>
<div class="alerta-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	 <?= Html::a('Volver', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);?>

	
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			'terminada',
		   ],
    ]) ?>
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'terminada')->checkBox() ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Confirmar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	 <?php ActiveForm::end(); ?>


   

</div>

