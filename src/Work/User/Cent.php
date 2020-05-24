<?php


namespace WorkWechat\Work\User;


use WorkWechat\Core\BaseClient;

class Cent extends BaseClient
{
    /**
     * 创建成员
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @deprecated  创建成员
     */
    public function create(array $data)
    {
        return $this->requestPostJson('cgi-bin/user/create', $data);
    }

    /**
     * 读取成员
     * @param string $userid 用户id
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @deprecated  在通讯录同步助手中此接口可以读取企业通讯录的所有成员信息，而自建应用可以读取该应用设置的可见范围内的成员信息。
     */
    public function get(string $userid)
    {
        return $this->requestGet('cgi-bin/user/get', ['userid' => $userid]);
    }

    /**
     * 更新成员
     * @param string $userid 用户id
     * @param array $data 更新数据
     * @deprecated  更新成员
     */
    public function update(string $userid, array $data = [])
    {

    }
}