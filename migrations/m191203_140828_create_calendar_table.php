<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calendar}}`.
 */
class m191203_140828_create_calendar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('calendar', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull()->comment('указатель на пользователя'),
            'activity_id'=>$this->integer()->notNull()->comment('указатель на событие'),
            'created_at'=>$this->timestamp()->comment('дата создания записи'),
            'updated_at'=>$this->timestamp()->comment('дата редактировиния'),
        ]);

        $this->addForeignKey('fk-calendar-activity_id',
            'calendar',
            'activity_id',
            'activity',
            'id'
        );
        $this->addForeignKey(
            'fk-calendar-user_id',
            'calendar',
            'user_id',
            'users',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-calendar-activity_id', 'calendar');
        $this->dropForeignKey('fk-calendar-user_id', 'calendar');
        $this->dropTable('calendar');
    }
}
