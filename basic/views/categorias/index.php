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

$this->title = Yii::t('app', 'Categorias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Categoria'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php 
        if ( isset(Yii::$app->user->identity->rol)){
            if(Yii::$app->user->identity->rol === 'A'){
                $template='{view} {update} {delete}';
            }else if(Yii::$app->user->identity->rol === 'M'){
                $template='{view}';
            }
            echo Html::a(Yii::t('app', 'Categorías-Etiquetas'), ['/categorias-etiquetas'], ['class' => 'btn btn-success']);
        }else{
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
            ['class' => 'yii\grid\ActionColumn',
                'template' => $template,
            ],
        ],
        ]);  
    ?>
<?php Pjax::end(); ?></div>
