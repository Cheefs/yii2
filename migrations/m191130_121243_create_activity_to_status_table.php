<?php

use yii\db\Migration;

/**
 * Связь события и статуса
 * Handles the creation of table `{{%activity_to_status}}`.
 */
class m191130_121243_create_activity_to_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('activity_to_status', [
            'activity_id' => $this->integer()->comment('указатель на событие'),
            'status_id' => $this->integer()->comment('указатель на статус'),
            'created_at' => $this->dateTime()
                ->comment('дата когда статус был создан, для соритовок и отслеживания как менялся статус')
        ]);

        $this->addForeignKey(
            'fk-activity_to_status-activity_id',
            'activity_to_status',
            'activity_id',
            'activity',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-activity_to_status-status_id',
            'activity_to_status',
            'status_id',
            'activity_statuses',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-activity_to_status-activity_id',
            'activity_to_status'
        );
        $this->dropForeignKey(
            'fk-activity_to_status-status_id',
            'activity_to_status'
        );

        $this->dropTable('activity_to_status');
    }
}
