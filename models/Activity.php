<?php

namespace app\models;

use Yii;
use DateTime;
use yii\base\Model;

/**
 *
 * 1. Событие должно иметь больше свойств.
 * a. Оно может повторяться.
 * b. Оно может быть блокирующим (в этот же день не может быть других событий).
 *
 *  Сущьность задачи
 * @property int $id             Id записи в базе данных
 * @property string $name        Название задачи
 * @property bool $isMain        Указание основная ли это задача на день
 * @property string $from        Граници задачи от
 * @property string $to          Граници задачи до
 * @property bool $isRepeatable  Повторяется ли это задача каждый день
 * @property string $desc        Описание задачи
 * @property array $repeatDays   Дни в которые данная задача должна повторятся
*/
class Activity extends Model {
    private int $id;
    private string $from;
    private string $to;
    public bool $isRepeatable;
    public bool $isMain;
    public string $name;
    public string $desc;
    public array $repeatDays = [];

    public function rules() {
        return [
            [[ 'id' ], 'int'],
            [[ 'isMain', 'isRepeatable' ], 'boolean'],
            [[ 'from', 'to', 'name', 'desc', 'repeatDays' ], 'safe'],
            [[ 'name', 'isMain', 'from', 'to', 'isRepeatable' ], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'from' => Yii::t('app', 'from'),
            'to' => Yii::t('app', 'to'),
            'name' => Yii::t('app', 'name'),
            'desc' => Yii::t('app', 'desc'),
            'isMain' => Yii::t('app', 'is main'),
            'repeatDays' => Yii::t('app', 'repeat days'),
            'isRepeatable' => Yii::t('app', 'is repeatable'),
        ];
    }

    /**
     * Установить повторение события
     * @param array $days выбранные дни для потвторения
    */
    public function setRepeat(array $days) {
        $dayModel = new Day();
        $this->isRepeatable = true;
        if ( !count($days) ) {
            $this->repeatDays = $dayModel->getAllDays();
        } else {
            $this->repeatDays = $days;
        }
    }

    /**
     *  Проверка возможности установить задачу на это время
    */
    private function checkAvailableSlot() {
        $isAvailable = true;
        /** тут будет обращение к модели Day и получение дней в границах между $from и $to*/
        $activityList = ( new Day() )->getActivities();

        if ( $activityList && is_array($activityList)  && count($activityList)) {
            foreach ( $activityList as $activity ) {
                /** на данный момент проверяется просто наложение, потом возможно будем смотреть на границу
                 * которая попала под эти ограничени и предложем сместить ее в какуюто сторону
                 */
                if ( $activity <= $this->from && $activity >= $this->to  ) {
                    $isAvailable = false;
                    break;
                }
            }
        }
        return $isAvailable;
    }

    /**
     * Установка переода задачи
     * @param string $from дата и время от
     * @param string $to дата и время до
    */
    public function setActivityInterval( string $from, string $to ) {
        try {
            $dateFrom = new DateTime( $from );
            $dateTo = new DateTime( $to );

            /** проверяем доступность времени на данную задачу */
            if ( $this->checkAvailableSlot() ) {
                $this->from = $dateFrom;
                $this->to = $dateTo;
            } else {
                $this->addError('from', \Yii::t('app', 'main activity is blocked this period'));
            }

        } catch (\Exception $e) {
            $this->addError('from', \Yii::t('app', 'incorrect time format'));
        }
    }
}
