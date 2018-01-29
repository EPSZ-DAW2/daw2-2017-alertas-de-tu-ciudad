<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ControlAcceso;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
			
            $user = $this->getUser();
			//$model=Usuario::findOne($user);
           /* if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }*/
			if (!$user)
				$this->addError($attribute, 'Usuario no confirmado, usuario bloqueado o usuario no registrado');
				//break;
			else if (!Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) 
			{
				//$this->inc_NumAccesos($user);
				$user->num_accesos= $user->num_accesos + 1;
				if($user->num_accesos >= 5){
					$user->bloqueado= 1;
					$dia=getdate();
					$fecha=$dia['year']."-".$dia['mon']."-".$dia['mday']." ".$dia['hours'].":".$dia['minutes'].":".$dia['seconds'];
					$user->bloqueo_fecha=$fecha;
					$user->bloqueo_usuario_id=0;
					$user->bloqueo_notas="Usuario bloqueado de forma automática";
					$user->num_accesos=5;
				}
				if (!$user->save()) {
					$this->addError( 'Modelo no guardado, num_Acessos');
				}
				$this->addError($attribute, 'Contraseña o usuario incorrecto');
				
			}
        }
		
    }


    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        /*if ($this->_user === false) {
            $this->_user = Usuario::findByUsername($this->email);
        }

        return $this->_user;*/
		if ($this->_user === false) {
            $this->_user = Usuario::findByUsername($this->email);
			if($this->_user!=NULL)
			{
				//$model= Usuario::findOne($this->_user);
				if ($this->_user->confirmado== 0 || $this->_user->bloqueado!=0)
					$this->_user= NULL;
			}
			
        }
        return $this->_user;
		
    }
}
