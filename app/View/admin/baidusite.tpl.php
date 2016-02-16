<?php include_once 'adminheader.tpl.php' ?>




<div class="span12">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>BaiduPush <small>Baidu Push</small></h1>
			</div>
              <form class="form-horizontal" action="<?php echo Route('admin/go_baidu'); ?>" method="POST">
                  <div class='push'>
                      <ul>
                          <li>
                              <div class="control-push">
                                  <label class="push-label" for="role">文章链接：</label>
                                  <div class="push-controls">
                                      <input type="text" class="input-push" style="width:200px" id="role" name="pushbaidu[]" value=""/>
                                  </div>
                              </div>
                              <div class="control-push">
                                  <label class="push-label" for="role">链接二：</label>
                                  <div class="push-controls">
                                      <input type="text" class="input-push" style="width:200px" id="role" name="pushbaidu[]" value=""/>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <div class="control-push">
                                  <label class="push-label" for="role">链接三：</label>
                                  <div class="push-controls">
                                      <input type="text" class="input-push" style="width:200px" id="role" name="pushbaidu[]" value=""/>
                                  </div>
                              </div>
                              <div class="control-push">
                                  <label class="push-label" for="role">链接四：</label>
                                  <div class="push-controls">
                                      <input type="text" class="input-push" style="width:200px" id="role" name="pushbaidu[]" value=""/>
                                  </div>
                              </div>
                          </li>
                      </ul><div style="clear:both;"></div>
                   </div>	
                  <fieldset>      
                   <div class="form-actions">
                       <button type="submit" class="btn btn-success btn-large" name="dosubmit" value="dosubmit">Baidu Push</button>
                       <button type="reset" class="btn">Cancel</button><span style="color:red;margin-left:9px">注意：每天推送有数量限制！</span>
                   </div>
                  </fieldset>
			</form>
		  </div>
        </div>
      </div>



<?php include_once 'adminfooter.tpl.php' ?>