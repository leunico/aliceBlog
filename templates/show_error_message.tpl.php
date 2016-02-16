<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!--[if IE 8]><style>.ie8 .alert-circle,.ie8 .alert-footer{display:none}.ie8 .alert-box{padding-top:75px}.ie8 .alert-sec-text{top:45px}</style><![endif]-->
<title><?php echo isset($seo_title) ? $seo_title : SEO_TITLE; ?> - <?php echo WEB_NAME;?></title>
<style>
body{margin:0;padding:0;background:#e6eaeb;font-family:Arial,'微软雅黑',sans-serif}
.alert-box{position:relative;display:none;margin:6pc auto 0;padding:180px 85px 22px;width:286px;border-radius:10px 10px 0 0;background:#fff;box-shadow:5px 9px 17px hsla(0,0%,40%,.75);color:#fff;text-align:center}
.alert-box p{margin:0}
.alert-circle{position:absolute;top:-50px;left:111px}
.alert-sec-circle{transition:stroke-dashoffset 1s linear;stroke-dashoffset:0;stroke-dasharray:735}
.alert-sec-text{position:absolute;top:11px;left:190px;width:76px;color:#000;font-size:68px}
.alert-sec-unit{text-align:center;font-size:34px}
.alert-body{margin:35px 0}
.alert-head{color:#242424;font-size:28px}
.alert-concent{margin:25px 0 14px;color:#7b7b7b;font-size:18px}
.alert-concent p{line-height:27px}
.alert-btn{display:block;width:286px;height:38px;background-color:#4ab0f7;color:#fff;text-decoration:none;letter-spacing:2px;font-size:20px;line-height:38px}
.alert-btn:hover{background-color:#6bc2ff}
.alert-footer{margin:0 auto;width:90pt;height:42px}
.alert-footer-icon{float:left}
.alert-footer-text{float:left;padding:3px 0 0 5px;height:40px;border-left:2px solid #eee;color:#0b85cc;text-align:left;font-size:9pt}
.alert-footer-text p{color:#7a7a7a;font-size:22px;line-height:18px}
</style>
</head>
<body class="ie8">
<div id="js-alert-box" class="alert-box">
	<svg class="alert-circle" width="234" height="234">
		<circle cx="117" cy="117" r="108" fill="#FFF" stroke="#43AEFA" stroke-width="17"></circle>
		<circle id="js-sec-circle" class="alert-sec-circle" cx="117" cy="117" r="108" fill="transparent" stroke="#F4F1F1" stroke-width="18" transform="rotate(-90 117 117)"></circle>
		<text class="alert-sec-unit" x="70" y="172" fill="#BDBDBD">秒跳转</text>
	</svg>
	<div id="js-sec-text" class="alert-sec-text"></div>
	<div class="alert-body">
		<!--<div id="js-alert-head" class="alert-head"></div>-->
		<div class="alert-concent">
            <p style="color:#D13C3C;"><?php echo $msg?></p>
		</div>
        <?php if (empty($jumpurl) ||  $jumpurl==''){?>
            <a id="js-alert-btn" class="alert-btn" href="<?php $url = get_referer_url(); echo Request::getRefererUrl();?>">点击立即跳转页面</a>
        <?php }else if ($jumpurl=='goback' ){ $url = "javascript:history.back();";?>
            <a id="js-alert-btn" class="alert-btn" href="javascript:history.back();">点击立即跳转页面</a>
        <?php } elseif ($jumpurl=="close") { ?>
            <a id="js-alert-btn" class="alert-btn" href="javascript:viod(0);" onclick="window.close();">点击关闭页面</a>
        <?php } elseif ($jumpurl) { ?>
            <a id="js-alert-btn" class="alert-btn" href="<?php $url = HTTP_ROOT.$jumpurl; echo HTTP_ROOT.$jumpurl ?>">点击立即跳转页面</a>
        <?php } ?>
	</div>
</div>
<script type="text/javascript">
function alertSet(url) {
    document.getElementById("js-alert-box").style.display = "block";
    //document.getElementById("js-alert-head").innerHTML = e;
    var t = <?php echo $ms;?>,
    n = document.getElementById("js-sec-circle");
    document.getElementById("js-sec-text").innerHTML = t,
    setInterval(function() {
        if (0 == t){
            location.href=url;
		}else {
            t -= 1,
            document.getElementById("js-sec-text").innerHTML = t;
            var e = Math.round(t / 10 * 735);
            n.style.strokeDashoffset = e - 735
        }
    },
    970);
}
</script>
<script>alertSet("<?php echo $url; ?>");</script> 
</body>
</html>