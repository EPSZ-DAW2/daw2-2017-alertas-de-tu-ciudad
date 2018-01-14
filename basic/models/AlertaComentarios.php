<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%alerta_comentarios}}".
 *
 * @property string $id
 * @property string $alerta_id
 * @property string $crea_usuario_id
 * @property string $crea_fecha
 * @property string $modi_usuario_id
 * @property string $modi_fecha
 * @property string $texto
 * @property string $comentario_id
 * @property integer $cerrado
 * @property integer $num_denuncias
 * @property string $fecha_denuncia1
 * @property integer $bloqueado
 * @property string $bloqueo_usuario_id
 * @property string $bloqueo_fecha
 * @property string $bloqueo_notas
 */
class AlertaComentarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%alerta_comentarios}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alerta_id', 'texto'], 'required'],
            [['alerta_id', 'crea_usuario_id', 'modi_usuario_id', 'comentario_id', 'cerrado', 'num_denuncias', 'bloqueado', 'bloqueo_usuario_id'], 'integer'],
            [['crea_fecha', 'modi_fecha', 'fecha_denuncia1', 'bloqueo_fecha'], 'safe'],
            [['texto', 'bloqueo_notas'], 'string'],
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
            'crea_usuario_id' => Yii::t('app', 'Crea Usuario ID'),
            'crea_fecha' => Yii::t('app', 'Crea Fecha'),
            'modi_usuario_id' => Yii::t('app', 'Modi Usuario ID'),
            'modi_fecha' => Yii::t('app', 'Modi Fecha'),
            'texto' => Yii::t('app', 'Texto'),
            'comentario_id' => Yii::t('app', 'Comentario ID'),
            'cerrado' => Yii::t('app', 'Cerrado'),
            'num_denuncias' => Yii::t('app', 'Num Denuncias'),
            'fecha_denuncia1' => Yii::t('app', 'Fecha Denuncia1'),
            'bloqueado' => Yii::t('app', 'Bloqueado'),
            'bloqueo_usuario_id' => Yii::t('app', 'Bloqueo Usuario ID'),
            'bloqueo_fecha' => Yii::t('app', 'Bloqueo Fecha'),
            'bloqueo_notas' => Yii::t('app', 'Bloqueo Notas'),
        ];
    }

    /**
     * @inheritdoc
     * @return AlertaComentariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertaComentariosQuery(get_called_class());
    }
}
