<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
    margin: 20px;
}
table a {
    color:#FEFDFD;
    font-weight: bold;
}
table {
    width: 100%;
    margin-bottom: 18px;
    padding: 0;
    font-size: 13px;
    border: 1px solid #141415;
    border-spacing: 0;
    border-collapse: separate;
	-webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    background-color: #37393c;
    font-family: Helvetica, Arial;
    font-size: 12px;
    color: white;
}

table th, table td {
    padding: 10px 10px 9px;
    line-height: 18px;
    text-align: left;
}

table th {
    padding-top: 9px;
    font-weight: bold;
    vertical-align: middle;
    color: #b6daff;
}

table td {
    vertical-align: top;
    border-top: 1px solid #ddd;
}

table th+th,table td+td,table th+td {
    border-left: 1px solid #ddd;
}

table thead tr:first-child th:first-child, table tbody tr:first-child td:first-child {
    -webkit-border-radius: 5px 0 0 0;
    -moz-border-radius: 5px 0 0 0;
    border-radius: 5px 0 0 0;
}

table thead tr:first-child th:last-child, table tbody tr:first-child td:last-child {
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
    border-radius: 0 5px 0 0;
}

table tbody tr:last-child td:first-child {
    -webkit-border-radius: 0 0 0 5px;
    -moz-border-radius: 0 0 0 5px;
    border-radius: 0 0 0 5px;
}

    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'test',
        'brandUrl' => '/',
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Главная', 'url' => '/'],
            ['label' => 'Регистрация', 'url' => '/site/register']

        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
<!-- Yandex.Metrika counter -->

<noscript></noscript>
<!-- /Yandex.Metrika counter -->
</html>
<?php $this->endPage() ?>
