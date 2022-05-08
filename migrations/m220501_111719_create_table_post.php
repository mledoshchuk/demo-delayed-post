<?php

use yii\db\Migration;

/**
 * Class m220501_111719_create_table_post
 */
class m220501_111719_create_table_post extends Migration
{
    public function Up()
    {
        $this->createTable("post", [
            "id" => $this->primaryKey()->unsigned(),
            "type" => $this->integer()
                ->notNull()
                ->unsigned(),
            "company_name" => $this->string(80)->notNull(),
            "position" => $this->string(45)->notNull(),
        ]);

        $this->createIndex("FK_post_type_type_idx", "post", "type");

        $this->addForeignKey(
            "FK_post_type_post_type",
            "post",
            "type",
            "post_type",
            "id",
            null,
            "cascade"
        );
    }

    public function Down()
    {
        $this->dropIndex("FK_post_type_type_idx", "post");

        $this->dropForeignKey("FK_post_type_post_type", "post");

        $this->dropTable("post");
    }
}
