<?php $css = 'timeline.css';include_once 'newheader.tpl.php';?>  

<body class="page page-id-2925 page-template page-template-pagestimeline-php comment-open site-layout-2 wc-shortcodes-font-awesome-enabled">
   
<?php $nav = 'timewait';include_once 'newnav.tpl.php';?>  
    
<section class="container timeline-page">
    <div class="pageside"><div class="pagemenus"><ul class="pagemenu"></ul></div></div>        
    <div class="content">
<script src="http://520.leunico.sinaapp.com/boot/js/modernizr.js"></script>
<div id="cd-timeline" class="cd-container">
 <div id="year-2014">
  <div class="year-wrap">
      <h2>时光旅行</h2>
      <div class="year-bg">
        <p class="year" style="color: #F36F6F;">Leunico</p>
      </div>
      <div class="bottom-jt"></div>
  </div>
  <div class="year-main">
      <?php foreach($timewait as $timew){ ?>
       <div class="cd-timeline-block">
			<div class="cd-timeline-img cd-picture">
				<span><i class="fa <?php echo $timew['classfa']; ?>"></i></span>
			</div>
			<div class="cd-timeline-content">
				<div class="timeline-img">
				  <img src="<?php echo $timew['img']; ?>">
				</div>
                <?php if(strlen($timew['content'])<50){echo "<p class=\"short\">".$timew['content']."</p>";}else{echo "<p>".$timew['content']."</p>";} ?>
				<span class="cd-date"><?php echo $timew['time']; ?></span>
			</div>
		</div>
      <?php } ?>		
	  </div>	
	</div>		
	<div id="to-be-continue">
      <div class="year-wrap" style="margin-bottom: 0;">
        <div class="year-bg">
          <p class="year" style="font-size:16px;width:100px">未完待续...</p></div>
          <div class="bottom-jt"></div>
        </div>
      </div>   
	</div> <!-- cd-timeline -->	
</div></section>       
<?php include_once 'newfooter.tpl.php';?>