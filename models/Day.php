<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 *  Сущьность дня
 * @property int $id             Id записи в базе данных
 * @property string $name        Название дня недели
 * @property bool $isWeekend     Флаг указываюший на тип дня рабочий\выходной
 * @property array $activityList Список задач
 *
 */
class Day extends Model {
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
}
