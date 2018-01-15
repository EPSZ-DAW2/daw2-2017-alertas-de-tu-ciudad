<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_incidencias".
 *
 * @property string $id
 * @property string $crea_fecha
 * @property string $clase_incidencia_id
 * @property string $texto
 * @property string $destino_usuario_id
 * @property string $origen_usuario_id
 * @property string $alerta_id
 * @property string $comentario_id
 * @property string $fecha_lectura
 * @property string $fecha_borrado
 * @property string $fecha_aceptado
 */
class UsuarioIncidencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_incidencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crea_fecha'], 'required'],
            [['crea_fecha', 'fecha_lectura', 'fecha_borrado', 'fecha_aceptado'], 'safe'],
            [['texto'], 'string'],
            [['destino_usuario_id', 'origen_usuario_id', 'alerta_id', 'comentario_id'], 'integer'],
            [['clase_incidencia_id'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'crea_fecha' => Yii::t('app', 'Crea Fecha'),
            'clase_incidencia_id' => Yii::t('app', 'Clase Incidencia ID'),
            'texto' => Yii::t('app', 'Texto'),
            'destino_usuario_id' => Yii::t('app', 'Destino Usuario ID'),
            'origen_usuario_id' => Yii::t('app', 'Origen Usuario ID'),
            'alerta_id' => Yii::t('app', 'Alerta ID'),
            'comentario_id' => Yii::t('app', 'Comentario ID'),
            'fecha_lectura' => Yii::t('app', 'Fecha Lectura'),
            'fecha_borrado' => Yii::t('app', 'Fecha Borrado'),
            'fecha_aceptado' => Yii::t('app', 'Fecha Aceptado'),
        ];
    }

    /**
     * @inheritdoc
     * @return UsuarioIncidenciaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuarioIncidenciaQuery(get_called_class());
    }
}
