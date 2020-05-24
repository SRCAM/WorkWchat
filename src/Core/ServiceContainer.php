<?php


namespace WorkWechat\Core;


use Pimple\Container;
use WorkWechat\Core\Providers\ConfigProvider;
use WorkWechat\Core\Providers\HttpClientProvider;
use WorkWechat\Core\Providers\RequestProvider;


/**
 * @property  \WorkWechat\Core\config                    $config
 * @property  \GuzzleHttp\Client                         $http_client
 * @property  \Symfony\Component\HttpFoundation\Request  $request
 *
 * Class ServiceContainer
 * @package WorkWechat\Core
 */
class ServiceContainer extends Container
{

    /**
     *
     * @var array
     */
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
            ConfigProvider::class,
            HttpClientProvider::class,
            RequestProvider::class
        ], $this->providers);
    }

    /**
     *
     * @param $id
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}