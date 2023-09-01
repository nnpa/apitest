<?php

use yii\db\Migration;

/**
 * Class m230901_164305_request
 */
class m230901_164305_request extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('request', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
            'name' => $this->string(),
            'message' => $this->text(),
            'comment' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => "ENUM('Active', 'Resolved')"

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230901_164305_request cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230901_164305_request cannot be reverted.\n";

        return false;
    }
    */
}
