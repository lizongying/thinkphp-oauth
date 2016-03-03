## 简介

oAuth2.0在ThinkPHP3.2的应用。

## 安装

推荐使用composer进行安装。<br>
[packagist地址](https://packagist.org/packages/lizongying/thinkphp-oauth) 
<p>
<code>
$ composer require lizongying/thinkphp-oauth dev-master
</code>
</p>

## 使用

本用例数据库使用MySQL5.6.17，如其他版本，注意兼容性。SQL文件位于 <code>./example/db/oauth.sql</code> 。本地数据库导入测试数据或建立相应的表，正式部署时务必删除 <codde>db</code> 文件夹和文件夹内的所有文件。<br>
网站根目录设置为 <code>example</code> 后直接访问 <code>http://localhost/</code> 。
