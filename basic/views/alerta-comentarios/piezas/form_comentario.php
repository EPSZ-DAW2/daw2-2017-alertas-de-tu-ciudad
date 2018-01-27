<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;


    $idComentarioPadre = 0;
    if(!empty($idAlerta)) {
        $redireccion = "//alertas/ficha?id=$idAlerta";
    }
    else {
        $redireccion = "index";
        $idAlerta = 0; //Para probar
    }
    if(!empty($_GET['idComentarioPadre'])) $idComentarioPadre = $_GET['idComentarioPadre'];

    /* @var $this yii\web\View */
    /* @var $model app\models\AlertaComentarios */
    /* @var $form yii\widgets\ActiveForm */

    ?>

    <div class="alerta-comentarios-form" >
        <?php $form = ActiveForm::begin(
                ['action' =>['alerta-comentarios/comentar?
                    idComentarioPadre='.$idComentarioPadre.
                    "&idAlerta=".$idAlerta."
                    &redireccion=$redireccion"], 'method' => 'post',]);
        ?>
        <?php if($idComentarioPadre == 0) {?>
            <?= $form->field($model, 'texto')->textArea(['rows'=>'5'])->label('Nuevo Comentario') ?>
        <?php }else {?>
            <?= $form->field($model, 'texto')->textArea(['rows'=>'5'])->label('Respuesta al comentario #'.$idComentarioPadre) ?>
        <?php } ?>
        <div class="form-group">
            <?php if($idComentarioPadre == 0) {?>
                <?= Html::submitButton(Yii::t('app', 'Comentar'), ['class' =>  'btn btn-success btn-right']) ?>
            <?php }else {?>
                <?= Html::submitButton(Yii::t('app', 'Responder'), ['class' =>  'btn btn-success btn-right']) ?>
            <?php } ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>
