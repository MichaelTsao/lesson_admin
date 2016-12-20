<?php

namespace app\models;

use mycompany\common\Logic;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "section".
 *
 * @property integer $section_id
 * @property string $name
 * @property integer $type
 * @property string $ctime
 * @property \app\models\Section[] $children
 */
class Section extends \yii\db\ActiveRecord
{
    const TYPE_CHAPTER = 1;
    const TYPE_POINT = 2;
    const TYPE_SECTION = 3;

    protected $_children = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['ctime'], 'safe'],
            [['name'], 'string', 'max' => 500],
            [['name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'section_id' => '章节ID',
            'name' => '名字',
            'type' => '类型',
            'ctime' => '创建时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'section_id',
                ],
                'value' => function ($event) {
                    if (!$this->section_id) {
                        return Logic::makeID();
                    } else {
                        return $this->section_id;
                    }
                },
            ],
            Children::className(),
        ];
    }

    public static function create($type, $id = null)
    {
        return new Section([
            'type' => $type,
            'section_id' => $id ? $id : Logic::makeID(),
        ]);
    }

    public static function get($id, $type)
    {
        if ($item = self::findOne($id)) {
            return $item;
        } else {
            return self::create($type, $id);
        }
    }
}
