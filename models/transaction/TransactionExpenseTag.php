<?php

namespace app\models\transaction;

use Yii;

/**
 * This is the model class for table "transaction_expense_tag".
 *
 * @property integer $expense_id
 * @property integer $tag_id
 *
 * @property Tag $tag
 * @property TransactionExpense $expense
 */
class TransactionExpenseTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_expense_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expense_id', 'tag_id'], 'required'],
            [['expense_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'expense_id' => 'Expense ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpense()
    {
        return $this->hasOne(TransactionExpense::className(), ['id' => 'expense_id']);
    }
}
