<?php

namespace app\controllers;

use app\models\ContactPost;
use app\models\Post;
use app\models\PostsQueue;
use yii\web\Controller;
use yii\base\DynamicModel;
use yii\queue\Queue;
use app\jobs\PostJob;

class ContactController extends Controller
{
    public function actionIndex()
    {
        $model = new ContactPost();

        \Yii::$app->queue->run(false);

        return $this->render("create", [
            "model" => $model,
        ]);
    }

    public function actionCreate()
    {
        $post = new Post();
        $postQueue = new PostsQueue();
        $contactPostRequest = $this->request->post();

        $insertedValues = [];
        $type = $contactPostRequest["type"];
        $companyName = $contactPostRequest["company_name"];
        $positionName = $contactPostRequest["position"];
        $contactName = $contactPostRequest["contact_name"];
        $contactEmail = $contactPostRequest["contact_email"];
        $postAtNow = date("Y-m-d H:i:s", strtotime("now"));
        $postAt = !empty($contactPostRequest["post_at"])
            ? date("Y-m-d H:i:s", strtotime($contactPostRequest["post_at"]))
            : $postAtNow;

        $postDynamicModel = DynamicModel::validateData(
            [
                "type" => $type,
                "company_name" => $companyName,
                "position" => $positionName,
                "contact_name" => $contactName,
                "contact_email" => $contactEmail,
                "post_at" => !empty($contactPostRequest["post_at"])
                    ? date(
                        "Y-m-d H:i:s",
                        strtotime($contactPostRequest["post_at"])
                    )
                    : null,
            ],
            [
                [["type", "company_name", "position"], "required"],
                [["type"], "integer"],
                [["company_name"], "string", "max" => 80],
                [["contact_name"], "string", "max" => 80],
                [["position"], "string", "max" => 45],
                [["contact_email"], "required"],
                [["contact_email"], "string", "max" => 255],
                [["contact_email"], "email"],
                [["contact_email"], "filter", "filter" => "trim"],
                [["post_at"], "datetime", "format" => "php:Y-m-d H:i:s"],
                [
                    ["post_at"],
                    "compare",
                    "compareValue" => $postAtNow,
                    "operator" => ">",
                    "message" =>
                    "Post At Date Cannot be a date in the past or current",
                    "when" => function ($contact) {
                        return !empty($contact->post_at);
                    },
                ],
            ]
        );

        $postValidate = $postDynamicModel->hasErrors();
        $postErrors = $postDynamicModel->getErrors();

        if ($this->request->isAjax && !$postValidate) {
            $result = $post->insertContactPost(
                $type,
                $positionName,
                $companyName,
                $contactEmail,
                $contactName,
                $postAt
            );
            $insertedValues["type"] = "contact";
            $insertedValues["position"] = $positionName;
            $insertedValues["company_name"] = $companyName;
            $insertedValues["contact_email"] = $contactEmail;
            $insertedValues["contact_name"] = $contactName;
            $insertedValues["post_at"] = $postAt;

            $htmlBody = $this->renderPartial("feedback", [
                "data" => $insertedValues,
            ]);

            if ($result == "Completed") {
                $queueResult = $this->actionAddPostToQueue(
                    $postQueue,
                    $post->id,
                    $postAtNow,
                    $postAt,
                    $htmlBody
                );
                echo $queueResult;
            } else {
                echo "error";
            }
        } else {
            $result = $this->renderPartial("error", [
                "items" => $postErrors,
            ]);
            print_r($result);
        }
    }

    public function actionAddPostToQueue($model, $id, $origin, $target, $html)
    {
        $origin = strtotime($origin);
        $target = strtotime($target) ?? strtotime("now");
        $interval = abs($origin - $target);

        if (\Yii::$app->queue->delay($interval)->push(
            new PostJob([
                "model" => $model,
                "id" => $id,
                "html" => $html,
                "text" => "Posted successfully",
            ])
        )) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
