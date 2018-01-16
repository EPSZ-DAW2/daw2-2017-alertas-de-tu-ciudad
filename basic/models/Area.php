<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property string $id
 * @property string $clase_area_id Código de clase de area: 0=Planeta, 1=Continente, 2=Pais, 3=Estado, 4=Region, 5=Provincia, 6=Municipio, 7=Localidad, 8=Barrio, 9=Zona, ...
 * @property string $nombre Nombre del area que lo identifica.
 * @property string $area_id Area relacionada. Nodo padre de la jerarquia o CERO si es nodo raiz.
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clase_area_id', 'nombre'], 'required'],
            [['area_id'], 'integer'],
            [['clase_area_id'], 'string', 'max' => 1],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'clase_area_id' => Yii::t('app', 'Código de clase de área'),
            'nombre' => Yii::t('app', 'Nombre del área'),
            'area_id' => Yii::t('app', 'Área relacionada'),
        ];
    }

    /**
     * @inheritdoc
     * @return AreaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreaQuery(get_called_class());
    }
}
