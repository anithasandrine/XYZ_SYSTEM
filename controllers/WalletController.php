<?php

namespace app\controllers;

use app\models\Wallet;
use app\models\WalletSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * WalletController implements the CRUD actions for Wallet model.
 */
class WalletController extends Controller
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
     * Lists all Wallet models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WalletSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Wallet model.
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
     * Creates a new Wallet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Wallet();
        $user = Yii::$app->user->identity;
        $wallet=Wallet::find()->where(['user'=>$user->id])->one()->id;
        $bal=Wallet::find()->where(['id'=>$wallet])->one()->balance;
         $model = $this->findModel($wallet);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                Yii::$app->db->createCommand("UPDATE wallet set balance=$bal+$model->balance where user=$user->id")->execute();
                return $this->redirect(['site/index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Wallet model.
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

    public function actionRecharge()
    {
        // $model = $this->findModel($id);

      $model=new Wallet(); 
      $user = Yii::$app->user->identity;
      $wallet=Wallet::find()->where(['user'=>$user->id])->one()->id;

       $model = $this->findModel($wallet);
      
       if ($this->request->isPost) {
        if ($model->load($this->request->post())) {

            $model->user=$user->id;

            if($model->save()){
                return $this->redirect(['site/index']);
            }
            
        }
    } else {
        $model->loadDefaultValues();
    }

    return $this->render('recharge', [
        'model' => $model,
    ]);
}

    /**
     * Deletes an existing Wallet model.
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
     * Finds the Wallet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Wallet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wallet::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
