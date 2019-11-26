<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * 2. Помимо события нужна сущность «День».
 *  Он может быть рабочим и выходным,
 *  может иметь привязанные события.
 *  Реализуйте подобную сущность. Пока в виде кодовой заглушки.
 *
 *  Сущьность дня
 * @property int $id             Id записи в базе данных
 * @property string $name        Название дня недели
 * @property bool $isWeekend     Флаг указываюший на тип дня рабочий\выходной
 * @property array $activityList Список задач
 *
 */
class Day extends Model {
    /** данные дни недели будут в базе данных как сущьности этой модели, а тут просто перечень их имен как мок временный*/
    const DAYS_LIST = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    private $id;
    public $name;
    public $isWeekend = false;
    private $activityList = [];

    public function rules() {
        return [
            [[ 'id' ], 'int'],
            [[ 'name' ], 'safe'],
            [[ 'isWeekend' ], 'boolean'],
            [['name', 'isWeekend'], 'required'],
            ['activityList', 'eact', 'rule' => ['safe']], /** будет свой валидатор а не safe */
        ];
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'name' => Yii::t('app', 'name'),
            'isWeekend' => Yii::t('app', 'is weekend'),
            'activityList' => Yii::t('app', 'activity list'),
        ];
    }

    /** просто список дней недели */
    public function getAllDays() {
        return self::DAYS_LIST;
    }
    /** получение всех задачь на день */
    public function getActivities() {
        return $this->activityList;
    }
    /**
     * Добавление задачи к данному дню
     * @param Activity $model новая задача
    */
    public function addActivity(Activity $model) {
        /** так как большинство валидаций будет в модели Activity тут можно смело добавлять новый обьект */
        $this->activityList[] = $model;
        /// и код сохранение данных в бд, в таблицу связки
    }

    /** когда нужно удалить запись на текущем дне ( перенесли мы ее на другой день ), фильтруем массив очищая от этого id
     * ( незачем нам делать update и select,  когда можем обойтись 1м update )
     *  и отправляем запрос на удаление в бд ( либо такие действия будут решатся на уровне тригеров )
     *
     * @param int $id id удаляемой записи
     */
    public function deleteActivity(int $id) {
       $this->activityList = array_filter($this->activityList, function ($item) use ($id) {
            return $item->id !== $id;
        });
       /// тут будет код удвление записи в таблице связки задачи и для
    }
}
