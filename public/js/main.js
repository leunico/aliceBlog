if( !window.console ){
    window.console = {
        log: function(){}
    }
}
var star=false;
function searcha(){    
    if($("#asearch").val() == '' || $("#asearch").val().length >20){
        if(!star){
           $("#asearch").next().after('<span style="margin-left:10px;color:#BF2F2F;font-size:16px"><i class="fa fa-times"></i>不能为空或过长！</span>');
           star = true; 
        }
        return false;        
    }else{
        return true;   
    }
}
/* 
 * jsui
 * ====================================================
*/
jsui.bd = $('body')
jsui.cont = $('section')
jsui.is_signin = jsui.bd.hasClass('logged-in') ? true : false;

if( $('.widget-nav').length ){
    $('.widget-nav li').each(function(e){
        $(this).hover(function(){
            $(this).addClass('active').siblings().removeClass('active')
            $('.widget-navcontent .item:eq('+e+')').addClass('active').siblings().removeClass('active')
        })
    })
}
if( $('.sns-wechat').length ){
    $('.sns-wechat').on('click', function(){
        var _this = $(this)
        if( !$('#modal-wechat').length ){
            $('body').append('\
                <div class="modal fade" id="modal-wechat" tabindex="-1" role="dialog" aria-hidden="true">\
                    <div class="modal-dialog" style="margin-top:200px;width:340px;">\
                        <div class="modal-content">\
                            <div class="modal-header">\
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                <h4 class="modal-title">'+ _this.attr('title') +'</h4>\
                            </div>\
                            <div class="modal-body" style="text-align:center">\
                                <img style="max-width:100%" src="'+ _this.data('src') +'">\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            ')
        }
        $('#modal-wechat').modal()
    })
}
    $('.qq-group').on('click', function(){
        var _this = $(this)
        if( !$('#modal-qq-group').length ){
            $('body').append('\
                <div class="modal fade" id="modal-qq-group" tabindex="-1" role="dialog" aria-hidden="true">\
                    <div class="modal-dialog" style="margin-top:200px;width:340px;">\
                        <div class="modal-content">\
                            <div class="modal-header">\
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                <h4 class="modal-title">'+ _this.attr('title') +'</h4>\
                            </div>\
                            <div class="modal-body" style="text-align:center">\
                                <img src="http://www.lzxya.com/public/img/toux.jpg" style="margin:25px 0">\
								<h3 style="color:#dd5862;font-size:18px;">QQ：867426952</h3>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            ')
        }
        $('#modal-qq-group').modal()
    })
if( Number(jsui.ajaxpager) > 0 && ($('.excerpt').length || $('.excerpt-minic').length) ){
    require(['ias'], function() {
        if( !jsui.bd.hasClass('site-minicat') && $('.excerpt').length ){
            $.ias({
                triggerPageThreshold: jsui.ajaxpager?Number(jsui.ajaxpager)+1:5,
                history: false,
                container : '.content',
                item: '.excerpt',
                pagination: '.pagination',
                next: '.next-page a',
                loader: '<div class="pagination-loading"><img src="'+jsui.uri+'/img/loading.gif"></div>',
                trigger: 'More',
                onRenderComplete: function() {
                    require(['lazyload'], function() {
                        $('.excerpt .thumb').lazyload({
                            data_attribute: 'src',
                            placeholder: jsui.uri + '/img/thumbnail.png',
                            threshold: 200
                        });
                    });
                }
            });
        }

        if( jsui.bd.hasClass('site-minicat') && $('.excerpt-minic').length ){
            $.ias({
                triggerPageThreshold: jsui.ajaxpager?Number(jsui.ajaxpager)+1:5,
                history: false,
                container : '.content',
                item: '.excerpt-minic',
                pagination: '.pagination',
                next: '.next-page a',
                loader: '<div class="pagination-loading"><img src="'+jsui.uri+'/img/loading.gif"></div>',
                trigger: 'More',
                onRenderComplete: function() {
                    require(['lazyload'], function() {
                        $('.excerpt .thumb').lazyload({
                            data_attribute: 'src',
                            placeholder: jsui.uri + '/img/thumbnail.png',
                            threshold: 200
                        });
                    });
                }
            });
        }
    });
}
if( $('.article-content').length ) $('.article-content a').tooltip({container: 'body'});

$('.content a').tooltip({container: 'body'});
$('.sidebar a').tooltip({container: 'body'});
/* 
 * lazyload
 * ====================================================
*/
if ( $('.thumb:first').data('src') || $('.widget_ui_posts .thumb:first').data('src') || $('.wp-smiley:first').data('src') || $('.avatar:first').data('src')) {
    require(['lazyload'], function() {
        $('.avatar').lazyload({
            data_attribute: 'src',
            placeholder: jsui.uri + 'img/avatar-default.png',
            threshold: 200
        })

        $('.thumb').lazyload({
            data_attribute: 'src',
            placeholder: jsui.uri + 'img/thumbnail.png',
            threshold: 200
        })

        $('.widget_ui_posts .thumb').lazyload({
            data_attribute: 'src',
           placeholder: jsui.uri + 'img/thumbnail.png',
           threshold: 200
          })

        $('.wp-smiley').lazyload({
            data_attribute: 'src',
            // placeholder: jsui.uri + '/img/thumbnail.png',
            threshold: 200
        })
    })
}
/* 
 * rollbar
 * ====================================================
*/
//被我关闭了功能 去评论链接
jsui.rb_comment = ''
//if (jsui.bd.hasClass('comment-open')) {
//    jsui.rb_comment = "<li><a href=\"javascript:(scrollTo('#comments',-15));\"><i class=\"fa fa-comments\"></i></a><h6>去评论<i></i></h6></li>"
//}
jsui.cont.append('\
    <div class="m-mask"></div>\
    <div class="rollbar-liao"><div class="rollbar"><ul>'
    +jsui.rb_comment+
    '<li><a href="javascript:(scrollTo());"><i class="fa fa-angle-up"></i></a><h6>去顶部<i></i></h6></li>\
    </ul></div></div>\
')

var scroller = $('.rollbar')
$(window).scroll(function() {
    document.documentElement.scrollTop + document.body.scrollTop > 200 ? scroller.fadeIn() : scroller.fadeOut();
})
/* 
 * bootstrap
 * ====================================================
*/
$('.user-welcome').tooltip({
    container: 'body',
    placement: 'bottom'
})
var _sidebar = $('.sidebar')
if (_sidebar) {
    var h1 = 0,
        h2 = 10
    var rollFirst = _sidebar.find('.widget:eq(' + (jsui.roll[0] - 1) + ')')
    var sheight = rollFirst.height()

    rollFirst.on('affix-top.bs.affix', function() {
        rollFirst.css({
            top: 0
        })
        sheight = rollFirst.height()

        for (var i = 1; i < jsui.roll.length; i++) {
            var item = jsui.roll[i] - 1
            var current = _sidebar.find('.widget:eq(' + item + ')')
            current.removeClass('affix').css({
                top: 0
            })
        };
    })
    rollFirst.on('affix.bs.affix', function() {
        rollFirst.css({
            top: h1
        })

        for (var i = 1; i < jsui.roll.length; i++) {
            var item = jsui.roll[i] - 1
            var current = _sidebar.find('.widget:eq(' + item + ')')
            current.addClass('affix').css({
                top: sheight + h2
            })
            sheight += current.height() + 10
        };
    })
    rollFirst.affix({
        offset: {
            top: _sidebar.height(),
            bottom: $('.footer').outerHeight()
        }
    })
}
$('.plinks a').each(function(){
    var imgSrc = $(this).attr('href')+'/boot/img/favicon.ico'
    $(this).prepend( '<img src="'+imgSrc+'">' )
})
/* 
 * comment
 * ====================================================
*/
if (jsui.bd.hasClass('comment-open')) {
    require(['comment'], function(comment) {
        comment.init()
    })
}
/* 
 * page u
 * ====================================================
*/
if (jsui.bd.hasClass('page-template-pagesuser-php')) {
    require(['user'], function(user) {
        user.init()
    })
}
/* 
 * page theme
 * ====================================================
*/
if (jsui.bd.hasClass('page-template-pagestheme-php')) {
    require(['theme'], function(theme) {
        theme.init()
    })
}
/* 
 * page nav
 * ====================================================
*/
if( jsui.bd.hasClass('page-template-pagesnavs-php') ){

    var titles = ''
    var i = 0
    $('#navs .items h2').each(function(){
        titles += '<li><a href="#'+i+'">'+$(this).text()+'</a></li>'
        i++
    })
    $('#navs nav ul').html( titles )

    $('#navs .items a').attr('target', '_blank')

    $('#navs nav ul').affix({
        offset: {
            top: $('#navs nav ul').offset().top,
            bottom: $('.footer').height() + $('.footer').css('padding-top').split('px')[0]*2
        }
    })
    if( location.hash ){
        var index = location.hash.split('#')[1]
        $('#navs nav li:eq('+index+')').addClass('active')
        $('#navs nav .item:eq('+index+')').addClass('active')
        scrollTo( '#navs .items .item:eq('+index+')' )
    }
    $('#navs nav a').each(function(e){
        $(this).click(function(){
            scrollTo( '#navs .items .item:eq('+$(this).parent().index()+')' )
            $(this).parent().addClass('active').siblings().removeClass('active')
        })
    })
}
/* 
 * page search
 * ====================================================
*/
if( jsui.bd.hasClass('search-results') ){
    var val = $('.site-search-form .search-input').val()
    var reg = eval('/'+val+'/i')
    $('.excerpt h2 a, .excerpt .note').each(function(){
        $(this).html( $(this).text().replace(reg, function(w){ return '<b>'+w+'</b>' }) )
    })
}
/* 
 * search
 * ====================================================
*/
$('.search-show').bind('click', function(){
    $(this).find('.fa').toggleClass('fa-remove')

    jsui.bd.toggleClass('search-on')

    if( jsui.bd.hasClass('search-on') ){
        $('.site-search').find('input').focus()
        jsui.bd.removeClass('m-nav-show')
    }
})
/* 
 * phone
 * ====================================================
*/
$('.m-icon-nav').on('click', function(){
    jsui.bd.toggleClass('m-nav-show')

    if( jsui.bd.hasClass('m-nav-show') ){
        jsui.bd.removeClass('search-on')
        $('.search-show .fa').removeClass('fa-remove')
    }
    
})
$('.m-mask').on('click', function(){
    jsui.bd.removeClass('m-nav-show')
})
/* 
 * baidushare
 * ====================================================
*/
if( $('.bdsharebuttonbox').length ){

    if ($('.article-content').length) $('.article-content img').data('tag', 'bdshare')

    window._bd_share_config = {
        common: {
            "bdText": '',
            "bdMini": "2",
            "bdMiniList": false,
            "bdPic": '',
            "bdStyle": "0",
            "bdSize": "24"
        },
        share: [{
            // "bdSize": 12,
            bdCustomStyle: jsui.uri + '/css/share.css'
        }]
    }

    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
}
$(document).on('click', function(e){
        e = e || window.event;
        var target = e.target || e.srcElement, _ta = $(target)

        if( _ta.hasClass('disabled') ) return
        if( _ta.parent().attr('data-type') ) _ta = $(_ta.parent()[0])
        if( _ta.parent().parent().attr('data-type') ) _ta = $(_ta.parent().parent()[0])

        var type = _ta.attr('data-type')

        switch( type ){
                case 'comment-insert-smilie':
            	if( !$('#comment-smilies').length ){
            		$('#commentform .comt-box').append('<div id="comment-smilies" class="hide2"></div>')
            		var res = ''
					for( key in options.smilies ){
						res += '<img data-simle="'+key+'" data-type="comment-smilie" src="'+jsui.uri+'/img/smilies/icon_'+options.smilies[key]+'.gif">'
					}
					$('#comment-smilies').html( res )
            	}
            	$('#comment-smilies').slideToggle(100)


            break; case 'comment-smilie':
            	grin( _ta.attr('data-simle') )
            	_ta.parent().slideUp(300)

            break; case 'switch-author':
            	$('.comt-comterinfo').slideToggle(300);
				$('#author').focus();
            	

            break; 
        }
    })
		var options = {
		smilies: {
			'mrgreen': 'mrgreen',
			'razz': 'razz',
			'smile': 'smile',
			'oops': 'redface',
			'grin': 'biggrin',
			'lol': 'lol',
			'neutral': 'neutral',
			'idea': 'idea',
			'wink': 'wink',
			'?': 'question',
			'arrow': 'arrow',
			'sad': 'sad',
			'cry': 'cry',
			'eek': 'eek',
			'surprised': 'surprised',
			'???': 'confused',
			'cool': 'cool',
			//'unhappy': 'unhappy',
			'mad': 'mad',
			'twisted': 'twisted',
			'roll': 'rolleyes',
			//'sick': 'sick',
			'evil': 'evil',
			'!': 'exclaim'
		}
	}

/* functions
 * ====================================================
 */
function is_ie6() {
		if ($.browser.msie) {
			if ($.browser.version == "6.0") return true;
		}
		return false;
	}

function grin(tag) {
		tag = ' :' + tag + ': ';
		myField = document.getElementById('comment');
		document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : insertTag(tag)
	}

	function insertTag(tag) {
		myField = document.getElementById('comment');
		myField.selectionStart || myField.selectionStart == '0' ? (startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = startPos, myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length), cursorPos += tag.length, myField.focus(), myField.selectionStart = cursorPos, myField.selectionEnd = cursorPos) : (myField.value += tag, myField.focus())
	} 
//上面两个是点击表情图片自动插入到评论框里。 
function scrollTo(name, add, speed) {
    if (!speed) speed = 300
    if (!name) {
        $('html,body').animate({
            scrollTop: 0
        }, speed)
    } else {
        if ($(name).length > 0) {
            $('html,body').animate({
                scrollTop: $(name).offset().top + (add || 0)
            }, speed)
        }
    }
}
function is_name(str) {
    return /.{2,12}$/.test(str)
}
function is_url(str) {
    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str)
}
function is_qq(str) {
    return /^[1-9]\d{4,13}$/.test(str)
}
function is_mail(str) {
    return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str)
}
$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function strToDate(str, fmt) { //author: meizz   
    if( !fmt ) fmt = 'yyyy-MM-dd hh:mm:ss'
    str = new Date(str*1000)
    var o = {
        "M+": str.getMonth() + 1, //月份   
        "d+": str.getDate(), //日   
        "h+": str.getHours(), //小时   
        "m+": str.getMinutes(), //分   
        "s+": str.getSeconds(), //秒   
        "q+": Math.floor((str.getMonth() + 3) / 3), //季度   
        "S": str.getMilliseconds() //毫秒   
    };
    if (/(y+)/.test(fmt))
        fmt = fmt.replace(RegExp.$1, (str.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

// Dian zan!
$.fn.postLike = function() {
	if ($(this).hasClass('actived')) {
		return false;
	} else {
		$(this).addClass('actived');
		var id = $(this).data("id"),
		action = $(this).data('action'),
        valuenum = $(this).data('num');   
		rateHolder = $(this).children('.count');
		var ajax_data = {
			action: valuenum,
			um_id: id,
			um_action: action
		};
		/*$.post("/ajax/scoreajax", ajax_data,
		function(data) {
			$(rateHolder).html(data);
		});*/
        $.ajax({
            url: "/articleshow/scoreajax",
            data: ajax_data,
            type: 'post',
            error: function(request) {
                //console.log(request);
                $(rateHolder).html(request.responseText);
            },
            success: function(data) {
                $(rateHolder).html(data);
            }		
        });
		return false;
	}
};
$(document).on("click", ".action",
function() {
	$(this).postLike();
});

+(function($){
	
	function b(){
	t = $(document).scrollTop();
	if($(window).scrollTop()>=200){ 
   $(".d_postlist").addClass("affix");
   $("#topblack").hide();
   jsui.bd.addClass('topblack-hidden');
   }
else{
	$(".d_postlist").removeClass("affix");
	$("#topblack").show();
	jsui.bd.removeClass('topblack-hidden');
	} 
	}
	
$(window).scroll(function(e){
	b();	
})
$(document).ready(function() {	

$('.ad-main-content-right').click(function(){
   $('.ad-main-content-right').toggleClass('sameating');
});
setTimeout(function(){						
$('.ad-bottom-wrapper').fadeIn(1500);
}, 1200);
$('.excerpt-see h2').click(function(){
$('.excerpt-see .fa-caret-down').toggleClass("rotate180deg");
$('.excerpt-see .note').slideToggle();
});
$(".tabs li").click(function(){
	if($(this).attr("class")!="sel")$(this).addClass("on")
},function(){
	$(this).removeClass("on")
}).click(function(){
	$(this).siblings().removeClass()
	$(this).attr("class","sel")
	$("ul.tabc:visible").fadeOut(100,function(){
		$("ul.tabc").eq($(".tabs li.sel").index()).fadeIn(100)
	})
})
//$('.liaoyue a').click(function(){
//$('#weixin_tip').slideDown(1500);
//})
	$('#wreading').click(function(){
	    $('.sidebar').hide();
	    $('.content').addClass("bigger-than-bigger");
		$('#duos_single').addClass("bigger-than-bigger");
	    $(".article-title").addClass("font30");
	    $(".article-content p").addClass("font18");
		$(".article-content pre,#sc_tips,#sc_error,.wc-shortcodes-highlight-red").addClass("font18");
		$(".article-content img").addClass("width800");
		$(".go-next a").addClass("ml510");
		$(".article-meta").addClass("font16");
		$(".article-meta .tags a,#topfollownav .article-nav a,.article-topnav-right a,.top-right-2 a").addClass("font15");
		$(".article-content h3").addClass("font22");
        $(".quick-page").addClass("mleft40");
		$(".c-main").addClass("font16");
		//$(".bigredcircle").addClass("hide");
		//$("#meihua").addClass("hide");
		//$(".leave").addClass("hide");
		$("#sreading").addClass("show-reading");
		$("#wreading").hide();
	})
	$('#sreading').click(function(){
	    $('.sidebar').fadeIn(800);
	    $('.content').removeClass("bigger-than-bigger");
		$('#duos_single').removeClass("bigger-than-bigger");
		$(".article-title").removeClass("font30");
	    $(".article-content p").removeClass("font18");
	    $(".article-content pre,#sc_tips,#sc_error,.wc-shortcodes-highlight-red").removeClass("font18");
		$(".article-content img").removeClass("width800");
		$(".go-next a").removeClass("ml510");
		$(".article-meta").removeClass("font16");
		$(".article-meta .tags a,#topfollownav .article-nav a,.article-topnav-right a,.top-right-2 a").removeClass("font15");
		$(".article-content h3").removeClass("font22");
		$(".quick-page").removeClass("mleft40");
		$(".c-main").removeClass("font16");
		//$(".bigredcircle").removeClass("hide");
		//$("#meihua").removeClass("hide");
		//$(".leave").removeClass("hide");
		$("#wreading").show();
		$("#sreading").removeClass("show-reading");
	})	

$('#dashang a').click(function(){
  $('#dashang img').toggle('slow');
})

$(".play-btn-mask").hover(function(){
	$(this).siblings("span").stop(!0).animate({opacity:1},150),
	$(this).stop(!0).animate({opacity:.4},200)},function(a){return $(a.relatedTarget).is($("span"))?!1:($(this).siblings("span").animate({opacity:0},200),void $(this).animate({opacity:0},200))})
	
	
	// 评论分页点击分页导航链接时触发分页
$(document).on("click", ".pagenav a", function(e) {
    e.preventDefault();
    $.ajax({
        type: "GET",
        url: $(this).attr('href'),
        beforeSend: function(){
			/* 触发后移除评论列表、评论分页及评论统计(不清楚的可参考张戈博客的评论ID元素) */
            $('.pagenav').remove();
            $('.commentlist').remove();
			/* 显示正在加载中效果 */
            $('#loading-comments').slideDown();
            $body.animate({scrollTop: $('#comments').offset().top - 65}, 800 );
        },
        dataType: "html",
        success: function(out){
			/* 在ajax拉取内容中查找评论列表部分 */
            result = $(out).find('.commentlist');
			/* 获取评论分页DIV模块 */
            nextlink = $(out).find('.pagenav');
            $('#loading-comments').slideUp('fast');
			/* 将评论统计输出到(加载中)模块的后面，并移除[加载中]模块 */
            $('#loading-comments').after(result.fadeIn(500));
			/* 将评论列表输出到评论统计模块的后面 */
            $('.commentlist').after(nextlink);
        }
    });
})


})
})(window.jQuery);