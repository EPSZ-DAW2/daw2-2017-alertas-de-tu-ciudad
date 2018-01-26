<?php

namespace app\controllers;

use Yii;
use app\models\AlertaComentarios;
use app\models\AlertaComentariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlertaComentariosController implements the CRUD actions for AlertaComentarios model.
 */
class AlertaComentariosController extends Controller
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
     * Lists all AlertaComentarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaComentariosSearch();
        $searchModel2 = new AlertaComentariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2 = $searchModel2->ordenarComentariosFechaDesc("");
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Displays a single AlertaComentarios model.
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
     * Creates a new AlertaComentarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AlertaComentarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AlertaComentarios model.
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
     * Deletes an existing AlertaComentarios model.
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
     * Finds the AlertaComentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AlertaComentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AlertaComentarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Función que crea un nuevo comentario pasadole un id de la alerta
     */
    public function actionComentar($idComentarioPadre)
    {
        //COMENTARIOS RELLENAR LA INFORMACION DEL USUARIO QUE VA A COMENTAR
        $nuevoComentario = new AlertaComentarios();
        $nuevoComentario->load(Yii::$app->request->post());

        //$nuevoComentario->id = 1;
        $nuevoComentario->alerta_id = 1; //Se obtiene de la variable que indique en que alerta estamos
        $nuevoComentario->crea_usuario_id = 3;//Se obtiene de sesion

        //Establecemos la zona horaria
        date_default_timezone_set('Europe/Amsterdam');
        //Obtenemos la hora y fecha actual
        $dateTimeNow = date('Y/m/d h:i:s', time());

        $nuevoComentario->crea_fecha = $dateTimeNow;
        // $nuevoComentario->modi_usuario_id = //Se obtiene de sesion
        // $nuevoComentario->modi_fecha = //Se obtiene de la sesion
        //$nuevoComentario->texto = Se obtiene del forumlario

        $nuevoComentario->comentario_id = $idComentarioPadre;

        //Cuando le das a responder que pase una variable por get de hacia quien va la respuesta
        $nuevoComentario->cerrado = 0;
        $nuevoComentario->num_denuncias = 0;
        $nuevoComentario->fecha_denuncia1 = null;
        $nuevoComentario->bloqueado = 0;
        $nuevoComentario->bloqueo_usuario_id = null;
        $nuevoComentario->bloqueo_fecha = null;
        $nuevoComentario->bloqueo_notas = null;


        //Guardamos el nuevo comentario en bases de datos
        $nuevoComentario->save();

        return $this->redirect(['index']);

    }


}
