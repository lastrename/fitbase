<?php

use frontend\models\ClubSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var ClubSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clubs';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="club-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Club', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([
        'enablePushState' => false,
        'enableReplaceState' => true,
    ]); ?>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['data-pjax' => 1],
    ]); ?>

    <div class="row mb-3">
        <div class="col-md-4">
            <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Nmae']) ?>
        </div>
        <div class="col-md-2" style="padding-top: 30px;">
            <?= $form->field($searchModel, 'archive')->checkbox() ?>
        </div>
        <div class="col-md-2" style="padding-top: 30px;">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'address:ntext',
            'created_at:datetime',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, ClubSearch $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
