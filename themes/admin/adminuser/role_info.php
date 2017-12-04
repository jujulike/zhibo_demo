<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="user_id" value="<?php echo $row['role_id'];?>">
  <div class="form4">
    <dl class="lineD">
      <dt>角色名</dt>
      <dd>
        <input name="role_name" id="role_name" type="text" value="<?php echo $row['role_name']?>"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt> 角色描述：</dt>
      <dd>
        <textarea name="role_describe" id="role_describe" ><?php echo $row['role_describe']?></textarea>
    </dl>
	<?php foreach ($checkboxdata as $k => $v) {?>
	<dl class="lineD">
      <dt class="parentSelect"> <?php echo $v['parent_checkbox']?></dt>
      <dd class="childselect">
        <?php echo $v['sub_checkbox']?>
    </dl>
	<?php }?>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="edit_role('<?php echo $row['role_id']?>')" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>

<script type="text/javascript">
function edit_role(role_id)
{
	postdata('form1', "<?php echo site_url('admin/adminuser/'. $action);?>"+"/"+role_id, 'dd');
}

function dd(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			window.location.href="<?php echo site_url('admin/adminuser/role_list')?>";
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

$(".parentSelect").find("input[type='checkbox']").click(function(){
	if ($(this).attr("checked"))
		$(this).parents(".parentSelect").next(".childselect").find("input[type='checkbox']").attr("checked", true);
	else
		$(this).parents(".parentSelect").next(".childselect").find("input[type='checkbox']").attr("checked", false);
});

</script>