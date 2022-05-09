<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m220509_062505_create_queue_table extends Migration
{
    public $tableName = '{{%queue}}';


    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'channel' => $this->string()->notNull(),
            'job' => $this->binary()->notNull(),
            'pushed_at' => $this->integer(11)->notNull(),
            'ttr' => $this->integer(11)->notNull(),
            'delay' => $this->integer()->notNull(),
            'priority' => $this->integer(11)->unsigned()->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(11),
            'attempt' => $this->integer(11),
            'done_at' => $this->integer(11),
        ]);

        $this->createIndex('channel', $this->tableName, 'channel');
        $this->createIndex('reserved_at', $this->tableName, 'reserved_at');
        $this->createIndex('priority', $this->tableName, 'priority');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
