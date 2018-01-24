<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CategoriasEtiquetas;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */

$source_categorias=array_merge([],array_unique(CategoriasEtiquetas::find()->joinWith('categoria AS categoria',false)->select(['categoria.nombre AS value'])->groupBy('categoria.id')->asArray()->all(),SORT_REGULAR));

$this->title = "Categorias en las que aparece";
$this->params['breadcrumbs'][] = ['label' => 'Categorias Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-etiquetas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
		  <?= Html::a('Volver', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
	 
	     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'categoria_id',
				['attribute' => 'nombre_categoria',
                'label' => 'Categoria Nombre',
                'value' => 'categoria.nombre',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'nombre_categoria',
                    'clientOptions' => [
                    'source' => $source_categorias,
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>