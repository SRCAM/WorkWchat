<?php


namespace WorkWechat\Work\User;


use WorkWechat\Core\BaseClient;

class Tag extends BaseClient
{
    /**
     * 创建标签
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90210
     * @param   array $data
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $data)
    {
        return $this->requestPostJson('cgi-bin/tag/create', $data);
    }

    /**
     * 更新标签名字
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90211
     * @param   int $id 标签ID
     * @param   string $tagName 标签名称
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, string $tagName)
    {
        $data = [
            'tagid' => $id,
            'tagname' => $tagName
        ];
        return $this->requestPostJson('cgi-bin/tag/update', $data);
    }

    /**
     * 删除标签
     * @link    https://work.weixin.qq.com/api/doc/90001/90143/90348
     * @param   int $id 标签ID
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $id)
    {
        return $this->requestGet('cgi-bin/tag/delete', ['tagid' => $id]);
    }

    /**
     * 获取标签成员
     * @link    https://work.weixin.qq.com/api/doc/90001/90143/90349
     * @param   int $id 标签ID
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function get(int $id)
    {
        return $this->requestGet('cgi-bin/tag/get', ['tagid' => $id]);
    }

    /**
     * 增加标签成员
     * @link    https://work.weixin.qq.com/api/doc/90001/90143/90350
     * @param   int $id
     * @param   array $userList
     * @param   array $partyList
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function addTagUsers(int $id, array $userList = [], array $partyList = [])
    {
        $data = [
            'tagid' => $id,
            'userlist' => $userList,
            'partylist' => $partyList
        ];
        return $this->requestPostJson('cgi-bin/tag/addtagusers', $data);
    }

    /**
     * 删除标签成员
     * @link    https://work.weixin.qq.com/api/doc/90001/90143/90351
     * @param   int $id
     * @param   array $userList
     * @param   array $partyList
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteTagUsers(int $id, array $userList = [], array $partyList = [])
    {
        $data = [
            'tagid' => $id,
            'userlist' => $userList,
            'partylist' => $partyList
        ];
        return $this->requestPostJson('cgi-bin/tag/deltagusers', $data);
    }

    /**
     * 获取标签列表
     * @link    https://work.weixin.qq.com/api/doc/90001/90143/90352
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function tagList()
    {
        return $this->requestGet('cgi-bin/tag/list');
    }
}