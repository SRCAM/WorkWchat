<?php

namespace WorkWechat\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\HandlerStack;
use http\Client;
use WorkWechat\Container;
use WorkWechat\Exception\WorkWechatApiException;
use WorkWechat\Exception\NotfindException;

class HasHttpRequests
{
    protected $httpClient;

    protected static $defaults = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ];

    protected function getHttpClient()
    {
        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => 'https://qyapi.weixin.qq.com',
            'timeout' => 2.0,
        ]);
        return $this->httpClient;
    }

    protected function getGuzzleHandler()
    {
        return \GuzzleHttp\choose_handler();
    }

    /**
     * 请求
     * @param $url
     * @param string $method
     * @param array $options
     * @return void
     * @throws NotfindException
     * @throws WorkWechatApiException
     */
    protected function request($url, $method = 'GET', $options = [])
    {

        $method = strtoupper($method);
        $config = Container::getInstance()->getConfig();
        $options = array_merge(self::$defaults, $options);
        $options['query']['access_token'] = $config['access_token'];
        try {
            $response = $this->getHttpClient()->request($method, $url, $options);
            $response->getBody()->rewind();
            return $this->getResponse($response);
        } catch (\GuzzleHttp\Exception\ConnectException $exception) {
            $path = $exception->getRequest()->getUri()->getPath();
            $host = $exception->getRequest()->getUri()->getHost();
            $getScheme = $exception->getRequest()->getUri()->getScheme();
            $url = $getScheme . '://' . $host . $path;
            throw new NotfindException($exception->getMessage(), $exception->getCode(), $url);
        }
    }

    /**
     * @param $response
     * @return mixed
     * @throws WorkWechatApiException
     */
    private function getResponse($response)
    {
        $contents = $response->getBody()->getContents();
        $contents = \GuzzleHttp\json_decode($contents, true);
        if ($contents['errcode'] != 0) {
            throw new WorkWechatApiException($contents['errcode']);
        }
        //如果设置的有access_token
        if (isset($contents['access_token'])) {
            return $contents;
        }
        return $contents;
    }
}