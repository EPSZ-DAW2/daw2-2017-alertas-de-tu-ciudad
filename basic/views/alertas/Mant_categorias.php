<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Alerta */
use yii\jui\AutoComplete;
use app\models\Categorias;
use app\models\CategoriasSearch;

/*  FICHA PUBLICA DE ALERTA para usuarios sin registrar*/

$this->title = Yii::t('app','Categorias de la Alerta '. $model->id);
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="alerta-view">

    <h1><?= Html::encode($this->title) ?></h1>
	
	 <?= Html::a('Volver', ['view', 'id'=>$model->id], ['class' => 'btn btn-primary']);?>

</div>
<div>
	<h2>Categorias enlazadas: </h2>
	 <?= 
        GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'nombre',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'nombre',
                    'clientOptions' => [
                    'source' => Categorias::find()->andWhere(['categoria_id'=>$model->id])->select(['nombre AS value'])->orderBy('nombre')->asArray()->all(),
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ],
                ]),
            ],
            'descripcion',
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view'=> function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'http://localhost/daw2-2017-alertas-de-tu-ciudad-master/basic/web/categorias/view?id='.$model->id, [
                                'title' => Yii::t('app', 'View'),
                        ]);
                    },
                ],
                'template' => '{view}',
            ],
        ],
        ]);  
    ?>
  
</div>