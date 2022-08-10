<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wallet_transactions".
 *
 * @property int $id
 * @property string|null $message
 * @property int $_to
 * @property float $amount
 * @property float $transaction_fee
 * @property int $_from
 *
 * @property Wallet $from
 */
class WalletTransactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallet_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['_to', 'amount'], 'required'],
            [['_to', '_from'], 'integer'],
            [['amount', 'transaction_fee'], 'number'],
            [['_from'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::className(), 'targetAttribute' => ['_from' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            '_to' => Yii::t('app', 'To'),
            'amount' => Yii::t('app', 'Amount'),
            'transaction_fee' => Yii::t('app', 'Transaction Fee'),
            '_from' => Yii::t('app', 'From'),
        ];
    }

    /**
     * Gets query for [[From]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(Wallet::className(), ['id' => '_from']);
    }
}
