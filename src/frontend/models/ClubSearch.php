<?php

namespace frontend\models;

use yii\data\ActiveDataProvider;

class ClubSearch extends Club
{
    public bool $archive = false;

    public function rules(): array
    {
        return [
            [['name'], 'string'],
            [['archive'], 'boolean'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = self::find();

        if ($this->load($params) && $this->validate()) {
            if ($this->archive) {
                $query->withDeleted()->deleted(); // ← показать только удалённые
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        if ($this->name) {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }

        return $dataProvider;
    }
}