<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\Clients;

$this->title = 'clients';
?>
<?php require_once '../views/site/menu.php'; ?>

<div class="row ">
    <p class="text-center login_name">Регистрация нового клиента</p>

    <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
    <div class="text-center">
        <div class="login_form">
            <p class="text-center form_section_name">Информация о клиенте</p>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($clients, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Имя Фамилия клиента"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($clients, 'birthday', ['enableLabel' => false])->Input('date', ['class'=>'form-control margin_b_10px', 'placeholder'=>"Дата рождения"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($clients, 'phone_number', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Номер телефона"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($clients, 'email', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Email"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($clients, 'is_parent')->checkbox(['class'=>'client_checkbox', 'label'=>' родитель'])?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Регистрация', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Registration']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    
    <?php if( Yii::$app->session->hasFlash('clientRegistered') ): ?>
        <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('clientRegistered')); ?></p>
    <?php endif;?>

</div>