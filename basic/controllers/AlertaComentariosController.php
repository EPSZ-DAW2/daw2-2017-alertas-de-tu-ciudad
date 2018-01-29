<?php

namespace app\controllers;

use Yii;
use app\models\AlertaComentarios;
use app\models\AlertaComentariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ControlAcceso;

/**
 * AlertaComentariosController implements the CRUD actions for AlertaComentarios model.
 */
class AlertaComentariosController extends Controller
{
    /**
     * @inheritdoc
     */
    //Control de accesos
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => ControlAcceso::className(),
                // 'only' => ['index','view','create','update','delete','bloquear'],
                'rules' =>[
                    [
                        //Acciones Permitidas para el administrador
                        'allow'=>true,
                        //Al administrador se le permiten plenos poderes
                        'actions'=>['index','view','create','administrar','update','delete','gestionhilos'],
                        'roles'=>['A'],
                    ],
                    [
                        //Acciones permitidas para el administrador, el usuario normal y el moderador
                        'allow' =>true,
                        'actions' =>['comentar'], //Se le permite comentar a los 3 usuarios
                        'roles' => ['A','N','M'],
                    ],
                    [
                        'allow' =>true,
                        'actions'=>['ajax'],
                        'roles'=> ['?','@'],
                    ]

                ],
            ],
        ];
    }

    /**
     * Función que realiza la acción del index, es decir, devuelve la información referente a los datos del administrador
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaComentariosSearch();//Datos para el Gridview de la vista inicial de la tabla
        $searchModel2 = new AlertaComentariosSearch();//Datos ordenados por fecha de modificación, para mostrar los comentarios en orden
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $idAlerta = "";
        $dataProvider2 = $searchModel2->ordenarComentariosFechaDesc($idAlerta); //Creamos otro data provider para mostrar los datos ordenados por su fehca

        //Renderizado de la vista index con los parámetros necesarios
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'idAlerta' => $idAlerta
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
     * Función que crea un nuevo modelo alertaComentario permitiendo al adminsitrador crear nuevos comentarios
     * Creates a new AlertaComentarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AlertaComentarios(); //Crea un nuevo comentario

        //Si se cargan los parametros del formulario por post y se guardan correctamete entonces
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Se renderiza la información guardada
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //Sino
        else {
            //Se carga de nuevo la página de creación
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionAdministrar()
    {
        $searchModel = new AlertaComentariosSearch();
        $dataProvider = $searchModel->obtenerComentariosPadres("");//Obtienes sólo los datos de los cometarios Raíz

        //Renderiza la vista para la administración de los hilos, la cual sólo contine comentarios padre.
        return $this->render('administrar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Función que actualiza la información de un comentario
     * Updates an existing AlertaComentarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id); //Se encuentra el modelo a través de su id

        //Si se cargan los nuevos parametros del formulario y se guardan de forma correcta
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //se redirige a la vista
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //sino
        else {
            //se vuelve a renderizar update
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Función que realiza el borrado de un comentario
     * Deletes an existing AlertaComentarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete(); //Se encuentra el id que se le pasa por parámetro y se elimina

        return $this->redirect(['index']);
    }

    /**
     * Función que encuentra un modelo y lo devuelve si lo encuentra de forma correta sino devuelve un fallo
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
     * Función que crea un nuevo comentario pasadole un id de la alerta, un comentario padre
     * y la redireccion una vez que secree
     */
    public function actionComentar($idComentarioPadre,$idAlerta,$redireccion)
    {

        $nuevoComentario = new AlertaComentarios(); //Se crea un nuevo modelo comentario
        $nuevoComentario->load(Yii::$app->request->post()); //Se le carga la información que le llega por post(texto)

        $nuevoComentario->alerta_id = $idAlerta; //Se obtiene de la variable que indique en que alerta estamos
        //INFORMACION QUE SE OBTIENE DE SESION
        //Si no está vacia la variable de sesion entonces
        if(!empty($_SESSION["__id"])) {
            $nuevoComentario->crea_usuario_id = $_SESSION["__id"]; //Se obtiene de sesion el id del crea usuario
            $nuevoComentario->modi_usuario_id = $_SESSION["__id"]; //Se obtiene de sesion el id del modiusuario
        }
        //Establecemos la zona horaria para obtener la hora y la fecha
        date_default_timezone_set('Europe/Amsterdam');
        //Obtenemos la hora y fecha actual
        $dateTimeNow = date('Y/m/d H:i:s', time()); //Formato de la hora


        //$nuevoComentario->texto = Se obtiene del formulario
        //$nuevoComentario->id = //Se crea automaticamente con autoincrement en el SQL
        $nuevoComentario->crea_fecha = $dateTimeNow; //Será la fecha de creación
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
    /*
     * Función que bloquea o cierra a los alerta-comentarios dado un padre
     */
    public function actionGestionhilos($id,$accion){

        $modeloPadre = $this->findModel($id); //obtenemos el modelo del padre a través de su id

        //Si el padre existe entonces se recorre buscando los hijos, cerrandolos,abriendolos, bloqueandolos o desbloqueandolos
        if(!empty($modeloPadre)) {

            $searchModel = new AlertaComentariosSearch(); //Se crea un modelo alerta comentario search
            $dataProvider = $searchModel->encontrarComentariosHijos($id); //Se obtiene le data provider con la información de los hijos
            $modelosHijos = $dataProvider->getModels(); //Se obtienen los modelos del os hijos

            //Se recorren los modelos obtenidos realizando la acción
            for ($i = 0; $i < sizeof($modelosHijos); $i++) {
                if (strcmp($accion,'cerrar') == 0) {
                    $modelosHijos[$i]->cerrado = 1;
                }
                if (strcmp($accion,'bloquear') == 0) {
                    $modelosHijos[$i]->bloqueado = 1;
                }
                if (strcmp($accion,'abrir') == 0) {
                    $modelosHijos[$i]->cerrado = 0;
                }
                if (strcmp($accion,'desbloquear') == 0) {
                    $modelosHijos[$i]->bloqueado = 0;
                }

                //Guardamos los datos de los hijos una vez modificados
                $modelosHijos[$i]->save();
                //LLamada recursiva con el siguiente hijo y sus hijos
                $this->actionGestionhilos($modelosHijos[$i]->id,$accion);

            }

            //Ahora realizamos la acción sobre el padre
            if (strcmp($accion,'cerrar') == 0) {
                $modeloPadre->cerrado = 1;
            }
            if (strcmp($accion,'bloquear') == 0) {
                $modeloPadre->bloqueado = 1;
            }
            if (strcmp($accion,'abrir') == 0) {
                $modeloPadre->cerrado = 0;
            }
            if (strcmp($accion,'desbloquear') == 0) {
                $modeloPadre->bloqueado = 0;
            }

            $modeloPadre->save(); //Guardamos la información del padre

        }


        //Redireccionamos a administrar
        return $this->redirect(["administrar"]);
    }
    /*
     * Función que devuelve el comentario al que respondio
     */
    public function actionAjax($id){
        //Si el comentario no es padre devolvemos su informacion
        if($id != 0) {
            if (($model = AlertaComentarios::findOne($id)) !== null) {
                echo '<div class="bubble">';
                echo($model->texto);
                
                echo "<div>";
            }
        }



    }

}
