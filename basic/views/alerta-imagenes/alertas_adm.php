<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\widgets\ImagenUnica; 
use yii\data\Pagination;
use yii\widgets\LinkPager;

/**
 * Vista creada para ayuda para los moderadores sobre todo, que les mostrará todas las alertas
 * en las cuales tienen permisos para administrar imágenes, así como la imagen característica de la misma.
 * 
**/


/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaImagenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Imágenes en alertas que puedes administrar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-imagen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div id="contenedor_alertas">
        
        <?php   
 
        foreach ($models as $alerta_model) 
        {
          ?>  
        <a style="text-decoration: none; color: black;" href="<?php echo Url::base(true);?>/alertas/imagenes?id=<?php echo $alerta_model->id;?>&url=<?php echo Url::current()?>">
        <div class = "previsualizador_alerta" style="padding-top: 15px; height: 200px; min-width: 567px; box-shadow: 0 3px 6px rgba(0,0,0,.16),0 3px 6px rgba(0,0,0,.23); float: left; position: relative; display: inline-block; margin-right:3px; margin-bottom: 10px; ">
            <div id="imagen_<?php echo $alerta_model->id;?>" style="float:left; position: absolute;"><div style="position:absolute; width:254px; height:164px; background:#d5d5d5; margin-left:16px;"></div></div>
            <div class="parte_derecha" style="float:right; position: absolute; margin-left: 285px;" >
                 <div style="font-size: 22px; font-weight: bold; width: 270px; overflow: hidden; white-space: nowrap;" > <?php echo $alerta_model->titulo;?> </div>
                 <div style="font-size: 13px;  width: 270px; overflow: hidden; height:140px" > <?php echo $alerta_model->descripcion; ?> </div>
            </div>
        </div> 
        </a>
        
         <?= ImagenUnica::widget(['UUID' => $alerta_model->imagen_id, 'div_render' => 'imagen_'.$alerta_model->id, 'view' => $this]) ?> 
    <?php
        } ?>
        </div>  
    <div style="clear: both;"></div>

  <?php
  echo LinkPager::widget([
        'pagination' => $pages,
        ]);
        
?>
    

</div>
