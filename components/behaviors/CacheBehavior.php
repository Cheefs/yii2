<?php

namespace app\components\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class CacheBehavior extends Behavior {
    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'deleteCache',
            ActiveRecord::EVENT_AFTER_UPDATE => 'deleteCache',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteCache',
            ActiveRecord::EVENT_AFTER_FIND => 'setCache',
        ];
    }

    public function setCache() {
        \Yii::$app->cache->set( get_class($this->owner) . '_' . $this->owner->id, $this->owner );
    }

    public function deleteCache() {
        \Yii::$app->cache->delete(get_class($this->owner) . "_" . $this->owner->getPrimaryKey());
    }
}