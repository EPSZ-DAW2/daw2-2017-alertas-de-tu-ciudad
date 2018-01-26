<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciones */

$this->title = 'Modificar el valor de la configuración: ' . $model->variable;
$this->params['breadcrumbs'][] = ['label' => 'Configuraciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->variable, 'url' => ['view', 'id' => $model->variable]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="configuraciones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
