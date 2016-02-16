var setIntervalFun = null; 
function setweixin(){
    setIntervalFun = setInterval(function(){
        $.post("http://www.lzxya.com/admin/wxlogin",{scene_id: scene_id},function(data){
            if(data == 'sucess'){
                $('#wx_default_tip').children().first().css('color','#27ae60').text('扫描成功，请等待跳转！');
                setTimeout(function(){location.href="http://www.lzxya.com/admin/wxindex";},1500);
                clearInterval(setIntervalFun); //如果没跳转先停止遍历
            }//else{$('#wx_default_tip').children().first().css('color','#19a7f0').text('失败！请刷新或联系站长。');}                
        });
        
    },2000);
}
$(document).ready(function(){
    setTimeout(function(){
        if(setIntervalFun != null){ 
            clearInterval(setIntervalFun)
            $('#wx_default_tip').children().first().css('color','#19a7f0').text('超过1分钟已失效，请刷新！');
        }       
    },60000);
});
$('#index_go').mouseover(function(){$(this).css('background-color','#606FBA');})
$('#index_go').mouseout(function(){$(this).css('background-color','#b5b5b5');})
$("#show_wechat_login").on("click", function(e) {
		e.preventDefault(), $("#normal_login_container").toggle(300), $("#login_container").toggle(300)
});
$("#social_login_weibo").on("click",function(){alert('sorry，未开放微博登录注册！');})
$("#clearl").on("click",function(){
    if($(this).parent().next()){$(this).parent().next().remove();}
     $(this).prev().val('').focus();
     $(this).remove(); 
});
$(function(){    
    var ok1=false;
    var ok2=false;  
    // 验证用户名
	var pattern = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
    $('#sign_in_username').focus(function(){
        //$(this).next().text('用户名应该为3-20位之间').removeClass('state1').addClass('state2');
    }).blur(function(){
        if(pattern.test($(this).val())){
            if($(this).next()){$(this).next().remove();}
            if($(this).parent().next()){$(this).parent().next().remove();}            
            $(this).after('<i class="fa fa-check status"></i>');
            ok1=true;
            if(ok1 && ok2){$('#sign_in_btn').css("background-color","#34b3db").removeAttr("disabled");}
        }else{
            if($(this).next()){$(this).next().remove();}  
            if($(this).parent().next()){$(this).parent().next().remove();}
            $('#sign_in_btn').css("background-color","#ccc").attr("disabled", "disabled"); ;
            $(this).after('<i class="fa fa-times-circle status" id="clearl"></i>');
            $(this).parent().after('<div class="inline-msg-box error">\u8bf7\u8f93\u5165\u6b63\u786e\u7684\u90ae\u7bb1\u683c\u5f0f\uff01</div>');
        }
        
    });    
    //验证密码
    $('#sign_in_password').focus(function(){
        //$(this).next().text('密码应该为6-20位之间').removeClass('state1').addClass('state2');
    }).blur(function(){
        if($(this).val().length >= 6 && $(this).val().length <=20 && $(this).val()!=''){
            if($(this).next()){$(this).next().remove();}
            if($(this).parent().next()){$(this).parent().next().remove();}
            $(this).after('<i class="fa fa-check status"></i>');
            ok2=true;
            if(ok1 && ok2){$('#sign_in_btn').css("background-color","#34b3db").removeAttr("disabled");}
        }else{
            if($(this).next()){$(this).next().remove();}  
            if($(this).parent().next()){$(this).parent().next().remove();}
            $('#sign_in_btn').css("background-color","#ccc").attr("disabled", "disabled"); ;
            $(this).after('<i class="fa fa-times-circle status" onclick="clear(this)"></i>');
            $(this).parent().after('<div class="inline-msg-box error">\u5bc6\u7801\u5e94\u8be5\u4e3a\u0036\u002d\u0032\u0030\u4f4d\u4e4b\u95f4</div>');
        }
        
    });     
    setweixin();
    //clearIntervalFun()
});