<?php

namespace app\models;

use Yii;
use Yii\Helpers\ArrayHelper;
use app\models\Alerta;

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
    public static $clases_area = [
        'Planeta',
        'Continente',
        'País',
        'Estado',
        'Región',
        'Provincia',
        'Municipio',
        'Localidad',
        'Barrio',
        'Zona'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{areas}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clase_area_id', 'nombre'], 'required'],
            [['area_id'], 'integer'],
            [['clase_area_id'], 'integer', 'max' => 10],
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
            'claseArea' => Yii::t('app', 'Clase de área'),
            'nombre' => Yii::t('app', 'Nombre del área'),
            'area_id' => Yii::t('app', 'Área relacionada'),
            'parentArea' => Yii::t('app', 'Área padre'),
            'parentName' => Yii::t('app', 'Nombre del área padre'),
            'childAreas' => Yii::t('app', 'Áreas hijas'),
            'childrenNames' => Yii::t('app', 'Áreas hijas'),
            'totalAlertas' => Yii::t('app', 'Nº de alertas relacionadas')
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

    public function getParentArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }
    public function getChildAreas() {
        return $this->hasMany(Area::className(), ['area_id' => 'id'])->inverseOf('parentArea');
    }
    public function getClaseArea() {
        return $this::$clases_area[$this->clase_area_id];
    }

    public function getParentName() 
    {
        $parent = $this->parentArea;
        if ($parent) return $parent->nombre;
    }

    public function getChildrenNames() {
        $children = $this->childAreas;
        if ($children) {
           return join(ArrayHelper::map($children, 'id', 'nombre'), ', ');
        }
    }

    public function getAlertasRelacionadas() {
        return $this->hasMany(Alerta::className(), ['area_id' => 'id']);
    }

    public function getAlertasNames() {
        $areas = $this->alertasRelacionadas;
        if ($areas) {
            return join(ArrayHelper::map($areas, 'id', 'titulo'), ', ');
        }
    }

    public function getTotalAlertas() {
        return $this->hasMany(Alerta::className(), ['area_id' => 'id'])->count();
    }

}
