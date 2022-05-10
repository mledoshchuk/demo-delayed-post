<?php

use yii\db\Migration;

/**
 * Class m220501_105735_create_table_post_type
 */
class m220501_105735_create_table_post_type extends Migration
{
    public function safeUp()
    {
        $this->createTable("post_type", [
            "id" => $this->primaryKey()->unsigned(),
            "type_name" => $this->string(80)->notNull(),
        ]);

        $this->createIndex("type_name_UNIQUE", "post_type", "type_name", true);

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                "post_type",
                ["type_name"],
                [["Contact"], ["Descriptive"]]
            )
            ->execute();
    }

    public function safeDown()
    {
        $this->dropIndex("type_name_UNIQUE", "post_type");

        $this->delete("post_type");

        $this->dropTable("post_type");
    }
}
