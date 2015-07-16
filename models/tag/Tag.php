<?php

namespace app\models\tag;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $user_id
 *
 * @property User $user
 */
class Tag extends \yii\db\ActiveRecord
{
    public function create($data, $user) {
        $this->user_id = $user;
        return parent::load($data);
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'user_id'], 'required'],
            [['type'], 'string'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tag', 'ID'),
            'name' => Yii::t('tag', 'Name'),
            'type' => Yii::t('tag', 'Type'),
            'user_id' => Yii::t('tag', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
