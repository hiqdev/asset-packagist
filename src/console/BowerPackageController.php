<?php

namespace hiqdev\assetpackagist\console;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\Json;

class BowerPackageController extends \yii\console\Controller
{
    /**
     * Fetches TOP-$count components from Bower ans saves to `config/bower.list`
     *
     * @param int $count
     * @param bool $skipCache
     */
    public function actionFetchTop($count = 1000, $skipCache = false)
    {
        $result = [];
        $components = $this->getComponents($skipCache);
        ArrayHelper::multisort($components, 'stars', SORT_DESC, SORT_NUMERIC);

        foreach (array_slice($components, 0, $count) as $component) {
            $result[] = 'bower-asset/' . $component['name'];
            echo Console::renderColoredString("%R{$component['stars']}%N - %g{$component['name']}%N");
            Console::moveCursorTo(0);
            Console::clearLine();
        }

        $componentsListPath = Yii::getAlias('@hiqdev/assetpackagist/config/bower.list');
        file_put_contents($componentsListPath, implode("\n", $result));

        echo Console::renderColoredString("Fetched %YBower%N components list. Found %G" . count($components) . "%N components.\n");
        echo Console::renderColoredString("Only %bTOP-" . $count . "%N components were added to the packages list.\n");
        echo Console::renderColoredString("See %G" . $componentsListPath . "%N\n");
    }

    /**
     * Gets components array from bower API
     *
     * @param bool $skipCache whether to skip using local cache
     * @return array
     */
    private function getComponents($skipCache = false)
    {
        $url = 'http://bower-component-list.herokuapp.com';
        $componentsFilePath = Yii::getAlias('@runtime/bower-cache/components.list');

        if (!$skipCache && is_file($componentsFilePath) && (time() - filemtime($componentsFilePath) < 60*60*6)) { // 6 hours
            $raw = file_get_contents($componentsFilePath);
        } else {
            $result = (new \GuzzleHttp\Client())->request('GET', $url);
            $raw = $result->getBody();
            file_put_contents($componentsFilePath, $raw);
        }

        return Json::decode($raw);
    }
}
