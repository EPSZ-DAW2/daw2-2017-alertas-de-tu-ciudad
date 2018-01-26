<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\LogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		 <?= Html::a('Ver todos los logs', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Ver sólo errores', ['index?LogsSearch[clase_log_id]=E'], ['class' => 'btn btn-success']) ?>
		 <?= Html::a('Ver logs de avisos', ['index?LogsSearch[clase_log_id]=A'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'crea_fecha',
           // 'clase_log_id',
			[
				'label' => 'Clase',
				'value' => function ($model) {
					return $model::getNombreClase($model->clase_log_id);
				}
			],
           // 'modulo',
          //  'texto:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
