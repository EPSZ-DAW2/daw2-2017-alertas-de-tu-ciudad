<?php
/*
Vista que accederá unicamente el Administrador una vez que pulse el botón de 'Incidencias, como 
administrador' en la vista index. En esta vista podrá volver a la vista anterior, avisar a un usuario,
o notificar, pulsando en los diferentes botones para poder ir a la escritura de la acción. 
*/

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioIncidenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Incidencias, vista de administración');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuario-incidencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Volver'), ['index'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Avisar a un usuario'), ['elegirusuario'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Notificar'), ['createnotificacion'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('app', 'Comprobar Eliminaciones'), ['borrar.php'], ['class' => 'btn btn-success']) ?>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'crea_fecha',
            'clase_incidencia_id',
            'texto:ntext',
            'destino_usuario_id',
             'origen_usuario_id',
            //	'alerta_id',
            // 'comentario_id',
             'fecha_lectura',
             'fecha_borrado',
             'fecha_aceptado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
