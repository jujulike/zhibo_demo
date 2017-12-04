<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">分类管理</div>
  <!-------- 搜索用户 -------->  
  <!-------- 导航列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a href="javascript:void(0);" class="btn_a" onclick="add('<?php echo $func ?>','<?php echo $alias?>');"><span>添加分类</span></a>
	<a  class="btn_a"  onclick="delMore('<?php echo $func ?>')"><span>删除分类</span></a>
	<?php if ($func == 'advertising') {?>
	<a href="<?php echo site_url('admin/advertisement/tlist/' . $alias)?>" class="btn_a" ><span>返回列表</span></a>
	<?php } else if (($func != 'live') && ($func != 'menu')) {?>
	<a href="<?php echo site_url('admin/' . $func)?>" class="btn_a" ><span>返回列表</span></a>
	<?php }?>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" style="80px" width="50px">ID</th>
    <th class="line_l" style="300px">分类名称</th>
    <th class="line_l">应用对象</th>
    <th class="line_l">标识别名</th>
	<th class="line_l">排序</th>
    <th class="line_l">状态</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="cateid[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['cateid']; ?>"></td>
			    <td><?php echo $v['cateid']; ?></td>
	    <td><?php echo str_repeat('&nbsp;', ($v['level']) * 6)?><?php echo $v['catename']?></td>
	    <td><?php echo $v['func']?></td>
	    <td><?php echo $v['alias']?></td>
		<td><?php echo $v['sort']?></td>
	    <td><?php if ($v['status'] == '1') { ?><B>激活</B><?php } else { ?><B style="color:red">未激活</B><?php } ?></td>
	    <td>
			<a href="javascript:edit(<?php echo $v['cateid']; ?>,'<?php echo $func ?>','<?php echo $alias?>');">编辑</a>
			<a href="javascript:del(<?php echo $v['cateid']; ?>,'<?php echo $func ?>');">删除</a>
			<?php if ($func == 'live') {?><a href="<?php echo site_url('admin/liveroom/tlist/'.$v['cateid'])?>">管理直播室</a><?php }?>
					</td>
			</tr>
		<?php }?>
		</form>
	</table>
  </div>

  <div class="Toolbar_inbox">
	<div class="page right"></div>
	<a href="javascript:void(0);" class="btn_a" onclick="add('<?php echo $func ?>','<?php echo $alias?>');"><span>添加分类</span></a>
	<a  class="btn_a"  onclick="delMore('<?php echo $func ?>')"><span>删除分类</span></a>
	<?php if ($func == 'advertising') {?>
	<a href="<?php echo site_url('admin/advertisement/tlist/' . $alias)?>" class="btn_a" ><span>返回列表</span></a>
	<?php } else if (($func != 'live') && ($func != 'menu')) {?>
	<a href="<?php echo site_url('admin/' . $func)?>" class="btn_a" ><span>返回列表</span></a>
	<?php }?>
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
			$('input[name="cateid[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="cateid[]"]').removeAttr('checked');
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
	
	//搜索用户
	var isSearchHidden = 1;
	function searchUser() {
		if(isSearchHidden == 1) {
			$("#searchUser_div").slideDown("fast");
			$(".searchUser_action").html("搜索完毕");
			isSearchHidden = 0;
		}else {
			$("#searchUser_div").slideUp("fast");
			$(".searchUser_action").html("搜索分类");
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
	function add(func,alias) {
//	$.jBox("get:<?php echo site_url('admin/user/add')?>");
	$.jBox("iframe:<?php echo site_url('admin/category/add')?>" + "/" + func+"/"+alias, {
			title: "",
			iframeScrolling: 'auto',
			height: 440,
			width: 350,
			buttons: { '关闭': true }
		});
}

	//编辑
	function edit(cateid,func,alias)
	{
		$.jBox("iframe:<?php echo site_url('admin/category/modi')?>" + "/" + cateid + "/" + func+"/"+alias, {
			title: "",
			iframeScrolling: 'auto',
			height: 440,
			width: 350,
			buttons: { '关闭': true }
		});
	}

	//删除
	function del(cateid,func)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.ajax({
				url: "<?php echo site_url('admin/category/del');?>"+"/"+cateid+"/"+func, 
				dataType: "json",
				success:function(data){
					if (data.code == '1')
					{
						$.jBox.tip(data.msg, 'success');
						window.setTimeout(function () {
							window.location.reload();
						}, 1000);
					}
					else
					{
						jBox.tip(data.msg, 'error');
					}
					}
			});
		else if (v == 'cancel')
//			jBox.tip(v, 'info');
		return true; //close
	};

	$.jBox.confirm("确定删除该分类吗？", "提示", submit);

}

	function delMore(func)
	{
		postdata('form1', "<?php echo site_url('admin/category/delMore');?>"+"/"+func, 'wshow');
	}


</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>