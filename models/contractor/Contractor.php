<?php

namespace app\models\contractor;

use Yii;

/**
 * This is the model class for table "contractor".
 *
 * @property integer $id
 * @property string $name
 * @property string $comment
 * @property integer $user_id
 *
 * @property User $user
 */
class Contractor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contractor';
    }

    public static function dropdown($userId) {
        $items = static::find()->where(['user_id' => $userId])->orderBy(['name' => SORT_ASC])->all();
        $result = [];
        foreach ($items as $item) {
            $result[$item->id] = $item->name;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['comment'], 'string'],
            [['user_id'], 'default', 'value' => Yii::$app->user->getId()],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('contractor', 'ID'),
            'name' => Yii::t('contractor', 'Name'),
            'comment' => Yii::t('contractor', 'Comment'),
            'user_id' => Yii::t('contractor', 'User ID'),
        ];
    }
    
    /**
     * 
     * @param string $name
     * @return Contractor
     */
    public static function getByName($name) {
        return self::findOne(['name' => $name]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
