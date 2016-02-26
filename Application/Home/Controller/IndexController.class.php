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
	 * 默认首页
     */
	public function index()
	{
  		header('Content-type:text/html;charset=utf-8');
  		echo '<a href="/home/index/addToken">增加access_token</a>'.'<br>';
  		echo '<a href="/home/index/test">测试表单到api</a>'.'<br>';
  		echo '<a href="/home/api/tokeninfo?access_token=iamming">获取令牌信息</a>'.'<br>';
  		echo '<a href="/home/api/users?access_token=iamming">获取所有用户信息</a>'.'<br>';
  		echo '<a href="/home/api/users/xiaoming?access_token=iamming">获取指定用户信息</a>'.'<br>';
  		echo '<hr>';
  		echo '<a href="/home/authcode/authorize?client_id=client&redirect_uri=http%3a%2f%2flocalhost%2fredirect&response_type=code">请求验证码</a>'.'<br>';
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
			0=>array(
				'username'  =>  'xiaoming',
				'password'  =>  password_hash('xiaoming', PASSWORD_DEFAULT),
				'name'      =>  'xiaoming',
				'email'     =>  'xiaoming@126.com',
				'photo'     =>  'http://localhoost/user/xiaoming',
			),
			1=>array(
				'username'  =>  'xiaohong',
				'password'  =>  password_hash('xiaohong', PASSWORD_DEFAULT),
				'name'      =>  'xiaoming',
				'email'     =>  'xiaohong@126.com',
				'photo'     =>  'http://localhoost/user/xiaohong',
			),
		);

		$result = M('users')
			->addAll($user);

		if ($result)
		{
			echo 'success';
		}
	}

	/**
	 * 增加用户token
     */
	public function addToken()
	{
		$token = array(
			0=>array(
				'access_token'  =>  'iamgod',
				'session_id'    =>  '1',
				'expire_time'   =>  time() + 86400,
			),
			1=>array(
				'access_token'  =>  'iamming',
				'session_id'    =>  '2',
				'expire_time'   =>  time() + 86400,
			),
			2=>array(
				'access_token'  =>  'iamhong',
				'session_id'    =>  '2',
				'expire_time'   =>  time() + 86400,
			),
		);
		M('oauth_access_tokens')
			->where('1=1')
			->delete();
		$result = M('oauth_access_tokens')
			->addAll($token);

		if ($result)
		{
			echo 'success';
		}
	}

	/**
	 * 增加权限
     */
	public function addScopes()
	{
		$scopes = array(
			0=>array(
				'access_token'  =>  'iamgod',
				'scope'         =>  'basic',
			),
			1=>array(
				'access_token'  =>  'iamgod',
				'scope'         =>  'email',
			),
			2=>array(
				'access_token'  =>  'iamgod',
				'scope'         =>  'photo',
			),
			3=>array(
				'access_token'  =>  'iamming',
				'scope'         =>  'email',
			),
			4=>array(
				'access_token'  =>  'iamhong',
				'scope'         =>  'photo',
			),
		);

		$result = M('oauth_access_token_scopes')
			->addAll($scopes);

		if ($result)
		{
			echo 'success';
		}
	}
	
	public function test()
	{
		echo '<form method="post" action="http://localhost/home/api"><input type="text" name="access_token" value="iamgod"><input type="text" name="secret" value="secret"><input type="submit" value="submit"></form>';
	}


}