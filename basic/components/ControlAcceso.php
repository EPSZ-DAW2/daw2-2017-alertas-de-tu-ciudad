<?php
namespace app\components;
use yii\filters\AccessControl;



class ControlAcceso extends AccessControl
{
	public $ruleConfig=['class'=>'app\components\ReglaAcceso'];
}

