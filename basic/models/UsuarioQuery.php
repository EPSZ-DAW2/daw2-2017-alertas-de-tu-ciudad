<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Usuario]].
 *
 * @see Usuario
 */
class UsuarioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Usuario[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Usuario|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
