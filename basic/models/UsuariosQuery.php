<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Usuarios]].
 *
 * @see Usuarios
 */
class UsuariosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Usuarios[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Usuarios|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
