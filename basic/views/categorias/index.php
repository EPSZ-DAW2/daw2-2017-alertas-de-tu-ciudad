<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
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

    
    <?php
        // PARA DEBUG
        if (Yii::$app->user->isGuest)
            echo '<h3 style="text-align:center;background-color:black;color:white">Eres invitado</h3>';
        else
            echo '<h3 style="text-align:center;background-color:black;color:white">Eres admin</h3>';
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Categorias'), ['create'], ['class' => 'btn btn-success']) ?>
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
                    'source' => Categorias::find()->select(['nombre AS value'])->orderBy('nombre')->asArray()->all(),
                    ],
                ]),
            ],
            'descripcion:ntext',
            'categoria_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        ]);  
    ?>
<?php Pjax::end(); ?></div>
