<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AlertaEtiquetas]].
 *
 * @see AlertaEtiquetas
 */
class AlertaEtiquetasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AlertaEtiquetas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AlertaEtiquetas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
