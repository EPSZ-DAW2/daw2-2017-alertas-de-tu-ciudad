<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?php if(isset($admin) && $admin==true){
				echo Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-success']);
				}
		?>
        <?= Html::a('Ver perfil', ['perfil'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'email:email',
            //'password',
            'nick',
            'nombre',
            'apellidos',
            // 'fecha_nacimiento',
            // 'direccion:ntext',
            // 'area_id',
            // 'rol',
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
			 'template' => ' {view} {update} {delete} {bloquear} {mensaje}',
			'buttons' => [
				'bloquear' => function ($url) {
					return Html::a(
						'<span class="glyphicon glyphicon-ban-circle"></span>',
						$url, 
						[
							'title' => 'Bloquear',
							'data-pjax' => '0',
						]
					);
				},
				
				'mensaje' => function($url, $model) {     // render your custom button
                    return Html::a(
					'<span class="glyphicon glyphicon-envelope"></span>',
					Yii::t('app', 'usuario-incidencias/createmensaje?id='.$model->id));
				},
			],
			],
        ],
    ]); ?>
	
<?php Pjax::end(); ?></div>