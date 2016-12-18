<?php

namespace app\models;

use mycompany\common\Logic;
use Yii;

/**
 * This is the model class for table "section".
 *
 * @property integer $section_id
 * @property string $name
 * @property integer $type
 * @property string $ctime
 */
class Section extends \yii\db\ActiveRecord
{
    const TYPE_CHAPTER = 1;
    const TYPE_POINT = 2;
    const TYPE_SECTION = 3;

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

    public static function create()
    {
        $section = new Section();
        $section->section_id = Logic::makeID();
    }
}
