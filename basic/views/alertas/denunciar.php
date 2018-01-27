<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Alerta */

$this->title = 'Denunciar Alerta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->terminada]];
$this->params['breadcrumbs'][] = 'Denunciar';
?>
<div class="alerta-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	 <?= Html::a('Volver', ['index'], ['class' => 'btn btn-primary']);?>

	
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			'fecha_denuncia1',
			'num_denuncias',
			'bloqueada',
		   ],
    ]) ?>
	<?php $form = ActiveForm::begin(); ?>
	
	
	<div class="form-group">
		<?php //Enlace para hacer la denuncia?>
		  <?= Html::a(Yii::t('app', 'Confirmar'), ['usuario-incidencias/createdenuncia', 'id'=>$model->id, 'tipo'=>"alerta"], ['class' => 'btn btn-success'])?>
    </div>
	 <?php ActiveForm::end(); ?>


   

</div>

