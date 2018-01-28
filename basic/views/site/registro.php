<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Rellene el siguiente formulario para registrarse: </p>

    <?php $form = ActiveForm::begin([
        'id' => 'registro-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
		
		<?= $form->field($model, 'nick')->textInput(['autofocus' => true]) ?>
		
		<?= $form->field($model, 'nombre')->textInput(['autofocus' => true]) ?>
		<?= $form->field($model, 'apellidos')->textInput(['autofocus' => true]) ?>
		<?= $form->field($model, 'fecha_nacimiento')->textInput(['autofocus' => true]) ?>
		<?= $form->field($model, 'direccion')->textInput(['autofocus' => true]) ?>
		<?= $form->field($model, 'area_id')->textInput(['autofocus' => true]) ?>

  

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Registrate', ['class' => 'btn btn-primary', 'name' => 'registro-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>


</div>
