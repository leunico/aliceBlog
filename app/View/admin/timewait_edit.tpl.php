<?php  include_once 'adminheader.tpl.php'; ?>


<script type="text/javascript">
    $(document).ready(function(){
        //arts('add');onsubmit="return arts('add')" 
    });
</script>
<div class="span9">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Edit TimeWait Diary <small>Edit TimeWait Diary</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/timewait_edit/'.$timewaits['id']); ?>" method="post" enctype="multipart/form-data">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="role">排序：</label>
						<div class="controls">
							<input type="text" style="width:50px" class="input-xlarge" id="role" name="order" value="<?php echo $timewaits['order']; ?>" /><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">样式：</label>
						<div class="controls">
                            <input type="text" class="input-xlarge" id="role" name="classfa" value="<?php echo $timewaits['classfa']; ?>"/><a style="margin-left:5px;" target="_blank" href="http://www.yeahzan.com/fa/facss.html">在这选</a>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">头像图：</label>
						<div class="controls">
							<input type="file" accept="image/png,image/jpeg" class="input-xlarge" style="width:200px" name="img" id="toux" onchange="javascript:setImageToux(60,60);"/>         
					</div>
                        <div class="control-group" style="margin-bottom:8px;">
                        <div class="controls">
                            <div class="timeline-img" id="localImag" ><img style="display:block;" id="preview" width=-1 height=-1/ src="<?php echo $timewaits['img']; ?>"></div>
                        </div>  
                    </div>
                    <div class="control-group">
						<label class="control-label" for="description">记录内容：</label>
						<div class="controls">
							<textarea class="input-xlarge" id="description" rows="3" name="content"><?php echo $timewaits['content']; ?></textarea><span class="validform"></span>
						</div>
					</div>
                    <div class="control-group">
						<label class="control-label" for="role">记录时间：</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="role" name="time" value="<?php echo $timewaits['time']; ?>"/><span class="validform"></span>
						</div>
					</div>                    
					<div class="form-actions">
                            <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Edit Diary</button>
                            <button type="reset" class="btn">Cancel</button>
				    <!--<input type="submit" class="btn btn-success btn-large" value="Save Role" /> <a class="btn" href="">Cancel</a>-->
					</div>					
				</fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php  include_once 'adminfooter.tpl.php'; ?>