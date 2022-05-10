<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Post;
/* @var $this yii\web\View */
/* @var $searchModel app\models\post\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'delayed.post';
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

</div>