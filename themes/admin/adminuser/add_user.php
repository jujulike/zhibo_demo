<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="user_id" value="<?php echo $row['user_id'];?>">
  <div class="form4">
    <dl class="lineD">
      <dt>用户名</dt>
      <dd>
        <input name="user_name" id="user_name" type="text"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt> Email地址：</dt>
      <dd>
        <input name="email" id="email" type="text"><span>*</span>
    </dl>
    <dl class="lineD">
      <dt>密码：</dt>
      <dd>
        <input name="password" id="password" type="password"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>确认密码：</dt>
      <dd>
        <input name="repassword" id="repassword" type="password"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>角色选择：</dt>
      <dd>
		<select name="role_id">
			<?php echo $role?>
		</select>
    </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="add_user()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>

<script type="text/javascript">
function add_user()
{
	postdata('form1', "<?php echo site_url('admin/adminuser/add_user');?>", 'dd');
}

function dd(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			window.location.href="<?php echo site_url('admin/adminuser/admin_list')?>";
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}
</script>