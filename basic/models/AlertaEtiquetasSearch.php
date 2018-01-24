<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlertaEtiquetas;

/**
 * AlertaEtiquetasSearch represents the model behind the search form about `app\models\AlertaEtiquetas`.
 */
class AlertaEtiquetasSearch extends AlertaEtiquetas
{
	 public $titulo_alerta;
    public $nombre_etiqueta;

	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'alerta_id', 'etiqueta_id'], 'integer'],
				[['titulo_alerta','nombre_etiqueta'], 'safe'],
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
        $query = AlertaEtiquetas::find();
		  $query = AlertaEtiquetas::find()->joinWith('alerta AS alerta')->joinWith('etiqueta AS etiqueta');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		  
		  $dataProvider->getSort()->attributes['titulo_alerta']= [
            'asc' => [   
                'alerta.titulo' => SORT_ASC,
                'etiqueta.nombre' => SORT_ASC,
                'id' => SORT_ASC,
                'alerta_id' => SORT_ASC,
                'etiqueta_id' => SORT_ASC,
                ],
            'desc' => [
                'alerta.titulo' => SORT_DESC,
                'etiqueta.nombre' => SORT_DESC,
                'id' => SORT_DESC,
                'alerta_id' => SORT_DESC,
                'etiqueta_id' => SORT_DESC,
                ],

            'default' => SORT_ASC,
            //'label' => 'Nombre CAT',
        ];
		  
        $dataProvider->getSort()->attributes['nombre_etiqueta']= [
            'asc' => [   
                'alerta.titulo' => SORT_ASC,
                'etiqueta.nombre' => SORT_ASC,
                'id' => SORT_ASC,
                'alerta_id' => SORT_ASC,
                'etiqueta_id' => SORT_ASC,
                ],
            'desc' => [
                'alerta.titulo' => SORT_DESC,
                'etiqueta.nombre' => SORT_DESC,
                'id' => SORT_DESC,
                'alerta_id' => SORT_DESC,
                'etiqueta_id' => SORT_DESC,
                ],

            'default' => SORT_ASC,
            //'label' => 'Nombre CAT',
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'alerta_id' => $this->alerta_id,
            'etiqueta_id' => $this->etiqueta_id,
        ]);
		  
		  $query->andFilterWhere(['like','alerta.titulo',$this->titulo_alerta])
            ->andFilterWhere(['like','etiqueta.nombre',$this->nombre_etiqueta]);

        return $dataProvider;
    }
}
