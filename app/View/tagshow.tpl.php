<?php include_once 'newheader.tpl.php'; ?>

<body class="archive category category-online-marketing category-8 site-layout-2 wc-shortcodes-font-awesome-enabled">
   
<?php include_once 'newnav.tpl.php';?>    
	
<section class='container mtop105'><div class='content-wrap'><div class='content'>			
    
<div class='pagetitle'>
    <div style="color: #7a6f6f;"><i class="fa fa-tag"></i> TAG:  <a style="color: #F36F6F;" href="javascript:void(0)" title="点我干嘛~"><?php echo $tag['tag']; ?></a></div>
</div>
<?php if(empty($tagarticleShow)) echo "<h3 style=\"margin-left: 250px;margin-top: 80px;color: #64BB81;\">Also, There is no related articles...</h3>"; ?>
<?php foreach($tagarticleShow as $article){ ?>
                <article class='excerpt excerpt-1'>
                    <a class='fleft' href="<?php echo Route('articleshow/'.$article['id']); ?>">
                        <?php if($article['top'] == 1) echo "<span class='mask-tags'>置顶文章</span>";  ?>
                        <img src="<?php echo ($article['image'] ? $article['image']:IMG_DEFAULT); ?>" alt="<?php echo $article['title']?>" class="thumb" /></a>
                    <div class='excerpt-right'>       
                        <header>
                            <h2><a href="<?php echo Route('articleshow/'.$article['id']); ?>" title="<?php echo $article['title']?>" rel='bookmark'><?php echo $article['title']?></a></h2>
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
                                <a class='pc' href="<?php echo Route('articleshow/'.$article['id']); ?>#comments"><?php echo $article['comcount'] ? $article['comcount']:0; ?>评论</a>
                            </p>
                         <p class='note'><?php echo $article['description']; ?></p>
                    </div>
                </article> 
<?php } echo $pageNav;?> 
</div>
</div>
    <aside class="sidebar fontSmooth" style="margin-top:0px;">    
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
<?php include_once 'newfooter.tpl.php';?>