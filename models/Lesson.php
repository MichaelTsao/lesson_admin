<?php

namespace app\models;

use Yii;
use mycompany\common\Logic;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "lesson".
 *
 * @property string $lesson_id
 * @property string $name
 * @property string $price
 * @property string $intro
 * @property string $details
 * @property string $cover
 * @property \yii\web\UploadedFile $coverFile
 * @property string $chapters
 * @property integer $status
 * @property string $ctime
 * @property string $teachers
 */
class Lesson extends \yii\db\ActiveRecord
{
    const STATUS_NOT_BEGIN = 1;
    const STATUS_RUNNING = 2;
    const STATUS_END = 3;
    public static $statuses = [
        self::STATUS_NOT_BEGIN => '未开始',
        self::STATUS_RUNNING => '进行中',
        self::STATUS_END => '已结束',
    ];

    public $coverFile;
    protected $_teachers = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['details'], 'string'],
            [['status'], 'integer'],
            [['ctime', 'teachers'], 'safe'],
            [['lesson_id'], 'string', 'max' => 12],
            [['name', 'intro', 'cover', 'chapters'], 'string', 'max' => 1000],
            [['coverFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lesson_id' => '课程ID',
            'name' => '名字',
            'price' => '价格',
            'intro' => '简介',
            'details' => '详情',
            'cover' => '封面',
            'coverFile' => '封面',
            'chapters' => '章节信息',
            'status' => '状态',
            'ctime' => '创建时间',
            'teachers' => '导师',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'lesson_id',
                ],
                'value' => function ($event) {
                    if (!$this->lesson_id) {
                        return Logic::makeID();
                    } else {
                        return $this->lesson_id;
                    }
                },
            ],
        ];
    }

    public function fields()
    {
        return [
            'lesson_id',
            'name',
        ];
    }

    public function setCover()
    {
        if ($this->coverFile = UploadedFile::getInstance($this, 'coverFile')) {
            $this->cover = Logic::makeID() . '.' . $this->coverFile->extension;
        }
    }

    public function saveCover()
    {
        if ($this->coverFile && $this->cover) {
            $this->coverFile->saveAs(Yii::getAlias('@webroot/images/' . $this->cover));
        }
    }

    public function getTeachers()
    {
        if ($this->_teachers === null) {
            $this->_teachers = LessonTeacher::find()
                ->select(['teacher_id'])
                ->where(['lesson_id' => $this->lesson_id])
                ->orderBy(['sort' => SORT_ASC])
                ->asArray()
                ->column();
        }
        return json_encode($this->_teachers);
    }

    public function setTeachers($value)
    {
        $this->_teachers = $value;
        LessonTeacher::deleteAll(['lesson_id' => $this->lesson_id]);
        foreach (json_decode($value, true) as $index => $item) {
            $teacher = new LessonTeacher();
            $teacher->lesson_id = $this->lesson_id;
            $teacher->teacher_id = $item;
            $teacher->sort = $index;
            $teacher->save();
        }
    }
}
