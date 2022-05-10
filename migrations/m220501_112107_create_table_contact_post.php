<?php

use yii\db\Migration;

/**
 * Class m220501_112107_create_table_contact_post
 */
class m220501_112107_create_table_contact_post extends Migration
{
    public function Up()
    {
        $this->createTable("contact_post", [
            "post_id" => $this->integer()
                ->unsigned()
                ->notNull(),
            "contact_name" => $this->string(80)->null(),
            "contact_email" => $this->string(255)->notNull(),
        ]);

        $this->createIndex(
            "FK_contact_post_post_id_post_idx",
            "contact_post",
            "post_id"
        );

        $this->addForeignKey(
            "FK_contact_post_post_id_post",
            "contact_post",
            "post_id",
            "post",
            "id",
            null,
            "cascade"
        );
    }

    public function Down()
    {
        $this->dropIndex("FK_contact_post_post_id_post_idx", "contact_post");

        $this->dropForeignKey("FK_contact_post_post_id_post", "contact_post");

        $this->dropTable("contact_post");
    }
}
