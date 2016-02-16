<?php include_once 'newheader.tpl.php'; ?>

<body class="home blog site-layout-2 wc-shortcodes-font-awesome-enabled">
    
<?php $nav = 1;include_once 'newnav.tpl.php'; ?> 
<script>
if(navigator.userAgent.match(/(iPhone|iPod|Android|ios)/i)){
setTimeout(alert('Hi,手机访问体验较差(UI烂)，用电脑访问会更好哦！'),2000);
}
</script>  
<section class="container mtop95">
    <div class="content-wrap">        
        <div class="main-content">
            <div class="content">                
                <div id="focusslide" class="carousel slide" data-ride="carousel">
                    <a class="close" href="javascript:void(0)" onClick="$('#focusslide').slideUp(800);" data-original-title="" title=""></a>
                    <ol class="carousel-indicators">
                        <li data-target="#focusslide" data-slide-to="0" class="active"></li>
                        <li data-target="#focusslide" data-slide-to="1"></li>
                        <li data-target="#focusslide" data-slide-to="2"></li>
                        <li data-target="#focusslide" data-slide-to="3"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                       <?php foreach($pushIndex as $k=>$push){ ?>                        
                        <div class="item <?php echo $k==2 ? 'active':''; ?>">
                            <a target="_blank" href="<?php echo $push['pushurl']; ?>"><img style="height：200px" src="<?php echo $push['pushimg']; ?>"></a>
                       </div>                       
                       <?php } ?>
                    </div>
                    <a class="left carousel-control" href="#focusslide" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                    <a class="right carousel-control" href="#focusslide" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
                </div>
                <div class="asb asb-index asb-index-01"></div>
                <?php foreach($articleList as $article){ ?>
                <article class='excerpt excerpt-0 recommend-sticky'>
                    <a class='fleft' href="<?php echo Route("articleshow/".$article['id']); ?>">
                        <?php if($article['top'] == 1) echo "<span class='mask-tags'>置顶文章</span>";  ?>
                        <img src="<?php echo ($article['image'] ? $article['image']:IMG_DEFAULT); ?>" alt="<?php echo $article['title']?>" class="thumb" /></a>
                    <div class='excerpt-right'>       
                        <header>
                            <h2><a href="<?php echo Route("articleshow/".$article['id']); ?>" title="<?php echo $article['title']?>" rel='bookmark'><?php echo $article['title']?></a></h2>
                        </header>
                        <p class='meta'>
                            <?php echo "<a class='entry-cat' href=".Route('class/'.$article['mid']).">".$articleclass[$article['mid']]."</a>"; ?>
                            <span class='author'> 
                                <span class='separator'>・</span>
                                <span class='author'><?php echo $article['author']; ?></span>
                                <time>
                                    <span class='separator'>・</span><?php echo date('Y-m-d', $article['ctime']);?>
                                </time>
                                <span class='pv'>
                                    <span class='separator'>・</span><?php echo $article['clicks']; ?>浏览
                                </span>
                                <span class='separator'>・</span>
                                <a class='pc' href="<?php echo Route("articleshow-".$article['id']).".html"; ?>#comments"><?php echo $article['comcount'] ? $article['comcount']:0; ?>评论</a>
                            </p>
                            <p class='note'><?php echo $article['description']; ?></p>
                    </div>
                </article> 
                <?php } echo $pageNav;?>     
            </div>
            
            <aside class="sidebar sidebar2 fontSmooth">        
                <div class="widget widget_ui_textasb">
                    <a class="style04" href="/class/me" target="_blank">
                        <strong>网站公告</strong>
                        <h2>Website Updating...</h2>
                        <p><img src='<?php echo IMAGE_DIR;?>toux.jpg' style='adminpic'></p>
                        <div class='profile'>
                            <span class='adminname'>Leunico</span>
                            <span class='admintitle'>Alice博客站长</span>
                        </div>
                        <div class='adminsaying'>Hi，欢迎来访。这是我用PHP开发的一个个人网站。在Git上有源码~</div>
                    </a>
                </div>
                <div class="widget widget_ui_posts">
                    <h3><i class="fa fa-thumbs-o-up fa-fw"></i>推荐阅读</h3>
                    <ul>
                        <?php  foreach($pushArticleList as $articlepush){ ?> 
                        <li>
                            <a href="<?php echo Route("articleshow/".$articlepush['id']); ?>">
                                <span class="thumbnail">
                                    <img  height="34" width="46" src="<?php echo ($articlepush['image'] ? $articlepush['image']:IMG_DEFAULT); ?>" alt="<?php echo $articlepush['title']; ?>" class="thumb" /></span>
                                <span class="text"><?php echo $articlepush['title']; ?></span>
                                <span class="muted"><?php echo $articleclass[$articlepush['mid']]; ?></span>
                                <span class="separator">・</span>
                                <span class="muted"><?php echo $articlepush['author']; ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="widget widget_ui_tags">
                    <h3><i class="fa fa-tags fa-fw"></i>云标签</h3>
                    <div class='items'>
                        <?php  foreach($tagList as $tags){  
                                  echo "<a href=\"".Route('tag/'.$tags['id'])."\">".$tags['tag'].'('.$tags['num'].')'."</a>"; 
                         } ?>
                        <a class="alltags" target="_blank" href="<?php echo Route('tag/showall') ?>">- 查看全部 -</a>
                    </div>
                </div>
                <div class="widget widget_ui_comments">
                    <h3><i class="fa fa-comments-o fa-fw"></i>最新评论</h3>
                    <ul>
                        <?php foreach($commentList as $comment){ ?>
                        <li>
                            <div class="postmeta">
                                <img alt='' src = "<?php echo IMG_TXING;?>" class='avatar avatar-50 photo' height='50' width='50' />
                                <a href="<?php echo Route('articleshow/'.$comment['aid'])."#comment-".$comment['id']?>" title="悄悄告诉你，这个是基佬">
                                    <strong><?php echo $comment['nickname'] ?></strong>
                                </a>
                                <span class="separator">・</span><?php echo wordTime($comment['ctime']) ?>
                            </div>
                            <div class="widgent_ui_comments_content"><?php echo EmojiH($comment['contents']) ?></div>
                            <div class="widget_ui_comments_title">
                                <p>评论于<a href="<?php echo Route('articleshow/'.$comment['aid'])?>"><?php echo $comment['title'] ?></a></p>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="widget widget_text">			
                    <div class="textwidget">
                        <!--<span class="WB_FB_plus">
                               <a href="http://weibo.com/u/3101570465" title="Leunico" target="_blank"><i id="fNum">81</i></a>
                               <em class="plus_arr"></em>
                            </span>-->
                        <iframe width="340" height="550" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=550&fansRow=1&ptype=1&speed=0&skin=5&isTitle=1&noborder=1&isWeibo=1&isFans=0&uid=3101570465&verifier=f6ab8812&dpc=1"></iframe>
                    </div>
                </div>
                <div class="widget widget_friendslink">
                    <div class="widget-title">
                        <h3><i class="fa fa-facebook-square fa-link"></i> 友情链接</h3>
                    </div>
                    <div class="linkwidget">
                        <div class="indexfriendslink">
                        <?php $link = getClass('friendslink'); foreach($link as $name=>$url){echo "<a href='".$url."' target=\"_blank\">".$name."</a>"; } ?>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>	
<?php include_once 'newfooter.tpl.php'; ?>   