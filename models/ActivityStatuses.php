<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_statuses".
 *
 * @property int $id
 * @property string $name название статуса
 * @property int $is_deleted флаг активности записи
 *
 * @property ActivityToStatus[] $activityToStatuses
 */
class ActivityStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityToStatuses()
    {
        return $this->hasMany(ActivityToStatus::className(), ['status_id' => 'id']);
    }
}
