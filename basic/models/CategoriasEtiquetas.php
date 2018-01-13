<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorias_etiquetas".
 *
 * @property string $id
 * @property string $categoria_id
 * @property string $etiqueta_id
 */
class CategoriasEtiquetas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorias_etiquetas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoria_id', 'etiqueta_id'], 'required'],
            [['categoria_id', 'etiqueta_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'categoria_id' => Yii::t('app', 'Categoria ID'),
            'etiqueta_id' => Yii::t('app', 'Etiqueta ID'),
        ];
    }
}
