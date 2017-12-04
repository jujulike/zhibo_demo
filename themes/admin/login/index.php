<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title><?php echo $cfg['site_title'] ?>管理后台</title>
<style type="text/css">
<!--
*{margin:0;padding:0}
body {
	font-family:arial;
	font-size: 12px;
	background:#EFF3F6;
	margin: 0px;
}
li{ list-style-type: none;}
ul, form, input { font-size:12px; padding:0; margin:0;}
a:link { color:#084F63;}
a:visited { color:#084F63;}
a:hover{ color:#cc3300;}
a img { border: none;}
img{ border: 0px;}
.fl { float:left;}
.wrap_login {width:532px;height:380px;text-align:left;margin:0 auto;margin-top:150px;background:url(<?php echo base_url($cfg['tpl_admin'])?>/login/images/login/login_box_bg.png) no-repeat top;position:relative}
.wrap_login .la {}
.wrap_login .lb { width:176px; height:215px; background:url(<?php echo base_url($cfg['tpl_admin'])?>/login/images/login/gm_l_f.gif) no-repeat center center;}
.wrap_login .box_login { width:257px;color:#fff;position:absolute;right:40px;top:80px;padding:20px 0 0 30px;font-size:14px}
.wrap_login .box_login dd{padding:0 0 15px;text-align:left}
.wrap_login .box_login dd label{width:60px;display:block;float:left;padding:5px 0}
.wrap_login .box_login .c1{margin-left:60px}
.wrap_login .box_login .txt{padding:5px;background-color:#C0E3F1;border:#C0E3F1 solid 1px; vertical-align:middle}
.wrap_login .box_login .txt2{padding:5px;background-color:#fff;border:#fff solid 1px; vertical-align:middle}
.wrap_login .lc ul { padding-left:20px;}
.wrap_login .lc li { float:left; width:237px; line-height:22px;}
.wrap_login .lx { margin-left:24px;}
.ldinput {border:1px solid #c3c6cb; padding:2px;}
.lf {  margin-bottom:13px; }
.footer_login {
	height:39px;
	line-height:22px;
	color:#084F63;
	text-align:center;
	padding-top:15px;
	position:absolute;
	bottom:10px;
	width:532px
}
-->
</style>

<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url($cfg['comm'])?>/js/jBox/Skins/Blue/jbox.css" />

<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/public2.js"></script>

<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/jBox/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/jBox/i18n/jquery.jBox-zh-CN.js"></script>


</head>
<body>
<div class="wrap_login">
  <div class="la fl">
    <div class="box_login">
      <form method="post" id="login"  class="nf lf" onsubmit="return false;">
			<dl>
					<dd>
					   <label>帐　号：</label>
					   <div class="c1"><input class="txt" onfocus="this.className='txt2'" onblur="this.className='txt'" type="text" name="username" value="" style="width:180px"></div>
				    </dd>
				<dd>
				    <label>密　码：</label>
				    <div class="c1"><input class="txt" onfocus="this.className='txt2'" onblur="this.className='txt'" type="password" name="passwd" value="" style="width:180px"></div>
				</dd>
				<?php if ($cfg['vercode_adminlogin'] == '1') {?>
				<dd>
				    <label>验证码：</label>
                    <div class="c1">
				 <input id="vercode" class="txt" onfocus="this.className='txt2'" name="vercode" value="" style="width:58px">
				    <a href="###" onclick="changeverify()"><img src="<?php echo site_url('tools/vercode') ?>" id="verifyimg" alt="换一张" style="vertical-align:middle" /></a>&nbsp;&nbsp;<a href="###" onclick="changeverify()">换一换</a><!-- <div id='copyverify'></div> -->
                    </div>  
				</dd>
				<script>
				$(document).ready(function(){
					$("#verifyimg").click(function(){
						changeverify();
					});
				});
				function changeverify()
				{
					$("#verifyimg").attr('src', '<?php echo site_url('tools/vercode') ?>' + '/' + Math.random());
				}
				</script>
				<?php } ?>
				<dd>
				    <label>&nbsp;</label>
                    <input type="image" src="<?php echo base_url($cfg['tpl_admin'])?>/login/images/login/btn_login.png" style="height:32px; width:102px;" onclick="adminLogin()" />
                </dd>
			</dl>
			</form>
		</div>
	</div>
	<div class="footer_login"><?php echo $cfg['site_copyright']?></div>
</div>
<script type="text/javascript">
function adminLogin()
{
	//postdata('login', '<?php echo site_url("admin/login"); ?>', 'enter');
	postdata('login', '/index.php/admin/login', 'enter');
}
</script>
</body>
</html>
