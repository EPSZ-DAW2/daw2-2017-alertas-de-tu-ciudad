<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencia */
if(isset($tipodenuncia)){
	$this->title = Yii::t('app', 'Denunciar '.$tipodenuncia);
}

if(isset($nombre)){
	$this->title = Yii::t('app', 'Enviar mensaje a '.$nombre);
}
if(isset($consulta)){
	$this->title = Yii::t('app', 'Escriba su consulta');
}
if(isset($notificacion)){
	$this->title = Yii::t('app', 'Escriba la notificación');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Volver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuario-incidencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formincidencia', [
        'model' => $model,
    ]) ?>

</div>
