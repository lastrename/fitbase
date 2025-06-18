<?php

use frontend\models\Client;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Client $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
            [
                'attribute' => 'gender',
                'value' => fn($model) => Client::getGenderOptions()[$model->gender],
            ],
            'birth_date:datetime',
            'created_at:datetime',
            [
                'attribute' => 'created_by',
                'value' => fn($model) => $model->createdByUser ? $model->createdByUser->username : '(unknown)',
            ],
            'updated_at:datetime',
            [
                'attribute' => 'updated_by',
                'value' => fn($model) => $model->updatedByUser ? $model->updatedByUser->username : '(unknown)',
            ],
            'deleted_at:datetime',
            [
                'attribute' => 'deleted_by',
                'value' => fn($model) => $model->deletedByUser ? $model->deletedByUser->username : '(unknown)',
            ],
            [
                'label' => 'Клубы',
                'value' => fn($model) => implode(', ', array_map(fn($club) => $club->name, $model->clubs)),
            ],
        ],
    ]) ?>

</div>
