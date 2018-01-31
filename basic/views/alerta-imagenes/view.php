<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\ImagenUnica; 
use yii\helpers\Url;
use app\models\AlertaImagen;
use app\models\Alerta; 
use app\models\Usuario; 
/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */

$this->title = 'Imagen con la ID: '. $model->id.', perteneciente a la alerta '. $model->alerta_id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagens'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
 $url = Url::previous();
  if(!isset($url))
     $url= Yii::$app->request->referrer;   
  
  $modelo_alerta= Alerta::findOne($model->alerta_id);
  $modelo_user_crea= Usuario::findOne($model->crea_usuario_id);
  $modelo_user_edita= Usuario::findOne($model->modi_usuario_id);
  
  if(isset($modelo_alerta))
      $titulo_alerta = $modelo_alerta->titulo;
  else $titulo_alerta = "Sin nombre";
  
  if(isset($modelo_user_crea))
    $nombre_user_crea = $modelo_user_crea->nick.' (ID: '.$model->crea_usuario_id.')';
  else $nombre_user_crea = "No existe.";
  
   if(isset($modelo_user_edita))
     $nombre_mod_crea = $modelo_user_edita->nick.' (ID: '.$model->modi_usuario_id.')';
   else $nombre_mod_crea = "Nadie ha modificado esta imagen.";
?>
  <?= Html::a(Yii::t('app', 'Volver'), $url, ['class' => 'btn btn-success']) ?>
<div class="alerta-imagen-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [                    
            'label' => 'Alerta:',
            'value' => $titulo_alerta.' (ID: '.$model->alerta_id.')',
            ],
            'orden',
            'imagen_id',
            'imagen_revisada',
            [                    
            'label' => 'Usuario que ha subido la imagen:',
            'value' => $nombre_user_crea,
            ],
            'crea_fecha',
            [                    
            'label' => 'Usuario que lo ha modificado:',
            'value' => $nombre_mod_crea,
            ],
            'modi_fecha',
            'notas_admin:ntext',
            [                    
            'label' => 'URL de la imagen:',
            'value' => $model->obtenerRutaFisica(),
            ],
            [                    
            'label' => 'Ruta física en disco de la imagen:',
            'value' => $model->obtenerRutaDisco(),
            ],
            [                    
            'label' => 'Tamaño en disco de la imagen:',
            'value' => AlertaImagen::transformarSize(get_headers($model->obtenerRutaFisica(), 1)["Content-Length"]),
            ],

        ],
    ]) ?>
    
    <div align="center" style="margin-top: 70px; margin-bottom: 30px;">
         <ul id="previsualizador" class="ul_imagen"></ul>
    </div>
    
    <?= ImagenUnica::widget(['id_imagen' => $model->id, 'div_render' => 'previsualizador', 'view' => $this]) ?>  

</div>
