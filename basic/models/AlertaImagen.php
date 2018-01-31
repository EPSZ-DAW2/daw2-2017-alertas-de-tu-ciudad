<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\FileHelper;
/**
 * This is the model class for table "alerta_imagenes".
 *
 * @property string $id
 * @property string $alerta_id
 * @property integer $orden
 * @property string $imagen_id
 * @property integer $imagen_revisada
 * @property string $crea_usuario_id
 * @property string $crea_fecha
 * @property string $modi_usuario_id
 * @property string $modi_fecha
 * @property string $notas_admin
 */
class AlertaImagen extends \yii\db\ActiveRecord
{
    public static $extensiones_permitidas = array("gif", "jpg", "jpeg", "png");
    public static $maximo_imagenes_por_alerta = 20;
    
    private $virtual_ruta = "";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alerta_imagenes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alerta_id', 'imagen_id'], 'required'],
            [['alerta_id', 'orden', 'imagen_revisada', 'crea_usuario_id', 'modi_usuario_id'], 'integer'],
            [['crea_fecha', 'modi_fecha'], 'safe'],
            [['notas_admin'], 'string'],
            [['imagen_id'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alerta_id' => Yii::t('app', 'Alerta ID'),
            'orden' => Yii::t('app', 'Orden'),
            'imagen_id' => Yii::t('app', 'Imagen ID'),
            'imagen_revisada' => Yii::t('app', 'Imagen Revisada'),
            'crea_usuario_id' => Yii::t('app', 'Crea Usuario ID'),
            'crea_fecha' => Yii::t('app', 'Crea Fecha'),
            'modi_usuario_id' => Yii::t('app', 'Modi Usuario ID'),
            'modi_fecha' => Yii::t('app', 'Modi Fecha'),
            'notas_admin' => Yii::t('app', 'Notas Admin'),
        ];
    }

    /**
     * Crea la ruta completa (FORMATO URL) de la imagen asociada al modelo a través
     * de su UUID.
     * Una vez generada la ruta la guardara en una variable privada para futuras referencias.
     * @return devuelve la ruta completa de la imagen o nulo, si no se pudo localizar.
     */
    public function obtenerRutaFisica()
    {
        if(!empty($virtual_ruta))
            return $virtual_ruta;

        $UUID = $this->imagen_id;   
       
        if(empty($UUID))
            return null;

        //separamos la UUID por las barras.
        $hashes = explode("-", $UUID);
        $ruta_completa = "";
        
        //Modificamos el orden de los hashes
        for($h=count($hashes)-1; $h >= 0; $h--)
        {
            $ruta_completa .= "/$hashes[$h]";
        }
        
        //agregamos la carpeta de uploads.
        $ruta_completa = '/uploads'.$ruta_completa;
                
        $imagenExiste = false;
        //buscamos la extensión que puede tener la imagen
        foreach($this::$extensiones_permitidas as $ext)
        {
            //probamos con los diferentes tipos, hasta dar con la extensión oportuna.
            if(file_exists(str_replace("/","\\",getcwd().$ruta_completa.'.'.$ext)))
            { 
                $ruta_completa = $ruta_completa.'.'.$ext;
                $imagenExiste = true;
                break;
            }
        } 
        
        if(!$imagenExiste)
            return null;
        
        // Agregamos la base que nos proporciona Yii a la url.
        $ruta_completa = Url::base(true).$ruta_completa;

        return $ruta_completa;
    }
    
        /**
     * Crea la ruta completa (EN DISCO) de la imagen asociada al modelo a través
     * de su UUID.
     * Una vez generada la ruta la guardara en una variable privada para futuras referencias.
     * @return devuelve la ruta completa de la imagen o nulo, si no se pudo localizar.
     */
    public function obtenerRutaDisco()
    {
        $ruta = $this->obtenerRutaFisica();  
        
        //En el caso de por cualquier razón no existe la imagen relacionada.
        //Entonces se borra solo el registro de la DB.
        if($ruta == NULL)
        {
           return NULL;
        }
        
        $divisiones = explode("/", $ruta);
        $c = count($divisiones);
        
        $ruta_relativa = "\uploads"; 
        
        //Obtiene la ruta relativa.
        for($itr = $c-5; $itr <= $c-1; $itr++)
            $ruta_relativa .= '\\'.$divisiones[$itr];
     
        //Transforma la ruta relativa en una completa.
        $ruta_relativa = getcwd().$ruta_relativa;
        
        return $ruta_relativa;
        //Devuelve la ruta absoluta a través de la relativa.
       // return realpath($ruta_relativa);
    }
    
    public function borrar()
    {
       $ruta = $this->obtenerRutaFisica();  
        
        //En el caso de por cualquier razón no existe la imagen relacionada.
        //Entonces se borra solo el registro de la DB.
        if($ruta == NULL)
        {
           $this->delete();
           return;
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
        $this->delete();
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

    /**
     * @inheritdoc
     * @return AlertaImagenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertaImagenQuery(get_called_class());
    }
    
    public static function Obtener_Imagen_UUID()
    {
        $post = Yii::$app->db->createCommand('SELECT UUID()')->query();
        return implode($post->read());
    }
    
    public static function transformarSize($bytes, $precision = 2) 
    { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }
    
    
    public static function eliminarTodas($idAlerta) 
    { 
       $imagenes = AlertaImagen::find()->tomarImagenesDesdeAlerta($idAlerta)->all(); 
       
       foreach ($imagenes as $imagen)
       {
           $imagen->borrar();
       } 
    }
    
}
