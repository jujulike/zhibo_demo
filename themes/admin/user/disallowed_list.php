<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">禁言用户</div>
  <!-------- 个人会员列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="line_l" width="30px">ID</th>
	<th class="line_l" width="120px">用户名</th>
	<th class="line_l" width="120px">状态</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($userlist)) {?>
	  <?php foreach ($userlist as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
		<td><?php echo $v['userid']; ?></td>
		<td><?php echo $v['username']; ?></td>
		<td><?php if ($v['cannotchat'] == '1') {?><span style="color:red">禁言</span><?php } else {?>已激活<?php }?></td>
	    <td>
			<?php if ($v['cannotchat'] == '1') {?><a href="javascript:canChat(<?php echo $v['id']; ?>);" class="sgbtn">激活</a><?php }?></td>
		</tr>
		<?php } }?>
		</form>
	</table>
  </div>
<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>

  <div class="Toolbar_inbox">
  	<div class="page right"></div>
  </div>
<script type="text/javascript">
function canChat(id)
{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/user/canChat');?>"+"/"+id, 
			function(d){
				var data = eval('('+d+')');
				if (data.code == '1')
				{
					jBox.tip(data.msg, 'success');
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

	$.jBox.confirm("确定激活该禁言用户吗？", "提示", submit);

}

</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
