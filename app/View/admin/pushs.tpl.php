<?php include_once 'adminheader.tpl.php' ?>




<div class="span12">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Push <small>Edit Push</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/pushs'); ?>" method="POST" enctype="multipart/form-data">
                  <div class='push'>
                      <ul>
                          <?php foreach($pushs as $push){?>
                          <li>
                              <div class="control-push">
                                  <label class="push-label" for="role">链接-<?php echo $push['id'] ?>：</label>
                                  <div class="push-controls">
                                      <input type="text" class="input-push" style="width:200px" id="role" name="pushurl[]" value="<?php echo $push['pushurl'] ?>"/>
                                  </div>
                              </div>
                              <div class="control-push">
                                  <label class="push-label" for="role">图片链接：</label>
                                  <div class="push-controls">
                                      <input type="text" class="input-push" readOnly="true" style="width:200px" id="role" name="pushimg[]" value="<?php echo $push['pushimg']; ?>"/>
                                  </div>
                              </div>
                              <div class="control-push">
                                  <div class="push-controls">
                                      <input type="file" accept="image/png,image/jpeg" class="input-push" style="width:200px" name="doc[]" id="doc-<?php echo $push['id'] ?>" onchange="javascript:setImagePreview(<?php echo $push['id'] ?>);"/>
                                  </div>
                              </div>
                              <div class="push-controls" id="localImag-<?php echo $push['id'] ?>" style="padding:5px;"><img id="preview-<?php echo $push['id'] ?>" width=-1 height=-1 src="<?php echo $push['pushimg']; ?>" /></div>
                          </li>
                          <?php }?>
                      </ul><div style="clear:both;"></div>
                   </div>	
                  <fieldset>      
                   <div class="form-actions">
                       <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Edit Push</button>
                       <button type="reset" class="btn">Cancel</button><span style="color:red;margin-left:9px">注意：图片的规格最好是810px*200px！</span>
                   </div>
                  </fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php include_once 'adminfooter.tpl.php' ?>