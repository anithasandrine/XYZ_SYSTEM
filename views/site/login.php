<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<div id="login">

    <h2 style="margin-left:35%;">
        <span class="fontawesome-lock"></span>Sign In</h2>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',

    /*'fieldConfig' => [
    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],*/
    ]); ?>

    <fieldset style="width:30%;margin-left:35%;">
        <p><?= $form->field($model, 'username')->textInput(['autofocus' => true, 'id'=>'username', 'placeholder'=>'username'])->label(false) ?></p>

        <p><?= $form->field($model, 'password')->passwordInput(['id'=>'password', 'placeholder'=>'Your Password'])->label(false) ?> </p>

        <center><?= Html::submitButton('Sign In', ['class' => 'btn btn-secondary pull-right', 'name' => 'login-button']) ?></center>
    </fieldset>
    <br>
    <br>
    <br>
    <center><p>
       You don't have an account?<br> <?= Html::a(Yii::t('app', 'Sign Up'), ['users/create'], ['class' => 'btn btn-secondary']) ?>
    </p></center>

    <?php ActiveForm::end(); ?>

</div> <!-- end login --> 