<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioIncidenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Usuario Incidencias');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuario-incidencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Usuario Incidencia'), ['create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Mandar mensaje o avisar a un usuario'), ['elegirusuario'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Hacer una  consulta'), ['createconsulta'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Notificar'), ['createnotificacion'], ['class' => 'btn btn-success']) ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'crea_fecha',
            'clase_incidencia_id',
            'texto:ntext',
            'destino_usuario_id',
             'origen_usuario_id',
             'alerta_id',
             'comentario_id',
             'fecha_lectura',
             'fecha_borrado',
             'fecha_aceptado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
