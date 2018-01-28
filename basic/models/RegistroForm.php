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
class RegistroForm extends Model
{
    public $email;
    public $password;
    public $nick;
    public $apellidos;
    public $fecha_nacimiento;
    public $direccion;
    public $nombre;
    public $area_id;


    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password', 'nick','nombre','apellidos','fecha_nacimiento','direccion','area_id'], 'required'],
            // rememberMe must be a boolean value
           // ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
           ['email', 'validarEmail'],
           ['nick', 'validarNick'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validarEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
			
            $user = Usuario::findByEmail($this->email);
			//$model=Usuario::findOne($user);
           /* if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }*/
			if ($user)
				$this->addError($attribute, 'Email registrado');
				//break;

        }
		
    }
	
	public function validarNick($attribute, $params)
    {
        if (!$this->hasErrors()) {
			
            $user = Usuario::findByNick($this->nick);
			//$model=Usuario::findOne($user);
           /* if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }*/
			if ($user)
				$this->addError($attribute, 'Nick registrado');
				//break;

        }
		
    }


    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function registro()
    {
        if ($this->validate()) {
            return (!$this->getUser());
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
            $this->_user = Usuario::findByUsername2($this->email, $this->nick);
			return $this->_user;
			/*if($this->_user==0)
			{
				//$model= Usuario::findOne($this->_user);
				//if ($this->_user->confirmado== 0 || $this->_user->bloqueado!=0)
					return false;
			}*/
			
        }
		
    }
}
