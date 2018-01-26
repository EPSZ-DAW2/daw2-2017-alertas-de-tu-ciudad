<?php

namespace app\controllers;

use Yii;
use app\components\ControlAcceso;
use app\models\Configuraciones;
use app\models\ConfiguracionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfiguracionesController implements the CRUD actions for Configuraciones model.
 */
class ConfiguracionesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
		
			'access' => [
                        'class' => ControlAcceso::className(),
                        'only' => ['index','create','update','delete'],
                        'rules' => [
                            // allow admin users
                            [
							    'actions' => ['index','create','update','delete'],
                                'allow' => true,
                                'roles' => ['A'],
                            ],
                            // everything else is denied
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
     * Lists all Configuraciones models.
     * @return mixed
     */
    public function actionIndex()
    {
		if(Yii::$app->user->identity==NULL){
			return $this->redirect('index.php?r=site/login');
		}else{
			
			$searchModel = new ConfiguracionesSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->pagination->pageSize=15;
			$numeropaginas=Configuraciones::findOne("numero_lineas_pagina");
			if($numeropaginas and $numeropaginas->valor>0){
				$dataProvider->pagination->pageSize=$numeropaginas->valor;
			}
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}
    }

   

    /**
     * Creates a new Configuraciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Configuraciones();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Configuraciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Configuraciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Configuraciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Configuraciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Configuraciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
