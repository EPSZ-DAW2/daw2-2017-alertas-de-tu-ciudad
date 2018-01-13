<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Elija un usuario');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_searchusuario', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'volver'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
           // 'email:email',
           // 'password',
            'nick',
            'nombre',
             'apellidos',
            // 'fecha_nacimiento',
            // 'direccion:ntext',
            // 'area_id',
             'rol',
            // 'fecha_registro',
            // 'confirmado',
            // 'fecha_acceso',
            // 'num_accesos',
            // 'bloqueado',
            // 'bloqueo_usuario_id',
            // 'bloqueo_fecha',
            // 'bloqueo_notas:ntext',

           [
            'class' => 'yii\grid\ActionColumn',
            'template' => ' {enviamensaje} {avisa}',  // the default buttons + your custom button
            'buttons' => [
                'enviamensaje' => function($url, $model) {     // render your custom button
                    return Html::a(Yii::t('app', 'Enviar mensaje'), ['createmensaje', 'id'=>$model->id], ['class' => 'btn btn-success']) ;
                },
				'avisa' => function($url, $model) {     // render your custom button
                    return Html::a(Yii::t('app', 'Avisar'), ['createaviso', 'id'=>$model->id], ['class' => 'btn btn-success']) ;
                }
            ]
        ],
        ],
    ]); ?>
</div>
