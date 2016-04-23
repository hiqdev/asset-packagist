<?php

class Storage
{


    protected function updatePackage($name, $versions)
    {
        $data = [
            'packages' => [
                $name => $versions,
            ],
        ];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = Yii::getAlias("@web/p/$name$$hash.json");
        if (!file_exists($path)) {
            static::mkdir(dirname($path));
            file_put_contents($path, $json);
            $this->updateProviderLatest($name, $hash);
        }

        return $hash;
    }

    protected function updateProviderLatest($name, $hash)
    {
        $latest_path = Yii::getAlias('@web/provider-latest.json');
        if (file_exists($latest_path)) {
            $data = Json::decode(file_get_contents($latest_path) ?: '[]');
        }
        if (!is_array($data)) {
            $data = [];
        }
        if (!isset($data['providers'])) {
            $data['providers'] = [];
        }
        $data['providers'][$name] = ['sha256' => $hash];
        $json = Json::encode($data);
        $hash = hash('sha256', $json);
        $path = Yii::getAlias("@web/p/provider-latest$$hash.json");
        if (!file_exists($path)) {
            file_put_contents($path, $json);
            /// TODO lock
            file_put_contents($latest_path, Json::encode($data));
            $this->updateIndex($hash);
        }

        return $hash;
    }

    protected function updateIndex($hash)
    {
        $data = [
            'providers-url'     => '/p/%package%$%hash%.json',
            'search'            => '/search.json?q=%query%',
            'provider-includes' => [
                'p/provider-latest$%hash%.json' => [
                    'sha256' => $hash,
                ],
            ],
        ];
        /// TODO lock
        file_put_contents(Yii::getAlias('@web/packages.json'), Json::encode($data));
    }

    public static function mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

}
