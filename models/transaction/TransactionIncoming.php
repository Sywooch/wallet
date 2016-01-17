<?php

namespace app\models\transaction;

use Yii;
use app\models\account\Account;
use app\models\account\Balance;
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
    
    public function save($runValidation = true, $attributeNames = null) {
        $date = date('Y-m-d', strtotime($this->transaction->date . " +1 day"));
        if ($this->isNewRecord) {
            if ($date >= '2015-11-01') {
                $balance = $this->account->getBalance($date);
                if ($balance->date != $date) {
                    $balance = new Balance();
                    $balance->date = $date;
                    $balance->account_id = $this->account->id;
                }
                $balance->sum = $this->account->getBalance($date)->sum + $this->sum;
                $balance->save();
                $balance->updateFuture($this->sum);
            } else {
                // For previous records
                $balance = $this->account->getBalance($date);
                if (!$balance) {
                    $balance = $this->account->getClosestFutureBalance($date);
                }
                if ($balance->date != $date) {
                    $balance = new Balance();
                    $balance->date = $date;
                    $balance->account_id = $this->account->id;
                }
                $balance->sum = $this->account->getBalance($date)->sum;
                $balance->save();
                $balance->updatePast(-$this->sum);
            }
        } else {
            if ($date >= '2015-11-01') {
                // Substract previos from next balances
                // Add new to next balances
                $balance = $this->account->getBalance($date);
                if ($balance->date != $date) {
                    $balance = new Balance();
                    $balance->date = $date;
                    $balance->account_id = $this->account->id;
                }
                $balance->sum = $this->account->getBalance($date)->sum + $this->sum - $this->oldAttributes['sum'];
                $balance->save();
                $balance->updateFuture($this->sum - $this->oldAttributes['sum']);
            } else {
                // 
            }
        }
        
        return parent::save($runValidation, $attributeNames);
        
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
