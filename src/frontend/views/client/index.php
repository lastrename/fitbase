<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\models\Client;
use frontend\models\ClientSearch;

/** @var ClientSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="client-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false, 'enableReplaceState' => true]); ?>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['data-pjax' => 1, 'class' => 'mb-3'],
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($searchModel, 'full_name') ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($searchModel, 'gender')->radioList(Client::getGenderOptions(), ['inline' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($searchModel, 'birth_from')->input('date') ?>
            <?= $form->field($searchModel, 'birth_to')->input('date') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'full_name',
            [
                'attribute' => 'gender',
                'value' => fn($model) => Client::getGenderOptions()[$model->gender] ?? '—',
            ],
            'birth_date:date',
            'created_at:datetime',
            [
                'label' => 'Clubs',
                'value' => fn($model) => implode(', ', array_map(fn($club) => $club->name, $model->clubs)),
            ],
            [
                'class' => yii\grid\ActionColumn::class,
                'urlCreator' => fn($action, $model) => Url::to([$action, 'id' => $model->id]),
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
