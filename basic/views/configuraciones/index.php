<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ConfiguracionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de configuraciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuraciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
    <p>
        <?= Html::a('Nueva variable de configuración', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'variable',
            'valor:ntext',

            ['class' => 'yii\grid\ActionColumn',
			'template' => '{update} {delete} ',
			
			'buttons' => [
				'delete' => function($url, $model){
					return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->variable], [
						'class' => '',
						'data' => [
							'confirm' => 'Seguro ? No podrás deshacer.',
							'method' => 'post',
						],
					]);
				}
				]
			],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
