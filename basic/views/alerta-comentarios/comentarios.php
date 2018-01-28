
<?php
use yii\widgets\LinkPager;
use app\models\AlertaComentarios;
use app\models\Usuarios;
?>

<?php
    $usuario = null;
    //Obtenemos el modelo del usuario
    if(!empty($_SESSION["__id"])){

        $usuario = new Usuarios(); //Creamos un modelo usuario
        $usuario = $usuario::findOne($_SESSION["__id"]); //encontrando toda su inforación por su id
    }

    $comentariosOrdenadosFecha = $dataProvider2->getModels();
    /*obtenemos la paginacion*/
    $pagination = $dataProvider2->getPagination();

    if ($pagination === false) {

    }
    else {

    // El total de las páginas obtenidas son
    $pagination->totalCount = $dataProvider2->getTotalCount();
    //El limite de las páginas es
    $limit = sizeof($comentariosOrdenadosFecha);

    //Nuevo comentario que metera el usuario por input
    $nuevoComentario = new AlertaComentarios();

    //No renderizamos el formulario a los usuarios no conectados
    if(!empty($usuario)) {
        //Renderiza la pieza del formulario para nuevos comentarios
        echo $this->render('piezas/form_comentario.php', [
            'model' => $nuevoComentario,
            'idAlerta' => $idAlerta]);
    }

    for ($count = 0; $count < $limit; ++$count) {
        //Renderizamos cada comentario de la página
        $dataComentario = $comentariosOrdenadosFecha[$count];

        echo $this->render('piezas/comentario.php',
            ['model'=>$searchModel,
            'dataComentario' => $dataComentario,
            'usuario' => $usuario
            ]);
    }

    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);
}


?>