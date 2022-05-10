<?php

use app\models\PostType;
use app\models\Post;
use app\models\PostsQueue;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\AssetBundle;

AssetBundle::register($this);
?>

<div class="post-form">
    <?php $modelPost = new Post(); ?>
    <?php $form = ActiveForm::begin([
        'action' => null,
        'options' => ['id' => 'descriptive-form']
    ]); ?>
    <div class="col-lg-4 col-md-6">
        <?= $form->field($model, 'type')->dropDownList(PostType::find()->select(['type_name', 'id'])->indexBy('id')->column(), ['id' => 'create-select', 'prompt' => 'Please select...']); ?>
        <?= $form->field($modelPost, 'company_name')->textInput() ?>
        <?= $form->field($modelPost, 'position')->textInput() ?>
        <?= $form->field($model, 'position_description')->textarea() ?>
        <?= $form->field($model, 'salary')->textInput() ?>
        <?= $form->field($model, 'starts_at', ['inputOptions' => ['class' => 'form-control datetimepicker']])->textInput(['autocomplete' => 'off']) ?>
        <?= $form->field($model, 'ends_at', ['inputOptions' => ['class' => 'form-control datetimepicker']])->textInput(['autocomplete' => 'off']) ?>
        <?= $form->field($model, 'post_at', ['inputOptions' => ['class' => 'form-control datetimepicker']])->textInput(['autocomplete' => 'off']) ?>
        <?= Html::Button('Create', ['class' => 'btn btn-primary', 'name' => 'descriptive-create-button', 'id' => 'descriptive-submit-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>

</div>