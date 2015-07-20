<?php

namespace app\models\currency;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property string $id
 * @property string $title
 * @property string $format
 *
 * @property Account[] $accounts
 */
class Currency extends \yii\db\ActiveRecord
{
    public static function listAll() {
        $currencies = self::find()->all();
        $result = [];
        foreach ($currencies as $c) {
            $result[$c->id] = $c->title;
        }
        return $result;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'format'], 'required'],
            [['id'], 'string', 'max' => 5],
            [['title'], 'string', 'max' => 64],
            [['format'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('currency', 'ID'),
            'title' => Yii::t('currency', 'Title'),
            'format' => Yii::t('currency', 'Format'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['currency' => 'id']);
    }
}
