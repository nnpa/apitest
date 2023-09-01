<?php

use yii\db\Migration;

/**
 * Class m230901_164032_users
 */
class m230901_164032_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
            'api_key' => $this->string(),
            'name' => $this->string(),
            'is_admin' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230901_164032_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230901_164032_users cannot be reverted.\n";

        return false;
    }
    */
}
