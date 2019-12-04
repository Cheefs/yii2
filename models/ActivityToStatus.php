<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_to_status".
 *
 * @property int $activity_id указатель на событие
 * @property int $status_id указатель на статус
 * @property string $created_at дата когда статус был создан, для соритовок и отслеживания как менялся статус
 *
 * @property Activity $activity
 * @property ActivityStatuses $status
 */
class ActivityToStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_to_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity_id', 'status_id'], 'integer'],
            [['created_at'], 'safe'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityStatuses::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => Yii::t('app', 'Activity ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ActivityStatuses::className(), ['id' => 'status_id']);
    }
}
