<?php

namespace frontend\models;

use yii\data\ActiveDataProvider;

class ClientSearch extends Client
{
    public string|null $birth_from = null;
    public string|null $birth_to = null;

    public function rules(): array
    {
        return [
            [['full_name'], 'safe'],
            [['gender'], 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            [['birth_from', 'birth_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Client::find()->with('clubs');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => ['pageSize' => 20],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'full_name', $this->full_name]);
        $query->andFilterWhere(['gender' => $this->gender]);

        if ($this->birth_from) {
            $query->andWhere(['>=', 'birth_date', $this->birth_from]);
        }
        if ($this->birth_to) {
            $query->andWhere(['<=', 'birth_date', $this->birth_to]);
        }

        return $dataProvider;
    }
}