<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Club $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clubs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="club-view">

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
            'name',
            'address:ntext',
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
        ],
    ]) ?>

</div>
