<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaImagenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Alerta Imagenes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-imagen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Agregar imágenes'), ['create'], ['class' => 'btn btn-success', 'style' => 
            'height: 70px; text-align: center; vertical-align: middle; line-height: 50px; width: 200px; font-size: 18px;']) ?>
        
         <?= Html::a(Yii::t('app', 'Revisar imágenes'), ['revisar'], ['class' => 'btn btn-success', 'style' => 
            'height: 70px; text-align: center; vertical-align: middle; line-height: 50px; width: 200px; font-size: 18px;']) ?>  
         
     <?= Html::a(Yii::t('app', 'Ver imágenes desde alerta'), ['alertasimgadmin'], ['class' => 'btn btn-success', 'style' => 
            'height: 70px; text-align: center; vertical-align: middle; line-height: 50px; width: 250px; font-size: 18px;']) ?>   
    </p>
    
   <?php Url::remember(); ?>

</div>
