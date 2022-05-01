<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $type
 * @property string $company_name
 * @property string $position
 *
 * @property ContactPost[] $contactPosts
 * @property DescriptivePost[] $descriptivePosts
 * @property PostsQueue[] $postsQueues
 * @property PostType $type0
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'company_name', 'position'], 'required'],
            [['type'], 'integer'],
            [['company_name'], 'string', 'max' => 80],
            [['position'], 'string', 'max' => 45],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => PostType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'company_name' => 'Company Name',
            'position' => 'Position',
        ];
    }

    /**
     * Gets query for [[ContactPosts]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ContactPostQuery
     */
    public function getContactPosts()
    {
        return $this->hasMany(ContactPost::className(), ['post_id' => 'id']);
    }

    /**
     * Gets query for [[DescriptivePosts]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\DescriptivePostQuery
     */
    public function getDescriptivePosts()
    {
        return $this->hasMany(DescriptivePost::className(), ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostsQueues]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PostsQueueQuery
     */
    public function getPostsQueues()
    {
        return $this->hasMany(PostsQueue::className(), ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Type0]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PostTypeQuery
     */
    public function getType0()
    {
        return $this->hasOne(PostType::className(), ['id' => 'type']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PostQuery(get_called_class());
    }
}
