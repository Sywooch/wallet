<?php

namespace app\models\transaction;

use Yii;
use app\models\account\Account;
/**
 * This is the model class for table "transaction_incoming".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $transaction_id
 * @property string $sum
 * @property string $comment
 * @property integer $user_id
 * @property integer $contractor_id
 * 
 * @property Account $account
 * @property Transaction $transaction
 * @property User $user
 * @property TransactionIncomingTag[] $transactionIncomingTags
 */
class TransactionIncoming extends \yii\db\ActiveRecord
{
    public function formName() {
        return "Transaction[incoming][" . $this->id . "]";
    }
    
    public function __construct() {
        $this->id = '%%newid%%';
        parent::__construct();
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_incoming';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'transaction_id', 'sum', 'user_id'], 'required'],
            [['account_id', 'contractor_id', 'transaction_id', 'user_id'], 'integer'],
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
    public function getTransactionIncomingTags()
    {
        return $this->hasMany(TransactionIncomingTag::className(), ['incoming_id' => 'id']);
    }
}
