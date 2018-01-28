<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\widgets\Pjax;
use app\models\Categorias;
use app\models\CategoriasSearch;



/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        if ( isset(Yii::$app->user->identity->rol)){
            if(Yii::$app->user->identity->rol === 'A'){
                echo Html::a(Yii::t('app', 'Create Categorie'), ['create'], ['class' => 'btn btn-success']).' ';
                $template='{view} {update} {delete}';
            }else if(Yii::$app->user->identity->rol === 'M'){
                $template='{view}';
            }
            echo Html::a(Yii::t('app', 'Categorías-Etiquetas'), ['/categorias-etiquetas'], ['class' => 'btn btn-success']);
        }else{
            CategoriasSearch::arbolCategorias();
            $template='{view}';
        }?>
    </p>
<?php Pjax::begin();?>    

    <?=        
        GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            ['attribute'=>'nombre',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'nombre',
                    'clientOptions' => [
                    'source' => array_merge([],array_unique(Categorias::find()->select(['nombre AS value'])->orderBy('nombre')->asArray()->all(),SORT_REGULAR)),
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ],
                ]),
            ],
            'descripcion:ntext',
            'categoria_id',
            ['attribute' => 'nombCatId',
                'label' => 'Nombre Categoria ID',
                'value' => 'categoria.nombre',
                'filter' => AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'nombCatId',
                    'clientOptions' => [
                    'source' => array_merge(array(),array_unique(Categorias::find()->joinWith('categoria AS categoria',false)->select(['categoria.nombre AS value'])->orderBy('categoria.nombre')->asArray()->all(),SORT_REGULAR)),
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ],
                ]),
                
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => $template,
            ],
        ],
        ]);  
    ?>
<?php Pjax::end(); ?></div>
