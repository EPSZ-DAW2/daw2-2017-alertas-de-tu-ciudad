<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\models\Alerta;
use app\models\Usuarios;
use app\components\ControlAcceso;
use app\models\AlertaComentarios;
use app\models\AlertaComentariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                        'roles'=>['A','M'], //El adminsitrador es igual al moderador pero por zonas
                    ],
                    [
                        //Acciones permitidas para el administrador, el usuario normal y el moderador
                        'allow' =>true,
                        'actions' =>['comentar','modificarcomentario','actualizarcomentario'], //Se le permite comentar a los 3 usuarios
                        'roles' => ['A','N','M'],
                    ],
                    [
                        'allow' =>true,
                        'actions'=>['ajax'],
                        'roles'=> ['?','@'], //las peticiones ajax son validas para todos
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //Renderizado de la vista index con los parámetros necesarios
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AlertaComentarios model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $usuario = new Usuarios();
        $usuario = $usuario::findOne($_SESSION['__id']);
        $comentario = new AlertaComentarios();
        $comentario = $comentario::findOne($id);
        $alerta = new Alerta();
        $alerta = $alerta::findOne($comentario->alerta_id);

        //Vamos acontrolar que el moderador solo pueda ver los comentarios de su zona
        if( $usuario->rol =='M' && strcmp($usuario->area_id ,$alerta->area_id) !=0){
            throw new  \yii\web\HttpException(401, 'EL moderador no tiene acceso para comentarios de esa zona');
        }

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
        //Establecemos la zona horaria para obtener la hora y la fecha
        date_default_timezone_set('Europe/Amsterdam');
        //Obtenemos la hora y fecha actual
        $dateTimeNow = date('Y/m/d H:i:s', time()); //Formato de la hora
        if($dateTimeNow === false ) $dateTimeNow = null; // Si se desconoce la hora y fecha de creacion ponemos a falso el valor

        $model->crea_fecha = $dateTimeNow; //Será la fecha de creación
        $model->modi_fecha = $model->crea_fecha; //En un primer momento la fecha de modificacion es igual a la de creacion
        $model->comentario_id = 0; //Id padre iniciado en 0

        $model->fecha_denuncia1 = 0; //Fecha denuncia1 se inicia 0
        $model->bloqueo_fecha = 0; //la fecha de bloqueo inciial es 0
        $model->bloqueo_notas = "0"; //la nota incial es 0 o null**/
        $model->modi_usuario_id = 0; //Ponemos a 0 porque lo modifica un administrador
        $model->crea_usuario_id = 0; //Ponemos a 0 porque lo crea un administrador

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

    /*
     * Función que muestra la adminsistración de los hilos
     */
    public function actionAdministrar()
    {
        $searchModel = new AlertaComentariosSearch();
        $dataProvider = $searchModel->obtenerComentariosPadres(Yii::$app->request->queryParams);//Obtienes sólo los datos de los cometarios Raíz

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
        $usuario = new Usuarios();
        $usuario=$usuario::findOne($_SESSION["__id"]);

        $comentario = new AlertaComentarios();
        $comentario = $comentario::findOne($id);
        $alerta = new Alerta();
        $alerta = $alerta::findOne($comentario->alerta_id);

        //Vamos acontrolar que el moderador solo pueda actaulizar los comentarios de su zona
        if( $usuario->rol =='M' && strcmp($usuario->area_id ,$alerta->area_id) !=0){
            throw new  \yii\web\HttpException(401, 'EL moderador no tiene acceso para comentarios de esa zona');
        }

        $model = $this->findModel($id); //Se encuentra el modelo a través de su id
        //Actualizar fecha de modificacion
        //Establecemos la zona horaria para obtener la hora y la fecha
        date_default_timezone_set('Europe/Amsterdam');
        //Obtenemos la hora y fecha actual
        $dateTimeNow = date('Y/m/d H:i:s', time()); //Formato de la hora

        $model->modi_fecha = $dateTimeNow;
        $model->modi_usuario_id = 0; //Se pone a 0 por haberse hecho por un administrador

        $bloqueoEstadoAnterior = $model->bloqueado; //Nos dice el estado antes de guardar los parametros post

        //Si se cargan los nuevos parametros del formulario y se guardan de forma correcta
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Si el bloqueo del estado anterior es 0 y el actual es distinto de 0 entoncesse rellena la nota con bloqueado
            if($bloqueoEstadoAnterior == 0
                && $model->bloqueado != 0
                && 0 == strcmp($model->bloqueo_notas,"0")){
                //Se fija la fecha/hora en la que se aha realizado el bloqueo
                $model->bloqueo_fecha = $dateTimeNow;
                //Fija en el texto de comentario notas que está bloqueado por defecto
                $model->bloqueo_notas = "bloqueado";
                //Se guarda el id de la persona que lo ha modificado
                $model->bloqueo_usuario_id = $usuario->id;
                $model->save();

            }
            //Accion contraria a lo anterior
            if($bloqueoEstadoAnterior != 0
                && $model->bloqueado == 0
            ){

                $model->bloqueo_fecha = '0000-00-00 00:00:00';
                //Fija en el texto de comentario notas que está bloqueado por defecto
                $model->bloqueo_notas = "0";
                //Al desbloquear quitamos la persona que bloqueo
                $model->bloqueo_usuario_id = '0';
                $model->save();
            }
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
        $usuario = new Usuarios();
        $usuario = $usuario::findOne($_SESSION['__id']);
        $comentario = new AlertaComentarios();
        $comentario = $comentario::findOne($id);
        $alerta = new Alerta();
        $alerta = $alerta::findOne($comentario->alerta_id);

        //Vamos acontrolar que el moderador solo pueda actaulizar los comentarios de su zona
        if( $usuario->rol =='M' && strcmp($usuario->area_id ,$alerta->area_id) !=0){
            throw new  \yii\web\HttpException(401, 'EL moderador no tiene acceso para comentarios de esa zona');
        }

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
        //Evitar comentar en un comentario que este bloqueado o cerrado
        if($idComentarioPadre != 0) {
            //Obtenemos los atributos del comentario padre para saber si esta cerrado  o bloqueado
            $comentarioPadre = new AlertaComentarios();
            $comentarioPadre = $comentarioPadre::findOne($idComentarioPadre);

            if ($comentarioPadre->bloqueado != 0 || $comentarioPadre->cerrado == 1) {
                throw new \yii\web\HttpException(401, 'No puedes comentar un mensaje bloqueado o cerrado');
            }
        }

        $nuevoComentario = new AlertaComentarios(); //Se crea un nuevo modelo comentario
        $nuevoComentario->load(Yii::$app->request->post()); //Se le carga la información que le llega por post(texto)

        $nuevoComentario->alerta_id = $idAlerta; //Se obtiene de la variable que indique en que alerta estamos
        //INFORMACION QUE SE OBTIENE DE SESION
        //Si no está vacia la variable de sesion entonces

        $nuevoComentario->crea_usuario_id = $_SESSION["__id"]; //Se obtiene de sesion el id del crea usuario
        $nuevoComentario->modi_usuario_id = $_SESSION["__id"]; //Se obtiene de sesion el id del modiusuario

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
        $nuevoComentario->fecha_denuncia1 = 0; //En un primer momento si no hay denuncia no hay fecha de denuncia
        $nuevoComentario->bloqueado = 0; //Comienza en desbloquedo
        $nuevoComentario->bloqueo_usuario_id = 0; //No pose usuarios bloqueados
        $nuevoComentario->bloqueo_fecha = 0; //No tiene la fecha de bloqueo
        $nuevoComentario->bloqueo_notas = "0"; //No tiene notas


        //Guardamos el nuevo comentario en bases de datos
        $nuevoComentario->save();
        $redireccion = $redireccion."#cPublicado".$nuevoComentario->id;
        //Redirigimos al index
        return $this->redirect([$redireccion]);

    }
    /*
     * Función que bloquea o cierra a los alerta-comentarios dado un padre
     */
    public function actionGestionhilos($id,$accion){

        $usuario = new Usuarios();
        $usuario = $usuario::findOne($_SESSION["__id"]);
        $modelComentario = new AlertaComentarios();
        $modelComentario = $modelComentario::findOne($id);

        $alerta = new Alerta();
        $alerta = $alerta::findOne($modelComentario->alerta_id);
        //Vamos acontrolar que el moderador solo pueda gestionar los comentarios de su zona
        if( $usuario->rol =='M' && strcmp($usuario->area_id ,$alerta->area_id) !=0){
            throw new  \yii\web\HttpException(401, 'EL moderador no tiene acceso para comentarios de esa zona');
        }

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

                    $modelosHijos[$i]->bloqueo_usuario_id = $usuario->id;
                    //Ponemos un valor en los hijos atendiendo a quien los bloquee
                    if($usuario->rol == 'A')
                        $modelosHijos[$i]->bloqueado = 2;
                    if($usuario->rol == 'M')
                        $modelosHijos[$i]->bloqueado = 3;

                    $modelosHijos[$i]->bloqueo_notas = 'bloqueado';
                }
                if (strcmp($accion,'abrir') == 0) {
                    $modelosHijos[$i]->cerrado = 0;
                }
                if (strcmp($accion,'desbloquear') == 0) {
                    $modelosHijos[$i]->bloqueado = 0;
                    $modelosHijos[$i]->bloqueo_notas = '0';
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

                $modeloPadre->bloqueo_usuario_id = $usuario->id;
                //Ponemos un valor en los hijos atendiendo a quien los bloquee

                if($usuario->rol == 'A')
                    $modeloPadre->bloqueado = 2;
                if($usuario->rol == 'M')
                    $modeloPadre->bloqueado = 3;

                    $modeloPadre->bloqueo_notas = 'bloqueado';

            }
            if (strcmp($accion,'abrir') == 0) {
                $modeloPadre->cerrado = 0;
            }
            if (strcmp($accion,'desbloquear') == 0) {
                $modeloPadre->bloqueado = 0;
                $modeloPadre->bloqueo_notas = '0';
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
                echo '<h4 class="AjaxIdpadre">#'.$id.'</h4>';
                echo($model->texto);


                echo "<div>";
            }
        }

    }
    /*
     * Función que que muestra el comentario del usuario para poder modificarlo
     */
    public function actionModificarcomentario($id){

        $modelComentario = AlertaComentarios::findOne($id);
        $alerta = new Alerta();
        $alerta = $alerta::findOne($modelComentario->alerta_id);
        $usuario = new Usuarios();
        $usuario = $usuario::findOne($_SESSION["__id"]);
        //Si el usuario es moderador y esta en su area puede modificar cualquier comentario de su area
        //O
        //Si el usuario es administrador puede modificar cualquier comentario
        //O
        //Si el usuario inscribio el comentario tambien puede modificarlo
        if( ($usuario->rol =='M' && strcmp($usuario->area_id ,$alerta->area_id) ==0)
            || $usuario->rol == 'A'
            ||($usuario->id == $modelComentario->crea_usuario_id)
        ){

            return $this->render("modificarComentarioForm",["model"=>$modelComentario]);
        }
        //Cuando intenten modificar un comentario que no es el suyo
        else{
            throw new \yii\web\HttpException(401, 'No tienes permisos para modificar ese comentario');
        }

    }
    /*
     * Función que actualiza los datos modificados de los comentarios
     */
    public function actionActualizarcomentario($id){

        $model = $this->findModel($id); //Se encuentra el modelo a través de su id
        //Actualizar fecha de modificacion
        //Establecemos la zona horaria para obtener la hora y la fecha
        date_default_timezone_set('Europe/Amsterdam');
        //Obtenemos la hora y fecha actual
        $dateTimeNow = date('Y/m/d H:i:s', time()); //Formato de la hora

        $model->modi_fecha = $dateTimeNow;
        $model->modi_usuario_id = $_SESSION["__id"];



        //Si se cargan los nuevos parametros del formulario y se guardan de forma correcta
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['/alertas/ficha', 'id' => $model->alerta_id]);
        }
        //sino
        else {
            //se vuelve a renderizar update
            return $this->render('', [
                'model' => $model,
            ]);
        }
    }

}
