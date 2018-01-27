<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Notas Bloqueo: ' . $model->nick;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nick, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Notas';
?>
<div class="usuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formbloqueonotas', [
        'model' => $model,
    ]) ?>

</div>