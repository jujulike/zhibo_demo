
<?php $this->load->view($cfg['tpl'] . "public/meta");?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'].'js/DatePicker/WdatePicker.js')?>"></script>
<style type="text/css">
body{background:none}
</style>
<body>
<!---------------------------顶部 -------------------------------------------------->

<!---------------------------内容区 #main -------------------------------------------------->

<div id="regForm" style="display:block;min-width:500px">
<div class="cfix regFormHead">
<div class="f1 fl">用户信息</div>
<div class="f2 fl">修改</div>
</div>


<div style="padding:30px;">
<form action="" id="userform" style="display:block">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">账户名：</td>
    <td><?php echo $row['username'] ?>
    
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">个人昵称：</td>
    <td><input name="name" type="text"  class="input" value="<?php echo $row['name'] ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">修改密码：</td>
    <td><input name="newpasswd" type="password" class="input" value="" />密码不改则留空</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">再输入一遍：</td>
    <td><input name="repasswd" type="password"  class="input"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Email：</td>
    <td><input name="email" type="text"  class="input" value="<?php echo $row['email'] ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">性别：</td>
    <td><label><INPUT TYPE="radio" NAME="gender" value="1" <?php if ($row['gender'] != '2') {?> checked <?php } ?> />男</label>  <label><INPUT TYPE="radio" NAME="gender" value="2" <?php if ($row['gender'] == '2') {?> checked <?php } ?> />女</label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">生日：</td>
    <td><input type="text" class="input"  name="birthday" onClick="WdatePicker()" value="<?php echo $row['birthday'] ?>" ></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td align="right">移动电话：</td>
	<td><input type="text" class="input" name="phone" value="<?php echo $row['phone'] ?>"></td>
  </tr>
  <tr>
	<td align="right">QQ号码：</td>
	<td><input type="text" class="input" name="qq" value="<?php echo $row['qq'] ?>"></td>
  </tr>	
  <tr>
    <td align="right">&nbsp;</td>
    <td><a href="javascript:void(0)" class="reg_btn" onclick="modi()">提交</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
function modi()
{
	postdata('userform', '<?php echo site_url("user/modi");?>', 'show');
}
</script>

</body>
</html>
