<?php

namespace app\controllers;

use app\models\DescriptivePost;
use app\models\Post;
use app\models\PostsQueue;
use yii\web\Controller;
use yii\base\DynamicModel;
use yii\queue\Queue;
use app\jobs\PostJob;

class DescriptiveController extends Controller
{
    public function actionIndex()
    {
        $model = new DescriptivePost();
        
        return $this->render("create", [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $post = new Post();
        $postQueue = new PostsQueue();
        $descriptive = new DescriptivePost();
        $descriptivetPostRequest = $this->request->post();

        $insertedValues = [];
        $type = $descriptivetPostRequest["type"];
        $companyName = $descriptivetPostRequest["company_name"];
        $positionName = $descriptivetPostRequest["position"];
        $positionDescription = $descriptivetPostRequest["position_description"];
        $salary = $descriptivetPostRequest["salary"];

        $postAtNow = date("Y-m-d H:i:s", strtotime("now"));
        $startsAt =
            !empty($descriptivetPostRequest["starts_at"]) ?
            date(
                "Y-m-d H:i:s",
                strtotime($descriptivetPostRequest["starts_at"])
            ) : $postAtNow;

        $endsAt = date(
            "Y-m-d H:i:s",
            strtotime($descriptivetPostRequest["ends_at"])
        );
        $postAt =
            !empty($descriptivetPostRequest["post_at"]) ?
            date(
                "Y-m-d H:i:s",
                strtotime($descriptivetPostRequest["post_at"])
            ) : $postAtNow;



        $postDynamicModel = DynamicModel::validateData(
            [
                "type" => $type,
                "company_name" => $companyName,
                "position" => $positionName,
                "position_description" => $positionDescription,
                "salary" => $salary,
                "starts_at" => !empty($descriptivetPostRequest["starts_at"])
                    ? date(
                        "Y-m-d H:i:s",
                        strtotime($descriptivetPostRequest["starts_at"])
                    )
                    : null,
                "ends_at" => !empty($descriptivetPostRequest["ends_at"])
                    ? date(
                        "Y-m-d H:i:s",
                        strtotime($descriptivetPostRequest["ends_at"])
                    )
                    : null,
                "post_at" => !empty($descriptivetPostRequest["post_at"])
                    ? date(
                        "Y-m-d H:i:s",
                        strtotime($descriptivetPostRequest["post_at"])
                    )
                    : null,
            ],
            [
                [["type", "company_name", "position", "ends_at"], "required"],
                [["type"], "integer"],
                [["company_name"], "string", "max" => 80],
                [["position"], "string", "max" => 45],
                [["salary"], "integer"],
                [["position_description"], "string"],
                [
                    ["starts_at", "ends_at", "post_at"],
                    "datetime",
                    "format" => "php:Y-m-d H:i:s",
                ],
                [
                    ["post_at"],
                    "compare",
                    "compareValue" => $postAtNow,
                    "operator" => ">",
                    "message" =>
                    "PostAt date Cannot be a date in the past or current",
                    "when" => function ($descriptive) {
                        return !empty($descriptive->post_at);
                    },
                ],
                [
                    ["starts_at"],
                    function () {
                        $origin = strtotime($this->starts_at);
                        $target = strtotime($this->ends_at);
                        $interval = abs($origin - $target);

                        if ($origin > $target) {
                            $this->addError(
                                "ends_at",
                                "EndsAt date must be more then StartsAt date"
                            );
                        } elseif ($interval < 7890000) {
                            $this->addError(
                                "starts_at",
                                "Interval between StartsAt and EndsAt dates must be more then 3 months"
                            );
                        }
                    },
                ]

            ]
        );

        $postValidate = $postDynamicModel->hasErrors();
        $postErrors = $postDynamicModel->getErrors();

        if ($this->request->isAjax && !$postValidate) {
            $result = $post->insertDescriptivePost(
                $type,
                $positionName,
                $companyName,
                $positionDescription,
                $salary,
                $startsAt,
                $endsAt,
                $postAt
            );

            $insertedValues["type"] = "descriptive";
            $insertedValues["position"] = $positionName;
            $insertedValues["company_name"] = $companyName;
            $insertedValues["position_description"] = $positionDescription;
            $insertedValues["salary"] = $salary;
            $insertedValues["starts_at"] = $startsAt;
            $insertedValues["ends_at"] = $endsAt;
            $insertedValues["post_at"] = $postAt;

            $htmlBody = $this->renderPartial("feedback", [
                "data" => $insertedValues,
            ]);

            if ($result == "Completed") {
                $this->actionAddPostToQueue(
                    $postQueue,
                    $post->id,
                    $postAtNow,
                    $postAt,
                    $htmlBody
                );
                echo "success";
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

        \Yii::$app->queue->delay($interval)->push(
            new PostJob([
                "model" => $model,
                "id" => $id,
                "html" => $html,
                "text" => "Posted successfully",
            ])
        );
    }
}
