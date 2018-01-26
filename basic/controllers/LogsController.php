<?php

namespace app\controllers;

use Yii;
use app\components\ControlAcceso;
use app\models\Logs;
use app\models\LogsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogsController implements the CRUD actions for Logs model.
 */
class LogsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
		
			'access' => [
                        'class' => ControlAcceso::className(),
                        'only' => ['index','create','view','delete'],
                        'rules' => [
							[
							    'actions' => ['create'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
						
                            // allow admin users
                            [
							    'actions' => ['index','view','delete'],
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
     * Lists all Logs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Logs model.
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
	para generar un log nuevo sólo hay que introducir la siguiente línea desde cualquier lugar de la aplicación
	lógicamente, al ser un return ha de ser la ultima linea
	  return $this->redirect(array("logs/create?codigo=elcodigoquesequiera&modulo=elmoduloquelogenera&texto=elqtextoquesequiera"));
	  modulo y texto pueden ser cadenas vacias
	  la otra alternativa es que se use la clase del modelo
     */
   public function actionCreate($codigo, $modulo, $texto)
    {
		//se prodria comprobar el $codigo en en función de el tipo de log hacer control de roles
        $model = new Logs();
		$model->crea_fecha= date("Y-m-d H:i:s");
		$model->clase_log_id=$codigo;
		$model->modulo=$modulo;
		$model->texto=$texto;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing Logs model.
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
     * Deletes an existing Logs model.
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
     * Finds the Logs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Logs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Logs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
