<?php

use yii\db\Migration;

/**
 * Class m220501_114602_create_table_descriptive_post
 */
class m220501_114602_create_table_descriptive_post extends Migration
{
    public function Up()
    {
        $this->createTable("descriptive_post", [
            "post_id" => $this->integer()
                ->unsigned()
                ->notNull(),
            "position_description" => $this->text(),
            "salary" => $this->integer()->null(),
            "starts_at" => $this->timestamp()
                ->notNull()
                ->defaultExpression("CURRENT_TIMESTAMP"),
            "ends_at" => $this->timestamp()->notNull(),
        ]);

        $this->createIndex(
            "FK_descriptive_post_post_id_post_idx",
            "descriptive_post",
            "post_id"
        );

        $this->addForeignKey(
            "FK_descriptive_post_post_id_post",
            "descriptive_post",
            "post_id",
            "post",
            "id",
            null,
            "cascade"
        );
    }

    public function Down()
    {
        $this->dropIndex(
            "FK_descriptive_post_post_id_post_idx",
            "descriptive_post"
        );

        $this->dropForeignKey(
            "FK_descriptive_post_post_id_post",
            "descriptive_post"
        );

        $this->dropTable("descriptive_post");
    }
}
