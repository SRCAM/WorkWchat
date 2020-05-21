<?php


namespace WorkWechat\Work;


use WorkWechat\Exception\ArgumentException;
use WorkWechat\Http\BaseRequest;

/**
 * 标签
 * Class Tag
 * @package WorkWechat\Ebs
 */
class Tag extends BaseRequest
{
    /**
     * 创建
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     * @throws ArgumentException
     */
    public function create(string $tagname, int $tagId)
    {
        if (strlen($tagname) > 32) {
            throw new ArgumentException('标签名称,长度限制为32个字以内');
        }
        if ($tagId < 0) {
            throw new ArgumentException('标签id，非负整型，');
        }
        return $this->httpPost('/cgi-bin/tag/create', ['tagname' => $tagname, 'tagid' => $tagId]);
    }

    /**
     * 更新
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     * @throws ArgumentException
     */
    public function update(int $tagId, string $tagname)
    {
        if (strlen($tagname) > 32) {
            throw new ArgumentException('标签名称,长度限制为32个字以内');
        }
        if ($tagId < 0) {
            throw new ArgumentException('标签id，非负整型，');
        }
        return $this->httpPost('/cgi-bin/tag/update', ['tagname' => $tagname, 'tagid' => $tagId]);
    }

    /**
     * 删除标签
     * @param int $tagId 标签ID
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function delete(int $tagId)
    {
        return $this->httpGet('/cgi-bin/tag/create', ['tagid' => $tagId]);
    }

    /**
     * 获取标签成员
     * @param int $tagId 标签ID
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function get(int $tagId)
    {
        return $this->httpGet('/cgi-bin/tag/get?', ['tagid' => $tagId]);
    }

    /**
     *增加标签成员
     * @param int $tagId
     * @param array $userList
     * @param array $partyList
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     * @throws ArgumentException
     */
    public function addTagUsers($tagId, array $userList = [], array $partyList = [])
    {
        if (count($userList) > 1000) {
            throw new ArgumentException('企业成员ID列表，单次请求个数不超过1000');
        }
        if (count($partyList) > 100) {
            throw new ArgumentException('企业部门ID列表，单次请求个数不超过100');
        }
        $data = [
            'tagid' => $tagId,
            'userlist' => $userList,
            'partylist' => $partyList
        ];
        return $this->httpPostJson('/cgi-bin/tag/addtagusers?', $data);
    }

    /**
     * 删除标签成员
     * @param $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     * @throws ArgumentException
     */
    public function deleteTagUser(int $tagId, array $userList = [], array $partyList = [])
    {
        if (count($userList) > 1000) {
            throw new ArgumentException('企业成员ID列表，单次请求个数不超过1000');
        }
        if (count($partyList) > 100) {
            throw new ArgumentException('企业部门ID列表，单次请求个数不超过100');
        }
        $data = [
            'tagid' => $tagId,
            'userlist' => $userList,
            'partylist' => $partyList
        ];
        return $this->httpPostJson('/cgi-bin/tag/deltagusers?', $data);
    }

    /**
     * 获取标签列表
     * @return \http\Client
     */
    public function list()
    {
        return $this->HttpGet('/cgi-bin/tag/deltagusers');
    }
}