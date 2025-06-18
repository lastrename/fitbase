<?php

namespace common\models\queries;

use yii\db\ActiveQuery;
use yii\db\Query;

class SoftDeleteQuery extends ActiveQuery
{
    protected bool $applyNotDeleted = true;

    public function withDeleted(): self
    {
        $this->applyNotDeleted = false;
        return $this;
    }

    public function notDeleted(): self
    {
        $this->applyNotDeleted = true;
        return $this;
    }


    public function deleted(): self
    {
        return $this->withDeleted()->andWhere(['IS NOT', 'deleted_at', null]);
    }

    public function prepare($builder): Query|ActiveQuery
    {
        if ($this->applyNotDeleted) {
            $this->andWhere(['deleted_at' => null]);
        }

        return parent::prepare($builder);
    }
}