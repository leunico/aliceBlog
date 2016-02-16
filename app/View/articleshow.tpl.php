<?php 
$nav = $articleShow['mid'];
$seo_title = $articleShow['seo_title'];
$seo_keywords = $articleShow['seo_keywords'];
$seo_description = $articleShow['seo_description'] ;
$js = 'scrollmonitor.js?ver=version';
include_once 'newheader.tpl.php'; ?>

<body class="single single-post postid-3378 single-format-standard comment-open site-layout-2 wc-shortcodes-font-awesome-enabled">
    
<?php include_once 'newnav.tpl.php'; ?> 

    <section class="container mtop105">
        <div class="content-wrap">
            <div class="content">
                <header class="article-header">
                    <h1 class="article-title fontSmooth">
                        <span class="bigredcircle"></span><span><?php echo $articleShow['title']; ?></span>
                    </h1>
                    <div class="article-meta">
                        <span class="cat">
                            <a href="<?php echo Route('class/'.$articleShow['mid']); ?>"><i class="fa fa-folder-open fa-fw"></i><?php echo $articleclass[$articleShow['mid']]; ?></a>
                        </span>
                        <span class='cat'><a href='#'><i class='fa fa-user fa-fw'></i><?php echo $articleShow['author']; ?></a></span>
                        <span class="muted1" id="i-sidebar">
                            <a href="javascript:void(0)" id="wreading"><i class="fa fa-camera fa-fw"></i>纯净阅读</a>
                            <a href="javascript:void(0)" id="sreading"><i class="fa fa-power-off fa-fw"></i>默认模式</a>
                        </span>
                        
                        <div class="tags">
                            <?php foreach($articleShow['tag'] as $tag){
                                    $route = urlencode(iconv("utf-8","gbk",$tag));
                                    echo "<span><i class=\"fa fa-lightbulb-o fa-fw\"></i><a href=".Route('tag/articletag/'.$route)." rel=\"tag\">".$tag."</a></span>";
                            }?>
                        </div>
                        <span class="item"></span>
                    </div>
                </header>
                <article class="article-content">	
                    <div class="quick-page">
                        <div class="go-previous">
                            <?php echo ($onone = $articleShow['navart']['oneone']) ? "<a href=".Route('articleshow/'.$onone['id'])." rel=\"prev\"><i class=\"fa fa-chevron-left\"></i></a>":''; ?>
                        </div>
                        <div class="go-next">
                            <?php echo ($next = $articleShow['navart']['next']) ? "<a href=".Route('articleshow/'.$next['id'])." rel=\"next\"><i class=\"fa fa-chevron-right\"></i></a>":''; ?>
                        </div>
                    </div>                                                            
                    <?php echo $articleShow['content']; ?>
                    <div class="post-add-like" style="display: block;text-align: center;width:100%;padding-bottom: 15px;padding-top: 15px;">
                        <a href="javascript:;" data-action="ding" data-id="<?php echo $articleShow['id']; ?>" data-num="<?php echo $articleShow['good_num']; ?>" id="likeit" class="action"><i class="fa fa-thumbs-o-up fa-fw"></i>赞(<span class="count"><?php echo $articleShow['good_num']; ?></span>)</a>
                        <a href="javascript:;" data-action="xu" data-id="<?php echo $articleShow['id']; ?>" data-num="<?php echo $articleShow['bad_num']; ?>" id="likeit" class="action"><i class="fa fa-thumbs-o-down fa-fw"></i>嘘(<span class="count"><?php echo $articleShow['bad_num']; ?></span>)</a>
                    </div>
                    <div class="article-bottom-meta">
                        <span class="item"><i class="fa fa-clock-o fa-fw"></i>发表于<?php echo date('Y-m-d', $articleShow['ctime']);?></span>
                        <span class="item post-views"><i class="fa fa-eye fa-fw"></i>浏览<?php echo $articleShow['clicks']; ?>次</span>
                        <span class="item"><i class="fa fa-comments-o fa-fw"></i>评论<?php echo ($articleShow['counts'] == 0) ? 0 : $articleShow['counts']; ?>次</span></div>
                </article>
                <div class="article-tags">标签：
                 <?php foreach($articleShow['tag'] as $tag){
                       $route = urlencode(iconv("utf-8","gbk",$tag));
                       echo "<span><a href=".Route('tag/articletag/'.$route)." rel=\"tag\">".$tag."</a></span>";
                 }?>
                </div>
                <div class='relates'><div class='title'><h3>相关推荐</h3></div><ul><?php foreach($articleRelevant as $articleR){ ?><li><a href='<?php echo Route('articleshow/'.$articleR['id']); ?>' class='thumb'><img src="<?php echo ($articleR['image'] ? $articleR['image']:IMG_DEFAULT); ?>" alt="<?php echo $articleR['title']; ?>" class="thumb" /><?php echo $articleR['title']; ?></a></li><?php } ?></ul></div>				
                <div class="article-way">
                    <span class="article-back">上一篇 <?php echo $articleShow['oneone'] ? "<a href=".Route('articleshow/'.$articleShow['oneone']['id'])." rel=\"prev\">".$articleShow['oneone']['title']."</a>" : "没有更多了"; ?></span>
                    <span class="article-forward"><?php echo $articleShow['next'] ? "<a href=".Route('articleshow/'.$articleShow['next']['id'])." rel=\"prev\">".$articleShow['next']['title']."</a>" : "没有更多了"; ?> 下一篇</span>
                </div>
            </div>
            
            <div id="duos_single" class="no_webshot">
                <div id="respond" class="no_webshot">		
                    <form action="#" method="post" id="commentform">
                    <div class="comt">
                        <div class="comt-title">
                            <div class="comt-avatar pull-left">
                                <img alt='' data-src='<?php echo IMG_TXING;?>' class='avatar avatar-50 photo avatar-default' height='50' width='50' />          
                            </div>                                       
                            <div class="comt-author"> 
                                <?php if(AuthComment('username') && AuthComment('email')){
                                            echo "<span class=\"who\">".AuthComment('username')."</span><span>发表我的评论</span> &nbsp"; 
                                            echo AuthComment('type') ? "" :"<a class=\"switch-author\" href=\"javascript:;\" data-type=\"switch-author\" style=\"font-size:12px;\">换个身份</a>";
                                        }else{
                                            echo "发表我的评论";   
                                        }
                                 ?>   
                            </div>
                            <p><a id="cancel-comment-reply-link" class="pull-right" href="javascript:;">取消评论</a></p>
                        </div>
                        
                        <div class="comt-box">
                            <textarea placeholder="If you have any comment, just post it here..." class="input-block-level comt-area" name="comment" id="comment" cols="100%" rows="3" tabindex="1" onKeyDown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>                            
                            <div class="comt-ctrl">
                                <div class="comt-tips">
                                    <input type='hidden' name='comment_post_ID' value="<?php echo $articleShow['id']; ?>" id='comment_post_ID' />
                                    <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
                                    <label for="comment_mail_notify" class="checkbox inline hide" style="padding-top:0"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>	
                                </div>
                                <button type="submit" name="submit" id="submit" tabindex="5"><i class="fa fa-check-circle-o"></i>提交评论</button>                                
                                <span data-type="comment-insert-smilie" class="muted comt-smilie"><i class="fa fa-github-alt"></i> 添加表情</span>
                            </div>
                        </div>
                        
                        <div class="comt-comterinfo" id="comment-author-info" >
                            <h4>Hi，您需要填写昵称和邮箱！</h4>
                            <div class="comment-first-tips">您的邮箱地址不会公开，仅仅用于收取回复。建议填写QQ邮箱，不宜填写工作邮箱。</div>
                            <ul>
                                <li class="form-inline"><label class="hide" for="author">昵称</label><input class="ipt" type="text" name="author" id="author" value="<?php echo AuthComment('username');?>" tabindex="2" placeholder="昵称"><span class="help-inline">昵称 (必填)</span></li>
                                <li class="form-inline"><label class="hide" for="email">邮箱</label><input class="ipt" type="text" name="email" id="email" value="<?php echo AuthComment('email');?>" tabindex="3" placeholder="邮箱"><span class="help-inline">邮箱 (必填)</span></li>
                                <li class="form-inline"><label class="hide" for="url">网址</label><input class="ipt" type="text" name="url" id="url" value="<?php echo AuthComment('url');?>" tabindex="4" placeholder="http://"><span class="help-inline">网址 (没有就留空)</span></li>
                            </ul>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="title" id="comments"><?php echo ($articleShow['counts'] == 0) ? "<small>来抢个沙发吧</small>" : "这篇文章共有 <b>(".$articleShow['counts'].")</b> 条评论"; ?></div>
                <div id="postcomments">
                <!-- 显示正在加载新评论 -->
                <div id="loading-comments">玩命加载中......</div>
                <ol class="commentlist">
                    <?php foreach($comments as $comment){ ?>
                    <li class="comment even thread-even depth-1 clearfix" id="comment-<?php echo $comment['id']; ?>">
                        <span class="comt-f"><?php echo $comment['website'] ? "有个人网址哦！" : $comment['louc'].'楼'; ?></span>
                        <div class="c-avatar"><img alt='' src='<?php echo IMG_TXING;?>' class='avatar avatar-50 photo' height='50' width='50' />
                            <div class="c-main" id="div-comment-<?php echo $comment['id']; ?>">
                                <p style="color:#8c8c8c;"><span class="c-author"><?php echo $comment['website'] ? "<a href='".$comment['website']."' rel='external nofollow' class='url'>".$comment['nickname']."</a>" : $comment['nickname']; ?></span><?php if($comment['email'] == '867426952@qq.com'){echo "<a title=\"Alice博客管理员\"><img src=\"http://www.liaosam.com/wp-content/themes/liaosam/images/2.png\" style=\"margin-top: -3px;\" class=\"box-hide box-show\"></a>";} ?></p>
                                <p><?php echo EmojiH($comment['contents']); ?></p>
                                <div class="c-meta"><?php echo wordTime($comment['ctime'])."<a class='comment-reply-link' href='/articleshow/".$comment['aid']."?replytocom=".$comment['id']."#respond' onclick='return addComment.moveForm(\"div-comment-".$comment['id']."\", \"".$comment['id']."\", \"respond\", \"".$comment['aid']."\")'>回复</a>"; ?>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($comment['son'])){    
                           echo "<ul class=\"children\">";                               
                            foreach(array_reverse($comment['son']) as $son){ ?>
                            <li class="comment even depth-2 clearfix" id="comment-<?php echo $son['id']; ?>">
                                <div class="c-avatar"><img alt='' src='<?php echo IMG_TXING;?>' class='avatar avatar-50 photo' height='50' width='50' />
                                    <div class="c-main" id="div-comment-<?php echo $son['id']; ?>"><p class="jiyou" style="color:#8c8c8c;margin-bottom:6px;">
                                        <span class="c-author"><?php echo $son['nickname']; ?></span>
                                        <?php if($son['email'] == '867426952@qq.com'){echo "<a title=\"Alice博客管理员\"><img src=\"http://www.liaosam.com/wp-content/themes/liaosam/images/2.png\" style=\"margin-top: -3px;\" class=\"box-hide box-show\"></a>";} ?>
                                        <div style="margin:8px 0 4px;">
                                            <?php echo $son['pid'] ? "<a href=\"#comment-".$son['pid']."\" rel=\"nofollow\" class=\"cute\">@".$son['pnickname']."</a>".EmojiH($son['contents']) : EmojiH($son['contents']); ?>
                                        </div>
                                        <div class="c-meta"><?php echo wordTime($son['ctime'])."<a class='comment-reply-link' href='/articleshow/".$son['aid']."?replytocom=".$son['id']."#respond' onclick='return addComment.moveForm(\"div-comment-".$son['id']."\", \"".$comment['id'].'-'.$son['id']."\", \"respond\", \"".$son['aid']."\")'>回复</a>"; ?>
                                        </div>
                                    </div>
                                </div>
                            </li><!-- #comment-## -->
                         <?php } echo "</ul>";}echo "</li>";}echo "</ol>".$articleShow['commentPage_nav']; ?>
                </div>
            </div>
        </div>        
   </div>
</div>
<aside class="sidebar fontSmooth">    
    <div class="widget d_postlist">        
        <div class="tabs">
            <ul class="clx">
                <li>最新文章</li>
                <li class="sel">热评文章</li>
                <li>随机推荐</li>
            </ul>
        </div>
        <div class="tabscontent">
            <ul class="tabc" style="display:none;">
                <?php foreach($newArticleList as $articleN){ ?>
                <li><a href="<?php echo Route('articleshow/'.$articleN['id']); ?>"><span class="thumbnail"><img  height="34" width="46" src="<?php echo ($articleN['image'] ? $articleN['image']:IMG_DEFAULT); ?>" alt="<?php echo $articleN['title']; ?>" class="thumb" /></span><span class="text"><?php echo $articleN['title']; ?></span><span class="muted"><?php echo date('Y-m-d', $articleN['ctime']);?></span></a></li>         
                <?php } ?>
            </ul>            
            <ul class="tabc">
                <?php foreach($commentArticleList as $articleC){ ?>
                <li><a href="<?php echo Route('articleshow/'.$articleC['id']); ?>" title="<?php echo "文章有".$articleC['count']."条评论"; ?>"><span class="thumbnail"><img  height="34" width="46" src="<?php echo ($articleC['image'] ? $articleC['image']:IMG_DEFAULT); ?>" alt="<?php echo $articleC['title']; ?>" class="thumb" /></span><span class="text"><?php echo $articleC['title']; ?></span><span class="muted"><?php echo date('Y-m-d', $articleC['ctime']);?></span></a></li>         
                <?php } ?>
            </ul>            
            <ul class="tabc" style="display:none;">
                <?php foreach($pushArticleList as $articleP){ ?>
                <li><a href="<?php echo Route('articleshow/'.$articleP['id']); ?>"><span class="thumbnail"><img  height="34" width="46" src="<?php echo ($articleP['image'] ? $articleP['image']:IMG_DEFAULT); ?>" alt="<?php echo $articleP['title']; ?>" class="thumb" /></span><span class="text"><?php echo $articleP['title']; ?></span><span class="muted"><?php echo date('Y-m-d', $articleP['ctime']);?></span></a></li>         
                <?php } ?>
            </ul>            
        </div>
        <div class="clear"></div>
    </div>        
</aside>
</section>	

<?php include_once 'newfooter.tpl.php'; ?>
