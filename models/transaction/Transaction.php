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
    public $unsavedExpenses = [];
    public $unsavedIncomes = [];
    public $unsavedOutgoings = [];
    
    public $expenses = [];
    public $incomings = [];
    public $outgoings = [];

    public $expenseContractorId = null;

    public function init() {
        parent::init();
        $this->date = strtotime('d.m.Y H:i', time());
    }
    
    public function load($data, $formName = null) {
        $loaded = parent::load($data, $formName);
        if (!$this->date) {
            $this->date = date('Y-m-d H:i:s');
        } else {
            $this->date = date('Y-m-d H:i:s', strtotime($this->date));
        }
        $scope = $formName === null ? $this->formName() : $formName;
        
        if (isset($data[$scope])) {
        
            if (isset($data[$scope]['outgoing'])) {
                foreach ($data[$scope]['outgoing'] as $key => $outgoing) {
                    if (isset($this->outgoings[$key])) {
                        $loaded &= $this->outgoings[$key]->load($outgoing, '');
                    } else {
                        $out = new TransactionOutgoing();
                        $out->id = $key;
                        $loaded &= $out->load($outgoing, '');
                        $this->outgoings[] = $out;
                    }
                }
            }

            if (isset($data[$scope]['incoming'])) {
                foreach ($data[$scope]['incoming'] as $key => $incoming) {
                    if (isset($this->incomings[$key])) {
                        $loaded &= $this->incomings[$key]->load($incoming, '');
                    } else {
                        $in = new TransactionIncoming();
                        $in->id = $key;
                        $loaded &= $in->load($incoming, '');
                        $this->incomings[] = $in;
                    }
                }
            }

            if (isset($data[$scope]['expense'])) {
                foreach ($data[$scope]['expense'] as $key => $expense) {
                    if (isset($this->expenses[$key])) {
                        $loaded &= $this->expenses[$key]->load($expense, '');
                    } else {
                        $exp = new TransactionExpense();
                        $exp->id = $key;
                        $loaded &= $exp->load($expense, '');
                        $this->expenses[] = $exp;
                    }
                }
            }
        }
        
        return $loaded;
    }
    
    public function save($runValidation = true, $attributeNames = null) {
        $return = parent::save($runValidation, $attributeNames);
        foreach ($this->expenses as $k => $expense) {
            $this->expenses[$k]->transaction_id = $this->id;
            $this->expenses[$k]->user_id = $this->user_id;
            $this->expenses[$k]->save() || ddump($this->expenses[$k]->errors);
        }
        foreach ($this->incomings as $k => $incoming) {
            $this->incomings[$k]->transaction_id = $this->id;
            $this->incomings[$k]->user_id = $this->user_id;
            $this->incomings[$k]->save() || ddump($this->incomings[$k]->errors);
        }
        foreach ($this->outgoings as $k => $outgoing) {
            $this->outgoings[$k]->transaction_id = $this->id;
            $this->outgoings[$k]->user_id = $this->user_id;
            $this->outgoings[$k]->save() || ddump($this->outgoings[$k]->errors);
        }
        return $return;
    }
    
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
        if ($contractors) {
            $keys = array_keys($contractors, max($contractors));
            $this->expenseContractorId = array_shift($keys);
        }

        $this->outgoings = [];
        foreach ($this->transactionOutgoings as $outgoing) {
            $this->outgoings[$outgoing->id] = $outgoing;
        }
        $this->incomings = [];
        foreach ($this->transactionIncomings as $incoming) {
            $this->incomings[$incoming->id] = $incoming;
        }
        $this->expenses = [];
        foreach ($this->transactionExpenses as $expense) {
            $this->expenses[$expense->id] = $expense;
        }
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
            [['date'], 'default', 'value' => date('d.m.Y H:i')],
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
