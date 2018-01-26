<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Configuraciones */

$this->title = 'Nueva variable de configuración';
$this->params['breadcrumbs'][] = ['label' => 'Configuraciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuraciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
