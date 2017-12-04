<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">管理员列表</div>
  <!-------- 企业会员列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a href="<?php echo site_url('admin/adminuser/add_user');?>" class="btn_a"><span>添加管理员</span></a>
	<a  class="btn_a"  onclick="del_admin()"><span>删除管理员</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" width="30px">ID</th>
	<th class="line_l" width="100px">用户名</th>
	<th class="line_l" width="150px">Email地址</th>
	<th class="line_l" width="150px">加入时间</th>
	<th class="line_l" width="150px">最后登录时间</th>
	<th class="line_l" width="100px">权限组</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="user_id[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['user_id']; ?>"></td>
		<td><?php echo $v['user_id']; ?></td>
		<td><?php echo $v['user_name']; ?></td>
		<td><?php echo $v['email']; ?></td>
		<td><?php echo date("Y-m-d H:i:s",$v['add_time']); ?></td>
		<td><?php if ($v['last_login'] != '0' || $v['last_login'] != '') { echo date("Y-m-d H:i:s",$v['last_login']);} ?></td>
		<td><?php if ($v['role_id'] == '') { echo "超级管理员"; } else {echo $v['role_name'];} ?></td>
	    <td>
			<!--<?php if ($v['role_id'] != '') {?><a href="<?php echo site_url('admin/user/edit_company_member' .'/' . $v['user_id'])?>">分派权限</a><?php }?>-->
			<a href="<?php echo site_url('admin/adminuser/edit_user' .'/' . $v['user_id'])?>">编辑</a>
			<a href="javascript:del_one_user(<?php echo $v['user_id']; ?>);">删除</a>
					</td>
			</tr>
		<?php } }?>
		</form>
	</table>
  </div>

<!--<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>-->

  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a href="<?php echo site_url('admin/adminuser/add_user');?>" class="btn_a"><span>添加管理员</span></a>
	<a  class="btn_a"  onclick="del_admin()"><span>删除管理员</span></a>
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
			$('input[name="user_id[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="user_id[]"]').removeAttr('checked');
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

		//删除
	function del_one_user(user_id)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/adminuser/del_one_user');?>"+ "/" +user_id, 
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

	$.jBox.confirm("确定删除该管理员吗？", "提示", submit);

}

	function del_admin()
	{
		postdata('form1', "<?php echo site_url('admin/adminuser/del_user');?>", 'wshow');
	}

</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>