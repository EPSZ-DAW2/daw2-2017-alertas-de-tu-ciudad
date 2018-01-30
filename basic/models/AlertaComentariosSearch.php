<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\models\AlertaComentarios;

/**
 * AlertaComentariosSearch represents the model behind the search form about `app\models\AlertaComentarios`.
 */
class AlertaComentariosSearch extends AlertaComentarios
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id',
                'alerta_id',
                'crea_usuario_id',
                'modi_usuario_id',
                'comentario_id',
                'cerrado',
                'num_denuncias',
                'bloqueado',
                'bloqueo_usuario_id',

                ],
                'integer'
            ],
            [
                ['crea_fecha',
                'modi_fecha',
                'texto',
                'fecha_denuncia1',
                'bloqueo_fecha',
                'bloqueo_notas',
                ],

                'safe'
            ],
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
<<<<<<< HEAD

            $usuario = new Usuarios();//Crea un modelo con la información del usuario
            $usuario=$usuario::findOne($_SESSION["__id"]);
            if(($usuario->rol) == 'M'){
                //En caso de que el usaurio sea moderador se le aplica el filtro para que solo vea alertas de su zona.
                /*
                SELECT * FROM alerta_comentarios
                    INNER JOIN alertas ON alerta_comentarios.alerta_id = alertas.id
                    INNER JOIN usuarios  ON alertas.area_id = usuarios.area_id WHERE usuarios.id = 1
                */
                $query = AlertaComentarios::find()
                    ->from('alerta_comentarios')
                    ->leftJoin('alertas','alerta_comentarios.alerta_id = alertas.id')
                    ->leftJoin('usuarios','alertas.area_id = usuarios.area_id')
                    ->where('usuarios.id = '. $usuario->id);
            }
            else{
                $query = AlertaComentarios::find();
            }
=======
        $query = AlertaComentarios::find();
>>>>>>> a6f4ffb58b9be3fda7dcd2dd5299c7c6fff2af3d

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
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
            'alerta_id' => $this->alerta_id,
            'crea_usuario_id' => $this->crea_usuario_id,
            'crea_fecha' => $this->crea_fecha,
            'modi_usuario_id' => $this->modi_usuario_id,
            'modi_fecha' => $this->modi_fecha,
            'comentario_id' => $this->comentario_id,
            'cerrado' => $this->cerrado,
            'num_denuncias' => $this->num_denuncias,
            'fecha_denuncia1' => $this->fecha_denuncia1,
            'bloqueado' => $this->bloqueado,
            'bloqueo_usuario_id' => $this->bloqueo_usuario_id,
            'bloqueo_fecha' => $this->bloqueo_fecha,
        ]);

        $query->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'bloqueo_notas', $this->bloqueo_notas]);

        return $dataProvider;
    }
    /*
     * Función que obtiene un data provider con los comentarios raiz o padres de los demás
     */
    public function obtenerComentariosPadres()
    {
<<<<<<< HEAD

            $usuario = new Usuarios();//Crea un modelo con la información del usuario
            $usuario=$usuario::findOne($_SESSION["__id"]);
            //Caso de moderador de zona
            if(($usuario->rol) == 'M'){

                //En caso de que el usaurio sea moderador se le aplica el filtro para que solo vea alertas de su zona.
                /*
                SELECT * FROM alerta_comentarios
                    INNER JOIN alertas ON alerta_comentarios.alerta_id = alertas.id
                    INNER JOIN usuarios  ON alertas.area_id = usuarios.area_id WHERE usuarios.id = 1
                */
                $query = AlertaComentarios::find()
                    ->leftJoin('alertas','alerta_comentarios.alerta_id = alertas.id')
                    ->leftJoin('usuarios','alertas.area_id = usuarios.area_id')
                    ->where('usuarios.id = '. $usuario->id)
                    //Añadimos esta condicion para solo mostrar los hilos abiertos
                    ->andFilterWhere(['comentario_id' => 0]);
            }
            //Caso que sea adminsitrador general
            else{
                $query = AlertaComentarios::find()
                    ->andFilterWhere(['comentario_id' => 0]);
            }

=======
        $query = AlertaComentarios::find()
            ->select(
                [
                    'id',
                    'alerta_id',
                    'crea_usuario_id',
                    'crea_fecha',
                    'modi_usuario_id',
                    'modi_fecha',
                    'texto',
                    'comentario_id',
                    'cerrado',
                    'num_denuncias',
                    'fecha_denuncia1',
                    'bloqueado',
                    'bloqueo_usuario_id',
                    'bloqueo_fecha',
                    'bloqueo_notas',
>>>>>>> a6f4ffb58b9be3fda7dcd2dd5299c7c6fff2af3d

                ]
            )

            //Añadimos esta condicion para solo mostrar los hilos abiertos
            ->andFilterWhere(['comentario_id' => 0]);

        //Creamos el data provider para obtener los comentarios padres ordenados por fecha
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort'=>[
                'defaultOrder' => [
                    'modi_fecha' => SORT_DESC,
                ]
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');

            return $dataProvider;
        }
        return $dataProvider;
    }

    /**
     * Función que crea devuelve un data provider con los datosOrdenados y devolviendo ademas el valor del nick(atributo virtual)
     * para los comentarios
     * @param $idIncidencia
     * @return ActiveDataProvider
     */
<<<<<<< HEAD
    public function ordenarComentariosFechaDesc($idIncidencia)
    {

            $usuario = new Usuarios();//Crea un modelo con la información del usuario

            //Si es moderador y el idIncidencia está vacio y nulo mostramos loscomentarios unicamente de su zona
            if(!empty($_SESSION["__id"]) && ($usuario->rol) == 'M' && empty($idIncidencia)){
                $usuario=$usuario::findOne($_SESSION["__id"]);
                //En caso de que el usaurio sea moderador se le aplica el filtro para que solo vea alertas de su zona.
                /*
                SELECT * FROM alerta_comentarios
                    INNER JOIN alertas ON alerta_comentarios.alerta_id = alertas.id
                    INNER JOIN usuarios  ON alertas.area_id = usuarios.area_id WHERE usuarios.id = 1
                */
                $query = AlertaComentarios::find()
                    ->select(
                        [
                            'alerta_comentarios.id',
                            'alerta_comentarios.alerta_id',
                            'alerta_comentarios.crea_usuario_id',
                            'alerta_comentarios.crea_fecha',
                            'alerta_comentarios.modi_usuario_id',
                            'alerta_comentarios.modi_fecha',
                            'alerta_comentarios.texto',
                            'alerta_comentarios.comentario_id',
                            'alerta_comentarios.cerrado',
                            'alerta_comentarios.num_denuncias',
                            'alerta_comentarios.fecha_denuncia1',
                            'alerta_comentarios.bloqueado',
                            'alerta_comentarios.bloqueo_usuario_id',
                            'alerta_comentarios.bloqueo_fecha',
                            'alerta_comentarios.bloqueo_notas',
                            'usuarios.nick',
                        ]


                    )
                    ->leftJoin('alertas','alerta_comentarios.alerta_id = alertas.id')
                    ->leftJoin('usuarios','alertas.area_id = usuarios.area_id')
                    ->where('usuarios.id = '. $usuario->id)
                        //Añadimos esta condicion para solo mostrar los hilos abiertos
                        ->andFilterWhere(['alerta_comentarios.cerrado' => 0]);

            }
            //si Administrador
            else{
                $query = AlertaComentarios::find()
                    ->select(
                        [
                            'alerta_comentarios.id',
                            'alerta_comentarios.alerta_id',
                            'alerta_comentarios.crea_usuario_id',
                            'alerta_comentarios.crea_fecha',
                            'alerta_comentarios.modi_usuario_id',
                            'alerta_comentarios.modi_fecha',
                            'alerta_comentarios.texto',
                            'alerta_comentarios.comentario_id',
                            'alerta_comentarios.cerrado',
                            'alerta_comentarios.num_denuncias',
                            'alerta_comentarios.fecha_denuncia1',
                            'alerta_comentarios.bloqueado',
                            'alerta_comentarios.bloqueo_usuario_id',
                            'alerta_comentarios.bloqueo_fecha',
                            'alerta_comentarios.bloqueo_notas',
                            'usuarios.nick',
                        ]
                    )
                    ->leftJoin('usuarios','`alerta_comentarios`.`crea_usuario_id`= `usuarios`.`id` ')
                    //Añadimos esta condicion para solo mostrar los hilos abiertos
                    ->andFilterWhere(['alerta_comentarios.cerrado' => 0]);


            }



=======
    public function ordenarComentariosFechaDesc($idIncidencia){

        $query = AlertaComentarios::find()
            ->select(
                [
                'alerta_comentarios.id',
                'alerta_comentarios.alerta_id',
                'alerta_comentarios.crea_usuario_id',
                'alerta_comentarios.crea_fecha',
                'alerta_comentarios.modi_usuario_id',
                'alerta_comentarios.modi_fecha',
                'alerta_comentarios.texto',
                'alerta_comentarios.comentario_id',
                'alerta_comentarios.cerrado',
                'alerta_comentarios.num_denuncias',
                'alerta_comentarios.fecha_denuncia1',
                'alerta_comentarios.bloqueado',
                'alerta_comentarios.bloqueo_usuario_id',
                'alerta_comentarios.bloqueo_fecha',
                'alerta_comentarios.bloqueo_notas',
                'usuarios.nick',
                ]
                )
                ->leftJoin('usuarios','`alerta_comentarios`.`crea_usuario_id`= `usuarios`.`id` ')
                //Añadimos esta condicion para solo mostrar los hilos abiertos
                ->andFilterWhere(['alerta_comentarios.cerrado' => 0]);

>>>>>>> a6f4ffb58b9be3fda7dcd2dd5299c7c6fff2af3d


        //Si existe el id de Incidencia se le hace el filtro sino se mostrarian todos los comentarios como en el caso del adminsitrador
        if(!empty($idIncidencia)){
            $query->andFilterWhere([
                'alerta_id' => $idIncidencia]);

        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort'=>[
                'defaultOrder' => [
                    'modi_fecha' => SORT_DESC,
                ]
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');

            return $dataProvider;
        }
        return $dataProvider;
    }

    /*
     * Función que encuentra todos los comentarios hijos dado un padre
     */
    public function encontrarComentariosHijos($idPadre){

        //Realizamos una selección con todos los hijos de idPadre
        $query = AlertaComentarios::find()





        ->andFilterWhere([
            'comentario_id' => $idPadre,
        ]);
        //Devolvemos estos hijos en el dataprovider
         $dataProvider = new ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 5,
             ],
             'sort'=>[
                 'defaultOrder' => [
                     'modi_fecha' => SORT_DESC,
                 ]
             ]
         ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;

    }
}
