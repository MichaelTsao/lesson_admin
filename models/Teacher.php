<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use mycompany\common\Logic;

/**
 * This is the model class for table "teacher".
 *
 * @property string $teacher_id
 * @property string $name
 * @property string $phone
 * @property integer $status
 * @property string $ctime
 */
class Teacher extends \yii\db\ActiveRecord
{
    const STATUS_NORMAL = 1;
    const STATUS_CLOSED = 2;
    public static $statuses = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_CLOSED => '关闭',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['ctime'], 'safe'],
            [['teacher_id'], 'string', 'max' => 12],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'teacher_id' => '导师ID',
            'name' => '名字',
            'phone' => '手机号',
            'status' => '状态',
            'ctime' => '创建时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'teacher_id',
                ],
                'value' => Logic::makeID(),
            ],
        ];
    }
}
