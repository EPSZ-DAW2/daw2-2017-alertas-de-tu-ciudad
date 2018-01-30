<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Area */

$rol = Yii::$app->user->identity->rol;

$this->title = Yii::t('app', 'Create Area');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Áreas'), 'url' => [ ($rol != 'A') ? 'index' : 'admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
