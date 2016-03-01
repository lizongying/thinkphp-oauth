<?php
/**
 * Author: Michael
 * Date: 2016/2/16
 * Time: 12:41
 */

namespace Home\Service;


class DBMember implements Member
{

    private $__info;

    /**
     * 获取用户信息
     * @return mixed
     */
    public function getInfo()
    {
        return $this->__info;
    }

    /**
     * 根据用户名获取用户信息
     * @param $userid
     * @return mixed
     */
    public function info($userid)
    {
        $resUser = D('Users u')
            ->field('u.name, t.name type, u.createtime')
            ->join('user_type t on t.id = u.type')
            ->where(['u.id'=>$userid])
            ->find();
        $this->__info = $resUser;
    }
}