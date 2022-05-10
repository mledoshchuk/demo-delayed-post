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
        
        return $this->render("create", [
            "model" => $model,
        ]);
    }

    public function actionLoad()
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
            "result" => $result
        ]);
    }
}
