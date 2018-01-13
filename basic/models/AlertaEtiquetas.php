<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alerta_etiquetas".
 *
 * @property string $id
 * @property string $alerta_id
 * @property string $etiqueta_id
 */
class AlertaEtiquetas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alerta_etiquetas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alerta_id', 'etiqueta_id'], 'required'],
            [['alerta_id', 'etiqueta_id'], 'integer'],
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
            'etiqueta_id' => Yii::t('app', 'Etiqueta ID'),
        ];
    }
}
