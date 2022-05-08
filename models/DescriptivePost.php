<?php

namespace app\models;

use Yii;
use yii\db\Query;

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
    public int $type = 2;
    public $company_name = '';
    public $position = '';
    public $position_name = '';
    public $post_at = '';
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
            [['ends_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['post_id', 'salary'], 'integer'],
            [['position_description'], 'string'],
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
    public function insertDescriptivePost(int $postId, $positionDescription, int $salary, $startsAt, $endsAt){
        
        $this->post_id = $postId;
        $this->position_description = $positionDescription;
        $this->salary = $salary;
        $this->starts_at = $startsAt;
        $this->ends_at = $endsAt;
        
        $this->save();

        return true;
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
}
