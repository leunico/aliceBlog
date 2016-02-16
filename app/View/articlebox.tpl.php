<?php include_once 'newheader.tpl.php'; ?>
<body class="page page-id-1228 page-template page-template-pagesarchives-php site-layout-2 wc-shortcodes-font-awesome-enabled">   
<?php $nav = "articlebox"; include_once 'newnav.tpl.php';?>
<section class='container container-page mtop125'>
<div class="pageside">
	<div class="pagemenus">
		<ul class="pagemenu"></ul>
	</div>
</div>
    <div class='content'>
        <header class='article-header'>
            <h1 class='article-title'>文章归档</h1>
        </header>
        <article class='article-content'>
            <p><img class="alignnone size-full" style="border-radius:4px;-webkit-border-radius:4px;margin-top:10px;margin-bottom:10px;" src="http://cdn.duitang.com/uploads/item/201303/27/20130327202512_GcEC2.jpeg" alt="哈哈哈哈" width="640" height="426"></p>
            <p>&nbsp;</p>
        </article>
        <article class='archives'>
            <?php foreach($articleClassList as $k=>$ret){?>
            <div class='item'><h3><?php echo $k."月"; ?></h3>            
                <ul class='archives-list'>                      
                    <?php foreach($ret as $article){
                             echo "<li><time>".date('d', $article['ctime'])."日</time>&nbsp;&nbsp;&nbsp;&nbsp;<a href=".Route('articleshow/'.$article['id']).">".$article['title']." </a>&nbsp;&nbsp;&nbsp;&nbsp;<span class='text-muted'><i class='fa fa-comment fa-fw'></i>".$article['count']."</span></li>"; }?>                
                </ul>
            </div>
            <?php } ?>
        </article>
    </div>
    </section>
      
<?php include_once 'newfooter.tpl.php';?>    