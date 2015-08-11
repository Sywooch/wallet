<?php

namespace app\models\transaction;

use Yii;

/**
 * This is the model class for table "transaction_incoming_tag".
 *
 * @property integer $incoming_id
 * @property integer $tag_id
 *
 * @property Tag $tag
 * @property TransactionIncoming $incoming
 */
class TransactionIncomingTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_incoming_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['incoming_id', 'tag_id'], 'required'],
            [['incoming_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'incoming_id' => 'Incoming ID',
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
    public function getIncoming()
    {
        return $this->hasOne(TransactionIncoming::className(), ['id' => 'incoming_id']);
    }
}
