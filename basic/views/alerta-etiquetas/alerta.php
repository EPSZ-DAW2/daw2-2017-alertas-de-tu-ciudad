<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Categorias Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-etiquetas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
		  <?= Html::a('Volver', ['view', 'id' => $model->etiqueta_id], ['class' => 'btn btn-primary']) ?>
    </p>
	 
	     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'categoria_id',
            'etiqueta_id',
        ],
    ]); ?>

</div>