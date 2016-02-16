<?php $js = 'scrollmonitor.js?ver=version'; include_once "newheader.tpl.php"; ?>

<body class="archive category category-life category-1 site-layout-2 wc-shortcodes-font-awesome-enabled">

<?php include_once "newnav.tpl.php"; ?>

<section class="container mtop105">
<div class="content-wrap">
<div class="content life-category">
    <div class='life-cover'>     
        <img src='<?php echo IMAGE_DIR;?>new-banner.jpg' style='margin-left:-60px;'>    
        <h2>不是所有的难过都需要呐喊，不是所有的遗憾都非要填满。</h2>
    </div>
    <?php foreach($articleClassList as $article){ ?>
    <article class='life excerpt-1'>
        <header><h2><a href="<?php echo Route('articleshow/'.$article['id']); ?>"><?php echo $article['title']?></a></h2></header>
        <p class='meta'><?php echo "<a class='entry-cat' href=".Route('class/'.$article['mid']).">".$articleclass[$article['mid']]."</a>"; ?>
            <span class='author'><span class='separator'>・</span>
                <span class='author'><a href='#'><?php echo $article['author']; ?></a></span>
                <span class='separator'>・</span>
                <a class='pc' href="<?php echo Route('articleshow/'.$article['id']); ?>#comments"><?php echo $article['comcount'] ? $article['comcount']:0; ?> 评论</a>
                <time><span class='separator'>・</span><?php echo date('Y-m-d', $article['ctime']);?></time>
            </p><a class="focus" href="<?php echo Route('articleshow/'.$article['id']); ?>"><img style="border-radius:4px;width:690px;height:auto;margin:5px 45px;" src="<?php echo getImage($article['content'],0); ?>" class="thumb wp-post-image" alt="<?php echo $article['title']?>" /></a>
	    <p class='note'><?php echo $article['description']; ?></p>
        <p class='more'><a href="<?php echo Route('articleshow/'.$article['id']); ?>">Read More</a></p>
    </article>
    <?php } echo $pageNav;?> 
</div></div></section>
<?php include_once "newfooter.tpl.php"; ?>
