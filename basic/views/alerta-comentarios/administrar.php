<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */

$this->title = Yii::t('app', 'Administrar Hilos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Administrar Hilos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-comentarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider3,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alerta_id',
            'crea_usuario_id',
            //'crea_fecha',
            'modi_usuario_id',
            'modi_fecha',
            //'texto:ntext',
            // 'comentario_id',
            //'cerrado',
            // 'num_denuncias',
            // 'fecha_denuncia1',
            // 'bloqueado',
            // 'bloqueo_usuario_id',
            // 'bloqueo_fecha',
            // 'bloqueo_notas:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>