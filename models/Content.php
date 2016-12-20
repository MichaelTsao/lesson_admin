<?php

namespace app\models;

use Yii;
use mycompany\common\Logic;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "content".
 *
 * @property integer $content_id
 * @property integer $type
 * @property string $url
 * @property string $content
 * @property string $ctime
 */
class Content extends ActiveRecord
{
    const TYPE_WORDS = 1;
    const TYPE_IMAGE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['content'], 'string'],
            [['ctime'], 'safe'],
            [['url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content_id' => '内容ID',
            'type' => '类型',
            'url' => '资源URL',
            'content' => '文字内容',
            'ctime' => '创建时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'content_id',
                ],
                'value' => function ($event) {
                    if (!$this->content_id) {
                        return Logic::makeID();
                    } else {
                        return $this->content_id;
                    }
                },
            ],
        ];
    }
}
