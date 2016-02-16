<?php include_once 'adminheader.tpl.php' ?>


<div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Edit Tags <small>Edit a Tag</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/tag_edit/'.$tags['id']); ?>" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="role">名称：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="username" value="<?php echo $tags['tag'] ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">出现次数：</label>
						<div class="controls">
                            <input type="text" readOnly="true" class="input-xlarge" id="role" name="openid" value="<?php echo $tags['num']; ?>"/>
						</div>
					</div>                    
                    <p  class="controls" style="color:red;">注意：此处修改相应的文章也会随之修改！</p>
					<div class="form-actions">
                            <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Edit User</button>
                            <button type="reset" class="btn">Cancel</button>
				    <!--<input type="submit" class="btn btn-success btn-large" value="Save Role" /> <a class="btn" href="">Cancel</a>-->
					</div>					
				</fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php include_once 'adminfooter.tpl.php' ?>