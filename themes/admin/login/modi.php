<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <form id="form1" name="form1" action="" method="post">		
		<!--<INPUT TYPE="hidden" NAME="adminid" value="<?php echo $row['adminid'];?>">
		<INPUT TYPE="hidden" NAME="passwd" value="<?php echo $row['passwd'];?>">-->
  <div class="form2">
    <dl class="lineD">
      <dt>旧密码：</dt>
      <dd>
        <input name="oldpasswd" id="oldpasswd" type="password"><span>*</span>
    </dl>
    <dl class="lineD">
      <dt>新密码：</dt>
      <dd>
        <input name="newpasswd" id="newpasswd" type="password" ><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>确认密码：</dt>
      <dd>
        <input name="repasswd" id="repasswd" type="password" ><span>*</span>
    </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="modi()" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>


<script type="text/javascript">
function modi()
{
	postdata('form1', "<?php echo site_url('admin/login/modi');?>", 'show');
}

</script>