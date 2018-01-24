
<?php
use yii\widgets\LinkPager;
?>

<?php
            $comentariosOrdenadosFecha = $dataProvider2->getModels();
            /*obtenemos la paginacion*/
            $pagination = $dataProvider2->getPagination();

            if ($pagination === false) {

            } else {

                // El total de las páginas obtenidas son
                $pagination->totalCount = $dataProvider2->getTotalCount();
                //El limite de las páginas es
                $limit = sizeof($comentariosOrdenadosFecha);
                //Renderiza la pieza del formulario para nuevos comentarios
                echo $this->render('piezas/form_comentario.php');

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