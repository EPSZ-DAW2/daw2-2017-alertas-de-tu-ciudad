<?php

namespace app\models;

use Yii;
use yii\base\Model;

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

           /* if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }*/
			if (!$user)
				$this->addError($attribute, 'Usuario no confirmado, usuario bloqueado o usuario no registrado');
				//break;
			else if (!$user->validatePassword($this->password)) 
			{
				//$this->inc_NumAccesos($user);
				$this->addError($attribute, 'Contraseña o usuario incorrecto');
				
			}
        }
    }
/*
	public function inc_NumAccesos($user)
	{
		/*if(Usuario::findOne($this->_user)){
			printf("Hecho");
		}
        $model = Usuario::findOne($user);
		$model->num_accesos= $model->num_accesos + 1;
		if($model->num_accesos >= 5){
			$model->bloqueado= 1;
			$model->num_accesos=5;
		}
        if ($model->save()) {
			$this->addError( 'Modelo no guardado, num_Acessos');
        }		
	}
*/
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
				$model= Usuario::findOne($this->_user);
				if ($model->confirmado== 0 || $model->bloqueado!=0)
					$this->_user= NULL;
			}
			
        }

        return $this->_user;
		
    }
}
