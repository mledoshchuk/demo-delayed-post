<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "contact_post".
 *
 * @property int $post_id
 * @property string|null $contact_name
 * @property string $contact_email
 *
 * @property Post $post
 */
class ContactPost extends \yii\db\ActiveRecord
{
    public int $type = 1;
    public $company_name = '';
    public $position = '';
    public $position_name = '';
    public $post_at = '';
    
    /**
     * {@inheritdoc}    
     */
    public static function tableName()
    {
        return 'contact_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'contact_email'], 'required'],
            [['post_id'], 'integer'],
            [['type'], 'integer'],
            [['post_at'], 'datetime', 'format' => 'Y-m-d H:i:s'],
            [['contact_name'], 'string', 'max' => 80],
            [['contact_email'], 'string', 'max' => 255],
            [['contact_email'], 'email'],
            [['contact_email'], 'filter','filter'=>'trim'],
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
            'contact_name' => 'Contact Name',
            'contact_email' => 'Contact Email'
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
}
