<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencia */

$this->title = Yii::t('app', 'Create Usuario Incidencia');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuario Incidencias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-incidencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
