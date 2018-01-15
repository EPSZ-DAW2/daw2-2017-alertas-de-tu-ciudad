<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AlertaEtiquetas */

$this->title = 'Create Alerta Etiquetas';
$this->params['breadcrumbs'][] = ['label' => 'Alerta Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-etiquetas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>