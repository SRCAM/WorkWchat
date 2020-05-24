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
     * @link https://work.weixin.qq.com/api/doc/90000/90135/90195
     * 创建成员
     */
    public function create(array $data)
    {
        return $this->requestPostJson('cgi-bin/user/create', $data);
    }

    /**
     * 读取成员
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90196
     * @param string $userId 用户id
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     * 在通讯录同步助手中此接口可以读取企业通讯录的所有成员信息，而自建应用可以读取该应用设置的可见范围内的成员信息。
     */
    public function get(string $userId)
    {
        return $this->requestGet('cgi-bin/user/get', ['userid' => $userId]);
    }

    /**
     * 更新成员
     * @param string $userId 用户id
     * @param array $data 更新数据
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90197
     */
    public function update(string $userId, array $data = [])
    {
        return $this->requestPostJson('cgi-bin/user/update', array_merge(['userid' => $userId], $data));
    }

    /**
     * 删除成员
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90198
     * @param   string $userId 用户id
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     * 仅通讯录同步助手或第三方通讯录应用可调用。若是绑定了腾讯企业邮，则会同时删除邮箱帐号。
     */
    public function delete(string $userId)
    {
        return $this->requestGet('cgi-bin/user/delete', ['userid' => $userId]);
    }

    /**
     * 批量删除成员
     * @link        https://work.weixin.qq.com/api/doc/90000/90135/90199
     * @param       array $useridList 成员UserID列表
     * @return      \Psr\Http\Message\ResponseInterface|void
     * @throws      \GuzzleHttp\Exception\GuzzleException
     */
    public function batchDelete(array $useridList = [])
    {
        return $this->requestPostJson('cgi-bin/user/batchdelete', $useridList);
    }

    /**
     * 获取部门成员
     * @link  https://work.weixin.qq.com/api/doc/90000/90135/90200
     * @param int $departmentId
     * @param bool $fetchChild
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDepartmentSimpleUserList(int $departmentId, bool $fetchChild = false)
    {
        $params = [
            'department_id' => $departmentId,
            'fetch_child' => (int)$fetchChild
        ];
        return $this->requestGet('cgi-bin/user/simplelist', $params);
    }

    /**
     * 获取部门成员详情
     * @link https://work.weixin.qq.com/api/doc/90000/90135/90201
     * @param int $departmentId 获取的部门id
     * @param bool $fetchChild 1/0：是否递归获取子部门下面的成员
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDepartmentUserList(int $departmentId, bool $fetchChild = false)
    {
        $params = [
            'department_id' => $departmentId,
            'fetch_child' => (int)$fetchChild
        ];
        return $this->requestGet('cgi-bin/user/list', $params);
    }

    /**
     * userid与openid互换
     * @link https://work.weixin.qq.com/api/doc/90000/90135/90202
     * @param string $userId 企业内的成员id
     * 该接口使用场景为企业支付，在使用企业红包和向员工付款时，需要自行将企业微信的userid转成openid。
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userIdConvertToOpenid(string $userId)
    {
        return $this->requestPostJson('cgi-bin/user/convert_to_openid', ['userid' => $userId]);
    }

//    public function ()
//    {
//
//    }

}