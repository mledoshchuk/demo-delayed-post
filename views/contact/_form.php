<?php

use app\models\PostType;
use app\models\Post;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\AssetBundle;

AssetBundle::register($this);
?>

<div class="post-form">
    <?php $postModel = new Post(); ?>
    <?php $form = ActiveForm::begin([
        'action' => null,
        'options' => ['id' => 'contact-form']
    ]); ?>
    <div class="col-lg-4">
        <?= $form->field($model, 'type')->dropDownList(PostType::find()->select(['type_name', 'id'])->indexBy('id')->column(), ['id' => 'create-select', 'prompt' => 'Please select...']); ?>
        <?= $form->field($postModel, 'company_name')->textInput() ?>
        <?= $form->field($postModel, 'position')->textInput() ?>
        <?= $form->field($model, 'contact_name')->textInput() ?>
        <?= $form->field($model, 'contact_email')->textInput() ?>
        <?= $form->field($model, 'post_at', ['inputOptions' => ['class' => 'form-control datetimepicker']])->textInput(['autocomplete' => 'off']) ?>
        <?= Html::Button('Create', ['class' => 'btn btn-primary', 'name' => 'contact-create-button', 'id' => 'contact-submit-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>

</div>