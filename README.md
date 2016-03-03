## 简介

oAuth2.0在ThinkPHP3.2的应用。

## 安装

推荐使用composer进行安装。

<p>
<code>
$ composer require lizongying/thinkphp-oauth dev-master
</code>
</p>
[packagist地址](https://packagist.org/packages/lizongying/thinkphp-oauth) 

## 使用

本用例数据库使用MySQL5.6.17，如其他版本，注意兼容性。SQL文件位于 <code>./example/db/oauth.sql</code> 。本地数据库导入测试数据或建立相应的表，正式部署时务必删除 <code>db</code> 文件夹和文件夹内的所有文件。<br>
网站根目录设置为 <code>example</code> 后直接访问 <code>http://localhost/</code> 。

## 感谢

<code>./example/ThinkPHP/Library/</code> 中增加了 <code>FastRoute</code> 、 <code>League</code> 、 <code>Orno</code> 、 <code>Symfony</code><br>
感谢以上代码奉献者！
