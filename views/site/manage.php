<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\User;
use app\models\Employees;
use app\models\Cities;
use app\models\ClientsForSending;

$this->title = 'area';
?>
<?php require_once '../views/site/menu.php'; ?>

<p class="text-center login_name">Регистрация новой площадки</p>
<div class="login_form">

        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
        <div class="form-group">
            <div class="text-center">
                <?= $form->field($users, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Логин новой площадки"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= $form->field($users, 'phone_number', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Номер телефона"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= $form->field($cities, 'city', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Город"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= $form->field($users, 'password', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Пароль"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= $form->field($users, 'employee_bonus', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Укажите процент бонусов"])?>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center">
                <?= Html::submitButton('Добавить площадку', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Registration']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        
</div>
<p class="text-center login_name">Выручка</p>
<div class="row">
    <div class="col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3">
        <p class="text-center login_name">Управление</p>
        <div class="login_form">

        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
            <div class="form-group">
                <div class="text-center">
                    <?php 
                        $items = ArrayHelper::map($AllUsers,'id','username');
                        $params = [
                            'prompt' => 'Выберите площадку'
                        ];
                    ?>
                    <?= $form->field($selectedUserForRevenue, 'user_id', ['enableLabel' => false])->dropDownList($items,$params) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= Html::submitButton('Выбрать площадку', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Registration']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <?php if($AllRevenues != NULL) { ?>
            <div>
                <span><b>Площадка:</b> </span><?= $AllRevenues[0]->user->username ?>
            </div>
            <div>
                <span><b>Номер телефона:</b> </span><?= $AllRevenues[0]->user->phone_number ?>
            </div>
            <div>
                <span><b>Город:</b> </span><?= $AllRevenues[0]->user->cities->city ?> 
            </div>
            <?php }?>

        </div>
    </div>
    <div class="col-md-offset-1 col-md-6 col-sm-offset-1 col-sm-6 col-xs-offset-1 col-xs-6">
        <p class="text-center login_name padding_bottom_top">Площадки</p>
        <table class="table table-striped client_table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Выручка</th>
                </tr>
            </thead>
            <tbody>
                <?php if($AllRevenues != NULL) { foreach ($AllRevenues as $revenues): ?>
                    <tr>
                        <td>
                            <?= $revenues->date ?>
                        </td>
                        <td>
                            <?= $revenues->revenue ?>
                        </td>
                    </tr>
                <?php endforeach; }?>
            </tbody>
        </table>
    </div>
</div>
<hr>
<p class="text-center login_name">Список работников</p>
<div class="row">
    <div class="col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3">
        <p class="text-center login_name">Управление</p>
        <div class="login_form">

        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
            <div class="form-group">
                <div class="text-center">
                    <?php 
                        $items = ArrayHelper::map($AllCities,'id','city');
                        $params = [
                            'prompt' => 'Выберите город'
                        ];
                    ?>
                    <?= $form->field($selectedCityForEmployees, 'city', ['enableLabel' => false])->dropDownList($items,$params) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= Html::submitButton('Выбрать город', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Registration']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <hr>
            
            <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($employees, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"ФИО работника"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($employees, 'phone_number', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Номер телефона"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= Html::submitButton('Добавить работника', ['class' => 'btn enter_btn btn-success margin_b_10px', 'name'=>'AddEmployees']) ?>
                    <?= Html::submitButton('Списать бонусы', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'DeleteBonus']) ?>
                    <?= Html::submitButton('Удалить работника', ['class' => 'btn enter_btn btn-danger    margin_b_10px', 'name'=>'DeleteEmployee']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <?php if( Yii::$app->session->hasFlash('employeeBonusNotFound') ): ?>
                <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('employeeBonusNotFound')); ?></p>
            <?php endif;?>
        </div>
    </div>


    <div class="col-md-offset-1 col-md-6 col-sm-offset-1 col-sm-6 col-xs-offset-1 col-xs-6">
        <p class="text-center login_name padding_bottom_top">Работники</p>
        <table class="table table-striped client_table">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Номер телефона</th>
                    <th>Город</th>
                    <th>Бонусы</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($AllEmployeesManage as $employeesManage): ?>
                <tr>
                    <td>
                        <?= $employeesManage->username ?>
                    </td>
                    <td>
                        <?= $employeesManage->phone_number ?>
                    </td>
                    <td>
                        <?= $employeesManage->cities->city ?>
                    </td>
                    <td>
                        <?= $employeesManage->bonus ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
    <div class="text-center">
    <p class="text-center form_section_name">Поиск клиента для SMS рассылки</p>
        <div class="login_form">
            <div class="form-group">
                <div class="text-center">
                    <label>Дата последнего посещения</label>
                    <?= $form->field($clientsForSending, 'last_visit_day', ['enableLabel' => false])->Input('date', ['class'=>'form-control margin_b_10px', 'placeholder'=>"Дата последнего посещения"])?>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <?= $form->field($clientsForSending, 'messageText', ['enableLabel' => false])->textarea(['class'=>'form-control margin_b_10px', 'placeholder'=>"Текст сообщения"])?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Отправить', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Search']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php if( Yii::$app->session->hasFlash('searchingClients') ): ?>
    <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('searchingClients')); ?></p>
<?php endif;?>