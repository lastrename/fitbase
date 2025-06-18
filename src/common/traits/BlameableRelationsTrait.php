<?php

namespace common\traits;

use common\models\User;
use yii\db\ActiveQuery;

trait BlameableRelationsTrait
{
    /**
     * @return ActiveQuery
     */
    public function getCreatedByUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdatedByUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDeletedByUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }
}
