<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="line_l" style="font-size:14px;font-weight:bold;text-align:center">时间</th>
	<?php foreach ($weekdate as $k => $v) {?>
    <th class="line_l" style="font-size:14px;font-weight:bold;text-align:center" width="13%"><?php echo $v['name']?><br /><?php echo getd(date("Y"),date("W"),$k+1,'m.d')?></th>
	<?php }?>
  </tr>
		<?php if(!empty($class_bime)) {?>
	  <?php foreach ($class_bime as $k=>$v) {?>
		<tr overstyle='on'>
		
		<td align="center"><?php echo $v?> ~ <?php echo @$class_etime[$k]?></td>
		<?php foreach ($weekdate as $k2 => $v2) {?>
	  	<td align="center"><?php echo @$class_name[$v2['id']][$k]?></td>
		<?php }?>
	  </tr>
		<?php } }?>
	</table>
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

</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
