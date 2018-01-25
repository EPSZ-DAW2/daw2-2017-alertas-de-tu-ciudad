<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Alerta;
use app\models\AlertaSearch;



/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =  Yii::t('app','Alertas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Alerta', ['create'], ['class' => 'btn btn-success']) ?>
    
	<?php if(isset($admin) && $admin==true){
			echo Html::a(Yii::t('app', 'Alertas-admin'), ['indexadmin'], ['class' => 'btn btn-success']);
			}
		?>
		</p>

   <?= GridView::widget([
   
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo:ntext',
            'descripcion:ntext',
            'fecha_inicio',
            'duracion_estimada',
            // 'direccion:ntext',
            // 'notas_lugar:ntext',
            // 'area_id',
            // 'detalles:ntext',
            // 'notas:ntext',
            // 'url:ntext',
            // 'imagen_id',
            // 'imagen_revisada',
            // 'categoria_id',
            // 'activada',
            // 'visible',
             'terminada',
            // 'fecha_terminacion',
            // 'notas_terminacion:ntext',
            // 'num_denuncias',
            // 'fecha_denuncia1',
             'bloqueada',
            // 'bloqueo_usuario_id',
            // 'bloqueo_fecha',
            // 'bloqueo_notas:ntext',
            // 'crea_usuario_id',
            // 'crea_fecha',
            // 'modi_usuario_id',
            // 'modi_fecha',
            // 'notas_admin:ntext',
			
			//Enlace a ficha de alerta para usuarios no registrados
             ['class' => 'yii\grid\ActionColumn',
			'template' => '  {ficha}',
				'buttons' => [
					'ficha' => function ($url) {
						return Html::a(
							'Ficha',
							$url, 
							[
								'title' => 'Ficha',
								
							]
						);
					},
				],
			
			],
			
			//Enlace a ficha y bloqueo de alerta para usuarios registrados
			[
			'class' => 'yii\grid\ActionColumn', 
			 'template' => '{view} {bloquear}',
				'buttons' => [
					'bloquear' => function ($url) {
						return Html::a(
							'<span class="glyphicon glyphicon-ban-circle"></span>',
							$url, 
							[
								'title' => 'Bloquear',
								
							]
						);
					},
				],
			],
			
			
			
			 ],
			 
			 
		
    ]); ?>




