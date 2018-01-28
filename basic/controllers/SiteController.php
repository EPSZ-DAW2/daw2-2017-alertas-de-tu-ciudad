<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegistroForm;
use app\models\ContactForm;
use app\models\Usuario;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			$model2=Usuario::findOne($_SESSION["__id"]);
			$dia=getdate();
			$fecha=$dia['year']."-".$dia['mon']."-".$dia['mday']." ".$dia['hours'].":".$dia['minutes'].":".$dia['seconds'];
			$model2->fecha_acceso=$fecha;
			$model2->num_accesos=$model2->num_accesos+1;
			$model2->save();
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	
	public function actionRegistro()
    {
        $model = new RegistroForm();
        if ($model->load(Yii::$app->request->post()) && $model->registro()) {
			$model2= new Usuario;
			$model2->email= $model->email;
			$model2->password= $model->password;
			$model2->nick= $model->nick;
			$model2->nombre= $model->nombre;
			$model2->apellidos= $model->apellidos;
			$model2->fecha_nacimiento= $model->fecha_nacimiento;
			$model2->direccion= $model->direccion;
			$model2->area_id= $model->area_id;
			$model2->rol= 'N';
			
			$dia=getdate();
			$fecha=$dia['year']."-".$dia['mon']."-".$dia['mday']." ".$dia['hours'].":".$dia['minutes'].":".$dia['seconds'];
			$model2->fecha_registro= $fecha;
			$model2->confirmado= 0;
			$model2->fecha_acceso= NULL;
			$model2->bloqueado= 0;
			$model2->num_accesos= 0;
			
			$model2->save();
			
			//return $this->redirect(['confirmar', 'nick' => $model->nick]);
            return $this->render('confirmar', [
            'model' => $model2,
        ]);
        }
		
		
        return $this->render('registro', [
            'model' => $model,
        ]);
    }
	
	/*public function actionConfirmar(){
		$model=Usuario::findOne($email);
		$model->confirmar=1;
		$model->save();
		return $this->render('login', [
            'model' => $model,
        ])
		
	}*/
	
	

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
		$model=Usuario::findOne($_SESSION["__id"]);
		$model->num_accesos=0;
		$model->save();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     *
     * Muestra la aplicación en modo "catchAll"
     */
    public function actionApagado()
    {
        //return 'Aplicación en Mantenimiento...';
        return $this->renderContent('Aplicación en Mantenimiento...');
        //return $this->render('apagado');
    }
}
