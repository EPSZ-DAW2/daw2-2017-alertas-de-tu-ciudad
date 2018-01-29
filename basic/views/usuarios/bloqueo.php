<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Bloquear Usuario: ' . $model->nick;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Bloquear';
?>
<div class="alerta-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	 <?= Html::a('Volver', ['index'], ['class' => 'btn btn-primary']);?>

	
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			'bloqueado',
		   ],
    ]) ?>
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6]) ?>
	
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Confirmar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	 <?php ActiveForm::end(); ?>


   

</div>