<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Alerta */

/*Vista de la ficha de una alerta para usuarios registrados*/

$this->title = Yii::t('app','Alerta '. $model->id);
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>	
		<?php 			
		
        echo Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        echo Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);
		echo Html::a('Finalizar', ['finalizar', 'id' => $model->id], ['class' => 'btn btn-primary']); 
		echo Html::a(Yii::t('app', 'Añadir etiqueta a la alerta'), ['alerta-etiquetas/create'], ['class' => 'btn btn-success']);
		echo Html::a('Denunciar', ['denunciar', 'id' => $model->id], ['class' => 'btn btn-danger']);
	
		?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titulo:ntext',
            'descripcion:ntext',
            'fecha_inicio',
            'duracion_estimada',
            'direccion:ntext',
            'notas_lugar:ntext',
            'area_id',
            'detalles:ntext',
            'notas:ntext',
            'url:ntext',
            'imagen_id',
            'categoria_id',
			'terminada',
            'bloqueada',
            'imagen_revisada',
            'activada',
            'visible',
            'fecha_terminacion',
            'notas_terminacion:ntext',
            'num_denuncias',
            'fecha_denuncia1',
            'bloqueo_usuario_id',
            'bloqueo_fecha',
            'bloqueo_notas:ntext',
            'crea_usuario_id',
            'crea_fecha',
            'modi_usuario_id',
            'modi_fecha',
            'notas_admin:ntext',
			
			
        ],
    ]) ?>
	
	<div>
	<?php
		
	//echo Html::a('Comentarios', ['finalizar', 'id' => $model->id], ['class' => 'btn btn-primary']);

	?>
	</div>

</div>
