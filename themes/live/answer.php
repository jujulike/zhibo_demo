
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
.newtitle{border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:200px}
.red{color:red}
.newtextarea{border:1px solid #ddd; padding:2px 5px; height:100px; line-height:20px; width:300px}
-->
</style>
<body>
<!---------------------------顶部 -------------------------------------------------->

<!---------------------------内容区 #main -------------------------------------------------->
<div class="login clearfix">
			<form name="regform" id="regform">
			<INPUT TYPE="hidden" NAME="answeruserid" value="<?php echo $userinfo['userid']?>">
			<INPUT TYPE="hidden" NAME="answername" value="<?php echo $userinfo['name']?>">
			<INPUT TYPE="hidden" NAME="questionid" value="<?php echo $row['questionid']?>">
			<INPUT TYPE="hidden" NAME="questionname" value="<?php echo $row['questionname']?>">
			<INPUT TYPE="hidden" NAME="questionuserid" value="<?php echo $row['questionuserid']?>">
			<INPUT TYPE="hidden" NAME="masterid" value="<?php echo $row['masterid']?>">
			<INPUT TYPE="hidden" NAME="ctime" value="<?php echo $row['ctime']?>">
			<table border="0" class="box-login">
			<tbody>
			<tr>
				<td width="50">问题：</td>
				<td width="200"><TEXTAREA name="questioncontent" class="newtextarea" readonly ><?php echo $row['questioncontent']?></TEXTAREA></td>
				</tr>		
			<tr>
				<td>回答：</td>
				<td><TEXTAREA NAME="content" ROWS="4" COLS="" class="newtextarea" ><?php echo $row['answercontent']?></TEXTAREA></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><label><input type="checkbox" name="tolive" <?php if ($row['tolive'] == '1') {?> checked="checked" <?php }?>/>&nbsp;推荐到直播区</label></td>
			</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onClick="answer(<?php echo $row['questionid']?>)" value=" 回 答 " class="login-button">&nbsp;&nbsp;</td>
				</tr>

			</tbody></table>			
			</form>
<script type="text/javascript">
function answer(id)
{
	postdata('regform', '<?php echo site_url("live/setAnswer");?>'+'/'+id, 'retanswer');
}

function retanswer(d)
{
	if(d.code == '1'){
		$("#question_" + d.delid, parent.document).remove();
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			top.tabshow($('.tab', parent.document).find("a[rel='qa']"));
			top.$.jBox.close();
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
	}
</script>

</body>
</html>
