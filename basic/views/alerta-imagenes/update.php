<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Alerta Imagen',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="alerta-imagen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
