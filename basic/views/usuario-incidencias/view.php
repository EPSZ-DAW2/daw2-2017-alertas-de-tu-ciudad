<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Usuarios;
/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencia */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuario Incidencias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/*Asignamos la id de cada usuario a las variables idUsuarioDestino y idUsuarioOrigen*/
$idUsuarioDestino = $model->destino_usuario_id;
$idUsuarioOrigen = $model->origen_usuario_id;

/*Asignamos el valor del campo 'email' de la tabla Usuarios a las diferentes variables*/
$emailOrigen = Usuarios::findOne($idUsuarioOrigen)['email'];
$emailDestino = Usuarios::findOne($idUsuarioDestino)['email'];

/*Se asocia el tipo de incidencia al nombre completo de esta*/
$tipo = $model->getClases();
$tipoIncidencia = $model->clase_incidencia_id;


?>
<div class="usuario-incidencia-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'crea_fecha',
            [
				'label' => 'Tipo de Incidencia',
				'value' => $tipo[$tipoIncidencia],
			],
            'texto:ntext',
            [
				'label' => 'Usuario Destino',
				'value' => $emailDestino,			
			],
            [
				'label' => 'Usuario Origen',
				'value' => $emailOrigen,
			],
            'alerta_id',
            'comentario_id',
            'fecha_lectura',
            'fecha_borrado',
            'fecha_aceptado',
        ],
	
    ]);
	
	if($model->clase_incidencia_id == 'C'){
		echo Html::a(Yii::t('app', 'Responder Consulta'), ['createmensaje', 'id' => $model->origen_usuario_id], ['class' => 'btn btn-success']);
	}
	?>

	<?php
	if($model->destino_usuario_id == Yii::$app->user->identity->id ){
		echo Html::a(Yii::t('app', 'Marcar como no leida'), ['view', 'id' => $model->id, 'noleida' => true], ['class' => 'btn btn-success']);
	}
	?> 

</div>
