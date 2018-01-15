<?php

namespace app\controllers;

use Yii;
use app\models\CategoriasEtiquetas;
use app\models\CategoriasEtiquetasSearch;
use app\models\CategoriasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoriasEtiquetasController implements the CRUD actions for CategoriasEtiquetas model.
 */
class CategoriasEtiquetasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CategoriasEtiquetas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriasEtiquetasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CategoriasEtiquetas model.
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
     * Creates a new CategoriasEtiquetas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoriasEtiquetas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CategoriasEtiquetas model.
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
     * Deletes an existing CategoriasEtiquetas model.
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
     * Finds the CategoriasEtiquetas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CategoriasEtiquetas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoriasEtiquetas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	 
	  /**
     * Displays a single CategoriasEtiquetas model.
     * @param string $id
     * @return mixed
     */
    public function actionCatego($id)
    {
		 $searchModel = new CategoriasEtiquetasSearch(['etiqueta_id' => $id]);
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		 
		 
        return $this->render('catego', [
            'model' => $this->findModel($id),
				'datos' => 'prueba',
				'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	
    }
}