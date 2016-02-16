<?php  include_once 'adminheader.tpl.php'; ?>


<div class="span12">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Personal Articles <small>Personal a Articles</small></h1>
			</div>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>Author</th>
						<th>文章标题</th>
						<th style="text-align:center;">推荐类型</th>
						<th>所属分类</th>
                        <th>创建时间</th>
						<th>点击数</th>
                        <th>评论数</th>
                        <th>赞</th>
						<th>拍砖</th>
						<th>文章操作</th>
					</tr>
				</thead>
				<tbody>
                <?php foreach($ArticleList as $article){?>
				<tr class="list-users">
					<td><?php echo $article['id'];?></td>
					<td><?php echo $article['author'];?></td>
                    <td><a href="<?php echo Route('articleshow/'.$article['id']);  ?>" target="_blank"><?php echo $article['title'];?></a></td>
                    <td style="text-align:center;">
                        <span class="label label-<?php echo ($article['recommend_type']=='1' ? 'important':'success') ?>">
                        <?php echo $article['recommend_type'] == 0 ? '无推荐': ($article['recommend_type'] == '1' ? '全站推荐':'首页推荐'); echo $article['top'] ? ' | 置顶':''; ?>
                        </span>
                    </td>					
                    <td><a href="#"><?php echo $article['mid'];?></a></td>
					<td><?php echo date('Y-m-d H:i:s', $article['ctime']);?></td>
					<td><p><a href="users.html" class="badge badge-inverse"><?php echo $article['clicks'];?></a></p></td>
                    <td><a href="<?php echo Route('admin/comments/?aid='.$article['id']);?>"><span class="badge badge-inverse"><?php echo $article['count'];?></span></a></td>
                    <td><span class="label label-success"><?php echo $article['good_num'];?></span></td>
                    <td><span class="label label-important"><?php echo $article['bad_num'];?></span></td>
					<td>
						<div class="btn-group">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Actions <span class="caret"></span></a>
							<ul class="dropdown-menu">
                                <li><a href="<?php echo Route('admin/article_edit/'.$article['id']);  ?>"><i class="icon-pencil"></i> Edit</a></li>
								<li><a href="<?php echo Route('admin/article_delete/'.$article['id']);  ?>"><i class="icon-trash"></i> Delete</a></li>
								<li class="nav-header">Hello Alice</li>
							</ul>
						</div>
					</td>
				</tr>
                <?php }?>
			  </tbody>
			</table>
            <?php echo $pageNav ?>
            <a href="<?php echo Route('admin/article_add'); ?>" class="btn btn-success">添加文章</a>
		  </div>
        </div>
      </div>



<?php  include_once 'adminfooter.tpl.php'; ?>