<?php

namespace app\controllers;

use Yii;
use app\models\AlertaImagen;
use app\models\Alerta;
use app\models\AlertaImagenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use app\components\ControlAcceso;
use yii\helpers\Url;
use yii\data\Pagination;

/**
 * AlertaImagenesController implements the CRUD actions for AlertaImagen model.
 */
class AlertaImagenesController extends Controller
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
            
            'access' => [
            'class' => ControlAcceso::className(),
            'only' => ['index','view','create','update','delete','revisar','imagenrevisar','ordenar'],
            'rules' =>[ 
                [
                'allow'=>true,
                'actions'=>['create','update', 'delete','ordenar'],
                'roles'=>['N'],
                ],
                [
                'allow'=>true,
                'actions'=>['index','view','create','update','delete','revisar', 'imagenrevisar', 'ordenar'],
                'roles'=>['A','M'],
                ],
            ],
         ],
        ];
    }

    /**
     * Lists all AlertaImagen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaImagenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionOrdenar()
    {
         if(Yii::$app->user->isGuest)
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
        if(!isset(Yii::$app->user->identity->rol))
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
        $ids = Yii::$app->request->post('ids');
        
        if(!isset($ids))
          return $this->EnviarMensajeError(new AlertaImagen(), '¡ERROR! IDS malformadas.', Yii::$app->request->referrer, true);
        
        $model = $this->findModel($ids[0]);
        
        $alerta = $model->alerta_id;
        $usuario_id = Yii::$app->user->getId();
        
        if(Yii::$app->user->identity->rol === 'N' || Yii::$app->user->identity->rol === 'M')
         {
             $modelo_alerta= Alerta::findOne($alerta);

             if(!isset($modelo_alerta) || $modelo_alerta->crea_usuario_id != $usuario_id)
                 return $this->EnviarMensajeError(new AlertaImagen(), '¡ERROR! No puedes ordenar imagenes de otra persona.', Yii::$app->request->referrer, true);
         }
        
        for($i=0; $i<count($ids); $i++)
        {
            $im = $this->findModel($ids[$i]);
            
            if($im->alerta_id != $alerta)
                continue;
            
            $im->orden = $i;
            $im->save();
        }
        
        $this->FijarImagenEnAlerta($alerta);
     // return $this->redirect(Yii::$app->request->referrer ?: 'index');
    }
    
    public function actionRevisar($opv=1, $vis=0)
    {
        $searchModel = new AlertaImagenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        switch($opv)
        {
            case 2:
               // Ultimos 7 dias
                $ultimosDias = mktime(0, 0, 0, date("m")  , date("d")-7, date("Y"));  
                $dataProvider->query->andWhere( 'DATE_FORMAT([[crea_fecha]], \'%Y-%m-%d\') BETWEEN \''.date("Y",$ultimosDias).'-'.date("m",$ultimosDias).'-'.date("d",$ultimosDias).'\' AND \''.date("Y").'-'.date("m").'-'.date("d").'\'');
                break;
            case 3:
                $dataProvider->query->andWhere(['imagen_revisada' => 0]);
                break;
            case 4:
                $dataProvider->query->andWhere('[[notas_admin]] IS NOT NULL AND [[notas_admin]] NOT IN ("")');
                break;
        }

        if($vis == 1)
        {
            $countQuery = clone $dataProvider->query;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $models = $dataProvider->query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render('revisar', [
                 'models' => $models,
                 'pages' => $pages,
            ]);
        }
        
        
        return $this->render('revisar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionImagenrevisar($id, $change = false)
    {
        if(Yii::$app->user->isGuest)
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
        if(!isset(Yii::$app->user->identity->rol))
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
        if(Yii::$app->user->identity->rol !== 'A')
          return $this->EnviarMensajeError(new AlertaImagen(), '¡ERROR! Debes ser administrador.', Yii::$app->request->referrer, true);
        
        
         $model = $this->findModel($id);
        
        if(!$change)
        {
            if($model->imagen_revisada == 0)
            {          
                $model->imagen_revisada = 1;   
                $model->save();
            }
        }
        
        $modelo_alerta= Alerta::findOne($model->alerta_id);
        
        if($modelo_alerta->imagen_id == $model->imagen_id)
        {
            $modelo_alerta->imagen_revisada = 1;
            $modelo_alerta->save();
        }
        
        
        $url = Url::previous();
             
        if(!isset($url))
         $url= Yii::$app->request->referrer;
             
        return $this->redirect($url ?: 'index');                 
        
    }
    
    
    /**
     * Displays a single AlertaImagen model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /***
     * Acción encargada de controlar la vista de subida de varias imagenes.
     * 
     * Debe ir e una función a parte, pues no será lo mismo crear un único registro para
     * una única imagen que para varias al mismo tiempo.
     */
    public function actionCreate($a_id=null)
    { 
        if(Yii::$app->user->isGuest)
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
        if(!isset(Yii::$app->user->identity->rol))
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
       $model = new AlertaImagen();

        $privilegios = false;
       //Si accede sin acceso directo, por id específica DEBE ser administrador.
       if(!isset($a_id) && Yii::$app->user->identity->rol === 'A')
       {
              $privilegios = true;    
       }
       else if(!isset($a_id) && Yii::$app->user->identity->rol !== 'A')
           return $this->EnviarMensajeError(new AlertaImagen(), '¡No tienes permisos para hacer esto!', Yii::$app->request->referrer, true);
           
         //Habría que comprobar el moderador. En el caso de que tuviera permisos para las imagenes.
        if (Yii::$app->user->identity->rol === 'A')
        {
                $privilegios = true;                    
        }             
        
        $usuario_id = Yii::$app->user->getId();

        //Habría que ver si permitimos crear a un moderador, supuestamente
        //debería tener permisos para la sección de imágenes.
        if (isset($a_id) && !$privilegios && (Yii::$app->user->identity->rol === 'N' || Yii::$app->user->identity->rol === 'M'))
         {
             $modelo_alerta= Alerta::findOne($a_id);

             if(!isset($modelo_alerta) || $modelo_alerta->crea_usuario_id != $usuario_id)
                 return $this->EnviarMensajeError(new AlertaImagen(), '¡No puedes agregar imágenes en la alerta de otro usuario!', Yii::$app->request->referrer, true);
         }
       
          
       //Accederemos siempre que se intente subir una imagen desde el input.
       //Es decir, siempre que que se produzca un submit.
       if (isset($_FILES['explorar_ficheros']))
       {        
            //Esto se podría cambiar por una variable en la configuración.
            $carpeta_subida_imagenes = "uploads";
            $extensiones_permitidas = $model::$extensiones_permitidas;
                
            //Numero total de imagenes subidas.
            //En el caso de que el input file este vacio, nos dirá que hay 1.
            //Por lo cual hay que comprobar su existencia en el bucle de comprobación
            // de más abajo.
            $total = count($_FILES['explorar_ficheros']['name']);
                
                
            // Realizamos un primer bucle para comprobar el estado de todas las imagenes.
            //Si alguna falla, detendremos la subida de todas ellas.
            $error = false;
            $code = UPLOAD_ERR_OK;
             for($i=0; $i<$total; $i++) 
             {
                 if($this->codigoErrorUpload($_FILES['explorar_ficheros']['error'][$i]))
                 {
                     $error = true;
                     $code = $_FILES['explorar_ficheros']['error'][$i];
                     break;
                 }
                 
                 $nombre_imagen = basename($_FILES['explorar_ficheros']['name'][$i]);
                 $extension_imagen = pathinfo(strtolower($nombre_imagen), PATHINFO_EXTENSION);
                            
                    if (!in_array($extension_imagen, $extensiones_permitidas))
                    {
                        $error = true;
                        $code = UPLOAD_ERR_EXTENSION;
                        break;
                    }   
             }   
                
             //En el caso de que exista un error al intentar subir las imagenes, volvemos
             //a la view en la que estabamos, pasándole el mensaje de error oportuno.
             if($error)
               return $this->EnviarMensajeError(new AlertaImagen(), $this->mensajeErrorUpload($code),'create');

                          
                $model->load(Yii::$app->request->post());
                //Esta alerta servira para todas las imagenes.

                 if(!isset($a_id))
                    $alerta_id = $model->alerta_id;
                 else $alerta_id = $a_id;

                $fecha = date("Y-m-d H:i:s"); // La fecha actual.

                $modelo_orden_ultimo = AlertaImagen::find()->tomarImagenesDesdeAlertaDESC($alerta_id)->one();
                $orden = $modelo_orden_ultimo->orden+1;
                
             // En el caso de que no se haya producido un error, procedemos a sacar las imagenes
             //de la carpeta temporal y crear los registros en la base de datos.
             for($i=0; $i<$total; $i++) 
             {
                $model = new AlertaImagen();
                $nombre_imagen = basename($_FILES['explorar_ficheros']['name'][$i]);
		$fichero_temporal = $_FILES['explorar_ficheros']['tmp_name'][$i];
		$extension_imagen = pathinfo(strtolower($nombre_imagen), PATHINFO_EXTENSION);
                            
                $UUID = $model::Obtener_Imagen_UUID();               
                $hashes = explode("-", $UUID);
                $ruta = "";

                if($privilegios)
                 $model->imagen_revisada = 1;
                
                $model->alerta_id = $alerta_id;
                $model->orden = $orden;
                $model->imagen_id = $UUID;          
                $model->crea_usuario_id = $usuario_id; 
                $model->crea_fecha = $fecha; 
                $model->modi_usuario_id = null; //Estamos creando, no modificando.
                $model->modi_fecha = null;  //Estamos creando, no modificando.
                $model->notas_admin = null; //Suponemos que al admin podra notas al editar una imagen.       
  

                for($h=count($hashes)-1; $h >= 1; $h--)
                {
                    $ruta .= "/$hashes[$h]";
                }
                
                $ruta = $carpeta_subida_imagenes.$ruta;
     
                 //En caso de que no exista la ruta, la creamos.
                if ( !is_dir($ruta)) {
                   mkdir($ruta, 0700, true);
                 }
                
                 //Agregamos el nombre del fichero al final.
               $ruta .= '/'.$hashes[0].'.'.$extension_imagen;

                if(!move_uploaded_file($fichero_temporal, $ruta))
                   return $this->EnviarMensajeError(new AlertaImagen(), $this->mensajeErrorUpload(UPLOAD_ERR_CANT_WRITE), 'create');
                
                $model->save();
                $orden = $orden + 1;//No está del todo implementado.     
 
             }
             
           $this->FijarImagenEnAlerta($a_id);
             
             $url = Url::previous();
             
             if(!isset($url))
                $url= Yii::$app->request->referrer;
             
            return $this->redirect($url ?: 'index');     
       }

       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Nunca debería llegar
        } else {
            return $this->render('create', [
                'model' => $model,
                'permisos' =>$privilegios,
                
            ]);
        }
    }

   
    private function EnviarMensajeError($model, $mensajeError, $return, $redirect=false)
    {
        $model->load(Yii::$app->request->post());

        Yii::$app->getSession()->setFlash('error', 'ERROR: '. $mensajeError);

        if($redirect)
              return $this->redirect($return ?: 'index');
        
        return $this->render($return, [
        'model' => $model,
    ]);   
    }  
    
    
    /**
     * Comprueba si existe algun error con el código de la imagen dada
     * FALSE = No hay errores.    TRUE = Existe algún error.
     * @param type $code
     * @return boolean
     */
    private function codigoErrorUpload($code)
    {
          if($code === UPLOAD_ERR_OK)
              return false;
          
        return true;     
    }  
    
    /**
     * Muestra el mensaje de error dependiendo del error dado por la imagen.
     * @param type $code
     * @return string
     */
    private function mensajeErrorUpload($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "Alguna imagen supera el límite máximo permitido.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "Superado el límite MAX_FILE_SIZE marcado por la directiva HTML.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "Solo se pudo subir parcialmente.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No se ha seleccionado ninguna imagen para subir.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "No se ha encontrado la carpeta temporal.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "No se pudo escribir en el disco.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "La extensión de la imagen no es correcta.";
                break;

            default:
                $message = "Se produjo un error desconocido.";
                break;
        }
        return $message;
    }
 
    
    
    /**
     * Updates an existing AlertaImagen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {        
         if(Yii::$app->user->isGuest)
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
        if(!isset(Yii::$app->user->identity->rol))
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
       $model = $this->findModel($id);
       
       if(!isset($model))
           return $this->redirect(Yii::$app->request->referrer ?: 'index');
       
        $usuario_id = Yii::$app->user->getId();

        //Habría que ver si permitimos crear a un moderador, supuestamente
        //debería tener permisos para la sección de imágenes.
        if (Yii::$app->user->identity->rol === 'N' || Yii::$app->user->identity->rol === 'M')
         {
             if($model->crea_usuario_id != $usuario_id)
                 return $this->EnviarMensajeError(new AlertaImagen(), '¡No puedes modificar imágenes que no sean tuyas!', Yii::$app->request->referrer, true);
         }
         
          
       //Accederemos siempre que se intente subir una imagen desde el input.
       //Es decir, siempre que que se produzca un submit.
       if (isset($_FILES['explorar_ficheros']))
       {                 
            $extensiones_permitidas = $model::$extensiones_permitidas;
                
            //Numero total de imagenes subidas.
            $total = count($_FILES['explorar_ficheros']['name']);
            
            if($total > 2)
                return $this->EnviarMensajeError($model, 'Debe introducir solamente una imagen.','update');
            
             $code = $_FILES['explorar_ficheros']['error'];
             $imagen_subida = true;
             
             if($this->codigoErrorUpload($code))
             {
                 if($code != UPLOAD_ERR_NO_FILE)
                    return $this->EnviarMensajeError(new AlertaImagen(), $this->mensajeErrorUpload($code), 'update'); 
                 else 
                     $imagen_subida = false;                  
             }
             
                $model->load(Yii::$app->request->post());
             
                $model->modi_usuario_id = $usuario_id; //ID del usuario que modifica. Esperando a que estén listos los usuarios.
                $model->modi_fecha = date("Y-m-d H:i:s"); ;  //Estamos creando, no modificando.
                
                if (Yii::$app->user->identity->rol === 'A')
                    $model->imagen_revisada = 1;
                
             if($imagen_subida)
             {
                 $ruta = $model->obtenerRutaFisica();
                 
                 if($ruta == null)
                 {
                     return $this->EnviarMensajeError($model, 'Imagen no encontrada.','update');
                 }
                 
                 $fichero_temporal = $_FILES['explorar_ficheros']['tmp_name'];
                 $nombre_imagen = basename($_FILES['explorar_ficheros']['name']);
                 $extension_imagen = pathinfo(strtolower($nombre_imagen), PATHINFO_EXTENSION);
                 
                $divisiones = explode("/", $ruta);
                $c = count($divisiones);

                $ruta_relativa = "\uploads"; 

                //Obtiene la ruta relativa.
                for($itr = $c-5; $itr <= $c-1; $itr++)
                    $ruta_relativa .= '\\'.$divisiones[$itr];

                //Transforma la ruta relativa en una completa.
                $ruta_relativa = getcwd().$ruta_relativa;

                //Borra la imagen.
                unlink($ruta_relativa);
                
                //confirmamos la extensión, retirando la anterior y poniendo la nueva
                $ruta_relativa = dirname($ruta_relativa).'\\'.pathinfo($ruta_relativa, PATHINFO_FILENAME);
                $ruta_relativa = $ruta_relativa.'.'.$extension_imagen;
                
                 //Subimos la nueva imagen
                  if(!move_uploaded_file($fichero_temporal, $ruta_relativa))
                   return $this->EnviarMensajeError(new AlertaImagen(), $this->mensajeErrorUpload(UPLOAD_ERR_CANT_WRITE), 'update');                        
            
                  
                 }
             
             $model->save();
             
             $url = Url::previous();
             
             if(!isset($url))
                $url= Yii::$app->request->referrer;
             
            return $this->redirect($url ?: 'index');          
       }
            

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // return $this->redirect(['view', 'id' => $model->id]);
            //Nunca debería llegar aquí.
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AlertaImagen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
         if(Yii::$app->user->isGuest)
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
        if(!isset(Yii::$app->user->identity->rol))
            return $this->redirect(Yii::$app->request->referrer ?: 'index');
        
       $model = $this->findModel($id);
       $alerta_id =  $model->alerta_id;
       
       if(!isset($model))
           return $this->redirect(Yii::$app->request->referrer ?: 'index');
       
        $usuario_id = Yii::$app->user->getId();

        //Habría que ver si permitimos crear a un moderador, supuestamente
        //debería tener permisos para la sección de imágenes.
        if (Yii::$app->user->identity->rol === 'N' || Yii::$app->user->identity->rol === 'M')
         {
             if($model->crea_usuario_id != $usuario_id)
                 return $this->EnviarMensajeError(new AlertaImagen(), '¡No puedes borrar imágenes que no sean tuyas!', Yii::$app->request->referrer, true);
         }

        $ruta = $model->obtenerRutaFisica();  
        
        //En el caso de por cualquier razón no existe la imagen relacionada.
        //Entonces se borra solo el registro de la DB.
        if($ruta == NULL)
        {
           $this->findModel($id)->delete();
           return $this->redirect(Yii::$app->request->referrer ?: 'index');
        }
        
        $divisiones = explode("/", $ruta);
        $c = count($divisiones);
        
        $ruta_relativa = "\uploads"; 
        
        //Obtiene la ruta relativa.
        for($itr = $c-5; $itr <= $c-1; $itr++)
            $ruta_relativa .= '\\'.$divisiones[$itr];
     
        //Transforma la ruta relativa en una completa.
        $ruta_relativa = getcwd().$ruta_relativa;
        
        //Borra la imagen.
        unlink($ruta_relativa);
             
        //Obtiene la base del directorio, es decir, la ruta anterior.
        $dir = dirname($ruta_relativa);

        //Va reduciendo la ruta hasta llegar a Uploads.
        //Borra todos los directorios de carpetas hasta Uploads, siempre
        //y cuando estas no tengan ningún archivo.
        while(basename($dir) != "Uploads")
        {
            if(!$this->directorio_vacio($dir))
                break;
            
            FileHelper::removeDirectory($dir);
            $dir = dirname($dir);
        }
        
        //Borra el registro de la base de datos.
        $this->findModel($id)->delete();
        
        $this->FijarImagenEnAlerta($alerta_id);
        
        return $this->redirect(Yii::$app->request->referrer ?: 'index');
      //  return $this->redirect(['index']);
    }
    
    function directorio_vacio($dir) 
    {
        if (!is_readable($dir)) return NULL;

            $handle = opendir($dir);
             while (false !== ($entry = readdir($handle))) 
              {
                if ($entry != "." && $entry != "..") 
                    return false;

              }
        return true;
    }

    
    
    private function FijarImagenEnAlerta($alerta_id)
    {
       $modelo_alerta= Alerta::findOne($alerta_id);
       
       $modelo_pre = AlertaImagen::find()->tomarImagenesDesdeAlerta($alerta_id)->one(); 
       
       $modelo_alerta->imagen_id =  $modelo_pre->imagen_id;
       $modelo_alerta->imagen_revisada =  $modelo_pre->imagen_revisada;
       $modelo_alerta->save();
    }
    
    
    /**
     * Finds the AlertaImagen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AlertaImagen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AlertaImagen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
