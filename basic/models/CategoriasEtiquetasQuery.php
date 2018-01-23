<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CategoriasEtiquetas]].
 *
 * @see CategoriasEtiquetas
 */
class CategoriasEtiquetasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CategoriasEtiquetas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CategoriasEtiquetas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
