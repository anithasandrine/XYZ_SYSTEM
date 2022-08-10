<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WalletTransactions */

$this->title = Yii::t('app', 'Send Money');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wallet Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-transactions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
