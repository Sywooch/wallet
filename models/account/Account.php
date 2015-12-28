<?php

namespace app\models\account;

use Yii;
use app\models\currency\Currency;
//use app\modules\transfer\models\account\IncomingAccount;
//use app\modules\transfer\models\account\OutgoingAccount;
//use app\modules\transfer\models\account\InternalAccount;
/**
 * This is the model class for table "account".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $currency_id
 * @property string $title
 * @property integer $parent_id
 * @property integer $virtual
 *
 * @property Currency $currency
 * @property User $user
 * @property Account $parent
 * @property Account[] $accounts
 * @property Balance[] $balances
 * @property IncomingAccount[] $incomingAccounts
 * @property InternalAccount[] $internalAccounts
 * @property OutgoingAccount[] $outgoingAccounts
 */
class Account extends \yii\db\ActiveRecord
{
    public $level = 0;

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['insert'] = $scenarios['default'];
        return $scenarios;
    }

    public static function forUser($userId, $types) {
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
        $result = array_map(function($item) {return str_pad("", $item->level, "-") . ' ' . $item->title;}, self::hierarcyForUser($userId, $types));
        return $result;
    }

    public function beforeSave($insert) {
        $this->user_id = Yii::$app->user->getId();
        return parent::beforeSave($insert);
    }
    
    public function renderFinance($sum) {
        if ($sum >= 0) {
            return sprintf($this->currency->format, $sum);
        } else {
            return '-' . sprintf($this->currency->format, -$sum);
        }
    }
    
    public function getClosestfutureBalance($date) {
        $balance = $this->getBalances()->where("date > '$date'")->orderBy(['date' => SORT_ASC])->one();
        return $balance;
    }
    
    public function getBalance($date) {
        if (is_null($date)) {
            return $this->getCurrentBalance();
        }
        $balance = $this->getBalances()->where("date <= '$date' AND date > " . date('Y-m-d', strtotime('first day of this month')))->orderBy(['date' => SORT_DESC])->one();
        if (!$balance) {
            return null;
        }
        return $balance;
    }
    
    public function getCurrentBalance() {
        return $this->getBalances()->orderBy(['date' => SORT_DESC])->one();
    }
    
    /**
     * 
     * @param string $name
     * @return Account
     */
    public static function getByName($name, $userId) {
        return self::findOne(['title' => $name, 'user_id' => $userId]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parent_id', 'virtual'], 'integer'],
            [['type'], 'safe'],
            [['currency_id'], 'string', 'max' => 5],
            [['currency_id'], 'default', 'value' => null],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('account', 'ID'),
            'user_id' => Yii::t('account', 'User ID'),
            'type' => Yii::t('account', 'Type'),
            'currency_id' => Yii::t('account', 'Currency'),
            'title' => Yii::t('account', 'Title'),
            'parent_id' => Yii::t('account', 'Parent ID'),
            'virtual' => Yii::t('account', 'Virtual'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
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
    public function getParent()
    {
        return $this->hasOne(Account::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalances()
    {
        return $this->hasMany(Balance::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomingAccounts()
    {
        return $this->hasMany(IncomingAccount::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternalAccounts()
    {
        return $this->hasMany(InternalAccount::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutgoingAccounts()
    {
        return $this->hasMany(OutgoingAccount::className(), ['account_id' => 'id']);
    }
}
