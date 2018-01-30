<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Usuarios;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */
/* @var $form yii\widgets\ActiveForm */

?>

<?php
if(!empty($_SESSION['__id'])){
$usuario = new Usuarios();
$usuario=$usuario::findOne($_SESSION["__id"]);
}
?>

<div class="alerta-comentarios-form col-md-6 col-md-offset-3">

    <?php $form = ActiveForm::begin(['action' =>Yii::getAlias('@web').'/alerta-comentarios/actualizarcomentario?id='.$model->id]); ?>
    <?= $form->field($model, 'id')->textInput([
            'type'=>'text',
            'min'=>0,
            'maxlength' => true,
            'readOnly'=>true,
            'placeholder'=>'El id no es modificable']) ?>


    <?= $form->field($model, 'alerta_id')->textInput(['type'=>'number',
        'min'=>1,
        'maxlength' => true,
        'readOnly' => true,

    ]) ?>

    <!--Texto del comentario-->
    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Modificar Comentario'), ['class' =>  'btn btn-success btn-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
