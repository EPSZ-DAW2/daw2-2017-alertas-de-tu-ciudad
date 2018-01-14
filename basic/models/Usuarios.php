<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%usuarios}}".
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $nick
 * @property string $nombre
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property string $direccion
 * @property string $area_id
 * @property string $rol
 * @property string $fecha_registro
 * @property integer $confirmado
 * @property string $fecha_acceso
 * @property integer $num_accesos
 * @property integer $bloqueado
 * @property string $bloqueo_usuario_id
 * @property string $bloqueo_fecha
 * @property string $bloqueo_notas
 */
class Usuarios extends \yii\db\ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usuarios}}';
    }
    
    /* LISTA ROLES USUARIOS */
    public static function ListaRoles(){

        return[
            'N'=>'Normal',
            'M'=>'Moderador',
            'A'=>'Administrador',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'nick', 'nombre', 'apellidos', 'rol', 'confirmado'], 'required'],
            [['fecha_nacimiento', 'fecha_registro', 'fecha_acceso', 'bloqueo_fecha'], 'safe'],
            [['direccion', 'bloqueo_notas'], 'string'],
            [['area_id', 'confirmado', 'num_accesos', 'bloqueado', 'bloqueo_usuario_id'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['nick'], 'string', 'max' => 25],
            [['nombre'], 'string', 'max' => 50],
            [['apellidos'], 'string', 'max' => 100],
            [['rol'], 'string', 'max' => 1],
            [['email'], 'unique'],
            [['nick'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'nick' => Yii::t('app', 'Nick'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
            'direccion' => Yii::t('app', 'Direccion'),
            'area_id' => Yii::t('app', 'Area ID'),
            'rol' => Yii::t('app', 'Rol'),
            'fecha_registro' => Yii::t('app', 'Fecha Registro'),
            'confirmado' => Yii::t('app', 'Confirmado'),
            'fecha_acceso' => Yii::t('app', 'Fecha Acceso'),
            'num_accesos' => Yii::t('app', 'Num Accesos'),
            'bloqueado' => Yii::t('app', 'Bloqueado'),
            'bloqueo_usuario_id' => Yii::t('app', 'Bloqueo Usuario ID'),
            'bloqueo_fecha' => Yii::t('app', 'Bloqueo Fecha'),
            'bloqueo_notas' => Yii::t('app', 'Bloqueo Notas'),
        ];
    }

    /**
     * @inheritdoc
     * @return UsuariosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuariosQuery(get_called_class());
    }
}
