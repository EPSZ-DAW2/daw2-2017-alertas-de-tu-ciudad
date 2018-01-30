<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Usuarios;
/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencia */

/*Asignamos la id de cada usuario a las variables idUsuarioDestino y idUsuarioOrigen*/
$idUsuarioDestino = $model->destino_usuario_id;
$idUsuarioOrigen = $model->origen_usuario_id;

/*Usuario registrado*/
$yo = Yii::$app->user->identity->id;

/*Roles*/
$rol = Usuarios::findOne($yo)['rol'];

/*Asignamos el valor del campo 'email' de la tabla Usuarios a las diferentes variables*/
$emailOrigen = Usuarios::findOne($idUsuarioOrigen)['email'];
$emailDestino = Usuarios::findOne($idUsuarioDestino)['email'];

/*Se asocia el tipo de incidencia al nombre completo de esta*/
$tipo = $model->getClases();
$tipoIncidencia = $model->clase_incidencia_id;

/*Migas de pan*/
$this->title = $tipo[$tipoIncidencia];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuario Incidencias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $tipo[$tipoIncidencia];


?>
<div class="usuario-incidencia-view">

    <h1><?= $tipo[$tipoIncidencia] ?></h1>


    <?php
	if($rol=='A' || $rol=='M'){
		echo DetailView::widget([
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
	}else{
		echo DetailView::widget([
			'model' => $model,
			'attributes' => [
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
			],
		
		]);
	}
	
	if($model->clase_incidencia_id == 'C' && $idUsuarioDestino==$yo){
		echo Html::a(Yii::t('app', 'Responder Consulta'), ['createmensaje', 'id' => $model->origen_usuario_id], ['class' => 'btn btn-success']);
	}
	?>

	<?php
	if($model->destino_usuario_id == Yii::$app->user->identity->id ){
		echo Html::a(Yii::t('app', 'Marcar como no leida'), ['view', 'id' => $model->id, 'noleida' => true], ['class' => 'btn btn-success']);
	}
	?> 

</div>
