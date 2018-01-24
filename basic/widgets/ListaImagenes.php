<?php
namespace app\widgets;

use yii\base\Widget;
use app\models\AlertaImagen;
use yii\helpers\Url;
    
class ListaImagenes extends Widget
{

    //**** SE REQUIEREN DOS PARAMETROS DE ENTRADA ****
    public $id_alerta; // El primer parametro es la id de la alerta.
    public $view;   // El segundo parametro es la vista. ** La vista sería $this en una vista, lógicamente.
    //*****
    
    private $rutas_imagenes = array();
    
    public function init()
    {
       parent::init();

       //Comenzamos tomando todas las imagenes asociadas a la alerta y guardándolas $imagenes.
       $imagenes = AlertaImagen::find()->tomarImagenesDesdeAlerta($this->id_alerta)->all();
       
       //Trataremos las rutas de las imagenes una a una y guardaremos la ruta física tratada en el array $rutas_imagenes.
       foreach($imagenes as $imagen)
       {
           $i = $imagen->obtenerRutaFisica();
           if($i != NULL)
            array_push($this->rutas_imagenes, $i);
       }       
   }

    public function run()
    {
        $this->view->registerCssFile(Url::base(true).'/css/imagenes.css');
        //Agregamos el div de previsualización en la vista.
        echo '<div style="margin-top: 30px; margin-bottom: 30px;">'
       . '<ul id="previsualizador" class="ul_imagen"></ul></div>';
        // Registramos en la fista el fichero de javascript donde están las funciones asociadas con las imagenes.
        // Lo haremos usando una ruta global, para evitar posibles problemas.
        $this->view->registerJSFile(Url::base(true).'/js/funciones_imagenes.js');
        
       foreach($this->rutas_imagenes as $ruta)
       {
           //Ejecutamos la función asociada al fichero JS registrado anteriormente.
           //Pasándole como dato la ruta de la imagen
           $this->view->registerJS('previsualizar_imagen("'.$ruta.'");', 4);
       }
       
    }
}