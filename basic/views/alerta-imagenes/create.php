<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */
/* @var $permisos boolean */

$this->registerJsFile('@web/js/funciones_imagenes.js');
$this->registerCssFile('@web/css/imagenes.css');

if(!isset($permisos))
    $permisos = false;

$this->title = Yii::t('app', 'Adjuntar imagenes en la Alerta');
    if($permisos)
    {
        $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagenes'), 'url' => ['index']];
        $this->params['breadcrumbs'][] = $this->title;
    }
 
  $url = Url::previous();
  
    if(!isset($url))
         $url= Yii::$app->request->referrer; 

?>

 <?= Html::a(Yii::t('app', 'Volver'), $url, ['class' => 'btn btn-success']) ?>
<div class="alerta-imagen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); // IMPORTANTE! ?>
    <?php if($permisos){?>
    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>
    <?php } ?>     
    <div  align="center" style="width:302px;padding-bottom: 1px;">
        <input style="display:none" accept="image/*" type="file" name="explorar_ficheros[]" id="explorar_ficheros" onchange="previsualizacion_img(this)" multiple="multiple" />
        <div class="adjuntar_imagen" onclick="document.getElementById('explorar_ficheros').click();">Adjuntar Imagenes</div>
    </div>
    
    <div style="margin-top: 70px; margin-bottom: 30px;">
         <ul id="previsualizador" class="ul_imagen"></ul>
    </div>
    
    
    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Subir todas las imagenes', ['class' => 'btn btn-success']) ?>
    </div>
        <?php ActiveForm::end(); ?>



</div>
