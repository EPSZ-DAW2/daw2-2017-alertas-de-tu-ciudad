<?php
/*************************************************************************** 
----------------------Controlador de las Incidencias------------------------

****************************************************************************/

namespace app\controllers; 

use Yii;
use app\components\ControlAcceso;
use app\models\UsuarioIncidencia;
use app\models\UsuarioIncidenciaSearch;
use app\models\Usuario;
use app\models\Configuraciones;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * UsuarioIncidenciasController implements the CRUD actions for UsuarioIncidencia model.
 */
class UsuarioIncidenciasController extends Controller
{
    /**
     * @inheritdoc
	 *
	 * Function Behaviors: función que se encarga de controlar el comportamiento de 
	 *					   la aplicación mediante filtros. 
	 *
	 * 					   Por ejemplo: podría realizarse el control de seguridad de los 
	 *					   				diferentes roles de usuario. 
	 *
     */
    public function behaviors()
    {
        return [
		'access' => [
                        'class' => ControlAcceso::className(),
                        'only' => ['index','index2','indexadmin','createconsulta','createmensaje','createnotificacion','createdenuncia','createaviso','view','delete', 'solicitabaja'],
                        'rules' => [
							[
							    'actions' => ['index','createconsulta','createmensaje','view','solicitabaja'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
						
                            // allow admin users
                            [
							    'actions' => ['index2','indexadmin','delete','createnotificacion','createaviso'],
                                'allow' => true,
                                'roles' => ['A','M'],
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
     * Lists all UsuarioIncidencia models.
     * @return mixed
	 *
	 * Function actionIndex:  tendrá acceso un usuario registrado (Normal) a dicho index. 
	 *						  
	 *						  Se realizará el filtro comprobando el tipo de Usuario al que va 
	 *						  dirigida esta acción mediante una consulta en SQL. 
     */
	 //ojo permisos para cualquier usuario
    public function actionIndex()
    {	
		if(!isset(Yii::$app->user->identity->id)){
			return $this-> redirect(['site/login']);
		}
	
		$paginacion=100;
		$admin=(Yii::$app->user->identity->rol=='A' || Yii::$app->user->identity->rol=='M');
		$configuracion= Configuraciones::findOne("numero_lineas_pagina");
		if($configuracion){
			$paginacion=$configuracion->valor;
		}
		//el usuario tiene que ver cualquier cosa que vaya dirigida hacia el o creada por el
        $searchModel = new UsuarioIncidenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$yo=Yii::$app->user->identity->id;
	  // $dataProvider= new SqlDataProvider(['sql' => 'SELECT * FROM usuario_incidencias']);
	   $dataProvider->query->andWhere("(clase_incidencia_id='N' or 
	   (clase_incidencia_id='M' and (destino_usuario_id=$yo or origen_usuario_id=$yo)) or 
	   (clase_incidencia_id='C' and origen_usuario_id=$yo ) or 
	   (clase_incidencia_id='A' and destino_usuario_id=$yo ) ) 
	   and fecha_borrado IS NULL");
	   
		$dataProvider->pagination = ['pageSize' => $paginacion];
		
		//modificar para que solo coja unos y dependiendo el rol coger unos parametros un otros

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'admin'=> $admin,
        ]);
    }
	//ojo permiso de admin 
	 public function actionIndex2($id)//Función para la revisión de incidencias desde usuarios
    {	
		if(!isset(Yii::$app->user->identity->id)){
			return $this-> redirect(['site/login']);
		}
	
		$paginacion=100;
		$admin=true;
		$configuracion= Configuraciones::findOne("numero_lineas_pagina");
		if($configuracion){
			$paginacion=$configuracion->valor;
		}
		//el usuario tiene que ver cualquier cosa que vaya dirigida hacia el o creada por el
        $searchModel = new UsuarioIncidenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$yo=Yii::$app->user->identity->id;
		$yo= $id;
		
	  // $dataProvider= new SqlDataProvider(['sql' => 'SELECT * FROM usuario_incidencias']);
	   $dataProvider->query->andWhere("(clase_incidencia_id='N' or 
	   (clase_incidencia_id='M' and (destino_usuario_id=$yo or origen_usuario_id=$yo)) or 
	   (clase_incidencia_id='C' and origen_usuario_id=$yo ) or 
	   (clase_incidencia_id='A' and destino_usuario_id=$yo ) ) 
	   and fecha_borrado IS NULL");
	   
		$dataProvider->pagination = ['pageSize' => $paginacion];
		
		//modificar para que solo coja unos y dependiendo el rol coger unos parametros un otros

        return $this->render('index2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'admin'=> $admin,
        ]);
    }
	
	/*
	* Función actionIndexadmin: el index al que solo podrá tener acceso el usuario Administrador
	*							y Moderador.  Se encargará de recoger el número de paginación 
	*							de la base de datos, 
	*/
	public function actionIndexadmin()
    {
		$paginacion=100; //valor por defecto de la paginación. 
		$configuracion= Configuraciones::findOne("numero_lineas_pagina");
		if($configuracion){
			$paginacion=$configuracion->valor;
		}
        $searchModel = new UsuarioIncidenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination = ['pageSize' => $paginacion]; 
		$u=Yii::$app->request->get('id');
		if($u!=null){
			$dataProvider->query->andWhere("(destino_usuario_id=$u or origen_usuario_id=$u)");
		}
        return $this->render('indexadmin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UsuarioIncidencia model.
     * @param string $id
     * @return mixed
	 *
	 *
	 * Function actionView: Una incidencia pasa a estar "leída" si el usuario destino 
	 *						la abre estando a NULO la fecha/hora de lectura. 
	 *						Si el usuario lo desea, puede cambiarlo a "no leída"; en este 
	 *						caso se establace a NULO el dato.
	 * PARÁMETROS:
	 * 		id: hace referencia al id de la incidencia para acceder a la información de dicha 
	 *			incidencia. 
     */
    public function actionView($id)
    {
		
		$model = $this->findModel($id); //Se igual al modelo toda la información de dicha incidencia 
		$yo = Yii::$app->user->identity->id;
		$permisoUsuarioNormal = ($model->clase_incidencia_id=='N' or 
	   ($model->clase_incidencia_id=='M' and ($model->destino_usuario_id=$yo or $model->origen_usuario_id==$yo)) or 
	   ($model->clase_incidencia_id=='C' and $model->origen_usuario_id==$yo ) or 
	   ($model->clase_incidencia_id=='A' and $model->destino_usuario_id==$yo )) and $model->fecha_borrado==null;
	    $permiso = ($permisoUsuarioNormal || (Yii::$app->user->identity->rol=='A' || Yii::$app->user->identity->rol=='M'));
		
		if(!$permiso){
			return $this-> redirect(['index']);
		}else{
			$noleida = Yii::$app->request->get('noleida');
			if($noleida){
				$model->fecha_lectura=null;
				$model->save();
				return $this->redirect(['index']);
			}else{
				if($model->fecha_lectura==null && $model->destino_usuario_id==$yo){
					$model->fecha_lectura=date("Y-m-d H:i:s");
					$model->save();
						
				}
				return $this->render('view', [
					'model' => $model,
					]);
				
				
			}
			
		}
    }

    /**
     * Creates a new UsuarioIncidencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
	 
    public function actionCreate()
    {
        $model = new UsuarioIncidencia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	*/
	
	/*
	* Funcion actionCreatedenuncia: llevará al usuario a denunciar mediante un texto (provisionalmente)
	*								para poder realizar la denuncia. 
	*
	**/
	
	public function actionCreatedenuncia($id,$tipo)
    {
	
        $model = new UsuarioIncidencia();
		$bien=true; // variable que controla el tipo de alerta al que se asigna la denuncia
		//$fechayhora = getdate();
		$model->crea_fecha=date("Y-m-d H:i:s"); //se obtine la fecha y hora actual
		$model->clase_incidencia_id='D'; //se asigna al campo 'clase_incidencia_id' la clave 'D' correspondiente a Denuncia
		$model->origen_usuario_id=Yii::$app->user->identity->id; //Se asigna al campo 'origen_usuario_id' la id del usuario
		/*Si la denuncia es de tipo 'alerta' entonces se asignará el $id de la denuncia al campo 'alerta_id' */
		if($tipo=="alerta"){
				$model->alerta_id=$id;
		/*Si la denuncia es de tipo 'comentario' entonces se asignará el $id de la denuncia al campo 'comentario_id' */	
		}elseif($tipo=="comentario"){
				$model->comentario_id=$id;
		/*Si no, la variable 'bien' se pondrá a 'false'*/
		}else{
				$bien=false;
		}
			
		/*Si el formulario es rellenado y enviado por post entonces entrará en el if*/
        if ($model->load(Yii::$app->request->post())) {
			
			/*Si la variable 'bien' no está a null entonces se guardarán los cambios y se 
			* redirigirá a la vista de visualización con los cambios establecidos.*/
			if($bien){
				$model->save();
				 return $this->redirect(['view', 'id' => $model->id]);
			}else{
			
				return $this->render('createincidencia', [
                'model' => $model,
				'tipodenuncia' => $tipo,
				'error' => 'no se puede realizar la denuncia',
            ]);
			}
           
        } else {
			
            return $this->render('createincidencia', [
                'model' => $model,
				'tipodenuncia' => $tipo,
            ]);
        }
    }
	
	/*
	* Funcion Createmensaje: 
	*/
	
	public function actionCreatemensaje($id)
    {
	
        $model = new UsuarioIncidencia();
		$bien=true;
		$destinatario = Usuario::findOne($id);
		//comprobar si existe
		$model->crea_fecha=date("Y-m-d H:i:s");
		$model->clase_incidencia_id='M';
		$model->origen_usuario_id=Yii::$app->user->identity->id;
		$model->destino_usuario_id=$id;
		
			
        if ($model->load(Yii::$app->request->post())) {
			
		
			if($bien){
				$model->save();
				 return $this->redirect(['view', 'id' => $model->id]);
			}else{
				return $this->render('createincidencia', [
                'model' => $model,
				'nombre' => $destinatario->nick,
				'error' => 'no se puede mandar el mensaje',
            ]);
			}
           
        } else {
			
            return $this->render('createincidencia', [
                'model' => $model,
				'nombre' => $destinatario->nick,
            ]);
        }
    }
	
	public function actionCreateconsulta()
    {
	
        $model = new UsuarioIncidencia();
		$bien=true;
		//comprobar si existe
		$model->crea_fecha=date("Y-m-d H:i:s");
		$model->clase_incidencia_id='C';
		$model->origen_usuario_id=Yii::$app->user->identity->id;
		if($model->origen_usuario_id==NULL){
			$bien=false;
		}
			
        if ($model->load(Yii::$app->request->post())) {
			
		
			if($bien){
				$model->save();
				 return $this->redirect(['view', 'id' => $model->id]);
			}else{
				return $this->render('createincidencia', [
                'model' => $model,
				'consulta' => true,
				'error' => 'no se puede mandar el mensaje',
            ]);
			}
           
        } else {
			
            return $this->render('createincidencia', [
                'model' => $model,
				'consulta' => true,
            ]);
        }
    }
	

	
	public function actionCreatenotificacion()
    {
	
        $model = new UsuarioIncidencia();
		$bien=true;
		//comprobar si existe
		$model->crea_fecha=date("Y-m-d H:i:s");
		$model->clase_incidencia_id='N';
		$model->origen_usuario_id=Yii::$app->user->identity->id;
		if($model->origen_usuario_id==NULL){
			$bien=false;
		}
			
        if ($model->load(Yii::$app->request->post())) {
			
		
			if($bien){
				$model->save();
				 return $this->redirect(['view', 'id' => $model->id]);
			}else{
				return $this->render('createincidencia', [
                'model' => $model,
				'notificacion' => true,
				'error' => 'no se puede mandar el mensaje',
            ]);
			}
           
        } else {
			
            return $this->render('createincidencia', [
                'model' => $model,
				'notificacion' => true,
            ]);
        }
    }
	
	public function actionCreateaviso($id)
    {
	
        $model = new UsuarioIncidencia();
		$bien=true;
		$destinatario = Usuario::findOne($id);
		//comprobar si existe
		$model->crea_fecha=date("Y-m-d H:i:s");
		$model->clase_incidencia_id='A';
		$model->origen_usuario_id=Yii::$app->user->identity->id;
		$model->destino_usuario_id=$id;
		
			
        if ($model->load(Yii::$app->request->post())) {
			
		
			if($bien){
				$model->save();
				 return $this->redirect(['view', 'id' => $model->id]);
			}else{
				return $this->render('createincidencia', [
                'model' => $model,
				'nombreaviso' => $destinatario->nick,
				'error' => 'no se puede mandar el mensaje',
            ]);
			}
           
        } else {
			
            return $this->render('createincidencia', [
                'model' => $model,
				'nombrenombreaviso' => $destinatario->nick,
            ]);
        }
    }
	
	 public function actionElegirusuario()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('elegirusuario', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing UsuarioIncidencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
			$aceptar=Yii::$app->request->post('aceptar');
			if($aceptar){
				$model->destino_usuario_id=Yii::$app->user->identity->id;
				$model->fecha_aceptado=date("Y-m-d H:i:s");
			}	
			$borrar=Yii::$app->request->post('borrar');
			if($borrar && $model->fecha_borrado==null){
				$model->fecha_borrado=date("Y-m-d H:i:s");
			}
			if($borrar==false && $model->fecha_borrado!=null){
				$model->fecha_borrado=null;
			}
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UsuarioIncidencia model.
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
     * Finds the UsuarioIncidencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsuarioIncidencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuarioIncidencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
