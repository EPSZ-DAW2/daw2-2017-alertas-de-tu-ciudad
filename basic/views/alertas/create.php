<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Alerta */

$this->title = 'Create Alerta';
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
