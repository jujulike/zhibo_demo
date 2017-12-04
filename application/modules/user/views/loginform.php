<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="<?php echo base_url('themes/css/reset.css')?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('themes/css/text.css')?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('themes/css/960_24_col.css')?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url('themes/css/style.css')?>" rel="stylesheet" type="text/css"/>
<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('themes/comm/js/jBox/Skins/Brown/jbox.css')?>" />

<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/jquery.jBox-2.3.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/i18n/jquery.jBox-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/f.js')?>"></script>

<style type="text/css">
<!--
.login{ background:#FEFAF1; border:1px solid #E7D5B4}
.login h6{ font-weight:100; border-bottom:1px solid #f0f0f0; text-indent:8px; padding:8px 0}
.box-login{ overflow:hidden; width:210px; margin:5px 8px}
.box-login td{ padding:6px 0; line-height:24px}
.login-con{border-top:1px solid #f0f0f0; padding:15px 0 20px 0; text-align:center; color:#666; line-height:24px}
.login-con .num{ font-family:'Arial'; font-weight:700; font-size:20px; color:#ff9000}
-->
</style>
<div class="login clearfix">
<h6>登陆直播室</h6>
			<form name="loginform" id="loginform">
			<table border="0" class="box-login">
				<tbody><!--<tr>
					<td width="45" style="text-align:right">用户名&nbsp;&nbsp;</td>
					<td width="165"><input type="text" name="username" id="username" style="border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:150px"></td>
				</tr>-->
				<tr>
					<td width="45" style="text-align:right">QQ&nbsp;&nbsp;</td>
					<td width="165"><input type="text" name="username" id="username" style="border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:150px"></td>
				</tr>
				<tr>
					<td style="text-align:right">密码&nbsp;&nbsp;</td>
					<td><input type="password" name="passwd" id="passwd"  style="border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:150px">&nbsp;<!--<a href="###" onclick="getpasswd()">忘记密码?</a>--></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onclick="login()" value="登陆" class="login-button">&nbsp;&nbsp;
					<?php if(empty($hidereg)) {?><input type="button" onclick="switchlogin()" value="立即注册" class="login-button">
					<?php }?></td>
				</tr>
			</tbody></table>			
			</form>
			<div class="login-con">
<!--				<a href="#" target="_blank"><INPUT TYPE="button" class="button3" VALUE="立即注册" ONCLICK=""></a>
				<br/><br/>-->
				已有<span class="num"><?php echo $regnum; ?></span>&nbsp;人注册
			</div>
</div>
<script type="text/javascript">

function login()
{
	postdata('loginform', '<?php echo site_url("user/login");?>', 'show');
}

function switchlogin()
{
	window.parent.register();
	$.jBox.close();
}

</script>
