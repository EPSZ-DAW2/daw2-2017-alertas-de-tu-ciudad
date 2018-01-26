<?php

use yii\helpers\Html;
use app\widgets\ListaImagenes;
use app\models\AlertaImagen;
use yii\helpers\FileHelper;
/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */

$this->title = Yii::t('app', 'Adjuntar imagen en Alerta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagenes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-imagen-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
    <?= ListaImagenes::widget(['id_alerta' => '54', 'view' => $this]) ?>
 

    <?php 
    
        function directorio_vacio($dir) 
    {
        if (!is_readable($dir)) return NULL;

            $handle = opendir($dir);
             while (false !== ($entry = readdir($handle))) 
              {
                if ($entry != "." && $entry != "..") 
                    return false;

              }
        return true;
    }

    
    ?>

        <?php 

      

        
  //  echo 'USER ID: '. Yii::$app->user->getId();
//echo $model->obtenerRutaFisica(); 
    
   //$this->registerJS(Url::base(true).'/js/funciones_imagenes.js','ver_img("aaaa");', 4);
  // $this->registerJS('ver_img("aaaa");', 4);
     // $this->registerScriptFile(Url::base(true).'/js/funciones_imagenes.js', 'ver_img("aaaa");', 4);
    ?>

</div>
