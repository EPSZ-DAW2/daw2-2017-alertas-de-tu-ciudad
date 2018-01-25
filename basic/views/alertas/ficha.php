<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Alerta */

/*  FICHA PUBLICA DE ALERTA para usuarios sin registrar*/

$this->title = Yii::t('app','Alerta '. $model->id);
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-view">

    <h1><?= Html::encode($this->title) ?></h1>
	
	 <?= Html::a('Volver', ['index'], ['class' => 'btn btn-primary']);?>

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
            //'url:ntext',
            'imagen_id',
            //'imagen_revisada',
            'categoria_id',
            //'activada',
           // 'visible',
            //'terminada',
            //'fecha_terminacion',
            //'notas_terminacion:ntext',
            //'num_denuncias',
            //'fecha_denuncia1',
            //'bloqueada',
            //'bloqueo_usuario_id',
            //'bloqueo_fecha',
            //'bloqueo_notas:ntext',
            //'crea_usuario_id',
            //'crea_fecha',
            //'modi_usuario_id',
            //'modi_fecha',
            //'notas_admin:ntext',
        ],
    ]) ?>

</div>
<div>
	<div>
	 <h3>Apartado para comentarios:</h3>
    </div>
    <div>
        <textarea  rows="10" name="comment" id="comment" placeholder="Comentarios" ></textarea>
    
	 <h3>Apartado para imagenes:</h3>
   
    <div>
        <textarea  rows="10" name="comment" id="comment" placeholder="Imagenes" ></textarea>
    </div>
  
</div>