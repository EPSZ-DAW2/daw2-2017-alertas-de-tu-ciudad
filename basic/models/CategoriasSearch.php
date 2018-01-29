<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categorias;
use app\controllers\CategoriasController;
use yii\grid\ActionColumn;
/**
 * CategoriasSearch represents the model behind the search form about `\app\models\Categorias`.
 */
class CategoriasSearch extends Categorias
{
    public $nombCatId;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id'], 'integer'],
            [['nombre', 'descripcion'], 'safe'],
            [['nombCatId'],'safe'],
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
        // $query = Categorias::find()->joinWith('categoria AS padre');
        $query = Categorias::find()->joinWith(['categoria categoria','padre padre']);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'pagination' => false,
            // 'pagination'=>[
            // 'pageSize' =>30,
            // ],
        ]);

        $dataProvider->getSort()->attributes['nombCatId']= [
            'asc' => [ 
                'padre.nombre' => SORT_ASC,
                'id' => SORT_ASC, 
                'nombre' => SORT_ASC,
                'descripcion' => SORT_ASC,
                'categoria_id' => SORT_ASC,
                ],
            'desc' => [
                'padre.nombre' => SORT_DESC,
                'id' => SORT_DESC, 
                'nombre' => SORT_DESC,
                'descripcion' => SORT_DESC,
                'categoria_id' => SORT_DESC,
                ],

            'default' => SORT_ASC,
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Busca categoria_id NULAS
        if($this->categoria_id==='0'){
            $this->categoria_id=NULL;
            $query->andFilterWhere([
                'categoria.id' => $this->id,
            ]); 
            $query->andWhere([
                'categoria.categoria_id' => $this->categoria_id,
            ]);
        }else{
            // Si la categoria_id no es NULA
            $query->andFilterWhere([
               'categoria.id' => $this->id,
               'categoria.categoria_id' => $this->categoria_id,
            ]);
        }
        
       
        $query->andFilterWhere(['like', 'categoria.nombre', $this->nombre])
            ->andFilterWhere(['like', 'categoria.descripcion', $this->descripcion])
            ->andFilterWhere(['like','padre.nombre',$this->nombCatId]);

        return $dataProvider;
    }
    
    public static function arbolCategorias($var=NULL,$tab=0)
    {   

        //$con = new CategoriasController('categorias','app');
        $query=Categorias::find();
        $cat=new ActiveDataProvider(['query'=>$query->andWhere([
                'categoria_id' => $var,
            ])]);
       
        
        $ci=$cat->getModels();
        $tab++;
        foreach ($ci as $key => $value) {
            echo '<p>';
            for ($i=0; $i <$tab-1 ; $i++) { 
               if($var!=NULL) echo  '&nbsp&nbsp&nbsp&nbsp';
            }
            echo Html::a(Yii::t('app', $value['nombre']), ['view?id='.$value['id']]);
             // echo Html::a(Yii::t('app', $value['nombre']), ['view?id='.$value['id']], ['class' => 'btn btn-success']);
            echo '</p>';
            
            self::arbolCategorias($value['id'],$tab);
        }
    }
    public static function arbolCategoriasArray($id=NULL,$tab=0)
    {   
            $temp=array();
            $ret=array();
            $spc='';

        $query=Categorias::find();
        $cat=new ActiveDataProvider(['query'=>$query->andWhere([
                'categoria_id' => $id,
            ])]);
        $mod=$cat->getModels();
        
        $tab++;
        for ($i=0; $i <$tab-1 ; $i++) 
               if($id!=NULL) $spc=$spc.'--';
        foreach ($mod as $key => $value) {
            $temp=$temp+array($value['id']=>$spc.$value['nombre']);
        // echo '<p>'.$value['id'].$spc.$value['nombre'].$value['categoria_id'].'</p>';
            $ret=$ret+$temp+self::arbolCategoriasArray($value['id'],$tab);            

        }
        return $ret;
    }
    
}
