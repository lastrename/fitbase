<?php

use yii\db\Migration;

class m250618_093209_add_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $params = Yii::$app->params['adminUser'];

        $this->insert('{{%user}}', [
            'username' => $params['username'],
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash($params['password']),
            'email' => $params['email'],
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $params = Yii::$app->params['adminUser'];
        $this->delete('{{%user}}', ['username' => $params['username']]);
    }
}
