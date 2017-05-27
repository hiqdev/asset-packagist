<?php
/**
 * Asset Packagist.
 *
 * @link      https://github.com/hiqdev/asset-packagist
 * @package   asset-packagist
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\assetpackagist\librariesio;

use GuzzleHttp\Psr7\Response;
use Yii;
use yii\caching\Cache;
use yii\data\BaseDataProvider;
use yii\di\Instance;
use yii\helpers\Json;

class ProjectDataProvider extends BaseDataProvider
{
    public $query;
    public $platform;

    /**
     * Enable cache to search results, false to disable
     * Cache is used to prevent rate limit.
     * @see https://libraries.io/api/#rate-limit
     * @var string|Cache|false
     */
    public $cache = 'cache';

    /**
     * @var int number of seconds that search result can remain valid in cache
     */
    public $cacheDuration = 600;

    /**
     * @var string|LibrariesioRepository
     */
    public $repository = 'librariesio';

    /**
     * @var int Total count from last request
     */
    protected $lastTotalCount = 0;

    public function init()
    {
        parent::init();

        if ($this->cache) {
            $this->cache = Instance::ensure($this->cache, Cache::className());
        }
        $this->repository = Instance::ensure($this->repository, LibrariesioRepository::className());
    }

    protected function prepareModels()
    {
        if (!$this->platform) {
            $this->platform = 'bower,npm';
        }
        if (is_array($this->platform)) {
            $this->platform = implode(',', $this->platform);
        }

        $query = [
            'q'         => $this->query,
            'platforms' => $this->platform,
        ];

        if (($sort = $this->getSort()) !== false) {
            foreach ($sort->getOrders() as $sort => $order) {
                $query['sort'] = $sort;
                $query['order'] = ($order === SORT_ASC) ? 'asc' : 'desc';
                break;
            }
        }

        if (($pagination = $this->getPagination()) !== false) {
            /**
             * Not use '$pagination->getPage()' because need define 'totalCount' first
             * totalCount is defined after request.
             */
            $page = (int) Yii::$app->getRequest()->getQueryParam($pagination->pageParam, 1);
            if ($page > 1) {
                $query['page'] = $page;
            }

            $query['per_page'] = $pagination->getPageSize();
        }

        $cacheKey = [static::className(), 'query' => $query];

        $items = [];
        $totalCount = 0;

        if ($this->cache && $this->cache->exists($cacheKey)) {
            list($totalCount, $items) = $this->cache->get($cacheKey);
        } else {
            /* @var $response Response */
            $response = $this->repository->search($query);

            if ($response->getStatusCode() !== 200) {
                return [];
            }

            $totalCount = (int) $response->getHeaderLine('total');
            $items = Json::decode($response->getBody());

            if ($this->cache) {
                $this->cache->set($cacheKey, [$totalCount, $items], $this->cacheDuration);
            }
        }

        $this->lastTotalCount = $totalCount;

        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->lastTotalCount;
        }

        $models = [];

        foreach ($items as $item) {
            $models[] = new Project(['attributes' => $item]);
        }

        return $models;
    }

    /**
     * @param Project[] $models
     * @return array
     */
    protected function prepareKeys($models)
    {
        $keys = [];

        foreach ($models as $model) {
            $keys[] = [
                'name'     => $model->name,
                'platform' => $model->name,
            ];
        }

        return $keys;
    }

    protected function prepareTotalCount()
    {
        $this->prepare();
        return $this->lastTotalCount;
    }

    public function setSort($value)
    {
        /**
         * Override the default attributes to sort.
         */
        if (is_array($value)) {
            $value = array_merge([
                'attributes' => [
                    'Rank'                        => 'rank',
                    'Stars'                       => 'stars',
                    'Dependents Count'            => 'dependents_count',
                    'Dependent Repos Count'       => 'dependent_repos_count',
                    'Latest Release Published At' => 'latest_release_published_at',
                    'Created At'                  => 'created_at',
                    'Contributions Count'         => 'contributions_count',
                ], ], $value);
        }

        parent::setSort($value);
    }
}
