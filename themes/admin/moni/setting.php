<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/DatePicker/WdatePicker.js"></script>
<div class="so_main">
  <div class="page_tit">虚拟人参数设置</div>
  <div class="list">
  <form id="form1" name="form1" action="" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="line_l" width="20%"></th>
	<th class="line_l" width="20%">开启虚拟人</th>
	<th class="line_l" width="20%">登录时间</th>
	<th class="line_l" width="20%">登出时间</th>
	<th class="line_l" width="20%">虚假人数量</th>
	  </tr>
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on'>
		<td><?php echo $v['name']; ?></td>
	  	<td><label>开启<input type="checkbox" name="id_<?php echo $v['id'] ?>" value="<?php echo $v['id']; ?>" <?php if (@$v['open'] == '1') { ?>checked<?php } ?>></label></td>
		<td><input name="btime_<?php echo $v['id'] ?>"  type="text" value="<?php if (!empty($v['btime'])) { echo $v['btime']; } else { echo date("H:i:s"); } ?>" onFocus="WdatePicker({dateFmt:'HH:mm:ss'})"></td>
		<td><input name="etime_<?php echo $v['id'] ?>"  type="text" value="<?php if (!empty($v['etime'])) { echo $v['etime']; } else { echo date("H:i:s"); } ?>" onFocus="WdatePicker({dateFmt:'HH:mm:ss'})"></td>
		<td><input name="moninumber_<?php echo $v['id'] ?>" maxlength="3" size="3" type="text" value="<?php if(empty($v['moninumber'])) {echo "0"; }else{ echo $v['moninumber'];}?>">&nbsp;建议不要超过200</td>
		</tr>
		<?php } }?>
	</table>
	</form>
  </div>

  <div class="Toolbar_inbox" style="text-align:center">
  	<div class="page right"></div>
	<a  class="btn_a"  onclick="setting()"><span>确认设置</span></a>
	<!--
	<a href="javascript:void(0);" class="btn_a" onclick="searchContent();">
		<span class="searchContent_action">搜索内容</span>
	</a>
	-->
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
	
	function setting()
	{
		postdata('form1', "<?php echo site_url('admin/moni/setting') . '/' . $roomid ;?>", 'retdo');
	}

	function retdo(d)
	{
		if (d.code == '1')
		{
			$.jBox.tip('修改成功', 'success');
		}
		else
		{
			$.jBox.tip('修改失败', 'error');
		}
	}


</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
