<?php
/**
 * Author: Michael
 * Date: 2016/2/16
 * Time: 12:41
 */

namespace Home\Service;


class DBMessages implements Messages
{

    private $__messages;

    /**
     * 获取用户消息
     * @return mixed
     */
    public function getMessages()
    {
        return $this->__messages;
    }

    /**
     * 根据用户名获取用户消息
     * @param $userid
     * @return mixed
     */
    public function messages($userid)
    {
        $resNotification = D('messages')
            ->field('subject')
            ->where(['userto'=>$userid, 'isstatus'=>'0'])
            ->order('id desc')
            ->select();
        $this->__messages->notification = $resNotification;
    }
}