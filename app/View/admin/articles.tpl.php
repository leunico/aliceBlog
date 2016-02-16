<?php  include_once 'adminheader.tpl.php'; ?>


<div class="span12">
		  <div class="row-fluid">
			<div class="page-header">
				<h1>Articles <small>All Articles</small></h1>
			</div>
            <div> 
                <form class="form-horizontal" action="<?php echo Route('admin/articles'); ?>" method="post">
				<fieldset>
                  <input type="text" style="width:120px" class="input-xlarge" id="role" name="keyword" placeholder="标题的关键字" value="<?php echo $scree['keyword']; ?>"/> 
                  <select name="num" style="width:120px">
                            <option value="ctime" >排序方式</option>
                            <option value="clicks" <?php if($scree['num']=='clicks') echo "selected";?>>点击量</option>
                            <option value="count" <?php if($scree['num']=='count') echo "selected";?>>评论数</option>
                            <option value="good_num" <?php if($scree['num']=='good_num') echo "selected";?>>赞的次数</option>
                            <option value="bad_num" <?php if($$scree['num']=='bad_num') echo "selected";?>>拍砖次数</option>
                  </select>
                    <select name="recommend_type" style="width:120px">
                            <option value="" >推荐类型</option>
                            <option value="2" <?php if($scree['recommend_type']=='2') echo "selected";?>>首页推荐</option>
                            <option value="1" <?php if($scree['recommend_type']=='1') echo "selected";?>>全站推荐</option>
                            <option value="3" <?php if($scree['recommend_type']=='3') echo "selected";?>>置顶</option>
                  </select>
                  <button type="submit" class="btn btn-success" name="dosubmit" value="dosubmit">筛选</button>
                </fieldset>
			    </form>
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
                <?php $meun = getClass('article_class');foreach($ArticleList as $article){?>
				<tr class="list-users">
					<td><?php echo $article['id'];?></td>
					<td><a href="<?php echo Route('admin/article_my/'.$article['uid']);  ?>"><?php echo $article['author'];?></a></td>
                    <td><a href="<?php echo Route('articleshow/'.$article['id']);  ?>" target="_blank"><?php echo $article['title'];?></a></td>
                    <td style="text-align:center;">
                        <span class="label label-<?php echo ($article['recommend_type']=='1' ? 'important':'success') ?>">
                        <?php echo $article['recommend_type'] == 0 ? '无推荐': ($article['recommend_type'] == '1' ? '全站推荐':'首页推荐'); echo $article['top'] ? ' | 置顶':''; ?>
                        </span>
                    </td>
                    <td><a href="#"><?php echo $meun[$article['mid']];?></a></td>
					<td><?php echo date('Y-m-d H:i:s', $article['ctime']);?></td>
					<td><span class="badge badge-inverse"><?php echo $article['clicks'];?></span></td>
                    <td><a href="<?php echo Route('admin/comments/?aid='.$article['id']);?>"><span class="badge badge-inverse"><?php echo $article['count'];?></span></a></td>
                    <td><span class="label label-success"><?php echo $article['good_num'];?></span></td>
                    <td><span class="label label-important"><?php echo $article['bad_num'];?></span></td>
					<td>
						<div class="btn-group">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Actions <span class="caret"></span></a>
							<ul class="dropdown-menu">
                                <li><a href="<?php echo Route('admin/article_edit/'.$article['id']);?>"><i class="icon-pencil"></i> Edit</a></li>
								<li><a href="javascript:if(confirm('确定吗？'))window.location='<?php echo Route('admin/article_delete/'.$article['id']);?>'"><i class="icon-trash"></i> Delete</a></li>
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