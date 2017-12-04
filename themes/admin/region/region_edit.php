<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
 
  
  <form id="form1" name="form1" action="" method="post">
		<INPUT TYPE="hidden" NAME="regionid" value="<?php echo $row['regionid'];?>">
		<INPUT TYPE="hidden" NAME="parentid" value="<?php if ($action == 'addRegion') {echo $parentid; } else { echo $row['parentid']; } ?>">
		<INPUT TYPE="hidden" NAME="regiontype" value="<?php if ($action == 'addRegion') {echo $regiontype; } else { echo $row['regiontype']; } ?>">
  <div class="form2">
	<dl class="lineD">
      <dt>地区名称：</dt>
      <dd>
        <input name="name" id="name" type="text" value="<?php echo $row['name'];?>"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>直辖市：</dt>
      <dd>
        <lable><input type="radio" name="ishot" value="1" <?php if ($row['iscity'] == '1') {?> checked="checked" <?php }?>>是</lable>
		<lable><input type="radio" name="ishot" value="0" <?php if ($row['iscity'] == '0') {?> checked="checked" <?php }?>>否</lable>
    </dl>
	<dl class="lineD">
      <dt>是否激活：</dt>
      <dd>
        <lable><input type="radio" name="status" value="1" <?php if ($row['status'] == '1') {?> checked="checked" <?php }?>>是</lable>
		<lable><input type="radio" name="status" value="0" <?php if ($row['status'] == '0') {?> checked="checked" <?php }?>>否</lable>
    </dl>
	<div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="editRegion()" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" class="btn_b">
    </div>
	</div>
</form>
<script text="text/javascript">
function editRegion()
{
	
	postdata('form1',"<?php echo site_url('admin/region' . '/'.$action.'/' . $row['regionid']);?>",'show');
	
}

</script>
</body>
</html>
