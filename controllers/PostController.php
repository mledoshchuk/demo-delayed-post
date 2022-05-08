<?php

namespace app\controllers;

use app\models\ContactPost;
use app\models\DescriptivePost;
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
        $modelContact = new ContactPost();
        $modelDescriptive = new DescriptivePost();
        $modelPost = new Post();
        
        switch ($typeId) {
            case "1":
                $result =  $this->renderAjax("@app/views/contact/create", [
                    "model" => $modelContact
                ]);
                break;
            case "2":
                $result =  $this->renderAjax("@app/views/descriptive/create", [
                    "model" => $modelDescriptive
                ]);
                break;
            default:
                $result =  $this->renderAjax("@app/views/post/create", [
                    "model" => $modelPost
                ]);
        }

        return \yii\helpers\Json::encode([
            "status" => true,
            "id" => $typeId,
            "result" => $result
        ]);
    }
}
