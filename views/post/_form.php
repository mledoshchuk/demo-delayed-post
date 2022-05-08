<?php

use app\models\PostType;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(  ['action' => null]); ?>
    <div class="col-lg-4">
        <?= $form->field($model, 'type')->dropDownList(PostType::find()->select(['type_name', 'id'])->indexBy('id')->column(), ['id' => 'create-select', 'prompt' => 'Please select...']); ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>