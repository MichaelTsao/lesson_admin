<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property string $parent_id
 * @property string $children
 * @property string $ctime
 */
class Tree extends \yii\db\ActiveRecord
{
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
            'ctime' => '创建时间',
        ];
    }

    public static function children($id)
    {
        $result = [];
        if ($parent = self::findOne($id)) {
            $result = json_decode($parent->children, true);
        }
        return $result;
    }

    public static function setChildren($id, $children)
    {
        if (!$parent = self::findOne($id)) {
            $parent = new Tree();
            $parent->parent_id = $id;
        }
        $parent->children = json_encode($children);
        if ($parent->save()) {
            return true;
        }
        return false;
    }
}
