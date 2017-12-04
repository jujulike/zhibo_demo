<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view($cfg['tpl'] . 'public/meta');?>
</head>

<body>
 <!--注册表单 -->
<div   class="cfix regFormHead">
<div class="f1 fl">用户注册</div>
<div class="f2 fl">设置账户及登录密码</div>
</div>

<div style="padding:30px;">
	<form action="" id="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="right">账户名：</td>
		<td> <input name="" type="text"   class="input"/>
		
		</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="right">个人昵称：</td>
		<td><input name="" type="text"  class="input" /></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="right">设置登录密码：</td>
		<td><input name="" type="password" class="input" value="" /></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="right">在输入一遍：</td>
		<td><input name="" type="password"  class="input"/></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="right">性别：</td>
		<td><input name="" type="radio" value="" />男  <input name="" type="radio" value="" />女</td>
		<td>&nbsp;</td>
	  </tr>
	  <?php if ($cfg['site_reg_vcode'] == '1') {?>
	  <tr>
		<td align="right">验证码：</td>
		<td><div class="cfix">
		<input name="r_code" type="text"  class="input" style="width:80px"/> <img src="<?php echo  site_url("code/create_vcode")?>" id="imgyzm" style="width:100px; height:32px" /> 
		</div>
		输入图片中的字符，区分大小写。<a href="javascipt:;">换一张</a></td>
		<td>&nbsp;</td>
	  </tr>
	  <?php }?>
	  <tr>
		<td align="right">&nbsp;</td>
		<td><a href="#" class="reg_btn" onclick="register()">提交</a>已有帐号，马上<a href="javasctip:;" onclick="closeLayer()">登录</a></td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	</form>
</div>

<script>
function register()
{
	postdata('regform',"<?php echo site_url('user/reg')?>",'show');
}
$("#refresh").click(function(){
		$("#imgyzm").attr('src', '<?php echo site_url("code/create_vcode");?>' + '/' + Math.random());
});
</script>

</body>
</html>
