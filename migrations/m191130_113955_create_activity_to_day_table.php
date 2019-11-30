<?php

use yii\db\Migration;

/**
 * Таблица связки дня и события
 * Handles the creation of table `{{%activity_to_day}}`.
 */
class m191130_113955_create_activity_to_day_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activity_to_day}}', [
            'day_id' => $this->integer()->notNull()->comment('указатель на день'),
            'activity_id' => $this->integer()->notNull()->comment('указатель на событие'),
        ]);

        /** внешний ключь для связи с событием */
        $this->addForeignKey(
            'fk-day-to-activity_id',
            'activity_to_day',
            'activity_id',
            'activity',
            'id',
            'CASCADE'
        );
        /** внешний ключь для связи с днем */
        $this->addForeignKey(
            'fk-day-to-activity-day_id',
            'activity_to_day',
            'day_id',
            'days',
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
            'fk-day-to-activity_id',
            'activity_to_day'
        );
        $this->dropForeignKey(
            'fk-day-to-activity-day_id',
            'activity_to_day'
        );

        $this->dropTable('{{%activity_to_day}}');
    }
}
