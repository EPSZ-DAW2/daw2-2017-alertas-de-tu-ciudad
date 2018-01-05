<?php

namespace app\models;

use Yii;
use app\models\Actividades;
use app\models\ActividadParticipantes;
use app\models\ActividadSeguimientos;
use app\models\ActividadComentarios;

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
 * @property integer $avisos_por_correo
 * @property integer $avisos_agrupados
 * @property integer $avisos_marcar_leidos
 * @property integer $avisos_eliminar_borrados
 * @property string $fecha_registro
 * @property integer $confirmado
 * @property string $fecha_acceso
 * @property integer $num_accesos
 * @property integer $bloqueado
 * @property string $fecha_bloqueo
 * @property string $notas_bloqueo
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            'P'=>'Patrocinador',
            'A'=>'Administrador',
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'nick', 'nombre', 'apellidos', 'rol','fecha_nacimiento'], 'required'],
            [['fecha_nacimiento','fecha_registro', 'fecha_acceso', 'fecha_bloqueo'],'safe'],
            [['fecha_nacimiento'], 'date', 'format' => 'yyyy-mm-dd', 'message'=>'Fecha no valida.(2000-12-31)'],
            [['direccion', 'notas_bloqueo'], 'string'],
            [['area_id', 'avisos_por_correo', 'avisos_agrupados', 'avisos_marcar_leidos', 'avisos_eliminar_borrados', 'confirmado', 'num_accesos', 'bloqueado'], 'integer'],
            ['email', 'match', 'pattern' => "/^.{5,255}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato no válido'],
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
            'id' => 'ID',
            'email' => 'Correo Electronico ',
            'password' => 'Contraseña',
            'nick' => 'Nick',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha de nacimiento',
            'direccion' => 'Direccion',
            'area_id' => 'Localizacion',
            'rol' => 'Rol. Por defecto N',
            'avisos_por_correo' => 'Avisos por correo',
            'avisos_agrupados' => 'Avisos agrupados',
            'avisos_marcar_leidos' => 'Marcar correos como leidos. Indicar dias',
            'avisos_eliminar_borrados' => 'Eliminar correos borrados. Indicar dias',
            'fecha_registro' => 'Fecha y Hora de registro ',
            'confirmado' => 'Registro confirmado',
            'fecha_acceso' => 'Fecha y Hora del ultimo acceso',
            'num_accesos' => 'Num de intentos de login fallidos',
            'bloqueado' => 'Usuario bloqueado',
            'fecha_bloqueo' => 'Fecha y Hora del bloqueo',
            'notas_bloqueo' => 'Notas',
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

    /*VALIDAR USUARIO*/
    public static function ValidarUsuario($nick,$password)
    {
        $usuario= Usuarios::find()->where(['nick'=>$nick, 'password'=>$password, 'confirmado'=>'1', 'bloqueado'=>'0'])->one();
//var_dump($usuario);
//exit();
        return isset($usuario) ? new static($usuario) : null;
    }
    // DEVUELVE ID PARA $USER
    public static function findIdentity($id)
    {
        $user = Usuarios::find()
            ->Where("id=:id", ["id" => $id])
            ->one();
        return isset($user) ? new static($user) : null;
    }

    /* Busca la identidad del usuario a través de su token de acceso */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        
    }

    /* Busca la identidad del usuario a través del username */
    public static function findByUsername($nick)
    {
        $users = Usuarios::find()
            ->where("confirmado=:confirmado", ["confirmado" => 1])
            ->andWhere("nick=:nick", [":nick" => $nick])
            ->all();

        foreach ($users as $user) {
            if (strcasecmp($user->nick, $nick) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /* Regresa el id del usuario */
    public function getId()
    {
        return $this->id;
    }

    /* Regresa la clave de autenticación */
    public function getAuthKey()
    {
        return $this->authKey;
    }
    
    /* Valida la clave de autenticación */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function x_validatePassword($password)
    {
        /* Valida el password */
        return $this->password === $password;
    }
    
    
    
    // FUNCION PARA DEVOLVER SI ES ADMIN O NO
    public static function isAdmin()
    {
      return (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol == 'A');
    }
    //FUNCION PARA DEVOLVER SI ES PATROCINADOR O NO
    public static function isPatrocinador()
    {
      return (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol == 'P');
    }
    //FUNCION PARA DEVOLVER SI ES MODERADOR O NO
    public static function isModerador()
    {
      return (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol == 'M');
    }
    //FUNCION PARA DEVOLVER SI ES NORMAL O NO
    public static function isNormal()
    {      
      return (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol == 'N');
    }



    /*CREADO POR ERNESTO NO BORRAR!!*/
    public function getAvisosRecibidos(){
        return $this->hasMany(UsuarioAvisos::className(), ['destino_usuario_id' => 'id']);
    }

    public function getAvisosEnviados(){
        return $this->hasMany(UsuarioAvisos::className(), ['origen_usuario_id' => 'id']);
    }


    //Obtiene las actividades creadas por ese usuario
     public function getActividadesPropias()
    {
        return $this->hasMany(Actividades::className(), ['crea_usuario_id'=>'id']);
    }

    //Obtiene las actividades seguidas por ese usuario
     public function getActividadesSeguimiento()
    {
        return $this->hasMany(Actividades::className(), ['id'=>'actividad_id'])
            ->viaTable('actividad_seguimientos', ['usuario_id'=>'id']);             
    }

    //Obtiene las actividades en las que participa ese usuario
     public function getActividadesParticipante()
    {
        return $this->hasMany(Actividades::className(), ['id'=>'actividad_id'])
             ->viaTable('actividad_participantes', ['usuario_id'=>'id']);
    }

    //Obtiene los comentarios en actividades de este participante
     public function getComentarios()
    {
        return $this->hasMany(ActividadComentarios::className(), ['crea_usuario_id'=>'id']);
    }

}
