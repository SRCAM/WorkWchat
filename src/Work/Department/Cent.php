<?php


namespace WorkWechat\Work\Department;


use WorkWechat\Core\BaseClient;

/**
 * 部门
 * Class Cent
 * @package WorkWechat\Work\Department
 */
class Cent extends BaseClient
{
    /**
     * 创建部门
     * @link https://work.weixin.qq.com/api/doc/90000/90135/90205
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $data)
    {
        return $this->requestPostJson('cgi-bin/department/create', $data);
    }

    /**
     * 更新部门
     * @link https://work.weixin.qq.com/api/doc/90000/90135/90205
     * @param int $id 部门id
     * @param array $data 需要修改的数据
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, array $data)
    {
        return $this->requestPostJson('cgi-bin/department/update', array_merge(['id' => $id], $data));
    }

    /**
     * 删除部门
     * @link  https://work.weixin.qq.com/api/doc/90000/90135/90207
     * @param int $id 部门id
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $id)
    {
        return $this->requestGet('cgi-bin/department/delete', ['id' => $id]);
    }

    /**
     * 获取部门列表
     * @link  https://work.weixin.qq.com/api/doc/90000/90135/90208
     * @param int $id 部门id
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserLIst(int $id = null)
    {
        return $this->requestGet('cgi-bin/department/list', ['id' => $id]);
    }
}