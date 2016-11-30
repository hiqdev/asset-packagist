<?php

namespace hiqdev\assetpackagist\console;

use hiqdev\assetpackagist\commands\AbstractPackageCommand;
use Yii;
use yii\base\Event;
use yii\console\Controller;
use yii\helpers\Console;
use zhuravljov\yii\queue\ErrorEvent;
use zhuravljov\yii\queue\JobEvent;
use zhuravljov\yii\queue\Queue;

class QueueController extends Controller
{
    public function init()
    {
        $this->attachEventHandlers();
    }

    public function actionRun($channel)
    {
        Yii::$app->queue->run($channel);
    }

    public function actionTest()
    {
        Yii::info(Console::renderColoredString('Lorem ipsum for time %y' . time() . '%n ' . "\n"), \hiqdev\assetpackagist\commands\CollectDependenciesCommand::class);
        sleep(1);
    }

    private function attachEventHandlers()
    {
        $out = function ($string) {
            $this->stdout(Console::renderColoredString($string));
        };

        Event::on(Queue::class, Queue::EVENT_BEFORE_WORK, function ($event) use ($out) {
            /** @var JobEvent $event */
            $out("%Y[{$event->channel}]%n %GNew job%n '" . get_class($event->job) . "'\n");
        });

        Event::on(Queue::class, Queue::EVENT_AFTER_WORK, function ($event) use ($out) {
            /** @var JobEvent $event */
            $out("%Y[{$event->channel}]%n %GJob%n '" . get_class($event->job) . "' %Gis completed%n\n");
        });

        Event::on(Queue::class, Queue::EVENT_AFTER_ERROR, function ($event) use ($out) {
            /** @var ErrorEvent $event */
            $out("%Y[{$event->channel}]%n %RJob '" . get_class($event->job) . "' finished with error:%n '" . $event->error . "'\n");
        });

        Event::on(AbstractPackageCommand::class, AbstractPackageCommand::EVENT_BEFORE_RUN, function ($event) use ($out) {
            /** @var AbstractPackageCommand $command */
            $command = $event->sender;
            $out("%g[" . get_class($command) . "]%n Working on package %N" . $command->getPackage()->getFullName() . "%n\n");
        });
    }
}

