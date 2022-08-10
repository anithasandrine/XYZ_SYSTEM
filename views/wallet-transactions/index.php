<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Users;
use app\models\Wallet;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WalletTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Wallet Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-transactions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Wallet Transactions'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // '_to',
            [
                'label'=>'sent from',
                'attribute'=>'_from',
                'value'=>function($model){
                    // $user = Yii::$app->user->identity;
                    
                  $user_id = Wallet::find()->where(['id'=>$model['_from']])->one()->user;
                  return $user = Users::find()->where(['id'=>$user_id])->one()->username;

                }
            ],
            [
                'label'=>'sent to',
                'attribute'=>'_to',
                'value'=>function($model){
                    // $user = Yii::$app->user->identity;
                    
                    // $user_id = Wallet::find()->where(['id'=>$model['_to']])->one()->user;
                  return $user = Users::find()->where(['id'=>$model['_to']])->one()->username;

                }
            ],
            'amount',
            'transaction_fee',
            'message:ntext',
           
            //'_from',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, app\models\WalletTransactions $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
