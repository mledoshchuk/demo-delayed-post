<?php

namespace app\jobs;

use yii\base\BaseObject;
use app\models\PostsQueue;

class PostJob extends BaseObject implements \yii\queue\JobInterface
{
    public $text;
    public $id;
    public $html;

    public function execute($queue)
    {
        try {
            $postQueue = new PostsQueue();

            \Yii::$app->mailer
                ->compose()
                ->setFrom("noreply@example.com")
                ->setTo("admin@example.com")
                ->setSubject("Notification")
                ->setTextBody($this->text)
                ->setHtmlBody($this->html)
                ->send();
            $postQueue->insertQueueNotification(
                $this->id,
                date("Y-m-d H:i:s", strtotime("now"))
            );
        } catch (\Exception $e) {
            \Yii::$app->mailer
                ->compose()
                ->setFrom("noreply@example.com")
                ->setTo("admin@example.com")
                ->setSubject("Notification")
                ->setTextBody("Queue failed")
                ->setHtmlBody($this->html . "<div><pre>" . $e . "</pre></div>")
                ->send();

            $postQueue->insertQueueNotification(
                $this->id,
                date("Y-m-d H:i:s", strtotime("now"))
            );
        }
    }
}
