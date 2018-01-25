<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\widgets\Pjax;
use app\models\AlertaEtiquetas;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaEtiquetasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$source_etiquetas=array_merge(array(),array_unique(AlertaEtiquetas::find()->joinWith('etiqueta AS etiqueta',false)->select(['etiqueta.nombre AS value'])->orderBy('etiqueta.nombre')->asArray()->all(),SORT_REGULAR));
$source_alertas=array_merge([],array_unique(AlertaEtiquetas::find()->joinWith('alerta AS alerta',false)->select(['alerta.id AS value'])->orderBy('alerta.id')->asArray()->all(),SORT_REGULAR));

$this->title = 'Alerta Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-etiquetas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?php if (!Yii::$app->user->isGuest ) { ?>
        <?= Html::a('Create Alerta Etiquetas', ['create'], ['class' => 'btn btn-success']) ?>
		<?php }//if ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
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
            'etiqueta_id',
            ['attribute' => 'nombre_etiqueta',
                'label' => 'Etiqueta Nombre',
                'value' => 'etiqueta.nombre',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'nombre_etiqueta',
                    'clientOptions' => [
                    'source' => $source_etiquetas,
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ],
                ]),
                
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
