<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Alerta */

$this->title = 'Bloquear Alerta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->terminada]];
$this->params['breadcrumbs'][] = 'Bloquear';
?>
<div class="alerta-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	 <?= Html::a('Volver', ['index'], ['class' => 'btn btn-primary']);?>

	
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			'bloqueada',
		   ],
    ]) ?>
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'bloqueada')->checkBox() ?>
	<?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6]) ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Confirmar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	 <?php ActiveForm::end(); ?>


   

</div>

