<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Categorias]].
 *
 * @see Categorias
 */
class CategoriasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Categorias[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Categorias|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
