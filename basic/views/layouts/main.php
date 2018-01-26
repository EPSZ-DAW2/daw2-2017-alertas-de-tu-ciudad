<?php
/* @var $this \yii\web\View */
/* @var $content string */
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>"> 
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?='<link rel="mask-icon" href="'.Yii::$app->request->baseUrl.'/img/pin_logo.png" color="#293dff">'?>
    <?='<link rel="icon" href="'.Yii::$app->request->baseUrl.'/img/pin_logo_c.png"'?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('app','Home'), 'url' => ['/site/index']],
			['label' => 'Alertas', 'url' => ['/alertas']],
            /*['label' => 'About', 'url' => ['/site/about']],*/
            /*['label' => 'Contact', 'url' => ['/site/contact']],*/
            //Acceso a Categorias 
            ['label' => Yii::t('app','Categories'), 'url' => ['/categorias']],
            //Acceso a Etiquetas 
            ['label' => Yii::t('app','Tags'), 'url' => ['/etiquetas']],
            //Acceso a Incidencias
            ['label' => 'Incidencias', 'url' => ['/usuario-incidencias']],
            //Acceso a usuarios
            ['label' => Yii::t('app','Users'), 'url' => ['/usuarios']],
            //Acceso a los comentarios de las alertas
            ['label' => 'Comentarios', 'url' => ['/alerta-comentarios']],
            ['label' => Yii::t('app', 'Áreas'), 'url' => ['/area']],
            //Index Imagenes listas.
            //Se modificará en un futuro para permitir únicamente el acceso
            //a administradores/moderadores.
            ['label' => Yii::t('app', 'Imágenes'), 'url' => ['/alerta-imagenes']],
			['label' => Yii::t('app', 'Config'), 'url' => ['/configuraciones'], 'visible'=>(!Yii::$app->user->isGuest and Yii::$app->user->identity->rol=='A') ],
            ['label' => Yii::t('app', 'Logs'), 'url' => ['/logs'], 'visible'=>(!Yii::$app->user->isGuest and Yii::$app->user->identity->rol=='A') ],

            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->nick . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php //Probar que funciona el JUI. 
          //echo yii\jui\DatePicker::widget(['name' => 'attributeName']);
        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Daw2 Alertas <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>