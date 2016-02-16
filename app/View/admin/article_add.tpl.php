<?php  include_once 'adminheader.tpl.php'; ?>


<script type="text/javascript">
    $(document).ready(function(){
        arts('add'); 
    });
</script>
<div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>New Article <small>Add a new Article</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/article_add'); ?>" method="post"  onsubmit="return arts('add')">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="role">标题：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="title" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">作者：</label>
						<div class="controls">
							<input type="text" readOnly="true" class="input-xlarge" id="role" name="author" value="<?php echo $loginInfo['username'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">文章分类：</label>
						<div class="controls">
							<select name="mid">
                                <?php foreach($blogMenuList as $k=>$v){
                                   echo "<option value='".$k."'>".$v."</option>";
                                }?>
                            </select>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">推荐类型：</label>
						<div class="controls">
							<select name="recommend_type">
                                    <option value="0">无推荐</option>
                                    <option value="1">全站推荐</option>
                                    <option value="2">首页推荐</option>
                            </select>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">SEO - Title：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="seo_title" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">SEO - Description：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="seo_description" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">SEO - 关键词：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="seo_keywords" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">标签(use '|')：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="tag" value=""/><span class="validform"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="description">文章描述Description：</label>
						<div class="controls">
							<textarea class="input-xlarge" id="description" rows="3" name="description"></textarea><span class="validform"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="slug">文章内容：</label>
						<div class="controls">
                            <p style="color:red">当要设置文章配图时HTML下图片增加CSS_"border-radius:4px",使用标签用'h1/h2...'标记。</p>
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain"></script>
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
                            <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Add Blog Article</button>
                            <button type="reset" class="btn">Cancel</button>
				    <!--<input type="submit" class="btn btn-success btn-large" value="Save Role" /> <a class="btn" href="">Cancel</a>-->
					</div>					
				</fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php  include_once 'adminfooter.tpl.php'; ?>