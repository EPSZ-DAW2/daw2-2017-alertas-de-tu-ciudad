<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CategoriasEtiquetas */

$this->title = Yii::t('app', 'Create Categorias Etiquetas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias Etiquetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-etiquetas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
