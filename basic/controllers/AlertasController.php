<?php

namespace app\controllers;

use Yii;
use app\models\Alerta;
use app\models\AlertaSearch;
use app\models\AlertaComentarios;
use app\models\AlertaComentariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ControlAcceso;
use app\models\Categorias;
use app\models\CategoriasSearch;
use yii\data\ActiveDataProvider;
use \app\models\AlertaImagen;


/**
 * AlertasController implements the CRUD actions for Alerta model.
 */
class AlertasController extends Controller
{
    /**
     * @inheritdoc
	 * Controlar los usuarios que pueden crear, modificar, borrar,Finalizar o Bloquear alertas
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => ControlAcceso::className(),
                'only' => ['view','create','update','delete','finalizar','ficha', 'bloquear','denunciar','imagenes','categorias'.'areas'],
                'rules' => [
                    [
                        'actions' => ['create','update','view','ficha','denunciar'],
                        'allow' => true,
                        'roles' => ['A','M','N'],
                    ],
                    [
                        'actions' => ['ficha'],
                        'allow' => true,
                        'roles' => ['A','M','N','?'],
                    ],
					[
                        'actions' => ['imagenes','categorias','areas','delete','finalizar','bloquear'],
                        'allow' => true,
                        'roles' => ['A','M'], //permisos moderador y administrador
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Alerta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	

    /**
     * Displays a single Alerta model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
	{
		$model = $this->findModel($id);
		
		if( $model->bloqueada == '1')
		{
			 return $this->render('finblock', [
                'model' => $model,
            ]);
		}
		
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados
		
		$model->fecha_inicio= date("Y-m-d H:i:s");
		return $this->render('view', [
            'model' => $model,
        ]);
    }
	

	
	
    /**
     * Creates a new Alerta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Alerta();
		
		$us=Yii::$app->user->identity->id; //solo pueden crear alertas nuevas usuarios registrados
		
		$model->crea_usuario_id=Yii::$app->user->identity->id; //usuario que crea la alerta
		$model->crea_fecha= date("Y-m-d H:i:s"); //Fecha en que se crea

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Alerta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$us=Yii::$app->user->identity->id; //solo pueden Modificar alertas nuevas usuarios registrados
		
		
		$model->modi_usuario_id=Yii::$app->user->identity->id; //usuario que modifica la alerta
		$model->modi_fecha= date("Y-m-d H:i:s"); //Fecha en que se modifica


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	/*Funcion para finalizar una alerta*/
	public function actionFinalizar($id)
    {
        $model = $this->findModel($id);
		
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
			
			$model->terminada='1';
            return $this->render('finalizar', [
                'model' => $model,
            ]);
        }
	 }

    /**
     * Deletes an existing Alerta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // Al eliminar una alerta, también se eliminarán todas las imágenes asociadas a la misma.
        AlertaImagen::eliminarTodas($id);
        // -------------------------------------------------------------------------------------
        
        $this->findModel($id)->delete();
		
	$us=Yii::$app->user->identity->id; //solo pueden Borrar alertas nuevas usuarios registrados
		// || $model->crea_usuario_id==Yii::$app->user->identity->id )

        return $this->redirect(['index']);
    }
	
	/*Funcion para acceder a la ficha de la alerta si eres usuario no registrado*/
	
	public function actionFicha($id)
    {
        $model = $this->findModel($id);
		
		
		if($model->terminada == '1' || $model->bloqueada == '1')
		{
			 return $this->render('finblock', [
                'model' => $model,
            ]);
		}
		

        $searchModelAlertaComentarios =  new AlertaComentariosSearch();
        $dataProviderAlertaComentarios = $searchModelAlertaComentarios->ordenarComentariosFechaDesc($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
			
			//$model->bloqueada='1';
            return $this->render('ficha', [
                'model' => $model,
                'idAlerta'=>$id,
                'searchModelAlertaComentarios' => $searchModelAlertaComentarios, //pasamos el searchmodel de nuestros comentarios
                'dataProviderAlertaComentarios' => $dataProviderAlertaComentarios, //Pasamos nuestro dataprovider de los comentarios
            ]);
        }
		
		
    }
	
	
	/*Funcion Bloquear alerta*/
		public function actionBloquear($id)
    {
        $model = $this->findModel($id);
		
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados
		
		$model->bloqueo_usuario_id=Yii::$app->user->identity->id; //usuario que la bloquear	
		$model->bloqueo_fecha= date("Y-m-d H:i:s"); //Fecha en que la bloquea


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
			
			$model->bloqueada='1';
            return $this->render('bloquear', [
                'model' => $model,
            ]);
        }
		
		
		
    }
	
	/*Funcion para contar las denuncias de una alerta*/
		public function actionDenunciar($id)
    {
        $model = $this->findModel($id);
		
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados

		$model->num_denuncias = $model->num_denuncias + 1;
		$model->fecha_denuncia1= date("Y-m-d H:i:s"); //Fecha de la denuncia
		if($model->num_denuncias == 5) //Cuando haya 5 denuncias se bloquea la alerta
		{
			$model->bloqueada='1';
		}
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
			$model->save();
           return $this->redirect(['usuario-incidencias/createdenuncia', 'id'=>$model->id, 'tipo'=>"alerta"]);

        }
		
		
		
    }
	
		/*Funcion para Enlazar con el mantenimiento de imagenes de una alerta*/
		public function actionImagenes($id)
    {
        $model = $this->findModel($id);
		
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
			//$model->save();
		    return $this->render('Mant_imagenes', [
                'model' => $model,
            ]);

        }
		
		
	}
	
	/*Funcion para Enlazar con el mantenimiento de categorias de una alerta*/
		public function actionCategorias($id)
    {
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados

		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity->rol=='A' || Yii::$app->user->identity->rol=='M'))
		{
		$query=Categorias::find()->where(['id'=>$id]);
                $searchModel = new CategoriasSearch();
        if ( isset(Yii::$app->request->get()['CategoriasSearch']['nombre']) && Yii::$app->request->get()['CategoriasSearch']['nombre'] != null)  {
                    $dataProvider=$searchModel->search(Yii::$app->request->get());
        }else{
            $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);
        }
       
        return $this->render('Mant_categorias', [
            'model' => $this->findModel($id),
			'searchModel' =>$searchModel, 
			'dataProvider'=>$dataProvider
        ]);
		}else{
			        $model = $this->findModel($id);

			 return $this->redirect(['view','id' => $model->id]);
		}
		
		
	}
	
		/*Funcion para Enlazar con el mantenimiento del Area de una alerta*/
		public function actionAreas($id,$area_id)
    {
		
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados
	
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity->rol=='A' || Yii::$app->user->identity->rol=='M'))
		{
			$model = $this->findModel($area_id);
		
		 if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id'=>$model->id]);
        } else {
			$model->save();
           return $this->redirect(['area/view', 'id'=>$area_id]);

			}
		}else{
			$model = $this->findModel($id);
			return $this->redirect(['view','id' => $model->id]);
		}
		
	}
	
    /**
     * Finds the Alerta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Alerta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alerta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
