<?php
/*
Vista que verá cualquier tipo de usuario registrado. Y comprobará si el usuario registrado 
es administrador, si es así entonces le aparecerá un botón a mayores para acceder al apartado 
de 'Incidencias, como administrador' que le llevara a la vista 'indexadmin'.
*/

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioIncidenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Incidencias');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuario-incidencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      	<?= Html::a(Yii::t('app', 'Hacer una  consulta'), ['createconsulta'], ['class' => 'btn btn-success']) ?>
		<?php if(isset($admin) && $admin==true){
			echo Html::a(Yii::t('app', 'Incidencias como administrador'), ['indexadmin'], ['class' => 'btn btn-success']);
			}
		?>
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
           //  'alerta_id',
           //  'comentario_id',
             'fecha_lectura',
             'fecha_borrado',
             'fecha_aceptado',

            ['class' => 'yii\grid\ActionColumn',
			'template' => '  {view}',
			]
        ],
    ]); ?>
</div>
