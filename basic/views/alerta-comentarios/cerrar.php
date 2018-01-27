<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */

$this->title = Yii::t('app', 'Create Alerta Comentarios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Comentarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-comentarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('administrar') ?>

</div>
