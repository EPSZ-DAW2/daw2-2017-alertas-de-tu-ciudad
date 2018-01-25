<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\widgets\Pjax;
use app\models\CategoriasEtiquetas;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriasEtiquetasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categorias Etiquetas');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="categorias-etiquetas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Categoria-Etiqueta'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'categoria_id',
            ['attribute' => 'nombre_categoria',
                'label' => 'Categoria Nombre',
                'value' => 'categoria.nombre',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'nombre_categoria',
                    'clientOptions' => [
                    'source' => array_merge([],array_unique(CategoriasEtiquetas::find()->joinWith('categoria AS categoria',false)->select(['categoria.nombre AS value'])->orderBy('categoria.nombre')->asArray()->all(),SORT_REGULAR)),
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
                    'source' => array_merge(array(),array_unique(CategoriasEtiquetas::find()->joinWith('etiqueta AS etiqueta',false)->select(['etiqueta.nombre AS value'])->orderBy('etiqueta.nombre')->asArray()->all(),SORT_REGULAR)),
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
