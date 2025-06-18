<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%club}}`.
 */
class m250617_125913_create_club_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%club}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->text(),
            'created_at' => $this->timestamp(),
            'created_by' => $this->integer(),
            'updated_at' => $this->timestamp()->null(),
            'updated_by' => $this->integer(),
            'deleted_at' => $this->timestamp()->null(),
            'deleted_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%club}}');
    }
}
