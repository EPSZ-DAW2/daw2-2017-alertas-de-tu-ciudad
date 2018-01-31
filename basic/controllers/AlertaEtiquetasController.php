<?php

namespace app\controllers;

use Yii;
use app\models\AlertaEtiquetas;
use app\models\Alerta;
use app\models\AlertaEtiquetasSearch;
use app\components\ControlAcceso;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlertaEtiquetasController implements the CRUD actions for AlertaEtiquetas model.
 */
class AlertaEtiquetasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => ControlAcceso::className(),
                'only' => ['view','create','update','delete','index','catego','alerquetas'],
                'rules' => [
                    [
                        'actions' => ['update','delete','index','view'],
                        'allow' => true,
                        'roles' => ['A'],
                    ],
					[
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['A','M','N'],
                    ],
                    [
                        'actions' => ['catego','alerquetas'],
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
     * Lists all AlertaEtiquetas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaEtiquetasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AlertaEtiquetas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AlertaEtiquetas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AlertaEtiquetas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Crea una nueva relación entre etiqueta y alerta y redirecciona al modelo de la alerta.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAnadir($id)
    {
		$model = new AlertaEtiquetas();
		$modelo = new Alerta();
		$model->alerta_id=$id;
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['alertas/view', 'id' => $id]);
		} else {
			return $this->render('anadir', [
				 'model' => $model,
				 'id' => $id,
			]);
		}
    }

    /**
     * Updates an existing AlertaEtiquetas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AlertaEtiquetas model.
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
     * Finds the AlertaEtiquetas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AlertaEtiquetas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AlertaEtiquetas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
