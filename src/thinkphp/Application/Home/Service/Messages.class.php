<?php
/**
 * Author: Michael
 * Date: 2016/2/16
 * Time: 12:41
 */

namespace Home\Service;


interface Messages
{

    /**
     * 获取用户信息
     * @return mixed
     */
    public function getMessages();

    /**
     * 根据用户名获取用户信息
     * @param $userid
     * @return mixed
     */
    public function messages($userid);

}