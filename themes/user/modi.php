
<?php $this->load->view($cfg['tpl'] . "public/meta2");?>
<script type="text/javascript" src="<?php echo base_url('assets/date/WdatePicker.js')?>"></script>

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
			<div class="sign-title"></div>

			<form name="regform" id="regform">
			<INPUT TYPE="hidden" NAME="userid" value="<?php echo $row['userid'] ?>" />
			<table border="0" class="box-login">
				<tbody><tr>
					<td style="text-align:right">用户名(<span class="red">*</span>)：</td>
					<td width="200"><?php echo $row['username'] ?></td>
				</tr>
				<tr>
					<td style="text-align:right">修改密码：</td>
					<td><input type="password" name="newpasswd" class="newtitle" ><br/>密码不改则留空</td>
				</tr>
				<tr>
					<td style="text-align:right">确认密码：</td>
					<td><input type="password" name="repasswd" class="newtitle"></td>
				</tr>
<tr>
				<td style="text-align:right">Email：</td>
				<td><input type="text" class="newtitle" name="email" value="<?php echo $row['email'] ?>" ></td>
			</tr>
<tr>
				<td style="text-align:right">姓名(<span class="red">*</span>)：</td>
				<td><input type="text" class="newtitle" name="name" value="<?php echo $row['name'] ?>"  ></td>
			</tr>
			<tr>
				<td style="text-align:right">性别：</td>
				<td>
				<label><INPUT TYPE="radio" NAME="gender" value="1" <?php if ($row['gender'] == '1') {?> checked <?php } ?> />男</label>&nbsp;
				<label><INPUT TYPE="radio" NAME="gender" value="2" <?php if ($row['gender'] == '2') {?> checked <?php } ?> />女</label>&nbsp;
				<label><INPUT TYPE="radio" NAME="gender" value="0" <?php if ($row['gender'] == '0') {?> checked <?php } ?> />保密</label>
				</td>
			</tr>


			<tr>
				<td style="text-align:right">生日：</td>
				<td><input type="text" class="newtitle"  name="birthday" onClick="WdatePicker()" value="<?php echo $row['birthday'] ?>" ></td>
			</tr>			<tr>
				<td style="text-align:right;">股龄(年)：</td>
				<td><input type="text" class="newtitle" name="stockage" value="<?php echo $row['stockage'] ?>"></td>
			</tr>			<tr>
				<td style="text-align:right">手机：</td>
				<td><input type="text" class="newtitle" name="phone"  value="<?php echo $row['phone'] ?>"></td>
			</tr>
			<tr>
				<td style="text-align:right">QQ号码：</td>
				<td><input type="text" class="newtitle" name="qq"  value="<?php echo $row['qq'] ?>"></td>
			</tr>		
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onclick="reg()" value=" 修 改 " class="login-button">&nbsp;&nbsp;</td>
				</tr>
			</tbody></table>			
			</form>
<script type="text/javascript">
function reg()
{
	postdata('regform', '<?php echo site_url("user/modi");?>', 'show');
}
</script>

</body>
</html>
