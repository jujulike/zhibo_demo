
<?php $this->load->view($cfg['tpl'] . "public/meta2");?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'] . 'js/DatePicker/WdatePicker.js')?>"></script>

<style type="text/css">
<!--
.login{ background:#FEFAF1; border:1px solid #E7D5B4}
.login h6{ font-weight:100; border-bottom:1px solid #f0f0f0; text-indent:8px; padding:8px 0}
.box-login{ overflow:hidden; width:420px; margin:5px 8px}
.box-login td{ padding:6px 0; line-height:24px}
.login-con{border-top:1px solid #f0f0f0; padding:15px 0 20px 0; text-align:center; color:#666; line-height:24px}
.login-con .num{ font-family:'Arial'; font-weight:700; font-size:20px; color:#ff9000}
.newtitle{border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:300px}
.red{color:red}
.newtextarea{border:1px solid #ddd; padding:2px 5px; height:70px; line-height:20px; width:300px}
-->
</style>
<body>
<!---------------------------顶部 -------------------------------------------------->

<!---------------------------内容区 #main -------------------------------------------------->
<div class="login clearfix">
			<div class="sign-title">请填写以下信息。</div>

			<form name="regform" id="regform">
			<INPUT TYPE="hidden" NAME="userid" value="<?php echo $userinfo['userid'];?>">
			<INPUT TYPE="hidden" NAME="appstatus" value="1">
			<INPUT TYPE="hidden" NAME="approomvip" value="<?php echo $approomvip?>">

			<table border="0" class="box-login">
				<tbody><tr>
					<td style="text-align:right">申请开通的用户名：</td>
					<td width="200"><?php echo $userinfo['username'];?></td>
				</tr>
				<td style="text-align:right">真实姓名：</td>
				<td><input type="text" class="newtitle" name="name"  value="<?php echo $userinfo['name'];?>"></td>
			</tr>
			<tr>
				<td style="text-align:right">性别：</td>
				<td>
				<label><INPUT TYPE="radio" NAME="gender" value="1" <?php if ($userinfo['gender'] == '1') { ?>checked <?php } ?>/>男</label>&nbsp;
				<label><INPUT TYPE="radio" NAME="gender" value="2" <?php if ($userinfo['gender'] == '2') { ?>checked <?php } ?>/>女</label>&nbsp;
				<label><INPUT TYPE="radio" NAME="gender" value="0" <?php if ($userinfo['gender'] == '0') { ?>checked <?php } ?>/>保密</label>
				</td>
			</tr>
			<tr>
				<td style="text-align:right">手机：</td>
				<td><input type="text" class="newtitle" name="phone"  value="<?php echo $userinfo['phone']?>" ></td>
			</tr>
			<tr>
				<td style="text-align:right">QQ：</td>
				<td><input type="text" class="newtitle" name="qq"  value="<?php echo $userinfo['qq']?>" ></td>
			</tr>
			<tr>
				<td style="text-align:right">Email：</td>
				<td><input type="text" class="newtitle" name="email" value="<?php echo $userinfo['email']?>"></td>
			</tr>
			<tr>
				<td style="text-align:right">个人简介：</td>
				<td><TEXTAREA NAME="userinfo" ROWS="4" COLS="" class="newtextarea" ><?php echo $userinfo['userinfo']?></TEXTAREA></td>
			</tr>	
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onclick="regVip()" value=" 申 请 " class="login-button">&nbsp;&nbsp;</td>
				</tr>
			</tbody></table>			
			</form>
			
<script type="text/javascript">
function regVip()
{
	postdata('regform', '<?php echo site_url("live/appVip") . "/" . $approomvip ?>', 'retvip');
}

function retvip(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			top.$.jBox.close();
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

</script>

</body>
</html>
