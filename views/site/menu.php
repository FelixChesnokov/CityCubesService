<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<header>
    <div class="row text-center">
        <div class="col-md-3 col-sm-3">
            <a href="<?php echo Url::to(['index']); ?>"><img src="images/logo.svg"></a>
        </div>
        <div class="col-md-3 col-sm-3">
            <a href="<?php echo Url::to(['visitors']); ?>">Добавить посетителя</a>
        </div>
        <div class="col-md-3 col-sm-3">
            <a href="<?php echo Url::to(['clients']); ?>">Добавить клиента</a>
        </div>
        <?php if(Yii::$app->user->identity->is_admin == 1){?>
        <div class="col-md-3 col-sm-3">
            <a href="<?php echo Url::to(['manage']); ?>">Управление</a>
        </div>
        <?php } ?>
    </div>
</header>
