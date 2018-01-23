<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alertas".
 *
 * @property string $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha_inicio
 * @property integer $duracion_estimada
 * @property string $direccion
 * @property string $notas_lugar
 * @property string $area_id
 * @property string $detalles
 * @property string $notas
 * @property string $url
 * @property string $imagen_id
 * @property integer $imagen_revisada
 * @property string $categoria_id
 * @property integer $activada
 * @property integer $visible
 * @property integer $terminada
 * @property string $fecha_terminacion
 * @property string $notas_terminacion
 * @property integer $num_denuncias
 * @property string $fecha_denuncia1
 * @property integer $bloqueada
 * @property string $bloqueo_usuario_id
 * @property string $bloqueo_fecha
 * @property string $bloqueo_notas
 * @property string $crea_usuario_id
 * @property string $crea_fecha
 * @property string $modi_usuario_id
 * @property string $modi_fecha
 * @property string $notas_admin
 */
class Alerta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alertas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['titulo', 'descripcion', 'direccion', 'notas_lugar', 'detalles', 'notas', 'url', 'notas_terminacion', 'bloqueo_notas', 'notas_admin'], 'string'],
            [['fecha_inicio', 'fecha_terminacion', 'fecha_denuncia1', 'bloqueo_fecha', 'crea_fecha', 'modi_fecha'], 'safe'],
            [['duracion_estimada', 'area_id', 'imagen_revisada', 'categoria_id', 'activada', 'visible', 'terminada', 'num_denuncias', 'bloqueada', 'bloqueo_usuario_id', 'crea_usuario_id', 'modi_usuario_id'], 'integer'],
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
            'titulo' => Yii::t('app', 'Titulo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
            'duracion_estimada' => Yii::t('app', 'Duracion Estimada'),
            'direccion' => Yii::t('app', 'Direccion'),
            'notas_lugar' => Yii::t('app', 'Notas Lugar'),
            'area_id' => Yii::t('app', 'Area ID'),
            'detalles' => Yii::t('app', 'Detalles'),
            'notas' => Yii::t('app', 'Notas'),
            'url' => Yii::t('app', 'Url'),
            'imagen_id' => Yii::t('app', 'Imagen ID'),
            'imagen_revisada' => Yii::t('app', 'Imagen Revisada'),
            'categoria_id' => Yii::t('app', 'Categoria ID'),
            'activada' => Yii::t('app', 'Activada'),
            'visible' => Yii::t('app', 'Visible'),
            'terminada' => Yii::t('app', 'Terminada'),
            'fecha_terminacion' => Yii::t('app', 'Fecha Terminacion'),
            'notas_terminacion' => Yii::t('app', 'Notas Terminacion'),
            'num_denuncias' => Yii::t('app', 'Num Denuncias'),
            'fecha_denuncia1' => Yii::t('app', 'Fecha Denuncia1'),
            'bloqueada' => Yii::t('app', 'Bloqueada'),
            'bloqueo_usuario_id' => Yii::t('app', 'Bloqueo Usuario ID'),
            'bloqueo_fecha' => Yii::t('app', 'Bloqueo Fecha'),
            'bloqueo_notas' => Yii::t('app', 'Bloqueo Notas'),
            'crea_usuario_id' => Yii::t('app', 'Crea Usuario ID'),
            'crea_fecha' => Yii::t('app', 'Crea Fecha'),
            'modi_usuario_id' => Yii::t('app', 'Modi Usuario ID'),
            'modi_fecha' => Yii::t('app', 'Modi Fecha'),
            'notas_admin' => Yii::t('app', 'Notas Admin'),
        ];
    }

    /**
     * @inheritdoc
     * @return AlertaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertaQuery(get_called_class());
    }
}
