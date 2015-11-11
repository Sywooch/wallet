<?php

namespace app\models\transaction;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $date
 * @property string $comment
 * @property integer $user_id
 *
 * @property User $user
 * @property TransactionExpense[] $transactionExpenses
 * @property TransactionIncoming[] $transactionIncomings
 * @property TransactionOutgoing[] $transactionOutgoings
 */
class Transaction extends \yii\db\ActiveRecord
{
    public $expenseContractorId = null;

    public function afterFind() {
        parent::afterFind();
        $contractors = [];
        
        foreach ($this->transactionExpenses as $transactionExpense) {
            if (isset($contractors[$transactionExpense->contractor_id])) {
                $contractors[$transactionExpense->contractor_id]++;
            } else {
                $contractors[$transactionExpense->contractor_id] = 1;
            }
        }
        if (!$contractors) {
            return;
        }
        $keys = array_keys($contractors, max($contractors));
        $this->expenseContractorId = array_shift($keys);
    }
    
    public function getAllContractorNames() {
        $contractors = [];
        foreach ($this->transactionExpenses as $expense) {
            $contractors[$expense->contractor->id] = $expense->contractor->name;
        }
        return join(", ", $contractors);
    }

    
        /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'user_id'], 'required'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'comment' => 'Comment',
            'user_id' => 'User ID',
        ];
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
    public function getTransactionExpenses()
    {
        return $this->hasMany(TransactionExpense::className(), ['transaction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionIncomings()
    {
        return $this->hasMany(TransactionIncoming::className(), ['transaction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionOutgoings()
    {
        return $this->hasMany(TransactionOutgoing::className(), ['transaction_id' => 'id']);
    }
}
