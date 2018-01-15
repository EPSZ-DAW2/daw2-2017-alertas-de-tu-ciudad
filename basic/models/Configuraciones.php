<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuraciones".
 *
 * @property string $variable
 * @property string $valor
 */
class Configuraciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuraciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['variable'], 'required'],
            [['valor'], 'string'],
            [['variable'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'variable' => 'Variable',
            'valor' => 'Valor',
        ];
    }

    /**
     * @inheritdoc
     * @return ConfiguracionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfiguracionesQuery(get_called_class());
    }
}
