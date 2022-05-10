<?php

namespace app\jobs;

use yii\base\BaseObject;

class PostJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
    public $model;
    public $text;
    public $html;
    

    public function execute($queue)
    {
        try {
            \Yii::$app->mailer
                ->compose()
                ->setFrom("noreply@example.com")
                ->setTo("admin@example.com")
                ->setSubject("Notification")
                ->setTextBody($this->text)
                ->setHtmlBody($this->html)
                ->send();

            $this->model->insertQueueNotification(
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

            $this->model->insertQueueNotification(
                $this->id,
                date("Y-m-d H:i:s", strtotime("now"))
            );
        }
        
    }
}
