<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CategoriasEtiquetas;
use app\models\CategoriasSearch;

/**
 * CategoriasEtiquetasSearch represents the model behind the search form about `app\models\CategoriasEtiquetas`.
 */
class CategoriasEtiquetasSearch extends CategoriasEtiquetas
{
    public $nombre_categoria;
    public $nombre_etiqueta;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'etiqueta_id'], 'integer'],
            [['nombre_categoria','nombre_etiqueta'], 'safe'],
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
        $query = CategoriasEtiquetas::find()->joinWith('categoria AS categoria')->joinWith('etiqueta AS etiqueta');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->getSort()->attributes['nombre_categoria']= [
            'asc' => [   
                'categoria.nombre' => SORT_ASC,
                'etiqueta.nombre' => SORT_ASC,
                'id' => SORT_ASC,
                'categoria_id' => SORT_ASC,
                'etiqueta_id' => SORT_ASC,
                ],
            'desc' => [
                'categoria.nombre' => SORT_DESC,
                'etiqueta.nombre' => SORT_DESC,
                'id' => SORT_DESC,
                'categoria_id' => SORT_DESC,
                'etiqueta_id' => SORT_DESC,
                ],

            'default' => SORT_ASC,
            //'label' => 'Nombre CAT',
        ];
        $dataProvider->getSort()->attributes['nombre_etiqueta']= [
            'asc' => [   
                'categoria.nombre' => SORT_ASC,
                'etiqueta.nombre' => SORT_ASC,
                'id' => SORT_ASC,
                'categoria_id' => SORT_ASC,
                'etiqueta_id' => SORT_ASC,
                ],
            'desc' => [
                'categoria.nombre' => SORT_DESC,
                'etiqueta.nombre' => SORT_DESC,
                'id' => SORT_DESC,
                'categoria_id' => SORT_DESC,
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
            'categoria_id' => $this->categoria_id,
            'etiqueta_id' => $this->etiqueta_id,
        ]);
        $query->andFilterWhere(['like','categoria.nombre',$this->nombre_categoria])
            ->andFilterWhere(['like','etiqueta.nombre',$this->nombre_etiqueta]);

        return $dataProvider;
    }
	 
	 /**
     * Crea data provider agrupado por ID. Hecho para ver las categorias a las que pertenece una etiqueta.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function CategoriasEt($params)
    {
        $query = CategoriasEtiquetas::find()->joinWith('categoria AS categoria')->joinWith('etiqueta AS etiqueta');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'categoria_id' => $this->categoria_id,
            'etiqueta_id' => $this->etiqueta_id,
        ]);
		  
        $query->andFilterWhere(['like','categoria.nombre',$this->nombre_categoria])
            ->andFilterWhere(['like','etiqueta.nombre',$this->nombre_etiqueta])->groupBy('categoria_id');

        return $dataProvider;
    }
	 
	 
    public function arbolEtiquetasArray()
    {   
        $temp=array();

        $query=Etiquetas::find();
        $cat=new ActiveDataProvider(['query'=>$query]);
        $mod=$cat->getModels();
        
        foreach ($mod as $key => $value) {
            $temp=$temp+array($value['id']=>$value['nombre']);
        }
        return $temp;
    }
}
