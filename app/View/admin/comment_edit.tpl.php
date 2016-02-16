<?php include_once 'adminheader.tpl.php' ?>


<div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Edit Comments <small>Edit a Comment</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/comment_edit/'.$comments['id']); ?>" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="role">昵称：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="nickname" value="<?php echo $comments['nickname'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="description">评论内容：</label>
						<div class="controls">
							<textarea class="input-xlarge" id="description" rows="3" name="contents"><?php echo $comments['contents'] ?></textarea><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">邮箱：</label>
						<div class="controls">
                            <input type="text" readOnly="true" class="input-xlarge" id="role" name="email" value="<?php echo $comments['email']; ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">个人网址：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="website" value="<?php echo $comments['website']; ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">IP：</label>
						<div class="controls">
                            <input type="text" readOnly="true" class="input-xlarge" id="role" name="email" value="<?php echo $comments['ip']; ?>"/>
						</div>
					</div>                    
                    <p  class="controls" style="color:red;">注意：此处修改相应的文章也会随之修改！</p>
					<div class="form-actions">
                            <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Edit Comment</button>
                            <button type="reset" class="btn">Cancel</button>
				    <!--<input type="submit" class="btn btn-success btn-large" value="Save Role" /> <a class="btn" href="">Cancel</a>-->
					</div>					
				</fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php include_once 'adminfooter.tpl.php' ?>