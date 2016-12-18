<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property string $parent_id
 * @property string $children
 * @property integer $last
 * @property string $ctime
 */
class Tree extends \yii\db\ActiveRecord
{
    const IS_LAST = 1;
    const IS_NOT_LAST = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'required'],
            [['last'], 'integer'],
            [['ctime'], 'safe'],
            [['parent_id'], 'string', 'max' => 12],
            [['children'], 'string', 'max' => 10000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => '父节点',
            'children' => '子项目',
            'last' => '是否最底层',
            'ctime' => '创建时间',
        ];
    }

    public static function children($id)
    {
        return json_decode(self::findOne($id)->children, true);
    }
}
