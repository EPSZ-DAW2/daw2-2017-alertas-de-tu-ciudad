<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alertas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Alerta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo:ntext',
            'descripcion:ntext',
            'fecha_inicio',
            'duracion_estimada',
            // 'direccion:ntext',
            // 'notas_lugar:ntext',
            // 'area_id',
            // 'detalles:ntext',
            // 'notas:ntext',
            // 'url:ntext',
            // 'imagen_id',
            // 'imagen_revisada',
            // 'categoria_id',
            // 'activada',
            // 'visible',
            // 'terminada',
            // 'fecha_terminacion',
            // 'notas_terminacion:ntext',
            // 'num_denuncias',
            // 'fecha_denuncia1',
            // 'bloqueada',
            // 'bloqueo_usuario_id',
            // 'bloqueo_fecha',
            // 'bloqueo_notas:ntext',
            // 'crea_usuario_id',
            // 'crea_fecha',
            // 'modi_usuario_id',
            // 'modi_fecha',
            // 'notas_admin:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
