<?php

namespace app\models\forms;

use app\models\Activity;
use app\models\Day;

class DayForm extends Day {
    /** данные дни недели будут в базе данных как сущьности этой модели, а тут просто перечень их имен как мок временный*/
    const DAYS_LIST = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

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