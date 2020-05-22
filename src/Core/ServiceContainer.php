<?php


namespace WorkWechat\Core;


use Pimple\Container;

//use WorkWechat\Core\Providers\ConfigProvider;
//use WorkWechat\Core\Providers\HttpClientProvider;
//use WorkWechat\Core\Providers\RequestProvider;

/**
 * @property  \WorkWechat\Core\Providers\ConfigProvider $config
 * @property  \WorkWechat\Core\Providers\HttpClientProvider $http_client
 * @property  \WorkWechat\Core\Providers\RequestProvider $request
 * Class ServiceContainer
 * @package WorkWechat\Core
 */
class ServiceContainer extends Container
{
    protected $providers = [];

    protected $defaultConfig = [];

    protected $userConfig = [];

    public function __construct(array $config = [], array $prepends = [])
    {
        $this->registerProviders($this->getProviders());
        parent::__construct($prepends);
        $this->userConfig = $config;
    }

    /**
     * 设置配置
     * @return array
     */
    public function getConfig()
    {
        $base = [
            'http' => [
                'timeout' => 10.0,
                'base_uri' => 'https://api.weixin.qq.com/',
            ]
        ];
        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            \WorkWechat\Core\Providers\ConfigProvider::class,
            \WorkWechat\Core\Providers\HttpClientProvider::class,
            \WorkWechat\Core\Providers\RequestProvider::class
        ], $this->providers);
    }

    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register($provider);
        }
    }
}