<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property string $id
 * @property string $crea_fecha
 * @property string $clase_log_id
 * @property string $modulo
 * @property string $texto
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }
	public static function getNombreClase($id){
		$a= ['E'=>"Error", 'A'=>"Aviso",'S'=>"Seguimiento",'I'=>"Información",'D'=>"Depuracion"];
		return $a[$id];
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crea_fecha', 'clase_log_id'], 'required'],
            [['crea_fecha'], 'safe'],
            [['texto'], 'string'],
            [['clase_log_id'], 'string', 'max' => 1],
            [['modulo'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crea_fecha' => 'Crea Fecha',
            'clase_log_id' => 'Clase Log ID',
            'modulo' => 'Modulo',
            'texto' => 'Texto',
        ];
    }

    /**
     * @inheritdoc
     * @return LogsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogsQuery(get_called_class());
    }
}
