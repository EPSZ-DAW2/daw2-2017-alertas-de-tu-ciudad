<?php
/**
 * Acción de modificación de imagenes.
 * Dependiendo de si eres usuario o administrador, podrás ver una u
 * otra cosa.
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\ImagenUnica; 
use app\components\ControlAcceso;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */
$this->title = Yii::t('app', 'Modificar Imagen');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Imagens'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
  $url = Url::previous();
  if(!isset($url))
     $url= Yii::$app->request->referrer;         
?>
  <?= Html::a(Yii::t('app', 'Volver'), $url, ['class' => 'btn btn-success']) ?>
<div class="alerta-imagen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alerta-imagen-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
      
    <?php if(!Yii::$app->user->isGuest &&  (Yii::$app->user->identity->rol === 'A' || Yii::$app->user->identity->rol === 'M')){ ?>
        
        
    <?= $this->render('update_admin_form', [
        'model' => $model, 'form' => $form,]) ?> 
    <?php }  ?>
        
    <div  align="center">       
        <div id="arrastrar_soltar" onclick="document.getElementById('explorar_ficheros').click();" class="adjuntar_imagen">
            <input style="" class="file_input_hack" accept="image/*" type="file" name="explorar_ficheros" id="explorar_ficheros" />
            <div style="margin-top: 10px; font-size:22px;"> Arrastre y suelte una imagen para subirla</div>
            <img style="width:200px; margin-top:15px; margin-bottom: 10px" src="<?php echo Url::base(true); ?>/img/upload.png">
            <div style="margin-top: 10px; font-size:22px;"> o pulse aquí.</div>
      </div>
    </div>
    
    <div style="margin-top: 30px; margin-bottom: 30px;">
         <ul id="previsualizador" class="ul_imagen"></ul>
    </div>
        
   <?= ImagenUnica::widget(['id_imagen' => $model->id, 'div_render' => 'previsualizador', 'view' => $this]) ?>     
        
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar cambios'), ['class' => 'btn btn-primary']) ?>
    </div>

            <?php
     $this->registerJs( <<< EOT_JS
    var element = document.querySelector('#arrastrar_soltar');
    soltar_objetos(element);            
EOT_JS
  );

        
  ActiveForm::end(); ?>


</div>
