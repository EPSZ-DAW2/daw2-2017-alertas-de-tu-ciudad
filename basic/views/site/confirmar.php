<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Confirmar Registro';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Rellene el siguiente formulario para iniciar sesión: </p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]);?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
			  
			   <?= Html::a(Yii::t('app', 'Regístrate!'), ['site/confirmar'], ['class' => 'btn btn-success']) ?>

            </div>
        </div>

    <?php ActiveForm::end(); ?>


</div>
