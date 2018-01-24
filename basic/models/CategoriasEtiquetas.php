<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorias_etiquetas".
 *
 * @property integer $id
 * @property integer $categoria_id
 * @property integer $etiqueta_id
 *
 * @property Categorias $categoria
 * @property Etiquetas $etiqueta
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
            [['categoria_id','etiqueta_id'],'unique', 'targetAttribute' => ['categoria_id','etiqueta_id'],'message' => 'La combinación de alerta etiqueta ya existe'],
            [['categoria_id', 'etiqueta_id'], 'required'],
            [['categoria_id', 'etiqueta_id'], 'integer'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
            'nombre_categoria' => Yii::t('app', 'Nombre Categoria'),
            'etiqueta_id' => Yii::t('app', 'Etiqueta ID'),
            'nombre_etiqueta' => Yii::t('app', 'Nombre Etiqueta'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEtiqueta()
    {
        return $this->hasOne(Etiquetas::className(), ['id' => 'etiqueta_id']);
    }

    /**
     * @inheritdoc
     * @return CategoriasEtiquetasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriasEtiquetasQuery(get_called_class());
    }
}
