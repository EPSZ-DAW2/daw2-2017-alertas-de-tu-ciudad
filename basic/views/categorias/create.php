<?php

use yii\helpers\Html;
use yii\jui\AutoComplete;


/* @var $this yii\web\View */
/* @var $model app\models\Categorias */

$this->title = Yii::t('app', 'Crear Categoria');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


 // var_dump($dataProvider("query"));

?>
<div class="categorias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= 

   
    $this->render('_form', [
        'model' => $model, 'dataProvider'=>$dataProvider
    ]) ?>

</div>
