<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "Categorias".
 *
 * @property string $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $categoria_id
 */
class Categorias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Categorias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','categoria_id'],'unique', 'targetAttribute' => ['nombre','categoria_id'],'message' => 'La combinación de categorias ya existe'],
            [['descripcion'], 'string'],
            [['categoria_id'],'integer'],
            [['nombre'],'unique','message' => 'La categoria ya existe'],
            [['nombre'],'string', 'max' => 25 ],
            [['nombre'],'required','message' => 'Introduzca un nombre'],
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
            'descripcion' => Yii::t('app', 'Descripcion'),
            'categoria_id' => Yii::t('app', 'Categoria ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return CategoriasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriasQuery(get_called_class());
    }

    
}
