<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

defined('YII_ENV') or define('YII_ENV', 'dev');
?>

<div class="container text-center">
    <img src="images/logo.svg" class="main_img">
    <h1 class="main_name">Вас приветствует CityCubes!</h1>
    <h1 class="main_name">Авторизируйтесь для продолжения</h1>
<?php
    echo Nav::widget([
        'options' => ['class' => 'main_name'],
        'items' => [
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'main_name']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
?>
</div>