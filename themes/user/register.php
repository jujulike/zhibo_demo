
<?php $this->load->view($cfg['tpl'] . "public/meta2");?>
<script type="text/javascript" src="<?php echo base_url('assets/date/WdatePicker.js')?>"></script>
<script src="<?php echo base_url('assets/home/sendUtil.js')?>" type="text/javascript"></script>
<style type="text/css">
<!--
.login{ background:#FEFAF1; border:1px solid #E7D5B4}
.login h6{ font-weight:100; border-bottom:1px solid #f0f0f0; text-indent:8px; padding:8px 0}
.box-login{ overflow:hidden; width:320px; margin:5px 8px}
.box-login td{ padding:2px 0; line-height:24px}
.login-con{border-top:1px solid #f0f0f0; padding:15px 0 20px 0; text-align:center; color:#666; line-height:24px}
.login-con .num{ font-family:'Arial'; font-weight:700; font-size:20px; color:#ff9000}
.newtitle{border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:150px}
.red{color:red}
-->
</style>
<body>
<!---------------------------顶部 -------------------------------------------------->

<!---------------------------内容区 #main -------------------------------------------------->
<div class="login clearfix">
			<form name="regform" id="regform">

			<table border="0" class="box-login">
				<tbody><!--<tr>
					<td width="116" style="text-align:right" >您的手机(<span class="red">*</span>)：</td>
				  <td width="250" ><input type="text" name="r_phone" id="r_phone"  class="newtitle" style = "width:120px">
					<?php if ($cfg['checkmobile'] == 1) {?>&nbsp;&nbsp;<span id ="yzm"><a id="codeBtn" href="javascript:;" onClick="sendSMS('r_phone','yzm','<?php echo site_url('home/sendSMS')?>','<?php echo site_url('home/checkPhone')?>');"><img src="<?php echo base_url('themes/images/home/bt14.jpg')?>"></a></span>
									<span id ="timestate" class="red"></span><?php }?></td>
				</tr>-->
				<tr>
					<td colspan="2"><img src="<?php echo base_url("themes/images/icon/tip.png");?>">&nbsp;注册填写资料说明：您在填写并提交本页面信息后，将留下正确QQ号，我们的客服将在24小时内对您所提交的资料进行审核,审核通过后，您将可以通过该帐号登录网站，获得完善的会员服务。如有疑问请点击<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $cfg['site_customer_qq'] ?>&site=qq&menu=yes" target="_blank"><img src="<?php echo base_url("themes/images/icon/qq_online.gif");?>" /></a></td>
				</tr>
				<tr>
				<td style="text-align:right" width="256" >QQ(<span class="red">*</span>)：</td>
				<td><input type="text" class="newtitle" name="r_qq" id="r_qq" ></td>
				</tr>				
				<tr>
					<td style="text-align:right" >您的手机：</td>
				  <td width="250" ><input type="text" name="r_phone" id="r_phone"  class="newtitle" style = "width:120px"></td>
				</tr>

				<tr>
				<td style="text-align:right">昵称(<span class="red">*</span>)：</td>
				<td><input type="text" class="newtitle" name="r_name" id="r_name" ></td>
				</tr>
				<tr>
					<td style="text-align:right">设置密码(<span class="red">*</span>)：</td>
					<td><input type="password" id="r_password" name="r_password" class="newtitle" ></td>
				</tr>
				<!--
				<tr>
				<td style="text-align:right">您的邮箱(<span class="red">*</span>)：</td>
				<td><input type="text" class="newtitle" name="r_email" id="r_email" ></td>
				</tr>
				-->
				<?php if ($cfg['checkmobile'] == "1") {?>
				<tr>
					<td style="text-align:right">手机验证码(<span class="red">*</span>)：</td>
					<td><input type="password" name="r_code" id="r_code" class="newtitle" ></td>
				</tr>
				<?php }?>
				<?php if ($cfg['site_reg_vcode'] == '1') { ?>
				<tr>
				<td style="text-align:right">验证码(<span class="red">*</span>)：</td>
				<td><input id="vcode" name="vcode" maxlength="4" style="width: 50px;"  type="text"  class="newtitle">
					<a id="refresh" href="###"><img src="<?php echo site_url("code/create_vcode") ?>" id="imgyzm" width="88" height="20" align="middle"   /></a></td>
				</tr>
				<?php } ?>
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onClick="register();" value=" 注 册 " class="login-button">&nbsp;&nbsp;</td>
				</tr>
			</tbody></table>			
			</form>
<script type="text/javascript">
function register()
{
	postdata('regform',"<?php echo site_url('home/reg')?>",'show');
}

$("#refresh").click(function(){
		$("#imgyzm").attr('src', '<?php echo site_url("code/create_vcode");?>' + '/' + Math.random());
});
</script>

</body>
</html>
