//用户js表单验证

/*function upperCase(value){ 
     username = document.getElementsByName('username')[0];
     var name = 'sucess';
     var password = 'sucess';
     $.get('http://520.leunico.sinaapp.com/ajax/getUserName',{username:value},function(data){            
            //console.log(username.value);
            name = data;
     });
     
     $.get('http://520.leunico.sinaapp.com/ajax/getPassWord',{username:username.value},function(data){            
           //console.log(username.value);
           password = data;
     });
    check(username,"用户名已经存在了",function(val){
        if(name == 'sucess'){
            return true;
        }else{
            return false;
        }        
    },'click');
}*/

function regs(type){    
    var stat = true;
    var click = 'click';  
    username = document.getElementsByName('username')[0];    
    newpw = document.getElementsByName('newpw')[0];       
    newpw_a = document.getElementsByName('newpw_a')[0];    
    email = document.getElementsByName('email')[0];
    if(type == 'edit'){
        oldpw = document.getElementsByName('oldpw')[0];
    }    
    
    check(username, "用户名的长度在3-20之间", function(val){
        if (val.match(/^\S+$/) && val.length >=3 && val.length <=20){
            return true;
        } else {
            stat = false;
            return false;
        }
    }, click);

    check(newpw, "密码必须在6-10位之间", function(val){
        if(type == 'edit'){
            if (val.length == 0 && oldpw.value== ''&& newpw_a.value== ''){return true;}
        }
        if (val.match(/^\S+$/) && val.length >= 6 && val.length <=10){
            return true;
        } else {
            stat = false;
            return false;
        }
    }, click);
    
    if(type == 'edit'){
    check(oldpw, "请输入正确的登录密码", function(val){
        if (val.length == 0 && newpw.value== ''&& newpw_a.value== ''){return true;}
        if (val.match(/^\S+$/) && val.length >= 6 && val.length <=10){
            return true;
        } else {
            stat = false;
            return false;
        }
    }, click);}
    
   check(newpw_a, "请确定重复密码和上面一致", function(val){
        if(type == 'edit'){
            if (val.length == 0 && newpw.value== ''&& oldpw.value== ''){return true;}
        }
        if (val.match(/^\S+$/) && val.length >=6 && val.length <=20 && val == newpw.value){
            return true;
        } else {
            stat = false;
            return false;
        }

    }, click);

   check(email, "请按邮箱规则输入", function(val){
        if (val.match(/\w+@\w+\.\w/)){
            return true;
        } else {
            stat = false;
            return false;
        }
    }, click);
    return stat;

}

//文章js表单验证
function arts(type){
   var stat = true;
   var click = 'click';
   title = document.getElementsByName('title')[0];
   seo_title = document.getElementsByName('seo_title')[0];
   seo_description = document.getElementsByName('seo_description')[0];
   seo_keywords = document.getElementsByName('seo_keywords')[0];
   tag = document.getElementsByName('tag')[0];
   description = $('#description')[0];//document.getElementById('description')[0];

   check(title, "标题的长度在10-35字之间", function(val){
        if (val.match(/^\S+$/) && val.length >=10 && val.length <=35){
            return true;
        } else {
            stat = false;
            return false;
        }
   }, click);
    
   check(seo_title, "SEO标题的长度在2-16字之间", function(val){
        if (val.match(/^\S+$/) && val.length >=2 && val.length <=16){
            return true;
        } else {
            stat = false;
            return false;
        }
   }, click);
    
   check(seo_description, "SEO描述的长度在0-100字之间", function(val){
        if(val == '')return true;
        if (val.match(/^\S+$/) && val.length >=0 && val.length <=100){
            return true;
        } else {
            stat = false;
            return false;
        }
   }, click);
    
   check(seo_keywords, "SEO关键字的长度在0-8字之间", function(val){
        if(val == '')return true;
        if (val.match(/^\S+$/) && val.length >=0 && val.length <=8){
            return true;
        } else {
            stat = false;
            return false;
        }
   }, click);
    
   check(tag, "标签的长度在2-10字之间", function(val){
        if (val.match(/^\S+$/) && val.length >=2 && val.length <=10){
            return true;
        } else {
            stat = false;
            return false;
        }
   }, click);
    
   check(description, "描述的长度在60-160字之间", function(val){
        if (val.match(/^\S+$/) && val.length >=60 && val.length <=160){
            return true;
        } else {
            stat = false;
            return false;
        }
   }, click);
   return stat; 
        
}

function gspan(cobj){//获取表单后的span 标签 显示提示信息
    if (cobj.nextSibling.nodeName != 'SPAN'){
        gspan(cobj.nextSibling);
    } else {
        return cobj.nextSibling;
    }
}

//检查表单 obj【表单对象】， info【提示信息】 fun【处理函数】  click 【是否需要单击， 提交时候需要触发】
function check(obj, info, fun, click){
    var sp = gspan(obj);//console.log(sp);
    obj.onfocus = function(){ //提示
        sp.innerHTML = "<i class='icon-exclamation-sign' style=\"margin-top:3px;\"></i> "+info;
        sp.style.color = "black";
    } 

    obj.onblur = function(){
        if (fun(this.value)){ //成功
            sp.innerHTML = "<i class='icon-ok' style=\"margin-top:3px;\"></i>";
            sp.style.color = "green";
        } else {  //错误
            sp.innerHTML = "<i class='icon-remove' style=\"margin-top:3px;\"></i> "+info;
            sp.style.color = "#ef392b";
        }

    }
    if (click == 'click'){
        obj.onblur();
    }

}

/*=================================================*/

function setImagePreview(id) {
    var docObj=document.getElementById("doc-"+id);
    var imgObjPreview=document.getElementById("preview-"+id);//console.log(imgObjPreview);
    if(docObj.files && docObj.files[0]){
        //火狐下，直接设img属性
        imgObjPreview.style.display = 'block';
        imgObjPreview.style.width = '240px';
        imgObjPreview.style.height = '96px';                    
        //imgObjPreview.src = docObj.files[0].getAsDataURL();
        
        //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式  
        imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
        
    }else{
        //IE下，使用滤镜
        docObj.select();
        var imgSrc = document.selection.createRange().text;
        var localImagId = document.getElementById("localImag-"+id);
        //必须设置初始大小
        localImagId.style.width = "240px";
        localImagId.style.height = "96px";
        //图片异常的捕捉，防止用户修改后缀来伪造图片
        try{
            localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
            localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
        }catch(e){
            alert("您上传的图片格式不正确，请重新选择!");
            return false;
        }
        imgObjPreview.style.display = 'none';
        document.selection.empty();
    }
    return true;
}
function setImageToux(w,h) {
    var docObj=document.getElementById("toux");
    var imgObjPreview=document.getElementById("preview");//console.log(imgObjPreview);
    if(docObj.files && docObj.files[0]){
        imgObjPreview.style.display = 'block';
        imgObjPreview.style.width = w+"px";
        imgObjPreview.style.height = h+"px";                    
        imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);        
    }else{
        docObj.select();
        var imgSrc = document.selection.createRange().text;
        var localImagId = document.getElementById("localImag");
        localImagId.style.width = w+"px";
        localImagId.style.height = h+"px";
        try{
            localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
            localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
        }catch(e){
            alert("您上传的图片格式不正确，请重新选择!");
            return false;
        }
        imgObjPreview.style.display = 'none';
        document.selection.empty();
    }
    return true;
}
function order(id,type){    
    $.get('http://www.lzxya.com/admin/setorder',{id:id,type:type},function(data){            
        if(data == "error"){
            alert("没有权限啊~");
        }else{
            $('#order-'+id).html(data);
        }  
    });   
    
}


















