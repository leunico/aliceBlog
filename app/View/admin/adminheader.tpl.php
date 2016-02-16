<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Admin | Strass</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin panel developed with the Bootstrap from Twitter.">
    <meta name="author" content="travis">

    <link href="<?php echo CSS_DIR?>bootstrap-admin.min.css" rel="stylesheet">
	<link href="<?php echo CSS_DIR?>site.css" rel="stylesheet">
    <link href="<?php echo CSS_DIR?>bootstrap-responsive.css" rel="stylesheet">
    <script src="<?php echo JS_DIR?>jquery.min.js"></script>
    <script src="<?php echo JS_DIR?>mysite.js"></script>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/" target="_blank">Alice Blog管理后台</a>
          <div class="btn-group pull-right">
            <a class="btn" href="<?php echo Route('admin/article_my'); ?>"><!--<i class="icon-user"></i>--> <?php echo Auth('username') ?></a>
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo Route('admin/user_edit');?>"><i class="icon-user" style="margin-top:3px;"></i> 修改信息</a></li>
              <li class="divider"></li>
              <li><a href="<?php echo Route('admin/article_add'); ?>"><i class="icon-edit" style="margin-top:3px;"></i> 发表文章</a></li>
              <li class="divider"></li>
              <li><a href="<?php echo Route('admin/loginout');?>"><i class="icon-off" style="margin-top:3px;"></i> 退出</a></li>
            </ul>
          </div>
          <div class="nav-collapse">
            <ul class="nav">
			<li><a href="<?php echo Route('admin'); ?>">首页介绍</a></li>
              <li class="dropdown"><a href="<?php echo Route('admin/articles'); ?>" class="dropdown-toggle" data-toggle="dropdown">文章管理 <b class="caret"></b></a>
				<ul class="dropdown-menu">
                    <li><a href="<?php echo Route('admin/article_my'); ?>">我的文章</a></li>
					<li class="divider"></li>
                    <li><a href="<?php echo Route('admin/articles'); ?>">文章列表</a></li>
					<li class="divider"></li>
                    <li><a href="<?php echo Route('admin/article_add'); ?>">新建文章</a></li>
				</ul>
			  </li>
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">管理用户 <b class="caret"></b></a>
				<ul class="dropdown-menu">
                    <li><a href="<?php echo Route('admin/user_add'); ?>">新建用户</a></li>
					<li class="divider"></li>
                    <li><a href="<?php echo Route('admin/users'); ?>">用户列表</a></li>
				</ul>
			  </li>
              <!--<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">缓存更新 <b class="caret"></b></a>
				<ul class="dropdown-menu">
                    <li><a href="">前台缓存更新</a></li>
					<li class="divider"></li>
                    <li><a href="">后台缓存更新</a></li>
				</ul>
			  </li>-->
              <li><a href="<?php echo Route('admin/comments');?>">评论管理</a></li>
              <li><a href="<?php echo Route('admin/tags');?>">标签管理</a></li> 
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">其它管理 <b class="caret"></b></a>
				<ul class="dropdown-menu">
                    <li><a href="<?php echo Route('admin/pushs'); ?>">首页Push</a></li>
					<li class="divider"></li>
                    <li><a href="<?php echo Route('admin/timewaits'); ?>">时光旅行</a></li>
				</ul>
			  </li>
              <li><a href="<?php echo Route('admin/mem_updata');?>">更新缓存</a></li>
              <li><a href="<?php echo Route('admin/go_baidu');?>">百度主动推送</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row-fluid">