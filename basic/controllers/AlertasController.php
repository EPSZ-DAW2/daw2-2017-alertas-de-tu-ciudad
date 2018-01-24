<?php

namespace app\controllers;

use Yii;
use app\models\Alerta;
use app\models\AlertaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AlertasController implements the CRUD actions for Alerta model.
 */
class AlertasController extends Controller
{
    /**
     * @inheritdoc
	 * Controlar los usuarios que pueden crear, modificar o borrar
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view','create','update','delete','finalizar','viewUsuario'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','finalizar','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
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
	
	public function actionIndexadmin()
    {
        $searchModel = new AlertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexAdmin', [
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionViewusuario($id)
    {
        return $this->render('viewUsuario', [
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
