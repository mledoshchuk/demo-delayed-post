<?php

namespace app\controllers;

use app\models\Post;
use yii\web\Controller;
use yii\helpers\Url;

class PostController extends Controller
{
    public function actionIndex()
    {
        $model = new Post();

        \Yii::$app->queue->run(false);
        return $this->render("create", [
            "model" => $model,
        ]);
    }

    public function actionRedirect()
    {
        $typeId = $this->request->post("typeId");

        switch ($typeId) {
            case "1":
                $url = Url::toRoute(["contact/index"]);
                break;
            case "2":
                $url = Url::toRoute(["descriptive/index"]);
                break;
            default:
                $url = Url::toRoute(["post/index"]);
        }

        return \yii\helpers\Json::encode([
            "status" => true,
            "url" => $url,
        ]);
    }
}
