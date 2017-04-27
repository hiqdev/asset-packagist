<?php
/**
 * Asset Packagist.
 *
 * @see      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\console;

use hiqdev\assetpackagist\commands\AbstractPackageCommand;
use Yii;
use yii\base\Event;
use yii\console\Controller;
use yii\helpers\Console;
use zhuravljov\yii\queue\ErrorEvent;
use zhuravljov\yii\queue\JobEvent;
use zhuravljov\yii\queue\Queue;

/**
 * Manages service Queue.
 */
class QueueController extends Controller
{
    public function init()
    {
        $this->attachEventHandlers();
    }

    /**
     * Runs the queue.
     */
    public function actionRun()
    {
        Yii::$app->queue->run();
    }

    /**
     * Test action to ensure that ErrorHandler flushes stack immediately.
     */
    public function actionTestErrorHandler()
    {
        Yii::info(Console::renderColoredString('Lorem ipsum for time %y' . time() . '%n ' . "\n"), \hiqdev\assetpackagist\commands\CollectDependenciesCommand::class);
        sleep(1);
    }

    /**
     * Attaches handlers on Queue events.
     */
    private function attachEventHandlers()
    {
        $out = function ($string) {
            $this->stdout(Console::renderColoredString($string));
        };

        Event::on(Queue::class, Queue::EVENT_BEFORE_WORK, function ($event) use ($out) {
            /** @var JobEvent $event */
            $out("%GNew job%n '" . get_class($event->job) . "'\n");
        });

        Event::on(Queue::class, Queue::EVENT_AFTER_WORK, function ($event) use ($out) {
            /** @var JobEvent $event */
            $out("%GJob%n '" . get_class($event->job) . "' %Gis completed%n\n");
        });

        Event::on(Queue::class, Queue::EVENT_AFTER_ERROR, function ($event) use ($out) {
            /** @var ErrorEvent $event */
            $out("%RJob '" . get_class($event->job) . "' finished with error:%n '" . $event->error . "'\n");
        });

        Event::on(AbstractPackageCommand::class, AbstractPackageCommand::EVENT_BEFORE_RUN, function ($event) use ($out) {
            /** @var AbstractPackageCommand $command */
            $command = $event->sender;
            $out('%g[' . get_class($command) . ']%n Working on package %N' . $command->getPackage()->getFullName() . "%n\n");
        });
    }
}
