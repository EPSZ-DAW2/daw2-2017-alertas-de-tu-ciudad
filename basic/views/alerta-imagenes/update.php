<?php
/**
 * Acción de modificación de imagenes.
 * Dependiendo de si eres usuario o administrador, podrás ver una u
 * otra cosa.
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\ImagenUnica; 

$this->registerJsFile('@web/js/funciones_imagenes.js');
$this->registerCssFile('@web/css/imagenes.css');

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */

$this->title = Yii::t('app', 'Modificar {modelClass}: ', [
    'modelClass' => 'Alerta Imagen',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="alerta-imagen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alerta-imagen-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
      
    <?php 
    //Si el usuario es administrador, podrá editar más opciones de la imagen.
    //Tocará editarlo cuando los usuarios estén realizados...
    //if(Yii::$app->user->isGuest){ ?>
    <?= $this->render('update_admin_form', [
        'model' => $model, 'form' => $form,]) ?>
        
    <?php //}  ?>
        
    <div align="center" style="width:302px;">
        <input accept="image/*" style="display:none" type="file" name="explorar_ficheros" id="explorar_ficheros" onchange="previsualizacion_img(this)" />
        <div class="adjuntar_imagen" onclick="document.getElementById('explorar_ficheros').click();">Nueva imagen</div>
    </div>
    
    <div style="margin-top: 70px; margin-bottom: 30px;">
         <ul id="previsualizador" class="ul_imagen"></ul>
    </div>
        
   <?= ImagenUnica::widget(['id_imagen' => $model->id, 'div_render' => 'previsualizador', 'view' => $this]) ?>     
        
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Modificar la imagen'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
