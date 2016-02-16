<?php

/*  
 *  框架核心配置文件
 *  @leunico 
 */

#>>主配置<<#
define('WEB_NAME', 'Alice Blog'); //网站名称

define('PROJECT_NAME', 'AliceBlog');

define('SEO_TITLE', 'Alice博客-PHP和前端分享');  //网站Title

define('SEO_KEYWORDS', '博客,PHP,前端,分享');    //网站关键字

define('SEO_DESCRIPTION', '分享生活，分享技术，Leunico的原创PHP博客');  //网站简介

define('HTTP_ROOT', 'http://www.lzxya.com/'); //访问域名

define('ROOT_PATH', '/home/wwwroot/htdocs'); //网站绝对路径

define('CONFIG_PATH', ROOT_PATH . '/config/'); //配置文件路径 

define('STATIC_PATH', HTTP_ROOT . 'public/'); //主题目录

define('CSS_DIR', STATIC_PATH . 'css/');

define('JS_DIR', STATIC_PATH . 'js/');

define('IMAGE_DIR', STATIC_PATH . 'img/');

define('SWF_DIR', STATIC_PATH . 'font/');

define('PLUG_DIR', STATIC_PATH . 'plug/'); //插件目录

define('IMG_DEFAULT', IMAGE_DIR . 'default.jpg');

define('IMG_TXING', IMAGE_DIR . 'ty.jpg');

#>>插件配置<<
define('BAIDU_SITE_API', 'http://data.zz.baidu.com/urls?site=520.leunico.sinaapp.com&token=FmPt3beiE9VEhM9b&type=original'); //百度推送api

define('ADMIN_QINIU_DIR', ROOT_PATH . '/public/plug/qiniu/'); //七牛云SDK路径

define('ADMIN_JINSHAN_DIR', ROOT_PATH . '/public/plug/ks/'); //金山云SDK路径 PS.暂时只会用金山云

define('QINIU_DIR_THUMB', '?imageView2/2/w/210/h/140/format/jpg/interlace/0/q/100'); //七牛云图片链接后缀

define('JINSHAN_DIR_THUMB', '@base@tag=imgScale&q=85&w='); //金山云图片链接后缀

define('ADMIN_UEDITOR_DIR', PLUG_DIR . 'ueditor_k/'); //百度UEDITOR富文本编辑器ueditor_k是金山云，ueditor是七牛云

#>>项目配置<<
define('COOKIE_DOMAIN', ''); //cookie 作用域

define('COOKIE_PRE', PROJECT_NAME . '_'); //cookie前缀

define('COOKIE_PATH', '/home/wwwroot/cookie'); //cookie作用路径

define('SESSION_PRE', PROJECT_NAME . '_'); //session前缀

define('TOKEN', 'weixin'); //微信的

define('EMAIL_SENT_FOR_REPLY', TRUE); //邮箱服务配置,TRUE是开启

define('EMAIL_ADDRESS', '13826914162@163.com');

define('EMAIL_PASSWORD', 'lzx013632350976');

define('EMAIL_SMTP', 'smtp.163.com');

define('TIMEZONE', 'Etc/GMT-8'); //时区设置

define('DEFAULT_APP_NAME', 'app'); //默认加载的项目

define('TEMPLATE_PATH', ROOT_PATH . '/'.DEFAULT_APP_NAME.'/View'); //模版路径

define('DEFAULT_CONTROLLER', 'index'); //默认加载的控制器

define('DEFAULT_METHOD', 'index'); //默认加载的方法

define('DEBUG', 1); //启用调试信息，1是开启

define('SQLDEBUG', FALSE); //启用数据库调试信息，true是开启

#>>MEMCACHE缓存配置<<#
define('MEMCACHE', TRUE); //是否开启缓存，TRUE是开启

define('MEMCACHE_HOST', '112.74.92.88');

define('MEMCACHE_PORT', 11211);

define('MEMCACHE_EXPIRATION', 6*3600);

define('MEMCACHE_PREFIX', 'Alice');

define('MEMCACHE_COMPRESSION', FALSE);

#>>数据库默认配置<<#
define('DB_TYPE', 'mysql');

define('DB_HOST', 'localhost');

define('DB_PORT', '3306');

define('DB_USERNAME', 'root');

define('DB_PASSWORD', 'admin');

define('DB_NAME', 'alice');
