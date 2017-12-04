<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">新闻资讯管理</div>
  <!-------- 搜索用户 -------->
  <!--
  <div id="searchUser_div" style="display:none;">
  	<div class="page_tit">搜索资讯 [ <a href="javascript:void(0);" onclick="searchUser();">隐藏</a> ]</div>
	
	<div class="form2">
	<form method="post" action="<?php echo site_url("admin/user/searchUser");?>">
	<dl class="lineD">
      <dt>分类名称</dt>
      <dd>
        <input name="catename" id="catename" type="text" value="">
        <p>多个时使用英文的","分割</p>
      </dd>
    </dl>
    <div class="page_btm">
      <input type="submit" class="btn_b" value="确定" />
    </div>
	</form>
  </div>
  </div>
  -->
  <!-------- 广告列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a href="<?php echo site_url('admin/article/add')?>" class="btn_a"><span>添加新闻资讯</span></a>
	<!--<a href="javascript:void(0);" class="btn_a" onclick="searchUser();">
		<span class="searchUser_action">搜索资讯</span>
	</a>
	-->
	<a  class="btn_a"  onclick="delMoreArticle()"><span>删除新闻资讯</span></a>
	<a href="<?php echo site_url('admin/category/tlist/article')?>" class="btn_a"><span>分类列表</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" width="50px">ID</th>
	<th class="line_l" width="200px">分类名称</th>
    <th class="line_l" width="300px">标题</th>
	<th class="line_l" width="100px">创建时间</th>
	<th class="line_l" width="50px">排序</th>
    <th class="line_l" width="50px">状态</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="articleid[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['articleid']; ?>"></td>
			    <td><?php echo $v['articleid']; ?></td>
	    <td><?php if (!empty($v['cateinfo'])) echo $v['cateinfo']['catename']; ?></td>
	    <td><?php echo $v['title']; ?></td>
		<td><?php echo date('Y-m-d',$v['ctime']); ?></td>
		<td><?php echo $v['sort']; ?></td>
	    <td><?php if ($v['status'] == '1') { ?><B>激活</B><?php } else { ?><B style="color:red">未激活</B><?php } ?></td>
	    <td>
			<a href="<?php echo site_url('admin/article/editArticle' .'/' . $v['articleid'])?>">编辑</a>
				<a href="javascript:copyArticle(<?php echo $v['articleid']; ?>);">复制</a>
			<a href="javascript:delArticle(<?php echo $v['articleid']; ?>);">删除</a>
					</td>
			</tr>
		<?php }?>
		</form>
	</table>
  </div>
<td colspan="9"><div class="page">记录:<?php echo $pagecount; ?> 条&nbsp;&nbsp;<?php echo $page;?></div></td>

  <div class="Toolbar_inbox">
	<div class="page right"></div>
	<a href="<?php echo site_url('admin/article/add')?>" class="btn_a"><span>添加新闻资讯</span></a>
	<!--<a href="javascript:void(0);" class="btn_a" onclick="searchUser();">
		<span class="searchUser_action">搜索资讯</span>
	</a>
	-->
	<a  class="btn_a"  onclick="delMoreArticle()"><span>删除新闻资讯</span></a>
	<a href="<?php echo site_url('admin/category/tlist/article')?>" class="btn_a"><span>分类列表</span></a>
  </div>
</div>
<script>
	//鼠标移动表格效果
	$(document).ready(function(){
		$("tr[overstyle='on']").hover(
		  function () {
		    $(this).addClass("bg_hover");
		  },
		  function () {
		    $(this).removeClass("bg_hover");
		  }
		);
	});
	
	function checkon(o){
		if( o.checked == true ){
			$(o).parents('tr').addClass('bg_on') ;
		}else{
			$(o).parents('tr').removeClass('bg_on') ;
		}
	}
	
	function checkAll(o){
		if( o.checked == true ){
			$('input[name="articleid[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="articleid[]"]').removeAttr('checked');
			$('tr[overstyle="on"]').removeClass("bg_on");
		}
	}

	//获取已选择用户的ID数组
	function getChecked() {
		var uids = new Array();
		$.each($('table input:checked'), function(i, n){
			uids.push( $(n).val() );
		});
		return uids;
	}

	//转移部门
	function changeDepartment(uids) {
		var uids = uids ? uids : getChecked();
		uids = uids.toString();
		if(!uids) {
			ui.error('请先选择用户');
			return false;
		}

		if(!confirm('转移成功后，已选择用户原来的部门信息将被覆盖，确定继续？')) return false;
		
		ui.box.load("http://abc.91mp.com/demo/sns/thinksns/index.php?app=admin&mod=User&act=changeDepartment&uids="+uids, {title:'转移部门'});
	}
	
	//转移用户组
	function changeUserGroup(uids) {
		var uids = uids ? uids : getChecked();
		uids = uids.toString();
		if(!uids) {
			ui.error('请先选择用户');
			return false;
		}

		if(!confirm('转移成功后，已选择用户原来的用户组信息将被覆盖，确定继续？')) return false;
		
		ui.box.load("http://abc.91mp.com/demo/sns/thinksns/index.php?app=admin&mod=User&act=changeUserGroup&uids="+uids, {title:'转移用户组'});
	}
	
	//搜索用户
	var isSearchHidden = 1;
	function searchUser() {
		if(isSearchHidden == 1) {
			$("#searchUser_div").slideDown("fast");
			$(".searchUser_action").html("搜索完毕");
			isSearchHidden = 0;
		}else {
			$("#searchUser_div").slideUp("fast");
			$(".searchUser_action").html("搜索用户");
			isSearchHidden = 1;
		}
	}
	
	function folder(type, _this) {
		$('#search_'+type).slideToggle('fast');
		if ($(_this).html() == '展开') {
			$(_this).html('收起');
		}else {
			$(_this).html('展开');
		}
		
	}

	// 添加
	function add() {
//	$.jBox("get:<?php echo site_url('admin/user/add')?>");
	$.jBox("iframe:<?php echo site_url('admin/article/add')?>", {
			title: "资讯添加",
			iframeScrolling: 'auto',
			height: 600,
			width: 550,
			buttons: { '关闭': true }
		});
		}

	//编辑
	function editAdvertisement(articleid)
	{
		$.jBox.open('iframe:<?php echo site_url("admin/article/editArticle");?>'+"/"+advertid, "资讯修改", 550, 600, { buttons: { '关闭': true} });
	}

	//复制
	function copyArticle(articleid)
	{
			$.get("<?php echo site_url('admin/article/copyArticle');?>"+"/"+articleid, 
			function(d){
				var data = eval('('+d+')');
				if (data.code == '1')
				{
					location.reload();
				}
				else
				{
					jBox.tip(data.msg, 'error');
				}
			});
	}

	//删除
	function delArticle(articleid)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/article/delArticle');?>"+"/"+articleid, 
			function(d){
				var data = eval('('+d+')');
				if (data.code == '1')
				{
//					jBox.tip(data.msg, 'success');
//					jBox.tip(data.msg, 'success');
					location.reload();
				}
				else
				{
					jBox.tip(data.msg, 'error');
				}
			});
		else if (v == 'cancel')
//			jBox.tip(v, 'info');
		return true; //close
	};

	$.jBox.confirm("确定删除该资讯吗？", "提示", submit);

}

	function delMoreArticle()
	{
		postdata('form1', "<?php echo site_url('admin/article/delMoreArticle');?>", 'wshow');
	}

</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>