<?php  include_once 'adminheader.tpl.php'; ?>


<div class="span12">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>TimeWait Diary <small>TimeWait a Diary</small></h1>
			</div>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th style="text-align:center;">排序</th>
						<th>样式</th>
						<th>头像图</th>
                        <th style="width:250px;">记录内容</th>
                        <th>记录时间</th>
						<th>创建时间</th>
                        <th>操作</th>
					</tr>
				</thead>
				<tbody>
                <?php foreach($timewaitList as $timewait){?>
				<tr class="list-users center">
                    <td style="text-align:center;"><a href="javascript:void(0)" onclick="order(<?php echo $timewait['id']; ?>,'-')"><i class='icon-minus' style="margin-top:3px;"></i></a> <?php echo "<span id=\"order-".$timewait['id']."\">".$timewait['order']."</span>";?> <a href="javascript:void(0)" onclick="order(<?php echo $timewait['id']; ?>,'+')"><i class='icon-plus' style="margin-top:3px;"></i></a></td>
                    <td><?php echo $timewait['classfa'];?></td>
                    <td><div class="timeline-img" ><img style="display:block;" src="<?php echo $timewait['img'];?>"/></div></td>					
                    <td style="line-height:normal;word-wrap:break-word;word-break:break-all;"><?php echo $timewait['content'];?></td>
                    <td><?php echo $timewait['time'];?></td>
					<td><?php echo date('Y-m-d H:i:s', $timewait['ctime']);?></td>
					<td>
                        <div class="btn-group" style="margin-top:20px;">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Actions <span class="caret"></span></a>
							<ul class="dropdown-menu">
                                <li><a href="<?php echo Route('admin/timewait_edit/'.$timewait['id']);  ?>"><i class="icon-pencil"></i> Edit</a></li>
								<li><a href="<?php echo Route('admin/timewait_delete/'.$timewait['id']);  ?>"><i class="icon-trash"></i> Delete</a></li>
								<li class="nav-header">Hello Alice</li>
							</ul>
						</div>
					</td>
				</tr>
                <?php }?>
			  </tbody>
			</table>
            <?php echo $pageNav ?>
            <a href="<?php echo Route('admin/timewait_add'); ?>" class="btn btn-success">添加时光记录</a>
		  </div>
        </div>
      </div>



<?php  include_once 'adminfooter.tpl.php'; ?>