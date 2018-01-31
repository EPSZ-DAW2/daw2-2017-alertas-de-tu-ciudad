<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alerta_etiquetas".
 *
 * @property string $id
 * @property string $alerta_id
 * @property string $etiqueta_id
 *
 * @property Etiquetas $etiqueta
 * @property Alertas $alertas
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
				[['alerta_id','etiqueta_id'],'unique', 'targetAttribute' => ['alerta_id','etiqueta_id'],'message' => 'Esa Alerta ya tiene enlazada la etiqueta'],
            [['alerta_id', 'etiqueta_id'], 'required'],
            [['alerta_id', 'etiqueta_id'], 'integer'],
            [['etiqueta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Etiquetas::className(), 'targetAttribute' => ['etiqueta_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alerta_id' => Yii::t('app', 'Alerta'),
            'etiqueta_id' => Yii::t('app', 'Etiqueta'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtiqueta()
    {
        return $this->hasOne(Etiquetas::className(), ['id' => 'etiqueta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlerta()
    {
        return $this->hasOne(Alerta::className(), ['id' => 'alerta_id']);
    }
}
