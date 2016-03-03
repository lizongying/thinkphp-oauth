<?php
/**
 * Author: Michael
 * Date: 2016/1/19
 * Time: 15:47
 */
namespace  Home\Model;
use Think\Model;

class UsersModel extends Model
{
    /**
     * @param null $username
     * @return bool|mixed
     */
    public function select($username = null)
    {
        if ($username !== null) {
            return false;
        }

        $result = M('users')
            ->field('username, password, name, email, photo')
            ->where(['username'=>$username])
            ->select();

        if (!$result || count($result) === 0) {
            return false;
        }

        return $result;
    }


    // 自动验证设置
    protected $_validate = array(
        array('username', 'require', '用户名必须填写！', 1),
        array('name', 'require', '姓名必须填写！', 1),
        array('email', 'email', '邮箱格式错误！', 2),
        array('username', '', '用户名已经存在！', 0, 'unique', 1),
    );

    //自动填充设置
    protected $_auto = array(
//        写入当前时间戳
        array('createtime', 'time', 1, 'function'),
        array('password', 'passwordHash', 3, 'function'),
        array('status', '1'),
//        写入用户注册IP地址
        array('ip', 'get_client_ip', 1, 'function'),
    );

}