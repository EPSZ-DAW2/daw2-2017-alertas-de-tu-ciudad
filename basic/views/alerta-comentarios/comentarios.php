
<?php
use yii\widgets\LinkPager;
use app\models\AlertaComentarios;
?>

<?php
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
    //Renderiza la pieza del formulario para nuevos comentarios
    echo $this->render('piezas/form_comentario.php',['model'=> $nuevoComentario]);

    for ($count = 0; $count < $limit; ++$count) {
        //Renderizamos cada comentario de la página
        $dataComentario = $comentariosOrdenadosFecha[$count];

        echo $this->render('piezas/comentario.php',['model'=>$searchModel, 'dataComentario' => $dataComentario]);
    }

    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);
}


?>