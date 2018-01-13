<?php

namespace app\models;

use Yii;

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
     * @inheritdoc
     * @return AlertaImagenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertaImagenQuery(get_called_class());
    }
}
