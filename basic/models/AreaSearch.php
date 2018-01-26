<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Area;

/**
 * AreaSearch represents the model behind the search form of `app\models\Area`.
 */
class AreaSearch extends Area
{
    public $parentName;
    public $claseArea;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'area_id', 'clase_area_id'], 'integer'],
            [['claseArea','parentName','nombre'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Area::find();

        // add conditions that should always apply here
        $query->joinWith(['parentArea pA'], true, 'LEFT OUTER JOIN');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'parentName' => [
                    'asc' => ['pA.nombre' => SORT_ASC],
                    'desc' => ['pA.nombre' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'nombre',
                'claseArea' => [
                    'asc' => ['clase_area_id' => SORT_ASC],
                    'desc' => ['clase_area_id' => SORT_DESC],
                    'default' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'area_id' => $this->area_id,
            'areas.clase_area_id' => $this->claseArea
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
        ->andFilterWhere(['like','pA.nombre', $this->parentName]);

        return $dataProvider;
    }
}
