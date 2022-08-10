<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WalletTransactions;

/**
 * WalletTransactionsSearch represents the model behind the search form of `app\models\WalletTransactions`.
 */
class WalletTransactionsSearch extends WalletTransactions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', '_to', '_from'], 'integer'],
            [['message'], 'safe'],
            [['amount', 'transaction_fee'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WalletTransactions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            '_to' => $this->_to,
            'amount' => $this->amount,
            'transaction_fee' => $this->transaction_fee,
            '_from' => $this->_from,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
