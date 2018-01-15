<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */

$this->title = Yii::t('app', 'Adjuntar imagen en Alerta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagenes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-imagen-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
