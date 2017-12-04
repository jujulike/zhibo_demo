<link type="text/css" media="all" rel="stylesheet" href="<?php echo base_url('themes/comm/js/jBox/Skins/Brown/jbox.css')?>" />

<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/jquery.jBox-2.3.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/i18n/jquery.jBox-zh-CN.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('themes/comm/js/f.js')?>"></script>
<script src="<?php echo base_url('themes/home/sendUtil.js')?>" type="text/javascript"></script>
<script type="text/javascript">

if(document.addEventListener){//如果是Firefox

  document.addEventListener("keypress",fireFoxHandler, true);

  }else{

   document.attachEvent("onkeypress",ieHandler);

  }
 

function fireFoxHandler(evt){


 if(evt.keyCode==13){
	 $("#btnlogin").click();
 }
}

function ieHandler(evt){


 if(evt.keyCode==13){
	 $("#btnlogin").click();
 }
}

$(document).ready(function() {
	jQuery.jqtab = function(tabtit,tab_conbox,shijian) {
		$(tab_conbox).find("li").hide();
		$(tabtit).find("li:first").addClass("thistab").show(); 
		$(tab_conbox).find("li:first").show();
	
		$(tabtit).find("li").bind(shijian,function(){
		  $(this).addClass("thistab").siblings("li").removeClass("thistab"); 
			var activeindex = $(tabtit).find("li").index(this);
			$(tab_conbox).children().eq(activeindex).show().siblings().hide();
			return false;
		});
	
	};
	/*调用方法如下：*/
	$.jqtab("#tabs","#tab_conbox","click");
	
	$.jqtab("#tabs2","#tab_conbox2","mouseenter");
	
});

function login()
{
	postdata('bd', '<?php echo site_url("user/login");?>', 'enter');

}

function register()
{
	postdata('bb',"<?php echo site_url('home/reg')?>",'show');
}

</script>
<div class="dl">

<ul class="tabs" id="tabs">
       <li><a href="">VIP登陆</a></li>
       <li><a href="">VIP注册</a></li>    
    </ul>
    <ul class="tab_conbox" id="tab_conbox">
        <li class="tab_con">
        <form id="bd">
			<table>
				<tr>
					<td><font style="font-size:14px;">用户名：</font></td>
					<td><input type="text" name="username" id="l_username" style="height:23px; width:129px;" /></td>
				</tr>
				<tr>
					<td><font style="font-size:14px;">密&nbsp;&nbsp;码：</font></td>
					<td><input type="password" id="passwd" name="passwd" class="input required" style="height:23px; width:129px;"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input class="anniu" type="button" id="btnlogin" value="" onClick="login();" /></td>
				</tr>
                 
				</table>
            </form>
        </li>
            	<!--注册部分 start-->
        <li class="tab_con">
        <form id="bb">
			<table>
				<tr>
					<td><font style="font-size:14px;">昵&nbsp;&nbsp;&nbsp;&nbsp;称：</font></td>
					<td><input type="text" name="r_name" id="r_name" style="height:23px; width:110px;" /></td>
					<td></td>
				</tr>
				<tr>
					<td><font style="font-size:14px;">手&nbsp;机&nbsp;号：</font></td>
					<td><input type="text" name="r_phone" id="r_phone" style="height:23px; width:110px;" /></td>
					<td><?php if ($checkmobile == 1) {?><span id ="yzm"><input id="codeBtn" class="anniu2" type="button" onClick="sendSMS('r_phone','yzm','<?php echo site_url('home/sendSMS')?>','<?php echo site_url('home/checkPhone')?>');" /></span><br />
				  <span id ="timestate"></span><?php }?></td>
				</tr>
				<?php if ($checkmobile == 1) {?>
				<tr>
					<td><font style="font-size:14px;">验&nbsp;证&nbsp;码：</font></td>
					<td><input type="text" name="r_code" id="r_code" style="height:23px; width:110px;" /></td>
					<td></td>
				</tr>
				<?php }?>
				<tr>
					<td><font style="font-size:14px;">设置密码：</font></td>
					<td><input type="password" id="r_password" name="r_password" class="input required" style="height:23px; width:110px;"/></td>
					<td></td>
				</tr>
				<tr>
					<td><font style="font-size:14px;">您的邮箱：</font></td>
					<td><input type="text" id="r_email" name="r_email" class="input required" style="height:23px; width:110px;"/></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><input class="anniu1" type="button" onClick="register();"/></td>
					<td></td>
				</tr>
              
			</table>
            </form>
        </li>  
		<!--注册部分 end-->  
       
    </ul>
</div>