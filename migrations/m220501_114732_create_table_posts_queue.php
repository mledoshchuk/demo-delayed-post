<?php

use yii\db\Migration;

/**
 * Class m220501_114732_create_table_posts_queue
 */
class m220501_114732_create_table_posts_queue extends Migration
{
    public function Up()
    {
        $this->createTable("posts_queue", [
            "id" => $this->primaryKey()->unsigned(),
            "post_id" => $this->integer()
                ->unsigned()
                ->notNull(),
            "post_at" => $this->timestamp()
                ->notNull()
                ->defaultExpression("CURRENT_TIMESTAMP"),
            "notification_sent_at" => $this->timestamp()
                ->notNull()
                ->defaultExpression("CURRENT_TIMESTAMP"),
        ]);

        $this->createIndex(
            "FK_posts_queue_post_id_post_idx",
            "posts_queue",
            "post_id"
        );

        $this->addForeignKey(
            "FK_posts_queue_post_id_post",
            "posts_queue",
            "post_id",
            "post",
            "id",
            null,
            "cascade"
        );
    }

    public function Down()
    {
        $this->dropIndex("FK_posts_queue_post_id_post_idx", "posts_queue");

        $this->dropForeignKey("FK_posts_queue_post_id_post", "posts_queue");

        $this->dropTable("posts_queue");
    }
}
