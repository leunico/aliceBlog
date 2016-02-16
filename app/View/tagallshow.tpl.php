<?php include_once 'newheader.tpl.php'; ?>

<body class="page page-id-2931 page-template page-template-pagestags-php comment-open site-layout-2 wc-shortcodes-font-awesome-enabled">

   
<?php include_once 'newnav.tpl.php';?>   
    
<div class="container container-page" style="margin-top: 40px;width: 720px;">
    <div class="pageside">
	   <div class="pagemenus">
		<ul class="pagemenu"></ul>
	   </div>
    </div>	
    <div class="content">
	  <header class="article-header"><h1 class="article-title"><i class="fa fa-tags"></i> 标签云</h1></header>
      <article class="article-content"></article>
		<div class="tag-clouds">
            <?php foreach($Tagall as $tag){ 
                    echo "<a href=".Route('tag/'.$tag['id']).">".$tag['tag']."<small>(".$tag['num'].")</small></a>";            
            }?>
			<a href="#">她很漂亮<small>(520)</small></a>           
       </div>
	</div>
</div>    
       
<?php include_once 'newfooter.tpl.php';?>