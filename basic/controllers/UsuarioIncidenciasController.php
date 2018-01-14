<?php

namespace app\controllers;

use Yii;
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
     * Lists all UsuarioIncidencia models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		$paginacion=100;
		$configuracion= Configuraciones::findOne("numero_lineas_pagina");
		if($configuracion){
			$paginacion=$configuracion->valor;
		}
		//el usuario tiene que ver cualquier cosa que vaya dirigida hacia el o creada por el
        $searchModel = new UsuarioIncidenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$yo=Yii::$app->user->identity->id;
	  // $dataProvider= new SqlDataProvider(['sql' => 'SELECT * FROM usuario_incidencias']);
	   /*$dataProvider->query->andWhere("(clase_incidencia_id='N' or 
	   (clase_incidencia_id='M' and (destino_usuario_id=.'$yo'. or origen_usuario_id=.'$yo'.)) or 
	   (clase_incidencia_id='C' and origen_usuario_id=.'$yo'. ) or 
	   (clase_incidencia_id='A' and destino_usuario_id=.'$yo'. ) )");*/
	   
		$dataProvider->pagination = ['pageSize' => $paginacion];
		
		//modificar para que solo coja unos y dependiendo el rol coger unos parametros un otros

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndexadmin()
    {
		$paginacion=100;
        $searchModel = new UsuarioIncidenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination = ['pageSize' => $paginacion];
		//modificar para que solo coja unos y dependiendo el rol coger unos parametros un otros

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UsuarioIncidencia model.
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
     * Creates a new UsuarioIncidencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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
	
	public function actionCreatedenuncia($id,$tipo)
    {
	
        $model = new UsuarioIncidencia();
		$bien=true;
		//$fechayhora = getdate();
		$model->crea_fecha=date("Y-m-d H:i:s");
		$model->clase_incidencia_id='D';
		$model->origen_usuario_id=Yii::$app->user->identity->id;
		if($tipo=="alerta"){
				$model->alerta_id=$id;
		}elseif($tipo=="comentario"){
				$model->comentario_id=$id;
		}else{
				$bien=false;
		}
			
        if ($model->load(Yii::$app->request->post())) {
			
		
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
