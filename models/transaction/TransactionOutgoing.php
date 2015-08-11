<?php

namespace app\models\transaction;

use Yii;

/**
 * This is the model class for table "transaction_outgoing".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $transaction_id
 * @property string $sum
 * @property string $comment
 * @property integer $user_id
 *
 * @property Account $account
 * @property Transaction $transaction
 * @property User $user
 * @property TransactionOutgoingTag[] $transactionOutgoingTags
 */
class TransactionOutgoing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_outgoing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'transaction_id', 'sum', 'comment', 'user_id'], 'required'],
            [['account_id', 'transaction_id', 'user_id'], 'integer'],
            [['sum'], 'number'],
            [['comment'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'transaction_id' => 'Transaction ID',
            'sum' => 'Sum',
            'comment' => 'Comment',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionOutgoingTags()
    {
        return $this->hasMany(TransactionOutgoingTag::className(), ['outgoing_id' => 'id']);
    }
}
