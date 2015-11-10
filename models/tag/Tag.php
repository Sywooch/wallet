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
 * @property integer $parent_id
 *
 * @property User $user
 */
class Tag extends \yii\db\ActiveRecord
{
    public $level = 0;
    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['insert'] = $scenarios['default'];
        return $scenarios;
    }
    
    public function create($data, $user) {
        $this->user_id = $user;
        return parent::load($data);
    }

    public static function forUser($userId, $types = null) {
        $condition = ["user_id" => $userId];
        if ($types) {
            $condition['type'] = $types;
        }
        return self::find()->where($condition);
    }
    
    private static function _buildHierarchy($item, $level = 0) {
        $model = $item['model'];
        $res = [$model->id => $model];
        $res[$model->id]->level = $level;
        if ($item['child']) {
            foreach ($item['child'] as $c) {
                $tree = self::_buildHierarchy($c, $level+1);
                foreach ($tree as $t) {
                    $res[$t->id] = $t;
                }
            }
        }
        return $res;
    }
    
    public static function hierarcyForUser($userId, $types = null) {
        $result = array();
        $tree = array();
        $indexed = array();
        $models = self::forUser($userId, $types)->all();
        $oldCount = null;
        $it = 0;
        while ($m = array_shift($models)) {
            $it++;

            $item = ['model' => $m, 'child' => []];
            if (!$m->parent_id) {
                $tree[] = &$item;
            } elseif (!isset($indexed[$m->parent_id])) {
                array_push($models, $m);
                continue;
            } else {
                $indexed[$m->parent_id]['child'][$m->id] = &$item;
            }
            $indexed[$m->id] = &$item;
            unset($item);
//            \dump('', $indexed);
            $oldCount = count($models);
        }
        foreach ($tree as $t) {
            $hier = self::_buildHierarchy($t);
            foreach ($hier as $h) {
                $result[$h->id] = $h;
            }
        }
        return $result;
    }
    
    public static function plainHierarcyForUser($userId, $types = null) {
        $result = [0 => "-"];
        $result += array_map(function($item) {return str_pad("", $item->level, "-") . ' ' . $item->name;}, self::hierarcyForUser($userId, $types));
        return $result;
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
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'integer']
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

    public function beforeSave($insert) {
        if (!$this->parent_id) {
            $this->parent_id = null;
        }
        parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
