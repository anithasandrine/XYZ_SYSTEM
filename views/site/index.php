<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Wallet;
use app\models\Users;

// $user = Yii::$app->user->identity;
// $wallet=Wallet::find()->where(['user'=>$user->id])->one()->id;

// var_dump($wallet);

$this->title = 'E-wallet System';

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">XYZ E_Wallet System</h1><br>
        <!-- <p>Welcome to Electronic Wallet</p> -->
    </div>

<?php if(Yii::$app->user->identity){ ?>
    
    <?php
         $user = Yii::$app->user->identity;
         $wallet=Wallet::find()->where(['user'=>$user->id])->one()->id;
         
    ?>
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 bg-light">
            <p>
                <?= Html::a(Yii::t('app', 'Recharge here'), ['wallet/create'], ['class' => 'btn btn-secondary']) ?>
            </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'=>'Your account balance',
                'attribute'=>'balance',
            ],
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, app\models\Wallet $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
            // 'balance',
          
        ],
    ]); ?>
     </div>
 
            
    
    <div class="col-lg-8 bg-light">
            <p>
                <?= Html::a(Yii::t('app', 'Send money to another wallet'), ['wallet-transactions/create'], ['class' => 'btn btn-secondary']) ?>
            </p>
    <h5>Transactions made on your account!</h5><br>
    <?= GridView::widget([
        'dataProvider' => $dataProviderTransactions,
        'filterModel' => $searchModelTransactions,
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
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, app\models\WalletTransactions $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
        ],
    ]); ?>


    </div>
    <?php } else{?>




    </div>
            <div class="col-lg-12 text-center">
               <p>
                Login Here!<br><br> <?= Html::a(Yii::t('app', 'Sign In'), ['site/login'], ['class' => 'btn btn-primary']) ?>
            </p>
            </div>
    <?php } ?>
  
            
            
       

    </div>
</div>
