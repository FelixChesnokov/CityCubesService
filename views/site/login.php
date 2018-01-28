<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<header>
    <div class="row">
        <div class="col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3">
            <a href="<?php echo Url::to(['index']); ?>"><img src="images/logo.svg"></a>
        </div>
    </div>
</header>
<div class="container">
    <div class="login_form">

        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
            <p class="text-center login_name">Вход</p>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($model, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control', 'placeholder'=>"Логин"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($model, 'password', ['enableLabel' => false])->passwordInput(['class'=>'form-control','placeholder'=>"Пароль"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= Html::submitButton('Войти', ['class' => 'btn enter_btn']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>