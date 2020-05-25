<?php


namespace WorkWechat\Work\User;


use WorkWechat\Core\BaseClient;

class Tag extends BaseClient
{
    /**
     * 创建标签
     * @link https://work.weixin.qq.com/api/doc/90000/90135/90210
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $data)
    {
        return $this->requestPostJson('cgi-bin/tag/create', $data);
    }

    /**
     * 更新标签名字
     * @link https://work.weixin.qq.com/api/doc/90000/90135/90211
     * @param int $id 标签ID
     * @param string $tagName 	标签名称
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, string $tagName)
    {
        $data = [
            'tagid' => $id,
            'tagname' => $tagName
        ];
        return $this->requestPostJson('cgi-bin/tag/update', $data);
    }
}