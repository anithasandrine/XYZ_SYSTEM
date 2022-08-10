<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WalletTransactionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-transactions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'message') ?>

    <?= $form->field($model, '_to') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'transaction_fee') ?>

    <?php // echo $form->field($model, '_from') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
