<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts_queue".
 *
 * @property int $id
 * @property int $post_id
 * @property string $post_at
 * @property string $notification_sent_at
 *
 * @property Post $post
 */
class PostsQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "posts_queue";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["post_id"], "required"],
            [["post_id"], "integer"],
            [["post_at", "notification_sent_at"], "safe"],
            [
                ["post_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Post::className(),
                "targetAttribute" => ["post_id" => "id"],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            "id" => "ID",
            "post_id" => "Post ID",
            "post_at" => "Post At",
            "notification_sent_at" => "Notification Sent At",
        ];
    }
    public function insertQueuePost(int $postId, $postAt)
    {
        $this->post_id = $postId;
        $this->post_at = $postAt;

        $this->save();

        return true;
    }

    public function insertQueueNotification(int $postId, $postAt)
    {
        $connection = Yii::$app->db;

        $connection
            ->createCommand(
            '
                update delayed_post.posts_queue set
                notification_sent_at = :post_at
                where post_id = :post_id;
            '
            )
            ->bindValue(":post_id", $postId)
            ->bindValue(":post_at", $postAt)
            ->execute();

        return true;
    }
    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ["id" => "post_id"]);
    }
}
