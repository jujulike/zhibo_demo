<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="user_id" value="<?php echo $row['user_id'];?>">
  <div class="form4">
    <dl class="lineD">
      <dt>用户名</dt>
      <dd>
        <input name="user_name" id="user_name" type="text" value="<?php echo $row['user_name']?>"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt> Email地址：</dt>
      <dd>
        <input name="email" id="email" type="text" value="<?php echo $row['email']?>" ><span>*</span>
    </dl>
    <dl class="lineD">
      <dt>旧密码：</dt>
      <dd>
        <input name="oldpassword" id="oldpassword" type="password"><span>*</span>
		<p>如果要修改密码,请先填写旧密码,如留空,密码保持不变</p>
    </dl>
	<dl class="lineD">
      <dt>新密码：</dt>
      <dd>
        <input name="newpassword" id="newpassword" type="password"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>确认新密码：</dt>
      <dd>
        <input name="renewpassword" id="renewpassword" type="password"><span>*</span>
    </dl>
	<?php if ($row['role_id'] != '') { ?>
	<dl class="lineD">
      <dt>角色选择：</dt>
      <dd>
		<select name="role_id">
			<?php echo $role?>
		</select>
    </dl>
	<?php }?>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="edit_user('<?php echo $row['user_id']?>')" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>

<script type="text/javascript">
function edit_user(user_id)
{
	postdata('form1', "<?php echo site_url('admin/adminuser/edit_user');?>"+"/"+user_id, 'dd');
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