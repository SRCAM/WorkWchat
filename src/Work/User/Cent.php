<?php


namespace WorkWechat\Work\User;


use Cassandra\Date;
use WorkWechat\Core\BaseClient;
use WorkWechat\Core\Exceptions\ArgumentException;

class Cent extends BaseClient
{
    /**
     * 创建成员
     * @param   array $data
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90195
     * 创建成员
     */
    public function create(array $data)
    {
        return $this->requestPostJson('cgi-bin/user/create', $data);
    }

    /**
     * 读取成员
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90196
     * @param   string $userId 用户id
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
     * @param   string $userId 用户id
     * @param   array $data 更新数据
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
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90200
     * @param   int $departmentId
     * @param   bool $fetchChild
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
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
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90201
     * @param   int $departmentId 获取的部门id
     * @param   bool $fetchChild 1/0：是否递归获取子部门下面的成员
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
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
     * 该接口使用场景为企业支付，在使用企业红包和向员工付款时，需要自行将企业微信的userid转成openid。
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/90202
     * @param   string $userId 企业内的成员id
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function userIdConvertToOpenid(string $userId)
    {
        return $this->requestPostJson('cgi-bin/user/convert_to_openid', ['userid' => $userId]);
    }

    /**
     * 获取加入企业二维码
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/91714
     * @param   int $sizeType qrcode尺寸类型 1: 171 x 171; 2: 399 x 399; 3: 741 x 741; 4: 2052 x 2052
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  ArgumentException
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function getJoinQrcode(int $sizeType)
    {
        if (!in_array($sizeType, [1, 2, 3, 4])) {
            throw new ArgumentException('qrcode尺寸类型，1: 171 x 171; 2: 399 x 399; 3: 741 x 741; 4: 2052 x 2052');
        }
        return $this->requestGet('cgi-bin/corp/get_join_qrcode', ['size_type' => $sizeType]);
    }

    /**
     * 获取手机号随机串
     * 支持企业获取手机号随机串，该随机串可直接在企业微信终端搜索手机号对应的微信用户。
     * @link    https://work.weixin.qq.com/api/doc/90000/90135/91735
     * @param   string $mobile 手机号
     * @param   string $state 企业自定义的state参数，
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function getMobileHashcode(string $mobile, string $state = null)
    {
        $data = [
            'mobile' => $mobile,
            'state' => $state
        ];
        return $this->requestPostJson('cgi-bin/user/get_mobile_hashcode?', $data);
    }

    /**
     * 获取企业活跃成员数
     * @link https://work.weixin.qq.com/api/doc/90000/90135/92714
     * @param   string $date 具体某天的活跃人数,最长支持获取30天前数据 $date => '2020-03-27'
     * @return  \Psr\Http\Message\ResponseInterface|void
     * @throws  ArgumentException
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function getActiveStat(string $date)
    {
        $last_time = strtotime('-30 days');
        if ($last_time > strtotime($date)) {
            throw new ArgumentException('只能获取30天前数据');
        }
        return $this->requestPostJson('cgi-bin/user/get_active_stat', ['date' => $date]);
    }
}