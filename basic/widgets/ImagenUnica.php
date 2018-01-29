<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\AlertaImagen;
use yii\helpers\Url;
    
class ImagenUnica extends Widget
{

    //**** SE REQUIEREN DOS PARAMETROS DE ENTRADA ****
    public $id_imagen = null; // El primer parametro es la id de la imagen a mostrar
    public $UUID;
    public $div_render;
    public $view;   // El segundo parametro es la vista. ** La vista sería $this en una vista, lógicamente.
    //*****
    
    private $imagen;
    
    public function init()
    {
       parent::init();      
       //Comenzamos buscando la id asociada a dicha imagen.     
       if(isset($this->id_imagen))
        $this->imagen = AlertaImagen::findOne($this->id_imagen);
       else if(isset($this->UUID))
         $this->imagen = AlertaImagen::find()->buscarPorUUID($this->UUID)->one();     
     
   }

    public function run()
    {
        if(!isset($this->imagen))
            return;
        
        $this->view->registerCssFile(Url::base(true).'/css/imagenes.css');
        // Registramos en la fista el fichero de javascript donde están las funciones asociadas con las imagenes.
        // Lo haremos usando una ruta global, para evitar posibles problemas.
        $this->view->registerJSFile(Url::base(true).'/js/funciones_imagenes.js');
        
        $ruta = $this->imagen->obtenerRutaFisica();
        
        if($ruta != NULL)
             $this->view->registerJS('previsualizar_imagen("'.$ruta.'", "'.$this->imagen->id.'","'.Yii::$app->user->getId().'", "'.$this->div_render.'");', 4);
   
    }
}