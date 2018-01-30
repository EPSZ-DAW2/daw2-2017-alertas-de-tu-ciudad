<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Áreas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Area'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <? Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'claseArea', 'filter' => $clasesArea ],
            'nombre',
            'parentName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <? Pjax::end(); ?>
</div>
