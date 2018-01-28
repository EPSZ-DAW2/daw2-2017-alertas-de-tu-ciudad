<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\widgets\LinkPager;

//PARA LA LISTA
/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaImagenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// PARA LAS IMAGENES
/* @var $visionActual int */

$this->title = Yii::t('app', 'Revisión de Alerta Imagenes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagenes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-imagen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <?php         
        $visionActual = Yii::$app->getRequest()->getQueryParam('vis');
        $opv = Yii::$app->getRequest()->getQueryParam('opv');
        
        $str = 'Ver lista';
        
        if(!isset($visionActual))
            $visionActual = 0;
        
        if(!isset($opv))
            $opv = 1;
        
        if($visionActual == 0)
        {
            $str = 'Ver imágenes';
            $visionActual = 1;
        }else $visionActual = 0;
        
        $dst_1 = 'btn btn-success';
        $dst_2 = 'btn btn-success';
        $dst_3 = 'btn btn-success';
        $dst_4 = 'btn btn-success';
        
        switch($opv)
        {
            case 1: $dst_1= 'btn btn-primary'; break;
            case 2: $dst_2= 'btn btn-primary'; break;
            case 3: $dst_3= 'btn btn-primary'; break;
            case 4: $dst_4= 'btn btn-primary'; break;
        }
        
        ?>
        
        <?= Html::a(Yii::t('app', 'Todas'), Url::current(['opv' => 1]), ['class' => $dst_1, 'title' => 'Muestra todas las imágenes.']) ?>
        <?= Html::a(Yii::t('app', 'Nuevas'), Url::current(['opv' => 2]), ['class' => $dst_2, 'title' => 'Muestra las imágenes de los últimos 7 días.']) ?>
        <?= Html::a(Yii::t('app', 'No revisadas'), Url::current(['opv' => 3]), ['class' => $dst_3, 'title' => 'Muestra las imágenes no revisadas.']) ?>
        <?= Html::a(Yii::t('app', 'Con notas de administrador'), Url::current(['opv' => 4]), ['class' => $dst_4, 'title' => 'Muestra las imágenes que tienen mensaje de administradores.']) ?>
        
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> '.Yii::t('app', $str), Url::current(['vis' => $visionActual]), ['class' => 'btn btn-primary btn-right']) ?>
    </p>
    
    <?php 
    
    if($visionActual == 0)
    {
       $this->registerCssFile(Url::base(true).'/css/imagenes.css');
        echo '<div style="margin-top: 30px; margin-bottom: 30px;">'
       . '<ul id="previsualizador" class="ul_imagen"></ul></div>';
       $this->registerJSFile(Url::base(true).'/js/funciones_imagenes.js');
       
        foreach ($models as $imagen) 
       {
           $i = $imagen->obtenerRutaFisica();

           //Ejecutamos la función asociada al fichero JS registrado anteriormente.
           //Pasándole como dato la ruta de la imagen
           if($i != NULL)
           {
            if(Yii::$app->user->identity->rol === 'A')
                $this->registerJS('previsualizar_imagen("'.$i.'", "'.$imagen->id.'", "'.$imagen->crea_usuario_id.':'.$imagen->imagen_revisada.'",  "previsualizador");', 4);  
            else  $this->registerJS('previsualizar_imagen("'.$i.'", "'.$imagen->id.'", "'.$imagen->crea_usuario_id.'",  "previsualizador");', 4);  
            
           }
           }
       
       $this->registerJS('barra_herramientas_imagenes("'.Url::base(true).'","'.Yii::$app->user->getId().'", "0","1","0");', 4);    
       
        
        echo LinkPager::widget([
        'pagination' => $pages,
        ]);
  
    }
    else
    {
    
    if($opv == 4){ ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
        
            'id',
            'alerta_id',
            //'orden',
            //'imagen_id',
            //'imagen_revisada',//**
            'crea_usuario_id',//**
            // 'crea_fecha',
            // 'modi_usuario_id',
            // 'modi_fecha',
            ['attribute' => 'notas_admin',
            'label' =>'Notas de administración',
            'format'=>'ntext',
            'contentOptions' => ['style' => 'width:42%'],
            ],
            // 'notas_admin:ntext',
         [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete} {imagenrevisar}',
        'buttons' => [
                'imagenrevisar' => function ($url, $model) {
                        $color = '';
                        if($model->imagen_revisada == 1) 
                            $color='style = "color:green;"';
                        
                        return Html::a(        
                                '<span '.$color.'class="glyphicon glyphicon-ok"></span>', 
                                $url);
                },
        ],
],

        
        ],
    ]); 
        ?>
    <?php } else {?>
    
      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alerta_id',
            //'orden',
            'imagen_id',
            'imagen_revisada',//**
            'crea_usuario_id',//**
            // 'crea_fecha',
            // 'modi_usuario_id',
            // 'modi_fecha',
            // 'notas_admin:ntext',

         [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete} {imagenrevisar}',
        'buttons' => [
                'imagenrevisar' => function ($url, $model) {
                        $color = '';
                        if($model->imagen_revisada == 1) 
                            $color='style = "color:green;"';
                        
                        return Html::a(        
                                '<span '.$color.'class="glyphicon glyphicon-ok"></span>', 
                                $url);
                },
        ],
],
        ],
    ]); 
        ?>
    <?php }} ?>
    
   <?php Url::remember(); ?>

</div>
