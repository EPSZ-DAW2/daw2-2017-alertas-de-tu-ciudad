<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaComentariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Alerta Comentarios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-comentarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Alerta Comentarios'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        <?= Html::a(Yii::t('app', 'Administrar Hilos'), ['administrar'], ['class' => 'btn btn-success']) ?>
    </p>
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
            'modi_usuario_id',
             'modi_fecha',
             //'texto:ntext',
            // 'comentario_id',
            //'cerrado',
            // 'num_denuncias',
            // 'fecha_denuncia1',
            // 'bloqueado',
            // 'bloqueo_usuario_id',
            // 'bloqueo_fecha',
            // 'bloqueo_notas:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <h1 id="Comentar">Comentarios Prueba</h1>
    <?= $this->render("comentarios.php",[
            'searchModel'=>$searchModel,
        'dataProvider2'=>$dataProvider2,
        'idAlerta' => $idAlerta,
    ]); ?>

<?php
    Pjax::end();
?>
</div>
