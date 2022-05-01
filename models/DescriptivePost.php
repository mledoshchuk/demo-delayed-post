<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "descriptive_post".
 *
 * @property int $post_id
 * @property string|null $position_description
 * @property int|null $salary
 * @property string $starts_at
 * @property string $ends_at
 *
 * @property Post $post
 */
class DescriptivePost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'descriptive_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'ends_at'], 'required'],
            [['post_id', 'salary'], 'integer'],
            [['position_description'], 'string'],
            [['starts_at', 'ends_at'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'position_description' => 'Position Description',
            'salary' => 'Salary',
            'starts_at' => 'Starts At',
            'ends_at' => 'Ends At',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PostQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\DescriptiveQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\DescriptiveQuery(get_called_class());
    }
}
