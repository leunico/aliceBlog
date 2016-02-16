<!DOCTYPE html>
<html lang="zh-CN" prefix="og: http://ogp.me/ns#">
    <head>
        <title>登录 | AliceBlog</title>
        <meta charset="utf-8" />
        <meta content="initial-scale=1.0,maximum-scale=1.0,width=device-width" name="viewport" />
        <link href="<?php echo HTTP_ROOT; ?>admin/login" rel="canoical" />
        <meta name="HandheldFriendly" content="True" />
        <!--<link href="http://7mnpep.com2.z0.glb.qiniucdn.com/assets/application-f9dfa86dc49a0bdcb5a90211d7828879.css" media="all" rel="stylesheet" />-->
        <link href="<?php echo CSS_DIR; ?>login.css" media="all" rel="stylesheet" />
        <link rel="shortcut icon" href="<?php echo IMAGE_DIR; ?>favicon.ico"> 
        <!--[if lte IE 9]>
        <link href="http://7mnpep.com2.z0.glb.qiniucdn.com/assets/application_split2-f9dfa86dc49a0bdcb5a90211d7828879.css" media="all" rel="stylesheet" />
        <![endif]-->
        <!--[if lt IE 9]><script src="http://7mnpep.com2.z0.glb.qiniucdn.com/assets/html5-19b1381eac228d0e4d8a0a1da8a84f6a.js"></script><![endif]-->             
    </head>         
<body class="sessions sessions_new"> 
        <div class="topbar-mask" id="topbar-mask"></div>
        <div id="content">
            <div id="login_container">            
                <div class="main impowerBox">
                    <div class="loginPanel normalPanel">
                        <div class="title">微信登录</div>
                        <div class="waiting panelContent">
                            <div class="wrp_code"><img class="qrcode lightBorder" src="<?php echo $wximage; ?>"></div>
                            <div class="info">
                                <div class="status status_browser js_status" id="wx_default_tip">
                                    <p>请使用微信扫描二维码登录</p>
                                    <p>本博客使用的是微信测试帐号，仅供学习和交流！</p>
                                </div>
                            </div>
                        </div>
                    </div>
		        </div>
            </div>
            <div id="sign_form_container">
                <div id="normal_login_container">
                    <nav id="sign_nav">
                        <div class="on" id="sign_in_nav"><img style="width:140px;height:35px;" src="<?php echo IMAGE_DIR; ?>navred.png">                        </div>
                    </nav>
                    <form action="<?php echo Route('admin/logingo');?>" class="form" id="sign_in" method="post">
                        <img style="border-radius: 50%;" alt="" id="avatar_preview" src="<?php echo IMAGE_DIR; ?>toux.jpg">
                        <div class="field input_field">
                            <label><i class="fa fa-user" for="sign_in_username"></i>
                                <input class="input" data-validate="required email" id="sign_in_username" name="email" placeholder="你的邮箱" type="text" />                               
                            </label>
                        </div>
                        <div class="field input_field no-sign">
                            <label><i class="fa fa-key" for="sign_in_password"></i>
                                <input class="input" data-validate="required" id="sign_in_password" name="password" placeholder="密码" type="password" />
                            </label>
                        </div>
                        <!--<div class="field input_field captcha-box unnecessary">
                            <label><i class="fa fa-exclamation" for="sign_in_captcha"></i>
                                <input class="input" id="sign_in_captcha" maxlength="4" name="captcha" placeholder="验证码" size="4" type="text" />
                                <img alt="验证码" class="captcha" />
                            </label>
                        </div>-->
                        <div class="field checkbox_field">
                            <input checked="checked" name="remember_me" type="checkbox" value="true" /><span>保持登录状态</span>
                            <!--<a href="javascript:;" id="forget_password">找回密码</a>-->
                        </div>
                        <div class="field msg msg_error"></div>
                        <div class="field msg msg_success"></div>
                        <div class="field">
                            <input class="gp_confirm" id="sign_in_btn" type="submit" name="dosubmit" value="登录" />
                        </div>                                   
                    </form>
                </div>
                
                <h2 id="sign_title">微信扫一扫登录/注册</h2>
                <ul id="social_login">
                    <li><a class="fa fa-home" href="/" id="index_go" title="返回首页"></a></li>
                    <li><a class="fa fa-weibo" data-type="social_login" href="javascript:;" id="social_login_weibo"></a></li>
                    <li><a class="fa fa-weixin" href="javascript:;" id="show_wechat_login"></a></li>
                </ul>
            </div>
            <section class="done mid-box"><i class="fa fa-check-circle ok"></i><h2></h2><p></p></section>
        </div>
        <div id="bg"></div>
        <div class="clear" id="footer"></div>
<script> var scene_id = '<?php echo $scene_id; ?>';</script>    
<script src="<?php echo JS_DIR; ?>jquery.min.js"></script>
<script src="<?php echo JS_DIR; ?>login.js"></script>
</body>
</html>