<?php include_once 'adminheader.tpl.php' ?>


<script type="text/javascript">
    $(document).ready(function(){
        arts('edit'); 
    });
</script>
<div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Edit Article <small>Edit a Article</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/article_edit/'.$articles['id']); ?>" method="post" onsubmit="return arts('edit')">
				<fieldset>
                    <div class="control-group">
						<label class="control-label" for="role">是否置顶：</label>
						<div class="controls">
                            <p style='color:red;margin-top:4.3px'><?php echo  $articles['top']=='1'? "是":'否';?></p>
                            <input type="hidden" name="top" value="<?php echo $articles['top'];?>"/>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="role">标题：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="title" value="<?php echo $articles['title'] ?>"/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">作者：</label>
						<div class="controls">
							<input type="text"  readOnly="true" class="input-xlarge" id="role" name="author" value="<?php echo $articles['author'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">文章分类：</label>
						<div class="controls">
							<select name="mid">
                                <?php foreach($blogMenuList as $k=>$v){?>
                                    <option value="<?php echo $k ?>" <?php if($articles['mid']==$v) echo "selected";?>><?php echo $v ?></option>
                                <?php }?>
                            </select>
						</div>
					</div>
                   <div class="control-group">
						<label class="control-label" for="role">推荐类型：</label>
						<div class="controls">
							<input type="hidden" name="recommend_type" value="<?php echo $articles['recommend_type'];?>"/>
                            <p style='color:blue;margin-top:4.3px'><?php echo $article['recommend_type'] == 0 ? '无推荐': ($article['recommend_type'] == '1' ? '全站推荐':'首页推荐');?></p>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">SEO - Title：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="seo_title" value="<?php echo $articles['seo_title'] ?>"/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">SEO - Description：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="seo_description" value="<?php echo $articles['seo_description'] ?>"/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">SEO - 关键词：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="seo_keywords" value="<?php echo $articles['seo_keywords'] ?>"/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">点击量：</label>
						<div class="controls">
							<input type="text"  readOnly="true"  class="input-xlarge" id="role" name="clickst" value="<?php echo $articles['clicks'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">赞的次数：</label>
						<div class="controls">
							<input type="text"  readOnly="true"  class="input-xlarge" id="role" name="good_num" value="<?php echo $articles['good_num'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">拍砖的次数：</label>
						<div class="controls">
							<input type="text"  readOnly="true"  class="input-xlarge" id="role" name="bad_num" value="<?php echo $articles['bad_num'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">标签(use '|')：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="tag" value="<?php echo $articles['tag'] ?>"/><span class="validform"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="description">文章描述Description：</label>
						<div class="controls">
							<textarea class="input-xlarge" id="description" rows="3" name="description"><?php echo $articles['description'] ?></textarea><span class="validform"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="slug">文章内容：</label>
						<div class="controls">
                            <p>If there is 'php/js/html'code, please use'[code]xxx[/code]'</p>
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain"><?php echo $articles['content'];?></script>
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="<?php echo ADMIN_UEDITOR_DIR?>ueditor.config.js"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="<?php echo ADMIN_UEDITOR_DIR?>ueditor.all.js"></script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container');
                            </script>
                          <!--  <textarea class="input-xlarge" id="textarea" lows="20" rows="10" name="content"></textarea> -->
						</div>
					</div>
					<div class="form-actions">
                            <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Edit Blog Article</button>
                            <button type="reset" class="btn">Cancel</button>
				    <!--<input type="submit" class="btn btn-success btn-large" value="Save Role" /> <a class="btn" href="">Cancel</a>-->
					</div>					
				</fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php  include_once 'adminfooter.tpl.php' ?>