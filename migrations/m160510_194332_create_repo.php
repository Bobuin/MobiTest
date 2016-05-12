<?php

use yii\db\Migration;

/**
 * Handles the creation for table `repo`.
 */
class m160510_194332_create_repo extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('repo', [
            'id'        => $this->primaryKey(),
            'repo_id'   => $this->integer()->notNull(),
            'repo_like' => $this->smallInteger()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('repo');
    }
}
