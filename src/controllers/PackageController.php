<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\controllers;

use Exception;
use hiqdev\assetpackagist\commands\PackageUpdateCommand;
use hiqdev\assetpackagist\exceptions\CorruptedPackageException;
use hiqdev\assetpackagist\exceptions\PackageNotExistsException;
use hiqdev\assetpackagist\exceptions\UpdateRateLimitException;
use hiqdev\assetpackagist\models\AssetPackage;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PackageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'update' => ['post'],
                ],
            ],
        ];
    }

    public function actionUpdate()
    {
        session_write_close();
        $query = Yii::$app->request->post('query');
        $package = $this->getAssetPackage($query);

        try {
            if (!$package->canBeUpdated()) {
                throw new UpdateRateLimitException();
            }

            Yii::createObject(PackageUpdateCommand::class, [$package])->run();
        } catch (UpdateRateLimitException $exception) {
            Yii::$app->session->addFlash('rate-limited', true);
        } catch (PackageNotExistsException $e) {
            return $this->renderPartial('not-found', ['package' => $package]);
        } catch (CorruptedPackageException $e) {
            return $this->renderPartial('fetch-error', ['package' => $package, 'exception' => $e]);
        } catch (Exception $e) {
            Yii::error([
                'UNKNOWN error during ' . $package->getFullName() . ' update',
                get_class($e),
                $e->getMessage(),
            ], __METHOD__);

            return $this->renderPartial('fetch-error', ['package' => $package]);
        }
        $package->load();

        return $this->renderPartial('details', ['package' => $package]);
    }

    public function actionSearch($query)
    {
        try {
            $package = $this->getAssetPackage($query);
            $params = ['package' => $package, 'query' => $query, 'forceUpdate' => false];

            if ($package->canAutoUpdate()) {
                $params['forceUpdate'] = true;
            }
        } catch (Exception $e) {
            return $this->render('wrong-name', compact('query'));
        }

        return $this->render('search', $params);
    }

    /**
     * @param string $query
     * @return AssetPackage
     */
    private static function getAssetPackage($query)
    {
        $filtredQuery = trim($query);
        $package = AssetPackage::fromFullName($filtredQuery);
        $package->load();

        return $package;
    }
}
