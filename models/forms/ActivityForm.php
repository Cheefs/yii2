<?php

namespace app\models\forms;

use app\models\Activity;
use app\models\Day;
use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/** перенес методы в форму, потому что они нужны тут а не в моделе
 *
 *  переведенные даты начала и завершения в timestamp ( данная переменная просто хранит в себе значение до инсерта )
 * @property $startedAtTimestamp
 * @property $finishedAtTimestamp
 */
//4) Модифицируйте форму создания события так, чтобы через неё можно было редактировать уже существующие события.
// ( тут как я понял, нужно привести к единому виду create update Views && Actions, и возможно поправить форму )
class ActivityForm extends Activity {

    private $startedAtTimestamp;
    private $finishedAtTimestamp;

    public function __construct($config = []) {
        $this->is_main = self::NOT_MAIN_ACTIVITY;
    }

    public function behaviors()
    {
        /** поведение для установки даты создания, и даты редактирование текущей датой */
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE =>  'updated_at',
                ],
            ],
        ];
    }
    // 5)* Сделайте так, чтобы для пользователя дата показывалась в формате «день.месяц.год», а в БД продолжала сохраняться в формате MySQL timestamp.
    /** перед сохранением, устанавливаем unix time
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert) {
        $this->started_at = $this->startedAtTimestamp;
        $this->finished_at = $this->finishedAtTimestamp;
        return parent::beforeSave($insert);
    }
    /**
     * После того как нашли данные в бд, форматируем их в понятные даты для пользователя
    */
    public function afterFind() {
        parent::afterFind();
        $this->started_at = Yii::$app->formatter->asDatetime( $this->started_at, self::DATE_FORMAT_FOR_FORMATTER );
        $this->finished_at = $this->finished_at ? Yii::$app->formatter->asDatetime( $this->finished_at, self::DATE_FORMAT_FOR_FORMATTER  ) : null;
    }

    public function rules() {
        $rules = [
            /** проверка по полю Started_at так как дата окончания необязательное то в случае не заполнения поля - валидация не сработает */
            [['started_at'], 'validateFinishedDate' ]
        ];
        return ArrayHelper::merge(parent::rules(), $rules );
    }
    /**
     *      Дата окончания события – необязательное поле. Расширьте валидацию модели так, чтобы было следующее.
    При пустом поле в систему сохранялось значение, равное дате начала.
    Дата окончания не могла бы быть меньше даты начала.
     **/
    public function validateFinishedDate() {
        if ( !$this->finished_at ) {
            $this->finished_at = $this->started_at;
        }
        $this->startedAtTimestamp = (new DateTime($this->started_at) )->getTimestamp();
        $this->finishedAtTimestamp = (new DateTime($this->finished_at))->getTimestamp();

        if (  $this->finishedAtTimestamp <  $this->startedAtTimestamp ) {
            $this->addError('finished_at', Yii::t('app', 'start date cant be more then finished date'));
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

    /**
     * Загрузка файлов
     */
    public function saveFiles() {
        $this->attachments = UploadedFile::getInstances($this, 'attachments');
        $filesList = $this->attachments;
        if ( $filesList && count($filesList) ) {
            foreach ($filesList as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
        }
    }
}
