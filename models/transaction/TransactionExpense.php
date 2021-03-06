<?php

namespace app\models\transaction;

use Yii;
use app\models\contractor\Contractor;
/**
 * This is the model class for table "transaction_expense".
 *
 * @property integer $id
 * @property string $name
 * @property integer $contractor_id
 * @property integer $transaction_id
 * @property string $price
 * @property string $qty
 * @property string $sum
 * @property double $discount
 * @property string $comment
 * @property integer $user_id
 *
 * @property Contractor $contractor
 * @property Transaction $transaction
 * @property User $user
 * @property TransactionExpenseTag[] $transactionExpenseTags
 */
class TransactionExpense extends \yii\db\ActiveRecord
{
    public function formName() {
        return "Transaction[expense][" . $this->id . "]";
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
        return 'transaction_expense';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'transaction_id', 'price', 'qty', 'sum', 'user_id'], 'required'],
            [['contractor_id', 'transaction_id', 'user_id'], 'integer'],
            [['price', 'qty', 'sum', 'discount'], 'number'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'contractor_id' => 'Contractor ID',
            'transaction_id' => 'Transaction ID',
            'price' => 'Price',
            'qty' => 'Qty',
            'sum' => 'Sum',
            'discount' => 'Discount',
            'comment' => 'Comment',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(Contractor::className(), ['id' => 'contractor_id']);
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
    public function getTransactionExpenseTags()
    {
        return $this->hasMany(TransactionExpenseTag::className(), ['expense_id' => 'id']);
    }
}
