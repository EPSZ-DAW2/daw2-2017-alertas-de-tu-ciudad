<?php
namespace app\components;

use yii\filters\AccessRule;


class ReglaAcceso extends AccessRule
{
	protected function matchRole($user)
	{
		$items = empty($this->roles) ? [] : $this->roles;

        if (!empty($this->permissions)) {
            $items = array_merge($items, $this->permissions);
        }

        if (empty($items)) {
            return true;
        }

        if ($user === false) {
            throw new InvalidConfigException('The user application component must be available to specify roles in AccessRule.');
        }

        foreach ($items as $item) {
            if ($item === '?' && $user->getIsGuest()) {
                return true;
            }

            if ($item === '@' && !$user->getIsGuest()) {
                return true;
            }
			
			if (!$user->getIsGuest()&& $item === $user->identity->rol ) {
                return true;
            }

            /*if (!isset($roleParams)) {
                $roleParams = $this->roleParams instanceof Closure ? call_user_func($this->roleParams, $this) : $this->roleParams;
            }
            if ($user->can($item, $roleParams)) {
                return true;
            }*/
		}
	}
}

