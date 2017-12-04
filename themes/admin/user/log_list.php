<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">操作日志列表</div>
  <!-------- 企业会员列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a  class="btn_a"  onclick="clearlog()"><span>清空日志</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="line_l" width="50px">ID</th>
	<th class="line_l" width="150px">操作日期</th>
	<th class="line_l" width="100px">用户类别</th>
	<th class="line_l" width="100px">用户名</th>
	<th class="line_l" width="100px">IP</th>
    <th class="line_l">操作日志</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
		<td><?php echo $v['logid']; ?></td>
		<td><?php echo date("Y-m-d H:i:s",$v['ctime']); ?></td>
		<td><?php if ($v['isadmin'] == '1') {?>管理员<?php } else if ($v['isadmin'] == '2') {?>用户<?php }?></td>
		<td><?php echo @$v['username']; ?></td>
		<td><?php echo $v['ip']; ?></td>
		<td><?php echo $v['info']; ?></td>
	  
	 </tr>
		<?php } }?>
		</form>
	</table>
  </div>

<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>

  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a  class="btn_a"  onclick="clearlog()"><span>清空日志</span></a>
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



	function clearlog()
	{
		postdata('form1', "<?php echo site_url('actionlog/clearlog');?>", 'show');
	}
</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>