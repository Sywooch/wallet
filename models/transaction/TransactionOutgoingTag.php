<?php

namespace app\models\transaction;

use Yii;

/**
 * This is the model class for table "transaction_outgoing_tag".
 *
 * @property integer $outgoing_id
 * @property integer $tag_id
 *
 * @property Tag $tag
 * @property TransactionOutgoing $outgoing
 */
class TransactionOutgoingTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_outgoing_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['outgoing_id', 'tag_id'], 'required'],
            [['outgoing_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'outgoing_id' => 'Outgoing ID',
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
    public function getOutgoing()
    {
        return $this->hasOne(TransactionOutgoing::className(), ['id' => 'outgoing_id']);
    }
}
