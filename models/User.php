<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string  $email
 * @property string  $last_name
 * @property string  $first_name
 * @property integer $state
 * @property string  $creation_date
 * @property integer $group_id
 *
 * @property Group   $group
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'creation_date',
                'updatedAtAttribute' => false,
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'group_id'], 'required'],
            [['state', 'group_id'], 'integer'],
            [['creation_date'], 'safe'],
            [['last_name', 'first_name'], 'string', 'max' => 255],
            ['email', 'email'],
            [['email'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'email'         => Yii::t('app', 'Email'),
            'last_name'     => Yii::t('app', 'Last Name'),
            'first_name'    => Yii::t('app', 'First Name'),
            'state'         => Yii::t('app', 'State'),
            'creation_date' => Yii::t('app', 'Creation Date'),
            'group_id'      => Yii::t('app', 'Group ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}
