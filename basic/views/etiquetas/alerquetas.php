<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AlertaEtiquetas;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */

$source_alertas=array_merge([],array_unique(AlertaEtiquetas::find()->joinWith('alerta AS alerta',false)->select(['alerta.id AS value'])->orderBy('alerta.id')->asArray()->all(),SORT_REGULAR));

$this->title = "Alertas en las que aparece";
$this->params['breadcrumbs'][] = ['label' => 'Alertas Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertas-etiquetas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
		  <?= Html::a('Volver', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
	 
	     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'alerta_id',
				['attribute' => 'titulo_alerta',
                'label' => 'Alerta Título',
                'value' => 'alerta.titulo',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'titulo_alerta',
                    'clientOptions' => [
                    'source' => $source_alertas,
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>