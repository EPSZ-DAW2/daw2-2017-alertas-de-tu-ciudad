<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use app\models\Categorias;
use app\models\CategoriasSearch;
use app\models\Alerta;
use app\models\AlertaSearch;


/* @var $this yii\web\View */
/* @var $model app\models\Categorias */

$this->title = 'Categoria: '.$model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$url ='http://localhost/daw/basic/web/alertas';?>
<div class="categorias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:ntext',
            'categoria_id',
        ],
    ]) ?>
	<h2>Alertas enlazadas: </h2>
	 <?= 
        GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'titulo',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'titulo',
                    'clientOptions' => [
                    'source' => Alerta::find()->andWhere(['categoria_id'=>$model->id])->select(['titulo AS value'])->orderBy('titulo')->asArray()->all(),
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
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'http://localhost/daw/basic/web/alertas/view?id='.$model->id, [
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
