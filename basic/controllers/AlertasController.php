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
                'only' => ['view','create','update','delete','finalizar','ficha', 'bloquear','denunciar'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','finalizar','view','bloquear','ficha','denunciar'],
                        'allow' => true,
                        'roles' => ['A','M','N'],
                    ],
                    [
                        'actions' => ['ficha'],
                        'allow' => true,
                        'roles' => ['A','M','N','?'],
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
		$us=Yii::$app->user->identity->id; //solo pueden Finalizar alertas nuevas usuarios registrados

        return $this->render('view', [
            'model' => $this->findModel($id),
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
        $this->findModel($id)->delete();
		
		$us=Yii::$app->user->identity->id; //solo pueden Borrar alertas nuevas usuarios registrados


        return $this->redirect(['index']);
    }
	
	/*Funcion para acceder a la ficha de la alerta si eres usuario no registrado*/
	
	public function actionFicha($id)
    {
        $model = $this->findModel($id);

        $searchModelAlertaComentarios =  new AlertaComentariosSearch();
        $dataProviderAlertaComentarios = $searchModelAlertaComentarios->ordenarComentariosFechaDesc($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
			
			//$model->bloqueada='1';
            return $this->render('ficha', [
                'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
			if($model->num_denuncias >= 5){
			$model->bloqueada='1';}
            return $this->render('denunciar', [
                'model' => $model,
            ]);
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
