<?php


namespace WorkWechat\Actions;


use WorkWechat\Http\BaseRequest;

/**
 * 部门
 * Class Department
 * @package WorkWechat\Ebs
 */
class Department extends BaseRequest
{
    /**
     * 创建部门
     * @param array $data
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function create($data)
    {
        return $this->httpPostJson('/cgi-bin/department/create', $data);
    }

    /**
     * 更新部门
     * @param int $id 部门id
     * @param array $data 更新数据
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function update($id, $data)
    {
        return $this->httpPostJson('/cgi-bin/department/update', array_merge(['id' => $id], $data));
    }

    /**
     * 删除部门
     * @param string $id
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function delete($id)
    {
        return $this->httpPostJson('/cgi-bin/department/delete', ['id' => $id]);
    }

    /**
     * 获取部门列表
     * @param string $id
     * @return void
     * @throws \WorkWechat\Exception\NotfindException
     * @throws \WorkWechat\Exception\WorkWechatApiException
     */
    public function list($id)
    {
        return $this->httpGet('/cgi-bin/department/list', ['id' => $id]);
    }
}