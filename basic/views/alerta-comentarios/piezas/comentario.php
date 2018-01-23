<?php

use yii\helpers\Html;


?>



    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <style class="">
        html, body {
            background-color: #f0f2fa;
            font-family: "PT Sans", "Helvetica Neue", "Helvetica", "Roboto", "Arial", sans-serif;
            color: #555f77;
            -webkit-font-smoothing: antialiased;
        }

        input, textarea {
            outline: none;
            border: none;
            display: block;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            font-family: "PT Sans", "Helvetica Neue", "Helvetica", "Roboto", "Arial", sans-serif;
            font-size: 1rem;
            color: #555f77;
        }
        input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
            color: #ced2db;
        }
        input::-moz-placeholder, textarea::-moz-placeholder {
            color: #ced2db;
        }
        input:-moz-placeholder, textarea:-moz-placeholder {
            color: #ced2db;
        }
        input:-ms-input-placeholder, textarea:-ms-input-placeholder {
            color: #ced2db;
        }

        p {
            line-height: 1.3125rem;
        }

        .comments {
            margin: 2.5rem auto 0;
            max-width: 60.75rem;
            padding: 0 1.25rem;
        }


        .photo {
            padding-top: 0.625rem;
            display: table-cell;
            width: 3.5rem;
        }
        .photo .avatar {
            height: 2.25rem;
            width: 2.25rem;
            border-radius: 50%;
            background-size: contain;
            background-image:url('<?= Yii::$app->request->baseUrl ?>/img/dummy.jpg');

        }

        .comment-block {
            padding: 1rem;
            background-color: #fff;
            display: table-cell;
            vertical-align: top;
            border-radius: 0.1875rem;
            width:100rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08);
        }
        .comment-block textarea {
            width: 100%;
            resize: none;
        }

        .comment-text {
            margin-bottom: 1.25rem;
            margin-top: 1.25rem;
        }

        .bottom-comment {
            color: #acb4c2;
            font-size: 0.875rem;
        }

        .comment-date {
            float: left;
        }

        .comment-name {
            float: left;
            font-weight:bold;
        }

        .comment-actions {
            float: right;
        }
        .comment-actions li {
            display: inline;
            margin: -2px;
            cursor: pointer;
        }
        .comment-actions li.complain {
            padding-right: 0.75rem;
            border-right: 1px solid #e1e5eb;
        }
        .comment-actions li.reply {
            padding-left: 0.75rem;
            padding-right: 0.125rem;
        }
        .comment-actions li:hover {
            color: #0095ff;
        }
    </style>


<div class="comments">

    <div class="photo">
        <div class="avatar">

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
                <li class="complain">Responder</li>
                <li class="complain"> Denunciar</li>
            </ul>
        </div>
    </div>

</div>




