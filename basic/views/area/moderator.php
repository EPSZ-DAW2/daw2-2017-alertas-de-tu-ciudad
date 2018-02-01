<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Usuario;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Alertas por área del moderador ('.$areaName.')');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Áreas'), 'url' =>'index'];
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
            'titulo',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'template' => '{ficha} {ver} {bloquear}',
                'controller' => 'alertas',
                'buttons' => [
                    'bloquear' => function ($url) {
						return Html::a(
							'<span class="glyphicon glyphicon-ban-circle"></span>',
							$url, 
							[
								'title' => 'Bloquear',
								
							]
						);
                    },
                    'ficha' => function ($url) {
						return Html::a(
							'<span class="glyphicon glyphicon-list"></span>',
							$url, 
							[
								'title' => 'Ficha',
								
							]
						);
					},
                ]
            ]
        ],
    ]); ?>
    <? Pjax::end(); ?>
</div>
