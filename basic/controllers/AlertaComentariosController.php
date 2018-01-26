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
            'dataProvider2' => $dataProvider2
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
    public function actionComentar($idComentarioPadre,$idAlerta,$redireccion)
    {
        //COMENTARIOS RELLENAR LA INFORMACION DEL USUARIO QUE VA A COMENTAR

        $nuevoComentario = new AlertaComentarios();
        $nuevoComentario->load(Yii::$app->request->post());

        $nuevoComentario->alerta_id = $idAlerta; //Se obtiene de la variable que indique en que alerta estamos
        //INFORMACION QUE SE OBTIENE DE SESION
        if(!empty($_SESSION["__id"])) {
            $nuevoComentario->crea_usuario_id = $_SESSION["__id"]; //Se obtiene de sesion
            $nuevoComentario->modi_usuario_id = $_SESSION["__id"]; //Se obtiene de sesion
        }
        //Establecemos la zona horaria
        date_default_timezone_set('Europe/Amsterdam');
        //Obtenemos la hora y fecha actual
        $dateTimeNow = date('Y/m/d h:i:s', time());

        //INFORMACIÓN YA ALMACENADA DEL COMENTARIO

        //$nuevoComentario->texto = Se obtiene del formulario
        //$nuevoComentario->id = //Se crea automaticamente con autoincrement en el SQL
        $nuevoComentario->crea_fecha = $dateTimeNow;
        $nuevoComentario->modi_fecha = $nuevoComentario->crea_fecha; //En un primer momento la fecha de modificacion es igual a la de creacion
        $nuevoComentario->comentario_id = $idComentarioPadre; //Metemos el padre al que responde
        $nuevoComentario->cerrado = 0; //Comienza en abierto
        $nuevoComentario->num_denuncias = 0; //En un primer momento no hay denuncias
        $nuevoComentario->fecha_denuncia1 = null; //En un primer momento si no hay denuncia no hay fecha de denuncia
        $nuevoComentario->bloqueado = 0; //Comienza en desbloquedo
        $nuevoComentario->bloqueo_usuario_id = null; //No pose usuarios bloqueados
        $nuevoComentario->bloqueo_fecha = null; //No tiene la fecha de bloqueo
        $nuevoComentario->bloqueo_notas = null; //No tiene notas


        //Guardamos el nuevo comentario en bases de datos
        $nuevoComentario->save();

        //Redirigimos al index
        return $this->redirect([$redireccion]);

    }


}
