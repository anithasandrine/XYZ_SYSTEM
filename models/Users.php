<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 *
 * @property Wallet[] $wallets
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 200],
            [['password', 'authKey', 'accessToken'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'accessToken' => Yii::t('app', 'Access Token'),
        ];
    }

    public function getAuthKey(){
        return $this->authKey;
    }
    public function getId(){
        return $this->id;
    }
    public function validateAuthKey($authKey){
        return $this->authKey===$authKey;
    }
    public static function findIdentity($id){
        return self::findOne($id);
    }
    public static function findIdentityByAccessToken($token,$type=null){
        throw new \yii2\base\NotSupportedException;
    }
    public static function findByUsername($username){
        return self::findOne(['username'=>$username]);
    }
    public function validatePassword($password){
       return $this->password ===$password;

       // return Yii::$app->getSecurity()->generatePasswordHash( $password);
    }

    /**
     * Gets query for [[Wallets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallets()
    {
        return $this->hasMany(Wallet::className(), ['users' => 'id']);
    }
}
