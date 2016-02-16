<?php  include_once 'adminheader.tpl.php'; ?>


<div class="span12">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Users <small>All Users</small></h1>
			</div>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>昵称</th>
						<th>openid</th>
						<th>微信昵称</th>
                        <th style="text-align:center;">发表的文章数</th>
						<th>创建时间</th>
						<th style="text-align:center;">网站权限属性</th>
						<th>用户操作</th>
					</tr>
				</thead>
				<tbody>
                <?php foreach($userList as $user){?>
				<tr class="list-users">
					<td><?php echo $user['id'];?></td>
					<td><a href="<?php echo Route('admin/article_my/'.$user['id']);?>"><?php echo $user['username'];?></a></td>
                    <td><?php echo $user['openid'];?></td>
					<td><?php echo $user['wxname'];?></td>
                    <td style="text-align:center;"><a href="<?php echo Route('admin/article_my/'.$user['id']);?>" class="badge badge-inverse"><?php echo $user['count'];?></a></td>
					<td><?php echo date('Y-m-d H:i:s', $user['ctime']);?></td>
                    <td style="text-align:center;"><span class="label label-<?php echo ($user['is_admin']=='1'? 'success':'important'); ?>"><?php echo ($user['is_admin']=='1'? '有':'无');echo ($user['is_block']=='1'? ' | 拉黑':'');?></span></td>
					<td>
						<div class="btn-group">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Actions <span class="caret"></span></a>
							<ul class="dropdown-menu">
                                <li><a href="<?php echo Route('admin/user_'.($user['is_block']=='0'? 'block':'unblock').'/'.$user['id']);?>"><i class="icon-lock"></i> <?php echo ($user['is_block']=='0'? 'block':'unblock');?></a></li>
								<li><a href="javascript:if(confirm('确定吗？'))window.location='<?php echo Route('admin/user_delete/'.$user['id']);?>'"><i class="icon-trash"></i> Delete</a></li>
								<li class="nav-header">Hello Alice</li>
                                <?php if($user['email']) echo "<li><a onclick=showemail('".$user['email']."');><i class=\"icon-lock\"></i><strong> Look Email</strong></a></li>"; ?>
							</ul>
						</div>
					</td>
			    </tr>
                <?php }?>
			   </tbody>
			</table>
              <?php echo $pageNav ?>
              <a href="<?php echo Route('admin/user_add'); ?>" class="btn btn-success">添加用户</a>
		  </div>
        </div>
      </div>
<script src="<?php echo JS_DIR?>jquery.js"></script>
<script type="text/javascript">
    
    function showemail(email){ 
         alert("他的邮箱是"+email);   
    }
    
</script>
<?php  include_once 'adminfooter.tpl.php'; ?>