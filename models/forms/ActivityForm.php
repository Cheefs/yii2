<?php

namespace app\models\forms;

use app\models\Activity;
use app\models\Day;
use DateTime;
use yii\web\UploadedFile;

/** перенес методы в форму, потому что они нужны тут а не в моделе  */
class ActivityForm extends Activity {

    /**
     * Загрузка файлов
     */
    public function saveFiles() {
        $filesList = UploadedFile::getInstances($this, 'attachments');

        if ($filesList && count($filesList) ) {
            foreach ($filesList as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
        }
    }

    /**
     * Установить повторение события
     * @param array $days выбранные дни для потвторения
     */
    public function setRepeat(array $days) {
        $dayModel = new DayForm();
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
        $activityList = ( new DayForm() )->getActivities();

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

    /** метод заглушка для заполнения данными */
    public function setData( $id ) {
        $this->id = $id;
        $this->name = "activity_$id";
        $this->desc = 'ijasoipd asdji asd jasopdij';
    }

}
