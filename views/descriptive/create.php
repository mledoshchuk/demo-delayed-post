<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = 'Create Post';
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
<?php $this->registerJsFile(
            '@web/js/entry.js',
            ['depends' => [\yii\web\JqueryAsset::class]]
        );    
?>
