<?php

use yii\helpers\Html;
use yii\grid\GridView;

//if (Yii::$app->user->isAdmin()) {

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriasEtiquetasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorias Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-etiquetas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Categorias Etiquetas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'categoria_id',
            'etiqueta_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
