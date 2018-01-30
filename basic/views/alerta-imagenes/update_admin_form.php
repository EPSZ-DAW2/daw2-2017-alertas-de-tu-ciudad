<?php
/**
 * Parametros adicionales que tendrá el administrador a la hora de modificar 
 * las imagenes.
**/
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagen */
/* @var $form yii\widgets\ActiveForm */

/* PERMITIREMOS a los administradores:
 * Poder cambiar la imagen a otra alerta.
 * Poder cambiar el usuario y la fecha en que se subió.
 * Agregar una nota de administración.
 * 
 * --- De forma automática:
 * Se seleccionará automáticamente la fecha de modificación así como la id del modificador.
 * El orden de la imagen prevalecerá.
 * 
 *  */
if(Yii::$app->user->identity->rol === 'A')
{
    $this->registerJSFile(Url::base(true).'/js/jquery.datetimepicker.js',['depends' => [\yii\web\JqueryAsset::className()]]);
   $this->registerCssFile(Url::base(true).'/css/jquery.datetimepicker.css');

?>

    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crea_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crea_fecha')->textInput(['id' => 'datetimepicker']) ?>

<?php } ?>
    <?= $form->field($model, 'notas_admin')->textarea(['rows' => 6]) ?>

<?php 
if(Yii::$app->user->identity->rol === 'A')
$this->registerJs("jQuery('#datetimepicker').datetimepicker();", View::POS_END);
?>