<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\ImagenUnica; 
use yii\helpers\Url;
use app\models\AlertaImagen;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */

$this->title = 'Imagen con la ID: '. $model->id.', perteneciente a la alerta '. $model->alerta_id;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagens'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
 $url = Url::previous();
  if(!isset($url))
     $url= Yii::$app->request->referrer;         
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
            'alerta_id',
            'orden',
            'imagen_id',
            'imagen_revisada',
            'crea_usuario_id',
            'crea_fecha',
            'modi_usuario_id',
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
