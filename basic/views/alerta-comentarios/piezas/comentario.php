<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alerta Comentarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>



    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <style class="cp-pen-styles">
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

    .comment-wrap {
        margin-bottom: 1.25rem;
        display: table;
        width: 100%;
        min-height: 5.3125rem;
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

    }

    .comment-block {
        padding: 1rem;
        background-color: #fff;
        display: table-cell;
        vertical-align: top;
        border-radius: 0.1875rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08);
    }
    .comment-block textarea {
        width: 100%;
        resize: none;
    }

    .comment-text {
        margin-bottom: 1.25rem;
    }

    .bottom-comment {
        color: #acb4c2;
        font-size: 0.875rem;
    }

    .comment-date {
        float: left;
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

    <div class="comment-wrap">
        <div class="photo">
            <div class="avatar">
                
            </div>
        </div>
        <div class="comment-block">
            <p class="comment-text"> </p>
                <div class="bottom-comment">
                    <div class="comment-date">Fecha y hora </div>
                    <ul class="comment-actions">
                        <li class="complain">
                            <span class="glyphicon glyphicon-share-alt"></span>
                            Responder
                        </li>
                        <li class="complain">
                            <span class="glyphicon glyphicon-warning-sign"></span>
                            Denunciar
                        </li>
                    </ul>
                </div>

        </div>
    </div>

</div>


