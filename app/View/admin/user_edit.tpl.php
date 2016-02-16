<?php include_once 'adminheader.tpl.php' ?>

<script type="text/javascript">
    $(document).ready(function(){
       regs('edit'); 
    });
</script>
<div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Edit User <small>Edit a User</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/user_edit/'); ?>" method="post" onsubmit="return regs('edit')">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="role">昵称：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="username" value="<?php echo $users['username'] ?>"/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">邮箱：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="email" value="<?php echo $users['email'] ?>"/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">openid：</label>
						<div class="controls">
                            <input type="text" readOnly="true" class="input-xlarge" id="role" name="openid" value="<?php echo ($users['openid'] ? $users['openid']:"Not wechat"); ?>"/>
						</div>
					</div>                    
                    <div class="control-group">
						<label class="control-label" for="role">微信昵称：</label>
						<div class="controls">
                            <input type="text" readOnly="true" class="input-xlarge" id="role" name="wxname" value="<?php echo ($users['wxname'] ? $users['wxname']:"Not wechat"); ?>"/>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">原密码：</label>
						<div class="controls">
                            <input type="password" class="input-xlarge" id="role" name="oldpw" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">新密码：</label>
						<div class="controls">
                            <input type="password" class="input-xlarge" id="role" name="newpw" value=""/><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">重复新密码：</label>
						<div class="controls">
                            <input type="password" class="input-xlarge" id="role" name="newpw_a" value=""/><span class="validform"></span>
						</div>
					</div>
                    <!--<div class="control-group">
						<label class="control-label" for="active">只改昵称：</label>
						<div class="controls">
							<input type="checkbox" name='top' id="active" value="1"/>
						</div>
					</div>-->
                    <p  class="controls" style="color:red;">注意：如果只改昵称和邮箱，请不要填写密码这三项</p>
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