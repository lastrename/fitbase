<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_club}}`.
 */
class m250618_082431_create_client_club_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_club}}', [
            'client_id' => $this->integer(),
            'club_id' => $this->integer(),
            'PRIMARY KEY(client_id, club_id)',
        ]);

        $this->addForeignKey('fk_client_club_client', 'client_club', 'client_id', 'client', 'id');
        $this->addForeignKey('fk_client_club_club', 'client_club', 'club_id', 'club', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client_club}}');
    }
}
