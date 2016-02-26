<?php
/**
 * Author: Michael
 * Date: 2016/2/16
 * Time: 12:41
 */

namespace Home\Service;


interface Member
{

    /**
     * 获取用户信息
     * @return mixed
     */
    public function getInfo();

    /**
     * 根据用户名获取用户信息
     * @param $userid
     * @return mixed
     */
    public function info($userid);

}