<?php

namespace app\models\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Users;

class AccountsController extends Controller
{
    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        $success = ['token' => ''];

        Yii::error($post);
        $model = Users::find()->where(['username' => $post['username']])->one();
        if (empty($model)) {
            $success['success'] = false;
            $success['message'] = Yii::t('app', 'Invalid username or password');
            return $success;
        }

        if (Yii::$app->security->validatePassword($post['password'], $model->password)) {
            $model->generateToken();

            $success['success'] = true;
            $success['message'] = Yii::t('app', 'Login was successful!');
            $success['token'] = $model->token_id;
            return $success;
        } else {
            $success['success'] = false;
            $success['message'] = Yii::t('app', 'Invalid username or password');
            return $success;
        }
    }
}
