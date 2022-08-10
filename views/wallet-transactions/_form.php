<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\WalletTransactions */
/* @var $form yii\widgets\ActiveForm */

$user=Yii::$app->user->identity;
?>

<div class="wallet-transactions-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?> -->

    <!-- <?= $form->field($model, '_to')->textInput() ?> -->
    <?= $form->field($model, '_to')->widget(\yii2mod\selectize\Selectize::className(), [
        'items'=>ArrayHelper::merge([null=>'Select User'],  ArrayHelper::map(Users::find()->where("id <> $user->id")->all(), 'id', function($model) {
            return $model->username;
        })),
        'pluginOptions' => [
            'persist' => false,
            'createOnBlur' => true,
            'create' => true
        ]
    ]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'transaction_fee')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
