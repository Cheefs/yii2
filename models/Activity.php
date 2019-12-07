<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property string $name название собития
 * @property string $started_at начало собития
 * @property string $finished_at завершение собития
 * @property int $is_repeatable цикличное ли событие
 * @property int $author_id
 * @property int $is_main указатель является ли событие основным
 * @property string $desc
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ActivityToStatus[] $activityToStatuses
 * @property mixed $author
 * @property Calendar[] $calendars
 */
class Activity extends \yii\db\ActiveRecord
{
    //2) Форматы дат могут меняться, поэтому хранить их в коде не лучшая идея. Вынесите форматы дат в конфигурацию.
    // Помните, что захламлять один файл web плохо. ??? ( постановка задачи странная, и непонятная , поэтому задал формат даты в форме,
    // а пользователю дату формирует виджет, надеюсь правильно понял )
    const DATE_FORMAT_FOR_DATE_PICKER = 'dd-mm-yyyy';
    const DATE_FORMAT_FOR_FORMATTER = 'php:d-m-Y h:i';

    const NOT_MAIN_ACTIVITY = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'started_at'], 'required'],
            [['started_at', 'finished_at'], 'safe'],
            [['is_repeatable', 'author_id', 'is_main', 'created_at', 'updated_at'], 'integer'],
            [['desc'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'started_at' => Yii::t('app', 'Started At'),
            'finished_at' => Yii::t('app', 'Finished At'),
            'is_repeatable' => Yii::t('app', 'Is Repeatable'),
            'is_main' => Yii::t('app', 'Is Main'),
            'desc' => Yii::t('app', 'Desc'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'author_id' => Yii::t('app', 'author id'),
        ];
    }

    public function getAuthor() {
       return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityToStatuses() {
        return $this->hasMany(ActivityToStatus::class, ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendars() {
        return $this->hasMany(Calendar::class, ['activity_id' => 'id']);
    }
}
