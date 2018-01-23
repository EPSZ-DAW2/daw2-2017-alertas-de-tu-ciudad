<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Etiquetas]].
 *
 * @see Etiquetas
 */
class EtiquetasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Etiquetas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Etiquetas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
