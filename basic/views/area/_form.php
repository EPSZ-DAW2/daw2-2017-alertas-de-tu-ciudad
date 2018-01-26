<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Area */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'clase_area_id')->dropDownList($model::$clases_area) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php 
    $posible_parents = null;
    if ($model->isNewRecord) {
        $posible_parents = $model::find()->asArray()->all();
    }
    else {
        $posible_parents = $model::find()->where(['<', 'clase_area_id', $model->clase_area_id])->asArray()->all();
    }
    ?>
    <?= $form->field($model, 'area_id')->dropDownList(ArrayHelper::map($posible_parents, 'id', 'nombre')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
