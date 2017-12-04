<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/DatePicker/WdatePicker.js"></script>
<div class="so_main">
  <div class="page_tit">课程设置</div>
  <div class="list">
  <form id="form1" name="form1" action="" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<th class="line_l">时间</th>
	<?php foreach ($weekdate as $k => $v) {?>
    <th class="line_l" width="11%"><?php echo $v['name']?></th>
	<?php }?>
	<th class="line_l" width="10%">操作</th>
	  </tr>
		<?php if(!empty($class_bime)) {?>
	  <?php foreach ($class_bime as $k=>$v) {?>
	  <tr overstyle='on'>
		
		<td><input type="text" style="width:80px" name="class_btime[]" value="<?php echo $v?>" > ~ <input type="text" style="width:80px" name="class_etime[]" value="<?php echo @$class_etime[$k]?>"></td>
		<?php foreach ($weekdate as $k2 => $v2) {?>
	  	<td><input type="text" style="width:100px" name="class_name[<?php echo $v2['id'] ?>][]" value="<?php echo @$class_name[$v2['id']][$k]?>"></td>
		<?php }?>
		<td><a href="javascript:;" class="add">添加</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="del">删除</a></td>
	  </tr>
		<?php } } else {?>
		<tr overstyle='on'>
		
		<td><input type="text" style="width:80px" name="class_btime[]"> ~ <input type="text" style="width:80px" name="class_etime[]"></td>
		<?php foreach ($weekdate as $k => $v) {?>
	  	<td><input type="text" style="width:100px" name="class_name[<?php echo $v['id'] ?>][]"></td>
		<?php }?>
		<td><a href="javascript:;" class="add">添加</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="del">删除</a></td>
	  </tr>
		<?php }?>
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

		$('.add').live('click', function() {
			var _clone = $(this).parents('tr').clone(true);
			$(this).parents('tr').after("<tr overstyle='on'>"+_clone.html()+"</tr>");
		});

		$('.del').live('click', function() {
			$(this).parents('tr').remove();
		});
		
	});

	function setting()
	{
		postdata('form1', "<?php echo site_url('admin/classes/setting') . '/' . $roomid ;?>", 'retdo');
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
