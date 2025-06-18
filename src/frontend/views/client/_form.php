<?php

use frontend\models\Client;
use frontend\models\Club;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Client $model */
/** @var yii\widgets\ActiveForm $form */

$genderOptions = Client::getGenderOptions();
$clubOptions = ArrayHelper::map(Club::find()->all(), 'id', 'name');
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true, 'required' => true]) ?>

    <?= $form->field($model, 'gender')->radioList($genderOptions, [
        'itemOptions' => ['labelOptions' => ['class' => 'me-3']],
    ]) ?>

    <?= $form->field($model, 'birth_date')->input('date') ?>

    <?= $form->field($model, 'club_ids')->widget(Select2::classname(), [
        'data' => $clubOptions,
        'options' => [
            'placeholder' => 'Select clubs...',
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group mt-4">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
