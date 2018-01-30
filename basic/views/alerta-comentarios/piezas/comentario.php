<?php

use yii\helpers\Html;

?>
<div class="bocadillo<?=$dataComentario->id?>">

</div>
<div  id="cPublicado<?=$dataComentario->id?>" class="comments <?="Respuesta".$dataComentario->id?>">
    <div class="photo">
        <div class="avatar" style="background-image:url('<?= Yii::$app->request->baseUrl ?>/img/dummy.jpg')";>
        </div>
    </div>
    <div class="comment-block ">
        <div class="comment-name">
            <h1><?=$dataComentario->nick?></h1>
            <h4> <b>#<?=$dataComentario->id?></b>
                <?php   if(($dataComentario->comentario_id) == 0){ //Comentario padre/raiz?>
                        <span class="glyphicon glyphicon-asterisk"></span>

                        <?php echo " Raiz ";
                        }
                        else {
                        ?><span class="glyphicon glyphicon-arrow-right"></span>
                            <?php echo "#".$dataComentario->comentario_id;
                        }
                        ?>
           </h4>
            <p class="comment-text">
                <?= $dataComentario->texto;?>
            </p>
            <div class="comment-date">
                <?php
                $date = new DateTime($dataComentario->modi_fecha);
                echo date_format($date, 'H:i:s (d-m-Y)');
                ?>
            </div>
            <!--Si el usuario está logeado entonces le mostramoslas acciones sino no-->
            <?php if(!empty($usuario)){ ?>
                <ul class="comment-actions">

                    <?php
                    //Si el comentario no está bloqueado permitimos responder
                    if(!$dataComentario->bloqueado) {?>
                        <a href="?idComentarioPadre=<?=$dataComentario->id?>&id=<?=$dataComentario->alerta_id?>#Comentar">
                            <li class="complain"><span class="glyphicon glyphicon-share-alt"></span> Responder </li>
                        </a>
                    <?php }
                    //Si no si el que ha creado el comentario es el usuario registrado le permitimos su modificacion,
                    // A los administradores les permitimos modificar todas
                    // y moderadores les permitimos modificar las de su zona
                    $alerta = new app\models\Alerta();
                    $alerta = $alerta::findOne($dataComentario->alerta_id);

                    //Si el usuario es moderador y esta en su area puede modificar cualquier comentario de su area
                    //O
                    //Si el usuario es administrador puede modificar cualquier comentario
                    //O
                    //Si el usuario inscribio el comentario tambien puede modificarlo
                    if( ($usuario->rol =='M' && strcmp($usuario->area_id ,$alerta->area_id) ==0)
                        || $usuario->rol == 'A'
                        ||(($usuario->id ==$dataComentario->crea_usuario_id) && $dataComentario->bloqueado == 0)
                    ){
                    ?>
                        <a href="<?=Yii::getAlias('@web')?>/alerta-comentarios/modificarcomentario?id=<?=$dataComentario->id?>">
                            <li class="complain"><span class="glyphicon glyphicon-pencil"></span> Modificar </li>
                        </a>
                    <?php
                    }
                    if($dataComentario->bloqueado){?>
                        <li class="complain redFont">
                            <span class="glyphicon glyphicon-ban-circle"></span> Bloqueado
                        </li>
                   <?php } ?>

                    <a href="<?=Yii::getAlias('@web')?>/usuario-incidencias/createdenuncia?id=<?=$dataComentario->id?>&tipo=comentario">
                        <li class="complain yellowFont">
                            <span class="glyphicon glyphicon-warning-sign"></span> Denunciar
                        </li>
                    </a>
                </ul>
            <?php } ?>
        </div>
    </div>

</div>
<?php
    $urlControladorAjax = Yii::getAlias('@web')."/alerta-comentarios/ajax?id=$dataComentario->comentario_id";
    $identificadorComentario = "\".Respuesta".$dataComentario->id."\"";
    $bocadillo = "\".bocadillo".$dataComentario->id."\"";
    $this->registerJs( <<< EOT_JS
        var flag = 0; //flag para evitar que se hagan varios appends a la vez
        $($identificadorComentario).hover(function(){
            //Si esta a 0 permitimos la peticion ajax
            if(flag == 0){
               
                jQuery.ajax({
                    url:'$urlControladorAjax',
                    type:'GET',
                    success:function(mensaje) {
                            //Si lo permite la flag lo añade
                            if(flag == 0)
                                $($bocadillo).append(mensaje);
                            flag = 1; //ponemos la flag a 1
                    },
                    error : function(){
                        console.log("error");
                    }
                });
            }
                    
        },function(){
                  
                   $(".bubble").remove();   //quitamos esa clase 
                   flag = 0;        //reiniciamos la flag
                  
        });

EOT_JS
    );
?>