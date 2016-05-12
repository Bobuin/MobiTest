<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160510_194345_create_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id'        => $this->primaryKey(),
            'user_id'   => $this->integer()->notNull(),
            'user_like' => $this->smallInteger()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
