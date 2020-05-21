<?php

namespace WorkWechat\Http;


class  BaseRequest extends HasHttpRequests
{
    /**
     * GET request
     * @param string $url
     * @param array $query
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    protected function httpGet($url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * @param string $url
     * @param array $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    protected function httpPost($url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $query
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    protected function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    protected function httpUpload()
    {

    }
}