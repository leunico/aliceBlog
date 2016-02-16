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
              <form class="form-horizontal" action="<?php echo Route('admin/article_edit/'.$articles['id']); ?>" method="post"  onsubmit="return arts('edit')">
				<fieldset>
                    <div class="control-group">
						<label class="control-label" for="active">置顶：</label>
						<div class="controls">
							<input type="checkbox" name='top' id="active" value="1" <?php if($articles['top']=='1') echo "checked";?>/>
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
                                <?php foreach($blogMenuList as $k=>$v){
                                    if($articles['mid']==$k){
                                        echo "<option value='".$k."' selected>".$v."</option>";
                                    }else{
                                        echo "<option value='".$k."'>".$v."</option>";
                                    }                              
                                }?>
                            </select>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">推荐类型：</label>
						<div class="controls">
							<select name="recommend_type">
                                    <option value="0"<?php if($articles['recommend_type']=='0') echo "selected";?>>无推荐</option>
                                    <option value="1"<?php if($articles['recommend_type']=='1') echo "selected";?>>全站推荐</option>
                                    <option value="2"<?php if($articles['recommend_type']=='2') echo "selected";?>>首页推荐</option>
                            </select>
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
							<input type="text" class="input-xlarge" id="role" name="clickst" value="<?php echo $articles['clicks'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">赞的次数：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="good_num" value="<?php echo $articles['good_num'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">拍砖的次数：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="bad_num" value="<?php echo $articles['bad_num'] ?>"/>
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
                            <p style="color:red">If there is 'php / js / html'code, please use'<code>[code]xxxx[/code]</code>',']' => '>'</p>
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