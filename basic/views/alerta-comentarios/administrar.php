<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */

$this->title = Yii::t('app', 'Administrar Hilos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Administrar Hilos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-comentarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alerta_id',
            'crea_usuario_id',
            //'crea_fecha',
            //'modi_usuario_id',
            //'modi_fecha',
            //'texto:ntext',
            // 'comentario_id',
             'cerrado',
            // 'num_denuncias',
            // 'fecha_denuncia1',
             'bloqueado',
            // 'bloqueo_usuario_id',
            // 'bloqueo_fecha',
            // 'bloqueo_notas:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{gestionhilos}',
                'buttons' => [
                    'gestionhilos' => function ($url) {
                        return Html::a(
                            'Cerrar<span class="glyphicon glyphicon-remove"></span>',
                            $url."&accion=cerrar",
                            [
                                'title' => 'Cerrar Hilo',
                            ]
                        );
                    },


                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{gestionhilos}',
                'buttons' => [

                    'gestionhilos' => function ($url) {
                        return Html::a(
                            'Bloquear<span class="glyphicon glyphicon-ban-circle"></span>',
                            $url."&accion=bloquear",
                            [
                                'title' => 'Bloquear Hilo',


                            ]
                        );
                    },
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{gestionhilos}',
                'buttons' => [
                    'gestionhilos' => function ($url) {
                        return Html::a(
                            'Abrir <span class="glyphicon glyphicon-ok"></span>',
                            $url."&accion=abrir",
                            [
                                'title' => 'Abrir Hilo',

                            ]
                        );
                    },


                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{gestionhilos}',
                'buttons' => [
                    'gestionhilos' => function ($url) {
                        return Html::a(
                            'Desbloquear <span class="	glyphicon glyphicon-comment"></span>',
                            $url."&accion=desbloquear",
                            [
                                'title' => 'Desbloquear Hilo',

                            ]
                        );
                    },

                ],
            ],

        ],
    ]); ?>
</div>