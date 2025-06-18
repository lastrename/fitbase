<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Expression;

class SoftDeleteBehavior extends Behavior
{
    public string $deletedAtAttribute = 'deleted_at';
    public string $deletedByAttribute = 'deleted_by';

    /**
     * @return array
     */
    public function events(): array
    {
        return [];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        /** @var ActiveRecord $model */
        $model = $this->owner;
        $model->{$this->deletedAtAttribute} = new Expression('NOW()');
        $model->{$this->deletedByAttribute} = Yii::$app->user->id ?? null;

        return $model->save(false, [$this->deletedAtAttribute, $this->deletedByAttribute]);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->owner->{$this->deletedAtAttribute} === null;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return !$this->isActive();
    }
}
