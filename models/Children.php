<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/12/19
 * Time: 下午6:42
 */

namespace app\models;

use yii\base\Behavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class Children
 * @package app\models
 *
 * @property string $childClass
 * @property \yii\db\ActiveRecord[] $children
 * @property \yii\db\ActiveRecord[] $_children
 * @property \yii\db\ActiveRecord $owner
 *
 */
class Children extends Behavior
{
    public $childClass = '\app\models\Section';
    protected $_children = null;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'validate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'save',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'save',
            ActiveRecord::EVENT_BEFORE_DELETE => 'delete',
        ];
    }

    /**
     * @return ActiveRecord[]
     */
    public function getChildren()
    {
        if ($this->_children === null) {
            $this->_children = $this->readChildren();
        }
        return $this->_children;
    }

    public function readChildren()
    {
        $children = [];
        $class = $this->childClass;
        foreach (Tree::children($this->owner->primaryKey) as $id) {
            $children[] = $class::findOne($id);
        }
        return $children;
    }

    /**
     * @param $newChildren \yii\db\ActiveRecord[]
     */
    public function setChildren($newChildren)
    {
        // TODO: validate new children
        $this->_children = $newChildren;
    }

    public function validate($event)
    {
        if (!$this->_children) {
            return true;
        }
        foreach ($this->_children as $child) {
            if (!$child->validate()) {
                $event->isValid = false;
                return false;
            }
        }
        return true;
    }

    public function save($event)
    {
        if ($this->_children === null) {
            return true;
        }

        $newList = [];

        // save children data
        foreach ($this->_children as $child) {
            $child->save();
            $newList[] = $child->primaryKey;
        }

        // remove not used old children
        $oldChildren = $this->readChildren();
        if ($oldChildren && $event->name == ActiveRecord::EVENT_BEFORE_UPDATE) {
            foreach ($oldChildren as $child) {
                if (!in_array($child->primaryKey, $newList)) {
                    $child->delete();
                }
            }
        }

        // save new children list
        Tree::setChildren($this->owner->primaryKey, $newList);

        return true;
    }

    public function delete($event)
    {
        if (!$children = $this->readChildren()) {
            return;
        }
        foreach ($children as $child) {
            if ($child) {
                $child->delete();
            }
        }
        Tree::deleteAll(['parent_id' => $this->owner->primaryKey]);
    }
}