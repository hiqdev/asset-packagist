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

use GuzzleHttp\Client;
use yii\base\Component;

class LibrariesioRepository extends Component
{
    /**
     * @var string Base URI for https://libraries.io
     */
    public $baseUri = 'https://libraries.io/api/';

    /**
     * Without api key, has 30/request/minute hate limit
     * With api key, has 60/request/minute hate limit.
     * @var string The user API Key
     */
    public $apiKey;

    /**
     * Options for Guzzle client
     * Example:
     * [
     *   'timeout'         => 0,
     *   'allow_redirects' => false,
     *   'proxy'           => '192.168.16.1:10'
     * ].
     *
     * @var array
     */
    public $clientOptions = [];

    /**
     * The Guzzle client.
     * @var Client
     */
    protected $client;

    public function init()
    {
        parent::init();

        $this->clientOptions['base_uri'] = $this->baseUri;

        $this->client = new Client($this->clientOptions);
    }

    /**
     * Send request to server with api_key and return a Response.
     * @param string $method
     * @param string $uri
     * @param array $options
     * @throws \GuzzleHttp\Exception\BadResponseException
     * @return \GuzzleHttp\Psr7\Response
     */
    public function request($method, $uri = '', array $options = [])
    {
        if (!isset($options['query'])) {
            $options['query'] = [];
        }
        if ($this->apiKey && !isset($options['query']['api_key'])) {
            $options['query']['api_key'] = $this->apiKey;
        }

        try {
            return $this->client->request($method, $uri, $options);
        } catch (\GuzzleHttp\Exception\BadResponseException $ex) {
            if ($ex->hasResponse()) {
                return $ex->getResponse();
            }
            throw $ex;
        }
    }

    /**
     * Search package in https://libraries.io.
     * @see https://libraries.io/api/#project-search
     * @param array $query
     * @return \GuzzleHttp\Psr7\Response
     */
    public function search($query = [])
    {
        return $this->request('GET', 'search', ['query' => $query]);
    }

    /**
     * Return the package info from https://libraries.io.
     * @see https://libraries.io/api/#project
     * @param string $platform
     * @param string $name
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getProject($platform, $name)
    {
        return $this->request('GET', $platform . '/' . $name);
    }
}
