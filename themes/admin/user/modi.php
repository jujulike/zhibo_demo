<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo SYSTEM_NAME; ?> - 用户注册</title>
<META HTTP-EQUIV="expires" CONTENT="0">
<?php echo $this->load->view('admin/public/meta.php')?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('themes/admin/css/admincp.css')?>" media="all" />
<script type="text/javascript" src="<?php echo base_url('assets/date/WdatePicker.js')?>"></script>
</head>

<body>
<div id="append"></div>
<div class="container">
		<div class="hastabmenu">
            <ul class="tabmenu">
                <li id="tabli1" class="tabcurrent"><a href="#">用户信息修改</a></li>
			</ul>
            <div id="tabli1div" class="tabcontentcur">
				<form id="userregform" method="post">			
                <table class="dbtb">
				<!--
                    <tr>
                        <td class="tbtitle">帐号&nbsp;<span class="red">*</span></td>
                        <td><input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" maxlength="32" class="txt" rel="check" style="width:200px" />只允许字母和数字</td>
                    </tr>

                    <tr>
                        <td class="tbtitle">登录密码&nbsp;<span class="red">*</span></td>
                        <td><input type="password" id="passwd" name="passwd"  maxlength="32" value="" class="txt"  rel="check" style="width:200px" /></td>
                    </tr>
                    <tr>
                        <td class="tbtitle">确认密码&nbsp;<span class="red">*</span></td>
                        <td><input type="password" id="repasswd" name="repasswd"  maxlength="32"  value="" class="txt" style="width:200px" /></td>
                    </tr>
				-->
                    <tr>
                        <td class="tbtitle">姓名&nbsp;<span class="red">*</span></td>
                        <td><input type="text" name="name" value="<?php echo $userinfo['name']; ?>" class="txt" maxlength="10"  rel="check"  style="width:200px" /></td>
                    </tr>
                    <tr>
                        <td class="tbtitle">设置安全问题&nbsp;<span class="red">*</span></td>
                        <td><input type="text" name="safequestion" maxlength="30" value="<?php echo $userinfo['safequestion']; ?>" class="txt" rel="check"  style="width:200px" />用来取回密码</td>
                    </tr>
                    <tr>
                        <td class="tbtitle">设置安全答案&nbsp;<span class="red">*</span></td>
                        <td><input type="text" name="safeanswer" maxlength="30" value="<?php echo $userinfo['safeanswer']; ?>" class="txt" rel="check"  style="width:200px" /></td>
                    </tr>
                    <tr>
                        <td class="tbtitle">邮箱&nbsp;</td>
                        <td><input type="text" name="email" maxlength="30" value="<?php echo $userinfo['email']; ?>" class="txt" rel="check"  style="width:200px" /></td>
                    </tr>
                    <tr>
                        <td class="tbtitle">生日</td>
                        <td><input type="text" name="birthday" value="<?php echo $userinfo['birthday']; ?>" class="txt"  style="width:200px"  onClick="WdatePicker({isShowClear:false,dateFmt:'yyyy-MM-dd',readOnly:true})" /></td>
                    </tr>
                    <tr>
                        <td class="tbtitle">性别</td>
                        <td><SELECT NAME="gender">
							<OPTION VALUE="0" >
							<OPTION VALUE="1" <?php if ($userinfo['gender'] == '1') { ?> selected <?php } ?>>男
							<OPTION VALUE="2" <?php if ($userinfo['gender'] == '2') { ?> selected <?php } ?>>女
                        </SELECT></td>
                    </tr>
			
                    <tr>
                        <td></td>
                        <td>
                            <input type="button" name="" id="userregformsubmit" value="提 交" class="btn"/>
                        </td>
                    </tr>
                </table>
				</form>
            </div>
		</div>
</div>
<script text="text/javascript">
$(document).ready(function(){
	
	$("#userregformsubmit").click(function()
	{
		$.jBox.tip('正在处理....', 'loading');
			$("#userregform").ajaxSubmit(
			{			
				type:"post",
				success:function(data){	
					var d = eval('(' + data + ')');
					if(d.code == '1'){
						$.jBox.tip(d.msg, 'success');
						window.setTimeout(function () {
							parent.$.jBox.close();
//							$(window.parent.document).find("#username").val($("#username").val());
						}, 2000);
					}else{
						$.jBox.tip(d.msg,'error');
					}
				}
			})		

	});
});
</script>
</body>
</html>
