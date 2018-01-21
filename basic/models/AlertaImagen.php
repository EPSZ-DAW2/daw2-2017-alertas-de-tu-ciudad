<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
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
     * Crea la ruta completa de la imagen asociada al modelo a través
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
    
}
