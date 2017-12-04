<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">VIP申请会员</div>
  <!-------- 个人会员列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a  class="btn_a"  onclick="del_app()"><span>删除申请</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" width="30px">ID</th>
	<th class="line_l" width="120px">用户名</th>
	<th class="line_l" width="120px">姓名</th>
	<th class="line_l" width="120px">QQ</th>
	<th class="line_l" width="150px">电话</th>
	<th class="line_l" width="200px">要申请VIP的直播室</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="userid[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['userid']; ?>"></td>
		<td><?php echo $v['userid']; ?></td>
		<td><?php echo $v['username']; ?></td>
		<td><?php echo $v['name']; ?></td>
		<td><?php echo $v['qq']; ?></td>
		<td><?php echo $v['phone']; ?></td>
		<td><?php if (empty($v['roominfo'])) { ?>该直播室已关闭<?php } else {echo $v['roominfo']['roomname']; }?></td>
	    <td>
			<a href="javascript:modi(<?php echo $v['userid']; ?>);" class="sgbtn">信息详情</a>&nbsp;&nbsp;
			<a href="javascript:setLevel(<?php echo $v['userid']; ?>)" class="sgbtn">设置VIP</a>&nbsp;&nbsp;
			<a href="javascript:delAppVip(<?php echo $v['userid']; ?>);" class="sgbtn">删除申请</a></td>
			</tr>
		<?php } }?>
		</form>
	</table>
  </div>

<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>

  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a  class="btn_a"  onclick="del_app()"><span>删除申请</span></a>
  </div>
<script type="text/javascript">
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
			$('input[name="userid[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="userid[]"]').removeAttr('checked');
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

function setLevel(userid)
{
	$.jBox.open('iframe:<?php echo site_url("admin/user/setLevel");?>' + "/" + userid, "用户等级设置", 500, 420, { buttons: { '关闭': true} });
}

function modi(userid)
{
	$.jBox.open('iframe:<?php echo site_url("admin/user/modi");?>' + "/" + userid, "用户信息修改", 500, 440, { buttons: { '关闭': true} });
}

function delAppVip(userid)
{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/user/delVipapp');?>"+"/"+userid, 
			function(d){
				var data = eval('('+d+')');
				if (data.code == '1')
				{
					jBox.tip(data.msg, 'success');
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

	$.jBox.confirm("确定删除这个申请信息吗？", "提示", submit);

}

function del_app()
{
	postdata('form1', "<?php echo site_url('admin/user/del_app');?>", 'wshow');
}


</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
