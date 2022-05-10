<?php

namespace app\models;

use Yii;
use yii\db\Connection;

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
        return "post";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["type", "company_name", "position"], "required"],
            [["type"], "integer"],
            [["company_name"], "string", "max" => 80],
            [["position"], "string", "max" => 45],
            [
                ["type"],
                "exist",
                "skipOnError" => true,
                "targetClass" => PostType::className(),
                "targetAttribute" => ["type" => "id"],
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
            "type" => "Type",
            "company_name" => "Company Name",
            "position" => "Position",
        ];
    }

    /**
     * Gets query for [[ContactPosts]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ContactPostQuery
     */
    public function getContactPosts()
    {
        return $this->hasMany(ContactPost::className(), ["post_id" => "id"]);
    }

    public function insertPost($type, $company_name, $position_name)
    {
        $this->type = $type;
        $this->company_name = $company_name;
        $this->position = $position_name;
        $this->save();

        return $this->id;
    }

    public function insertContactPost(
        int $type,
        $positionName,
        $companyName,
        $contactEmail,
        $contactName,
        $postAt
    ) {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->type = $type;
            $this->company_name = $companyName;
            $this->position = $positionName;
            $this->save();

            $connection
                ->createCommand(
                '
                insert into delayed_post.contact_post(post_id, contact_email, contact_name) 
                values (:post_id, :contact_email, :contact_name);

                insert into delayed_post.posts_queue(post_id, post_at) values (:post_id, :post_at);
                 '
                )
                ->bindValue(":contact_email", $contactEmail)
                ->bindValue(":contact_name", $contactName)
                ->bindValue(":post_at", $postAt)
                ->bindValue(":post_id", $this->id)
                ->execute();

            $transaction->commit();

            return "Completed";
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return $e;
        }
    }

    public function insertDescriptivePost(
        int $type,
        $positionName,
        $companyName,
        $positionDescription,
        int $salary,
        $startsAt,
        $endsAt,
        $postAt
    ) {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $this->type = $type;
            $this->company_name = $companyName;
            $this->position = $positionName;
            $this->save();

            $connection
                ->createCommand(
                '
                    insert into delayed_post.descriptive_post(post_id, position_description, salary, starts_at, ends_at) 
                    values (:post_id, :position_description, :salary, :starts_at, :ends_at);

                    insert into delayed_post.posts_queue(post_id, post_at) values (:post_id, :post_at);
                '
                )
                ->bindValue(":post_id", $this->id)
                ->bindValue(":position_description", $positionDescription)
                ->bindValue(":salary", $salary)
                ->bindValue(":starts_at", $startsAt)
                ->bindValue(":ends_at", $endsAt)
                ->bindValue(":post_at", $postAt)
                ->execute();

            $transaction->commit();

            return "Completed";
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return $e;
        }
    }

    /**
     * Gets query for [[DescriptivePosts]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\DescriptivePostQuery
     */
    public function getDescriptivePosts()
    {
        return $this->hasMany(DescriptivePost::className(), [
            "post_id" => "id",
        ]);
    }

    /**
     * Gets query for [[PostsQueues]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PostsQueueQuery
     */
    public function getPostsQueues()
    {
        return $this->hasMany(PostsQueue::className(), ["post_id" => "id"]);
    }

    /**
     * Gets query for [[Type0]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PostTypeQuery
     */
    public function getType0()
    {
        return $this->hasOne(PostType::className(), ["id" => "type"]);
    }
}
