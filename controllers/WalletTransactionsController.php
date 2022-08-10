<?php

namespace app\controllers;

use app\models\WalletTransactions;
use app\models\WalletTransactionsSearch;
use app\models\Wallet;
use app\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * WalletTransactionsController implements the CRUD actions for WalletTransactions model.
 */
class WalletTransactionsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all WalletTransactions models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WalletTransactionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WalletTransactions model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WalletTransactions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WalletTransactions();
        $user = Yii::$app->user->identity;


        $model->_from=Wallet::find()->where(['user'=>$user->id])->one()->id;

        $balance= Wallet::find()->where(['user'=>$user->id])->one()->balance;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if($model->amount < 10000){
                    $model->transaction_fee =0;
                }
                else if($model->amount >= 10000 && $model->amount  < 100000 ){
                    $model->transaction_fee =200;
                }
                else{
                    $model->transaction_fee=300;
                }
                 
                // $to= Wallet::find()->where(['id'=>$model->_to])->one()->user;
                $to= Users::find()->where(['id'=>$model->_to])->one()->id;
                $receiver = Users::find()->where(['id'=>$model->_to])->one()->username;

                $receiver_wallet= Wallet::find()->where(['user'=>$to])->one()->id;

                $model->message="Money was sent from ".$user->username. " to ".$receiver;

                if($model->amount > $balance){
                    echo "<script> alert('Insufficient balance')</script>";
                }
                else{
                    if($model->save()){

                    Yii::$app->db->createCommand("UPDATE wallet SET balance = balance - $model->amount - $model->transaction_fee where id = $model->_from")->execute();
                    Yii::$app->db->createCommand("UPDATE wallet SET balance = balance + $model->amount where id = $receiver_wallet")->execute();
                    return $this->redirect(['site/index']);
                }
                }
                
                

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WalletTransactions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WalletTransactions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WalletTransactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return WalletTransactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WalletTransactions::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
