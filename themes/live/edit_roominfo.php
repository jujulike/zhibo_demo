
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
			<form name="regform" id="regform">
			<INPUT TYPE="hidden" NAME="roomid" value="<?php echo $roominfo['roomid'];?>">

			<table border="0" class="box-login">
			<tbody>
			<?php if ($cate == '1') {?>
			<tr>
					<td style="text-align:right">播主简介(<span class="red">*</span>)：</td>
					<td><TEXTAREA NAME="userinfo" ROWS="4" COLS="" class="newtextarea" ><?php echo $roominfo['userinfo']?></TEXTAREA></td>
			</tr>
			<?php } else {?>
			<tr>
				<td style="text-align:right">直播室简介(<span class="red">*</span>)：</td>
				<td><TEXTAREA NAME="roominfo" ROWS="4" COLS="" class="newtextarea" ><?php echo $roominfo['roominfo']?></TEXTAREA></td>
			</tr>
			<?php }?>
			<tr>
				<td>&nbsp;</td>
				<td style="padding-top:15px"><input type="button" onclick="setroom('<?php echo $roominfo['roomid']?>','<?php echo $cate?>')" value=" 修 改 " class="login-button">&nbsp;&nbsp;</td>
			</tr>

			</tbody></table>			
			</form>
<script type="text/javascript">
function setroom(roomid,cate)
{
	postdata('regform', '<?php echo site_url("live/editRoominfo");?>'+'/'+roomid+'/'+cate+'/1', 'show');
}
</script>

</body>
</html>
