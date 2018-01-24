<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Etiquetas */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiquetas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		<-- añadidos botones para enlazar con categorias-etiquetas y con las consultas de incidencias para pedir cambio etiquetas-->
		  <?= Html::a('Ver alertas donde aparece', ['alerquetas', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
		  <?= Html::a('Ver categorias donde aparece', ['catego', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
		  <?= Html::a(Yii::t('app', 'Añadir etiqueta a una categoría'), ['categorias-etiquetas/create'], ['class' => 'btn btn-success']) ?>
		  <?= Html::a(Yii::t('app', 'Pedir corrección etiqueta'), ['usuario-incidencias/createconsulta'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>

</div>
