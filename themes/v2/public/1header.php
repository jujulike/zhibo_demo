 
  <div id="head" class="cfix">
    <div class="head_bg1"><a class="logo" href="<?php echo site_url("home") ?>"><img src="<?php if (!empty($cfg['imgthumb'])) echo base_url($cfg['imgthumb']); ?>" width="127" height="40" /></a></div>
    <div class="head_bg2 cfix">
    <div id="rightMenu" class="cfix fr">
      <div class="fr reglink">
		<?php if ((!empty($userinfo)) && ($userinfo['level'] != '-1')) { ?>
        <p style="padding-top:5px">
		<span><a href="javascript:void(0)"  onclick="modi()" title="修改个人信息" style="margin-top:0" ><?php echo $userinfo['name'];?></a></span>
        <span style="border:none"><a href="<?php echo site_url("user/logout") ?>" style="margin-top:0">退出</a></span>
        </p>
		<script type="text/javascript">
		function modi()
			{
				var ii = $.layer({
					type: 2,
					maxmin: false,
					closeBtn: [0, true],
					title: false,
					area: ['550px', '600px'],
					iframe: {src: '<?php echo site_url('user/modi');?>',scrolling: 'yes'}
				});

				
			}
		</script>
		<?php } else {?>
		<a href="javascript:void(0)" onclick="userlogin()"> <img src="<?php echo base_url($cfg['tpl'])?>/images/login_icon.png" width="43" height="42" /></a>
		<a href="javascript:void(0)" onclick="reg()"> <img src="<?php echo base_url($cfg['tpl'])?>/images/reg_icon.png" width="43" height="42" /></a>
		<?php }?>
	  </div>
      <!--<div class="search cfix "  style="float:right">
        <input type="text"  placeholder="用户搜索" />
        <input type="button" class="button" />
      </div>-->
      <div class="fl cfix" style="padding:5px 0 0 15px">
 
			<span id="NavList" class="drop-down" ><div class="drop-panel">
				<ul class="drop-nav-list">
					<?php foreach ($adlist[166] as $k => $v) {?>
					<li class="item">
						<a href="<?php echo prep_url($v['link'])?>" target="_blank" title="<?php echo $v['title']?>">
							<?php echo $v['title']?>
						</a>
					</li>
					<?php }?>
					
				</ul>
			</div><a href="###"><img src="<?php echo base_url($cfg['tpl'])?>/images/head_icon1.png"  />导航</a></span>
	  
		  
	 

	<script>
		$("#NavList").on("mouseenter",function(){$(this).addClass("drop-down-open")}).on("mouseleave",function(){$(this).removeClass("drop-down-open")});
	</script>

	  <span><a href="javascript:void(0)" onclick="topnews()"><img src="<?php echo base_url($cfg['tpl'])?>/images/head_icon2.png"   />财经数据</a></span> <span><a href="javascript:void(0)" onclick="getClasses()"><img src="<?php echo base_url($cfg['tpl'])?>/images/head_icon3.png"   />课程安排</a></span> </div>
      </div>
      <div class="cfix"></div>
    </div>
  </div>


  <script type="text/javascript">
	function topnews()
		{
			var ii = $.layer({
				type: 2,
				maxmin: false,
				closeBtn: [0, true],
				title: "查看财经数据",
				area: ['700px', '600px'],
				iframe: {src: 'http://www.jin10.com/jin10.com.html',scrolling: 'yes'}
			});
			
		}

	function getClasses()
	{
		var ii = $.layer({
				type: 2,
				maxmin: false,
				closeBtn: [0, true],
				title: '查看课表',
				area: ['700px', '300px'],
				iframe: {src: '<?php echo site_url("live/classes")?>',scrolling: 'yes'}
			});
	}

	function reg(){
		var ii = $.layer({
			type: 1,
			area: ['700px', 'auto'],
			title:false,
			fix : true,
			page: {dom : '#regForm'}
		})
	}


	function userlogin(){
		var ii = $.layer({
			type: 1,
			area: ['auto', 'auto'],
			title:false,
			fix : true,
			page: {dom : '#loginForm'}
		})
	} 
	

	</script>


 <!--注册表单 -->
<div id="regForm" style="display: none">
<div   class="cfix regFormHead">
<div class="f1 fl">用户注册</div>
<div class="f2 fl">设置账户及登录密码</div>
</div>


<div style="padding:15px;">
<form action="" id="form1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">账户名：</td>
    <td> <input name="username" type="text"   class="input"/>&nbsp;<span style="color:red">必填</span>
      
    </td>
    </tr>
  <tr>
    <td align="right">个人昵称：</td>
    <td><input name="name" type="text"  class="input" />&nbsp;<span style="color:red">必填</span></td>
    </tr>
  <tr>
    <td align="right">设置登录密码：</td>
    <td><input name="passwd" type="password" class="input" value="" />&nbsp;<span style="color:red">必填</span></td>
    </tr>
  <tr>
    <td align="right">再输入一遍：</td>
    <td><input name="repasswd" type="password"  class="input"/>&nbsp;<span style="color:red">必填</span></td>
    </tr>
  <tr>
    <td align="right">手机号：</td>
    <td><input name="phone" type="text" class="input" />&nbsp;<span style="color:red">必填</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">邮箱：</td>
    <td><input name="email" type="text" class="input" />&nbsp;<span style="color:red">必填</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">QQ：</td>
    <td><input name="qq" type="text" class="input" />&nbsp;<span style="color:red">选填</span></td>
    <td>&nbsp;</td>
  </tr>
  <?php if ($cfg['site_reg_vcode'] == '1') {?>
	  <tr>
		<td align="right">验证码：</td>
		<td><div class="cfix">
		  <input name="r_code" type="text"  class="input" style="width:80px"/> <img src="<?php echo  site_url("code/create_vcode")?>" id="imgyzm" style="width:100px; height:32px" /> 
		  </div>
		  输入图片中的字符，区分大小写。<a href="javascript:void(0)" id="refresh">换一张</a></td>
		</tr>
	  <?php }?>
  <tr>
    <td align="right">&nbsp;</td>
    <td><a href="javascript:void(0)" class="reg_btn" onclick="register()">提交</a>已有帐号，马上<a href="javascript:void(0);" onclick="closeLayer()">登录</a></td>
    </tr>
</table>
</form>
</div>

<script>
function register()
{
	postdata('form1',"<?php echo site_url('user/reg')?>",'show');
}

function closeLayer(){
	layer.closeAll();
	userlogin();
	
	}

$("#refresh").click(function(){
		$("#imgyzm").attr('src', '<?php echo site_url("code/create_vcode");?>' + '/' + Math.random());
});
</script>

</div>









<!--登陆表单 -->
<div id="loginForm" style="display:none">
<div   class="cfix regFormHead">
<div class="f2 fl">会员登陆</div>
</div>


<div style="padding:15px;">
<form action="" id="form2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">账户名：</td>
    <td> <input name="username" type="text"   class="input"/>
    
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">登录密码：</td>
    <td><input name="passwd" type="password" class="input" value="" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><a href="javascript:void(0)" class="reg_btn" onclick="login()">登陆</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>

<script>
function login()
{
	postdata('form2',"<?php echo site_url('user/login')?>",'show');
}
</script>

</div>



