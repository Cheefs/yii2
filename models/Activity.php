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
    public $id;
    public $from;
    public $to;
    public $isRepeatable;
    public $isMain;
    public $name;
    public $desc;
    public $repeatDays = [];
    public $attachments = [];

    public function rules() {
        return [
            [[ 'id' ], 'integer'],
            [[ 'isMain', 'isRepeatable' ], 'boolean'],
            [[ 'from', 'to', 'name', 'desc', 'repeatDays' ], 'safe'],
            [[ 'name', 'isMain', 'from', 'to', 'isRepeatable' ], 'required'],
            [['attachments'], 'file'],
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
}
