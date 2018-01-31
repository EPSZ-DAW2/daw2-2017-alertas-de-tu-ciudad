<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Alertas por área del moderador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Áreas'), 'url' => [ ($rol != 'A') ? 'index' : 'admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-admin">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <? Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'rol',
            'area_id',
            'areaClase:text:Tipo de área',
            'areaName:text:Nombre del área',
            'alertasNames:text:Alertas Relacionadas'

        ],
    ]); ?>
    <? Pjax::end(); ?>
</div>
