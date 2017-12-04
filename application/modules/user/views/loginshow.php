<div class="login clearfix">
<h6>登陆直播室</h6>
			<table border="0" class="clearfix box-login">
				<tbody>
				<tr>
					<td width="50%">&nbsp;&nbsp;你好:<span class="orange"><?php echo $this->_d['userinfo']['name']; ?></span>&nbsp;&nbsp;</td>
					<td><input type="button" value="信息修改" class="button2" onclick="usermodi()"></td>
				</tr>
				<?php if (!empty($this->_d['userinfo']['ismaster'])) { ?>
				<tr>
					<?php if ($hasCate == 1) {?>
					<td>&nbsp;&nbsp;<input type="button" value="进入直播室" class="button2" onclick="goroom('<?php echo site_url("live/room" . "/" . $this->_d['userinfo']['ismaster']);?>')">&nbsp;&nbsp;</td>
					<td><input type="button" value="开设主题" class="button2" onclick="setLiveMaster()"></td>
				</tr>

				<?php } } else { ?>
				<!--
				<tr>
					<td style="text-align:right">直播室“<?php echo $this->_data['userinfo']['name']; ?>”还在申请当中，请耐心等待.</td>
				</tr>
				-->
				<?php } ?>
				<tr>
					<td style="text-align:center" colspan="2">欢迎来到谈股论金直播平台！</td>
				</tr>
			</tbody></table>			
			<div class="login-con">
<!--				<a href="#" target="_blank"><INPUT TYPE="button" class="button3" VALUE="立即注册" ONCLICK=""></a>
				<br/><br/>-->
				已有<span class="num"><?php echo $regnum; ?></span>&nbsp;人注册
			</div>
</div>
<script type="text/javascript">

function usermodi()
{
	$.jBox("iframe:<?php echo site_url('user/modi');?>", {title: "个人信息修改",iframeScrolling: 'no',height: 530,width: 350,buttons: { '关闭': true }});
}

</script>