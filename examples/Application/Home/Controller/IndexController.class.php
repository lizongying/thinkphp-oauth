<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{

    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index()
    {
        header('Content-type:text/html;charset=utf-8');
        echo '<a href="/home/index/addToken">增加access_token</a>' . '<br>';
        echo '<a href="/home/index/test">测试api</a>' . '<br>';
        echo '<a href="/home/api/tokeninfo?access_token=iamming">获取令牌信息</a>' . '<br>';
        echo '<a href="/home/api/users?access_token=iamming">获取所有用户信息</a>' . '<br>';
        echo '<a href="/home/api/users/xiaoming?access_token=iamming">获取指定用户信息</a>' . '<br>';
        echo '<hr>';
        echo '<a href="/home/index/addClient">增加client_id和secret</a>' . '<br>';
        echo '<hr>';
        echo '<a href="/home/index/addRedirect">增加redirect_uri</a>' . '<br>';
        echo '<hr>';
        echo '<a href="/home/authcode/authorize?response_type=code&client_id=client&scope=&state=' . md5(uniqid(rand(10000, 99999), true)) . '&redirect_uri=' . urlencode('http://redirect') . '">获取授权码</a>' . '<br>';
        echo 'response_type：表示授权类型，必选项，此处的值固定为code' . '<br>';
        echo 'client_id：表示客户端的ID，必选项' . '<br>';
        echo 'redirect_uri：表示重定向URI，必选项' . '<br>';
        echo 'scope：表示申请的权限范围，可选项，此处默认basic' . '<br>';
        echo 'state：表示客户端的当前状态，可以指定任意值，认证服务器会原封不动地返回这个值，此处为32位随机字符串' . '<br>';
        echo 'http://localhost/home/authcode/authorize?response_type=code&client_id=client&scope=&state=' . md5(uniqid(rand(10000, 99999), true)) . '&redirect_uri=' . urlencode('http://redirect') . '<br>';
    }

    /**
     * 请求页面
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 增加用户
     */
    public function addUser()
    {
        $user = array(
            0 => array(
                'username' => 'xiaoming',
                'password' => password_hash('xiaoming', PASSWORD_DEFAULT),
                'name' => 'xiaoming',
                'email' => 'xiaoming@126.com',
                'photo' => 'http://localhoost/user/xiaoming',
            ),
            1 => array(
                'username' => 'xiaohong',
                'password' => password_hash('xiaohong', PASSWORD_DEFAULT),
                'name' => 'xiaoming',
                'email' => 'xiaohong@126.com',
                'photo' => 'http://localhoost/user/xiaohong',
            ),
        );

        $result = M('users')
            ->addAll($user);

        if ($result) {
            echo 'success';
        }
    }

    /**
     * 增加用户token
     */
    public function addToken()
    {
        $token = array(
            0 => array(
                'access_token' => 'iamgod',
                'session_id' => '1',
                'expire_time' => time() + 86400,
            ),
            1 => array(
                'access_token' => 'iamming',
                'session_id' => '2',
                'expire_time' => time() + 86400,
            ),
            2 => array(
                'access_token' => 'iamhong',
                'session_id' => '2',
                'expire_time' => time() + 86400,
            ),
        );
        M('oauth_access_tokens')
            ->where('1=1')
            ->delete();
        $result = M('oauth_access_tokens')
            ->addAll($token);

        if ($result) {
            echo 'success';
        }
    }

    /**
     * 增加权限
     */
    public function addScopes()
    {
        $scopes = array(
            0 => array(
                'access_token' => 'iamgod',
                'scope' => 'basic',
            ),
            1 => array(
                'access_token' => 'iamgod',
                'scope' => 'email',
            ),
            2 => array(
                'access_token' => 'iamgod',
                'scope' => 'photo',
            ),
            3 => array(
                'access_token' => 'iamming',
                'scope' => 'email',
            ),
            4 => array(
                'access_token' => 'iamhong',
                'scope' => 'photo',
            ),
        );

        $result = M('oauth_access_token_scopes')
            ->addAll($scopes);

        if ($result) {
            echo 'success';
        }
    }

    /**
     * 保存client
     */
    public function saveClient()
    {
        $data = [
            'id' => I('post.id'),
            'secret' => I('post.secret'),
            'name' => I('post.name'),
        ];

        $result = M('oauth_clients')
            ->add($data);

        if (!$result) {
            echo 'error';
        }
        echo 'success';
    }

    /**
     * 增加client
     */
    public function addClient()
    {
        echo '
		<form method="post" action="/home/index/saveclient">
			<input type="text" name="id" placeholder="id">
			<input type="text" name="secret" placeholder="secret">
			<input type="text" name="name" placeholder="name">
			<input type="submit" value="submit">
		</form>
		';
        echo '<hr>';
        $id = 'client' . rand(10000, 99999);
        $secret = 'secret' . rand(10000, 99999);
        $name = $id;
        echo '
		<form method="post" action="/home/index/saveclient">
			<input type="text" name="id" value="' . $id . '">
			<input type="text" name="secret" value="' . $secret . '">
			<input type="text" name="name" value="' . $name . '">
			<input type="submit" value="submit">
		</form>
		';
    }

    /**
     * 保存redirect_uri
     */
    public function saveRedirect()
    {
        $where = ['client_id' => I('post.client_id')];
        $data = ['redirect_uri' => I('post.redirect_uri')];

        $result = M('oauth_client_redirect_uris')
            ->where($where)
            ->save($data);

        if (!$result) {
            echo 'error';
        }
        echo 'success';
    }

    /**
     * 增加redirect_uri
     */
    public function addRedirect()
    {
        echo '
		<form method="post" action="/home/index/saveredirect">
			<input type="text" name="client_id" placeholder="id">
			<input type="text" name="redirect_uri" placeholder="name">
			<input type="submit" value="submit">
		</form>
		';
        echo '<hr>';
        $resultClient = M('oauth_clients')
            ->field('id')
            ->select();
        $str = '';
        foreach($resultClient as $k=>$v)
        {
            $str .= '<option value ="'.$v['id'].'">'.$v['id'].'</option>';
        }
        $redirect_uri = 'http://redirect' . rand(10000, 99999);
        echo '
		<form method="post" action="/home/index/saveredirect">
			<select name="client_id">
			'.$str.'
			</select>
			<input type="text" name="redirect_uri" value="' . $redirect_uri . '">
			<input type="submit" value="submit">
		</form>
		';
    }

    public function test()
    {
        echo '<form method="post" action="http://localhost/home/api"><input type="text" name="access_token" value="iamgod"><input type="text" name="secret" value="secret"><input type="submit" value="submit"></form>';
    }


}