<?php $this->load->view($cfg['tpl'] . "public/meta2");?>

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
<h6>获取密码，请输入您注册时的QQ号</h6>
			<form name="passwdform" id="passwdform">
			<table border="0" class="box-login">
				<tbody><tr>
					<td width="45" style="text-align:right">QQ&nbsp;&nbsp;</td>
					<td width="165"><input type="text" name="username" id="username" style="border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:150px"></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onclick="sendpasswd()" value="确 定" class="login-button">&nbsp;&nbsp;
					</td>
				</tr>
			</tbody></table>			
			</form>			
</div>
<script type="text/javascript">

function sendpasswd()
{
	postdata('passwdform', '<?php echo site_url("user/getpasswd");?>', 'noshow');
}

</script>
