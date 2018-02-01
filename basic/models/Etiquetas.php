<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etiquetas".
 *
 * @property string $id
 * @property string $nombre
 *
 * @property CategoriasEtiquetas[] $categoriasEtiquetas
 */
class Etiquetas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'etiquetas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 40],
				[['nombre'], 'unique', 'message' => 'La etiqueta ya existe'],
				[['nombre'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriasEtiquetas()
    {
        return $this->hasMany(CategoriasEtiquetas::className(), ['etiqueta_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return EtiquetasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EtiquetasQuery(get_called_class());
    }
}
