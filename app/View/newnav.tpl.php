<header class="header">
  <div id="topcontainer">
    <div class="container" id="nav">
      <div class="circle-wrapper">
      <div class="red doted-circle circling"></div>
    </div>
    <div class="logo" style="width:152px;">
        <a href="http://www.lzxya.com" title="啊哒！" style="width:152px;">
        <div class="circle-wrapper">
            <div class="red doted-circle circling"></div>
        </div>
        <img src="<?php echo IMAGE_DIR;?>navred.png">
        </a>
     </div>	
     <div class="top-search">
         <form method="get" class="site-search-form" action="#" >
             <button class="search-btn" type="submit">
                 <span class="icon-search"></span>
             </button>
             <input class="search-input" name="s" type="text" placeholder="" value="">
         </form>
     </div>
        <ul class="site-nav site-navbar main-nav">
            <li id="menu-1" class="menu-item menu-item-type-custom menu-item-object-custom current_page_item menu-item-home menu-1<?php if($nav==1) echo " current-menu-item"; ?>"><a href="/">首页</a></li>
            <?php
                if(!$meunclass || !$articleclass){
					$getclass = getClass();
                    $meunclass = $getclass['menu_class'];
                    $articleclass = $getclass['article_class'];
                }
                foreach($meunclass as $key=>$val){             
                    if(is_array($val)){                     
                        echo "<li id=\"menu-".$key."\" class=\"menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-".$key.($val[$nav] ? " current-menu-item":"")."\"><a href=".Route('class/'.$key).">".$val[$key]."</a><ul class=\"sub-menu\">";
                        foreach($val as $k=>$v){                            
                           if($k !== $key) echo "<li id=\"menu-".$k."\" class=\"menu-item menu-item-type-taxonomy menu-item-object-category menu-item-".$k."\"><a href=".Route('class/'.$k).">".$v."</a></li>"; 
                        }
                        echo "</ul></li>";
                    }else{
                        
                        echo "<li id=\"menu-".$key."\" class=\"menu-item menu-item-type-taxonomy menu-item-object-category menu-item-".$key.($nav == $key ? " current-menu-item":"")."\"><a href=".Route('class/'.$key).">".$val."</a></li>";    
                    }                                        
                } 
            ?>
            <li id="menu-8" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-7"><a href="<?php echo Route("admin/login"); ?>">她很漂亮</a></li>
            <li class="navto-search"><a href="javascript:;" class="search-show active"><i class="fa fa-search"></i></a></li>
        </ul>
        <i class="fa fa-bars m-icon-nav"></i>
      </div>
   </div>
</header>
<div class="site-search">
    <div class="container">
        <form method="post" class="site-search-form" action="<?php echo Route('index/search'); ?>" onsubmit="return searcha()">
            <input class="search-input" name="search" type="text" placeholder="输入关键字" value="" id='asearch'>
            <button class="search-btn" type="submit" name="dosubmit" value="dosubmit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>

