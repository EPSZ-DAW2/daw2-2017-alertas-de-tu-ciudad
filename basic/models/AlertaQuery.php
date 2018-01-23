<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Alerta]].
 *
 * @see Alerta
 */
class AlertaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Alerta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Alerta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
