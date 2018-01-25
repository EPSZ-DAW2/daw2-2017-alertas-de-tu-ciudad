<?php
/**
 * Parametros adicionales que tendrá el administrador a la hora de modificar 
 * las imagenes.
**/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
?>

    <?= $form->field($model, 'alerta_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crea_usuario_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'crea_fecha')->textInput() ?>

    <?= $form->field($model, 'notas_admin')->textarea(['rows' => 6]) ?>
