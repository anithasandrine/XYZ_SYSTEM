<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wallet".
 *
 * @property int $id
 * @property float $balance
 * @property int $user
 *
 * @property User $user0
 * @property WalletTransactions[] $walletTransactions
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['balance', 'user'], 'required'],
            [['balance'], 'number'],
            [['user'], 'integer'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'balance' => Yii::t('app', 'Balance'),
            'user' => Yii::t('app', 'User'),
        ];
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * Gets query for [[WalletTransactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWalletTransactions()
    {
        return $this->hasMany(WalletTransactions::className(), ['wallet' => 'id']);
    }
}
