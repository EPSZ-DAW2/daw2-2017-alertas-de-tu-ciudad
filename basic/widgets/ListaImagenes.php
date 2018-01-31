<?php
namespace app\widgets;


use Yii;
use app\models\Alerta;
use yii\base\Widget;
use app\models\AlertaImagen;
use yii\helpers\Url;
use app\components\ControlAcceso;
use yii\widgets\ActiveForm;    

class ListaImagenes extends Widget
{

    //**** SE REQUIEREN DOS PARAMETROS DE ENTRADA ****
    public $id_alerta; // El primer parametro es la id de la alerta.
    public $view;   // El segundo parametro es la vista. ** La vista sería $this en una vista, lógicamente.
    //*****

    private $imagenes;
    public function init()
    {
       parent::init();

       //Comenzamos tomando todas las imagenes asociadas a la alerta y guardándolas $imagenes.
       $this->imagenes = AlertaImagen::find()->tomarImagenesDesdeAlerta($this->id_alerta)->all();         
   }

    public function run()
    {
        $this->view->registerCssFile(Url::base(true).'/css/imagenes.css');
        
        $form = ActiveForm::begin(['action' => Url::base(true).'/alerta-imagenes/create?a_id='.$this->id_alerta, 'options' => ['enctype' => 'multipart/form-data']]); // IMPORTANTE! 

       $admin = 0;
       $creador = 0;
       $modelo_alerta = NULL;
       
       if(!Yii::$app->user->isGuest)
       {
            if(Yii::$app->user->identity->rol === 'A')
                    $admin = 1;
            else if(Yii::$app->user->identity->rol === 'N')
            {
                  $modelo_alerta= Alerta::findOne($this->id_alerta);
                 if(isset($modelo_alerta) && $modelo_alerta->crea_usuario_id == Yii::$app->user->getId())
                       $creador = 1;
            }
            
            if(Yii::$app->user->identity->rol === 'M')
            {  
                $resultado = (new \yii\db\Query())
                ->select(['id'])
                ->from('usuarios_area_moderacion')
                ->where(['usuario_id' => Yii::$app->user->getId(),'area_id' => $modelo_alerta->area_id])
                ->count();

                //Si el usuario tiene permisos de moderación en dicha alerta que pertenece al area x, entonces
                //podrá hacer todas las funciones del administrador. Es decir podrá ver todas las herramientas de adminsitración.
                if(isset($resultado) && $resultado >= 1)
                {
                    $admin = 1;
                }             
            }
            
            
       }
        
       if($creador || $admin)
         echo '<div style="font-size: 17px; margin-top:10px;">Para especificar el orden de las imágenes, puedes '
            . 'arrástralas y luego guardar el orden.</div>';
        
        //Agregamos el div de previsualización en la vista.
        echo '<div style="margin-top: 10px; margin-bottom: 30px;">'
       . '<ul id="previsualizador" class="ul_imagen"></ul></div>';
        // Registramos en la fista el fichero de javascript donde están las funciones asociadas con las imagenes.
        // Lo haremos usando una ruta global, para evitar posibles problemas.
        $this->view->registerJSFile(Url::base(true).'/js/funciones_imagenes.js');
        
       //Trataremos las rutas de las imagenes una a una y guardaremos la ruta física tratada en el array $rutas_imagenes.
       foreach($this->imagenes as $imagen)
       {
           $i = $imagen->obtenerRutaFisica();

           //Ejecutamos la función asociada al fichero JS registrado anteriormente.
           //Pasándole como dato la ruta de la imagen
           if($i != NULL)
           {
            if(($admin))
                $this->view->registerJS('previsualizar_imagen("'.$i.'", "'.$imagen->id.'", "'.$imagen->crea_usuario_id.':'.$imagen->imagen_revisada.'",  "previsualizador");', 4);  
            else  $this->view->registerJS('previsualizar_imagen("'.$i.'", "'.$imagen->id.'", "'.$imagen->crea_usuario_id.'",  "previsualizador");', 4);  
            
           }
       }
       
       if($admin || $creador)
       {
            $this->view->registerJS('barra_herramientas_imagenes("'.Url::base(true).'","'.Yii::$app->user->getId().'", "'.$creador.'","'.$admin.'", "1", "'.Yii::$app->request->getCsrfToken().'");', 4); 
            $this->view->registerJS(file_get_contents(Url::base(true).'/js/imagenes_arrastrar.js'));
       }

        Url::remember();
        ActiveForm::end();
    }
}