<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EtiquetasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?php if (isset(Yii::$app->user->identity->rol) && Yii::$app->user->identity->rol === 'A') {$template = '{view} {update} {delete}';}
			  else{$template='{view}';}//if para que vea los botones del grid quien debe ?>
		<?php if (!Yii::$app->user->isGuest) { ?>
        <?= Html::a('Crear Etiquetas', ['create'], ['class' => 'btn btn-success']) ?>
		  <?= Html::a(Yii::t('app', 'Añadir etiqueta a una categoría'), ['categorias-etiquetas/create'], ['class' => 'btn btn-success']) ?>
		  <?= Html::a(Yii::t('app', 'Añadir etiqueta a una alerta'), ['alerta-etiquetas/create'], ['class' => 'btn btn-success']) ?>	
		<?php }//if para que solo usuarios registrados puedan verlos?>
		
		<?php if (isset(Yii::$app->user->identity->rol) && Yii::$app->user->identity->rol === 'A') {?>
		  <?= Html::a(Yii::t('app', 'Etiquetas y categorias'), ['/categorias-etiquetas'], ['class' => 'btn btn-success']) ?>
		  <?= Html::a(Yii::t('app', 'Etiquetas y alertas'), ['/alerta-etiquetas'], ['class' => 'btn btn-success']) ?>
	<?php }//if?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',

            ['class' => 'yii\grid\ActionColumn','template'=> $template ],
        ],
    ]); ?>
</div>