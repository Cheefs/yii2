<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity}}`.
 */
class m191130_103534_create_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('название собития'),
            'started_at' => $this->bigInteger()->notNull()->comment('начало собития'),
            'finished_at' => $this->bigInteger()->comment('завершение собития'),
            'is_repeatable' => $this->boolean()->notNull()->defaultValue(false)->comment('цикличное ли событие'),
            'is_main' => $this->boolean()->notNull()->defaultValue(false )
                ->comment('указатель является ли событие основным'),
            'desc' => $this->text(),
            'author_id' => $this->integer(),
            'created_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('activity');
    }
}
