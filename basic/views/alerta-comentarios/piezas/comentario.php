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
            <h1>Nombre Usuario #<?=$dataComentario->comentario_id?></h1>
        </div>
        <p class="comment-text">
            <?= $dataComentario->texto;?>
        </p>
        <div class="bottom-comment">
            <div class="comment-date"><?= $dataComentario->modi_fecha;?></div>
            <ul class="comment-actions">
                <a href=""> <li class="complain"><span class="glyphicon glyphicon-share-alt"></span> Responder </li></a>
                <a href=""><li class="complain"> <span class="glyphicon glyphicon-warning-sign"></span> Denunciar </li></a>
            </ul>
        </div>
    </div>

</div>




