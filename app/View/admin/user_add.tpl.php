<?php  include_once 'adminheader.tpl.php'; ?>


<script type="text/javascript">
    $(document).ready(function(){
       regs('add'); 
    });
</script>
<div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>New User <small>Add a new user</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/user_add'); ?>" method="post" onsubmit="return regs('add')">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="role">昵称：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="username" value="<?php echo $loginInfo['username'] ?>"/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">邮箱：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="email" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">密码：</label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="role" name="newpw" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">再次输入密码：</label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="role" name="newpw_a" value=""/><span class="validform"></span>
						</div>
					</div>
                    <p  class="controls" style="color:red;">注意：昵称使用中文不能过长，否则可能出错！</p>
					<div class="form-actions">
                            <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Add Blog User</button>
                            <button type="reset" class="btn">Cancel</button>
				    <!--<input type="submit" class="btn btn-success btn-large" value="Save Role" /> <a class="btn" href="">Cancel</a>-->
					</div>					
				</fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php  include_once 'adminfooter.tpl.php'; ?>