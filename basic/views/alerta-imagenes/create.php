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

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id'=>'form_submit',]]); // IMPORTANTE! ?>
    <?php if($permisos){?>
    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>
    <?php } ?>     
    <div  align="center">       
        <div id="arrastrar_soltar" onclick="document.getElementById('explorar_ficheros').click();" class="adjuntar_imagen">
            <input style="" class="file_input_hack" accept="image/*" type="file" name="explorar_ficheros[]" id="explorar_ficheros"  multiple="multiple" />
            <div style="margin-top: 10px; font-size:22px;"> Arrastre y suelte imágenes para subir</div>
            <img style="width:200px; margin-top:15px; margin-bottom: 10px" src="<?php echo Url::base(true); ?>/img/upload.png">
            <div style="margin-top: 10px; font-size:22px;"> o pulse aquí.</div>
      </div>
    </div>
    
    <div style="margin-top: 30px; margin-bottom: 30px;">
         <ul id="previsualizador" class="ul_imagen"></ul>
    </div>
    
    
    <?php
     $this->registerJs( <<< EOT_JS
    var element = document.querySelector('#arrastrar_soltar');
    soltar_objetos(element);            
EOT_JS
  ); 
     
    ?>
      
    <div class="form-group" style="text-align: center;">
        
        <?= Html::submitButton('Subir todas las imagenes', ['class' => 'btn btn-success']) ?>
     </div>
        <?php ActiveForm::end(); ?>



</div>
