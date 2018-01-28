<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

use app\widgets\Alert;

use app\models\Visitors;
use app\models\Clients;
use app\models\Employees;

$this->title = 'visitors';
?>

<?php require_once '../views/site/menu.php'; ?>


<div class="row">
    <div class="col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3">
        <p class="text-center login_name">Добавить посетителя</p>
        <div class="login_form">

            <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($visitors, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Имя Фамилия ребенка"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($visitors, 'phone_number', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Номер телефона"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($visitors, 'minutes', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Количество минут"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($visitors, 'visit_price', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Цена посещения"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= Html::submitButton('Регистрация', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'Registration']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>

            <hr>
            <p class="text-center login_name">Списать бонусы</p>
            <?php $form2 = ActiveForm::begin(['options'=>['class'=>'form-horizontal', 'name'=>'deleteBonusForm']]); ?>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($visitorsBonus, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Имя Фамилия ребенка"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($visitorsBonus, 'phone_number', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Номер телефона"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= Html::submitButton('Списать', ['class' => 'btn enter_btn margin_b_10px', 'name'=>'deleteBonus']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
            <?php if( Yii::$app->session->hasFlash('clientBonusNotFound') ): ?>
                <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('clientBonusNotFound')); ?></p>
            <?php endif;?>

            <hr>
            <p class="text-center login_name">Сейчас работают</p>

            <?php foreach ($nowWorkingEmployees as $nowWorkingEmployee): ?>
                <p class="form_section_name margin_top_0"><?= $nowWorkingEmployee->username ?></p>
            <?php endforeach; ?>

            <p class="text-center login_name">Добавить работника</p>
            <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal', 'name'=>'deleteBonusForm']]); ?>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($employees, 'username', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Имя Фамилия работника"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= $form->field($employees, 'phone_number', ['enableLabel' => false])->textInput(['class'=>'form-control margin_b_10px', 'placeholder'=>"Номер телефона"])?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= Html::submitButton('Начать работу', ['class' => 'btn btn-success enter_btn margin_b_10px', 'name'=>'StartWork']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <?= Html::submitButton('Закончить работу', ['class' => 'btn btn-warning enter_btn margin_b_10px', 'name'=>'EndWork']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
            <?php if( Yii::$app->session->hasFlash('employeeWorking') ): ?>
            <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('employeeWorking')); ?></p>
            <?php endif;?>
            <?php if( Yii::$app->session->hasFlash('employeeWorked') ): ?>
            <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('employeeWorked')); ?></p>
            <?php endif;?>
            <?php if( Yii::$app->session->hasFlash('employeeNotFound') ): ?>
                <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('employeeNotFound')); ?></p>
            <?php endif;?>
            


                
            <hr><br>
            <div class="modal fade" id="basicModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal_teacher modal-content">
                        <button class="close" type="button" data-dismiss="modal">X</button>
                        <div class="text-center">
                            <p class="text-center login_name">Работали сегодня</p>

                            <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal', 'name'=>'AddEmployeesBonus']]); ?>
                                <div class="margin_b_10px">
                                    <div class="inline_block">
                                        <?php foreach ($AllEmployeesWorked as $employeesWorked): ?>
                                            <div>
                                                <label class="form_section_name margin_top_0 black_text"><?= $employeesWorked->username ?>: с</label>
                                                <label class="form_section_name margin_top_0 "><?= $employeesWorked->start_work ?></label>
                                                <label class="form_section_name margin_top_0 black_text"> до </label>
                                                <label class="form_section_name margin_top_0"><?= $employeesWorked->end_work ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="text-center">
                                        <?= Html::submitButton('Очистить список', ['class' => 'btn btn-danger enter_btn margin_b_10px', 'name'=>'AddEmployeesBonus']) ?>
                                    </div>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger enter_btn margin_b_10px" data-toggle="modal" data-target="#basicModal">Очистить список</button>
            <?php if( Yii::$app->session->hasFlash('employeeWorkNow') ): ?>
                <p class="text-center color_red"><?php echo(Yii::$app->session->getFlash('employeeWorkNow')); ?></p>
            <?php endif;?>
        </div>
    </div>
  
    
        
    <div class="col-md-offset-1 col-md-6 col-sm-offset-1 col-sm-6 col-xs-offset-1 col-xs-6">
        <p class="text-center login_name padding_bottom_top">Посетители</p>
        <table class="table table-striped client_table">
            <thead>
                <tr>
                    <th></th>
                    <th>ФИО</th>
                    <th>Номер телефона</th>
                    <th>Конец посещения</th>
                    <th>Бонусное время(мин)</th>
                </tr>
            </thead>
            <tbody>
            
            <?php foreach ($AllVisitors as $visitor): ?>
                <tr>
                    <td>
                        <?= $visitor->id ?>
                    </td>
                    <td>
                        <?= $visitor->username ?>
                    </td>
                    <td>
                        <?= $visitor->phone_number ?>
                    </td>
                    <td id="<?= $visitor->id ?>">
                        <?= $visitor->exit_time ?>
                    </td>
                    <td>
                        <?= $visitor->bonus ?>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
