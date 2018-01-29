<?php

namespace app\controllers;

use Yii;
use app\components\ControlAcceso;
use app\models\Categorias;
use app\models\CategoriasSearch;
use app\models\Alerta;
use yii\data\ActiveDataProvider;
use app\models\AlertaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rbac\Rule;
use app\models\Usuario;

/**
 * CategoriasController implements the CRUD actions for Categorias model.
 */
class CategoriasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => ControlAcceso::className(),
                // 'only' => ['view','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['A'],
                    ],
                    [
                        'actions' => ['view','index'],
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
     * Lists all Categorias models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $searchModel = new CategoriasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        (isset(Yii::$app->user->identity->rol))?$rol=Yii::$app->user->identity->rol:$rol=NULL;
        (isset($rol) && $rol === 'A')? $template='{view} {update} {delete}':$template='{view}';
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template' => $template,
            'rol' => $rol,
        ]);
    }

    /**
     * Displays a single Categorias model.
     * @param string $id
     * @return mixed
     */

    public function actionView($id)
    {
        $query=Alerta::find()->where(['categoria_id'=>$id]);
                $searchModel = new AlertaSearch();
        if ( isset(Yii::$app->request->get()['AlertaSearch']['titulo']) && Yii::$app->request->get()['AlertaSearch']['titulo'] != null)  {
                    $dataProvider=$searchModel->search(Yii::$app->request->get());
        }else{
            $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);
        }
       
        return $this->render('view', [
            'model' => $this->findModel($id),'searchModel' =>$searchModel, 'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Creates a new Categorias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categorias();
        $searchModel = new CategoriasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,'searchModel' =>$searchModel, 'dataProvider'=>$dataProvider
            ]);
        }
    }

    /**
     * Updates an existing Categorias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new CategoriasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,'dataProvider' =>$dataProvider
            ]);
        }
    }

    /**
     * Deletes an existing Categorias model.
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
     * Finds the Categorias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Categorias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categorias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
}
