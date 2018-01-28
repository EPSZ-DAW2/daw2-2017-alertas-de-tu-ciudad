<?php

use yii\helpers\Html;

?>

<div class="comments">

    <div class="photo">
        <div class="avatar" style="background-image:url('<?= Yii::$app->request->baseUrl ?>/img/dummy.jpg')";>
        </div>
    </div>
    <div class="comment-block">
        <div class="comment-name">
            <h1><?=$dataComentario->nick?></h1>
            <h4 class="<?="Respuesta".$dataComentario->id?>"> <b>#<?=$dataComentario->id?></b>
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

                    <?php if(!$dataComentario->bloqueado) {?>
                        <a href="?idComentarioPadre=<?=$dataComentario->id?>&id=<?=$dataComentario->alerta_id?>#Comentar">
                            <li class="complain"><span class="glyphicon glyphicon-share-alt"></span> Responder </li>
                        </a>
                    <?php }else{?>
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
    $this->registerJs( <<< EOT_JS

        $($identificadorComentario).hover(function(){
         
                    jQuery.ajax({
                        url:'$urlControladorAjax',
                        type:'GET',
                        success:function(mensaje) {
                            
                            console.log(mensaje);
                        },
                        error : function(){
                            console.log("error");
                        }
                    });
        });

EOT_JS
    );
?>