<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ControlAcceso;
/**
 * UsuariosController implements the CRUD actions for Usuario model.
 */
class UsuariosController extends Controller
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
               // 'only' => ['index','view','create','update','delete','bloquear'],
                'rules' =>[ [
					'allow'=>true,
					'actions'=>['index','perfil','updatePerfil'],
					'roles'=>['N'],
				],
				[
					'allow'=>true,
					'actions'=>['index','view','create','update','delete','bloquear','perfil','updateperfil'],
					'roles'=>['A','M'],
				],
				],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionPerfil()
    {
        return $this->render('perfil', [
            'model' => $this->findModel($_SESSION["__id"]),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();
		$dia=getdate();
		$fecha=$dia['year']."-".$dia['mon']."-".$dia['mday']." ".$dia['hours'].":".$dia['minutes'].":".$dia['seconds'];
		$model->fecha_registro=$fecha;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
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
	
	public function actionUpdateperfil()
    {
        $model = $this->findModel($_SESSION["__id"]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['perfil', 'id' => $model->id]);
        } else {
            return $this->render('updatePerfil', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	//Funcion para cambiar manualmente el bloqueado
	public function actionBloquear($id)
    {
		if($this->findModel($id)){
			printf("Hecho");
		}
        $model = $this->findModel($id);
		$model2= $this->findModel($_SESSION["__id"]);
		if($model->bloqueado==0){
			if($model2->rol=='M'){
				if($model2->id!=$model->id && $model->rol!='A')//El moderador no se puede bloquear a sí mismo ni a un administrador
				{
					$dia=getdate();
					$fecha=$dia['year']."-".$dia['mon']."-".$dia['mday']." ".$dia['hours'].":".$dia['minutes'].":".$dia['seconds'];
					$model->bloqueo_fecha=$fecha;
					$model->bloqueo_usuario_id=$model2->id;//Se guarda el id del que bloqueaa
					$model->bloqueado=3;
					//$model->bloqueo_notas="Usuario bloqueado de forma manual por un Moderador";
				}
			}else if($model2->rol=='A'){ 
				if($model2->id!=$model->id)//El administrador no se puede bloquear a sí mismo
				{
					$dia=getdate();
					$fecha=$dia['year']."-".$dia['mon']."-".$dia['mday']." ".$dia['hours'].":".$dia['minutes'].":".$dia['seconds'];
					$model->bloqueo_fecha=$fecha;
					$model->bloqueo_usuario_id=$model2->id;//Se guarda el id del que bloqueaa
					$model->bloqueado=2;
					//$model->bloqueo_notas="Usuario bloqueado de forma manual por un Administrador";
				}
			}
			
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['index']);
			} else {
				
				//$model->bloqueada='1';
				return $this->render('bloqueo', [
					'model' => $model,
				]);
			}
		
		}else{
			$model->bloqueo_usuario_id=0;
			$model->bloqueo_fecha=NULL;
			$model->bloqueo_notas=NULL;
			$model->bloqueado=0;
			
			$model->save();
			
			return $this->redirect(['index']);
			
		}
		
        
    }
}
