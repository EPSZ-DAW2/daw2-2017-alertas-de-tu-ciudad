<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->nick;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['updateperfil', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Solicitar Baja', ['usuario-incidencias/solicitabaja'], [
            'class' => 'btn btn-danger',
            
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'email:email',
            'password',
            'nick',
            'nombre',
            'apellidos',
            'fecha_nacimiento',
            'direccion:ntext',
           /* 'area_id',
            'rol',
            'fecha_registro',
            'confirmado',
            'fecha_acceso',
            'num_accesos',
            'bloqueado',
            'bloqueo_usuario_id',
            'bloqueo_fecha',
            'bloqueo_notas:ntext',*/
        ],
    ]) ?>
	<p>
		<?= Html::a(Yii::t('app', 'Crear una incidencia'), ['usuario-incidencias/createconsulta'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Ver mis incidencias'), ['usuario-incidencias/index', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
	</p>
</div>
