<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */

$this->title = Yii::t('app', 'Actualizar {modelClass}: ', [
    'modelClass' => 'Categorias Etiquetas',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias Etiquetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="categorias-etiquetas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
