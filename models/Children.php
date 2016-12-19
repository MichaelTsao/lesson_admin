<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/19
 * Time: 下午6:42
 */

namespace app\models;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * Class Children
 * @package app\models
 *
 * @property string $childClass
 * @property \yii\db\ActiveRecord[] $children
 * @property \yii\db\ActiveRecord[] $_children
 *
 */
class Children extends Behavior
{
    public $childClass = '\app\models\Section';
    protected $_children = null;
    protected $_oldChildren = null;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'validate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'save',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'save',
            // TODO: before delete
        ];
    }

    public function getChildren()
    {
        if ($this->_children === null) {
            $class = $this->childClass;
            $this->_children = $class::findAll(Tree::children($this->owner->primaryKey));
        }
        return $this->_children;
    }

    /**
     * @param $newChildren \yii\db\ActiveRecord[]
     */
    public function setChildren($newChildren)
    {
        $this->_oldChildren = $this->_children;
        $this->_children = $newChildren;
    }

    public function validate()
    {
        if (!$this->_children) {
            return true;
        }
        foreach ($this->_children as $child) {
            if (!$child->validate()) {
                return false;
            }
        }
        return true;
    }

    public function save()
    {
        $newList = [];
        foreach ($this->_children as $child) {
            $child->save();
            $newList[] = $child->primaryKey;
        }

        // remove not used old children
        if ($this->_oldChildren) {
            foreach ($this->_oldChildren as $child) {
                if (!in_array($child->primaryKey, $newList)) {
                    $child->delete();
                }
            }
        }

        // save new children list
        Tree::setChildren($this->owner->primaryKey, $newList);
        return true;
    }
}