<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lesson_teacher".
 *
 * @property string $lesson_id
 * @property string $teacher_id
 */
class LessonTeacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lesson_teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lesson_id', 'teacher_id'], 'required'],
            [['lesson_id', 'teacher_id'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lesson_id' => '课程',
            'teacher_id' => '导师',
        ];
    }
}
