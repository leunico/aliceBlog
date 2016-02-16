<?php

/*  
 *  框架唯一入口文件
 *  @leunico 
 */

//引入框架核心文件
require_once 'AliceFrameWork/App.php';

//初始化框架
$obj = new AliceFrameWork\App();
$obj->init();
