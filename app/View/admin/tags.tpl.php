<?php  include_once 'adminheader.tpl.php'; ?>


<div class="span12">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Tags <small>All Tags</small></h1>
			</div>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>名称</th>
                        <th style="text-align:center;">出现次数</th>
                        <th width="440">用户操作<span style="color:red;"><b> * 删除文章标签会把标签变成‘杂文’！</b></span></th>
					</tr>
				</thead>
				<tbody>
                <?php foreach($tagList as $tag){?>
				<tr class="list-users">
					<td><?php echo $tag['id'];?></td>
					<td><a href="<?php echo Route('');?>"><?php echo $tag['tag'];?></a></td>
                    <td style="text-align:center;"><a href="<?php echo Route('');?>" class="badge badge-inverse"><?php echo $tag['num'];?></a></td>
					<td>
						<div class="btn-group">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Actions <span class="caret"></span></a>
							<ul class="dropdown-menu">
                                <li><a href="<?php echo Route('admin/tag_edit/'.$tag['id']);?>"><i class="icon-lock"></i> Edit</a></li>
                                <li><a href="<?php echo Route('admin/tag_delete/'.$tag['id']);?>"><i class="icon-trash"></i> Delete</a></li>
								<li class="nav-header">Hello Alice</li>
							</ul>
						</div>
					</td>
			    </tr>
                <?php }?>
			   </tbody>
			</table>
              <?php echo $pageNav ?>
		  </div>
        </div>
      </div>

<?php  include_once 'adminfooter.tpl.php'; ?>