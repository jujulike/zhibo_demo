<?php $this->load->view($cfg['tpl'] . "public/meta2");?>

<style type="text/css">
<!--
.login{ background:#FEFAF1; border:1px solid #E7D5B4}
.login h6{ font-weight:100; border-bottom:1px solid #f0f0f0; text-indent:8px; padding:8px 0}
.box-login{ overflow:hidden; width:210px; margin:5px 8px}
.box-login td{ padding:6px 0; line-height:16px}
.login-con{border-top:1px solid #f0f0f0; padding:15px 0 20px 0; text-align:center; color:#666; line-height:24px}
.login-con .num{ font-family:'Arial'; font-weight:700; font-size:20px; color:#ff9000}
-->
</style>
<div class="login clearfix">
<h6>您如何看当前的行情？</h6>
			<form name="voteform" id="voteform">
			<table border="0" class="box-login">
				<tbody>
				<tr>
					<td width="45" style="text-align:right">&nbsp;&nbsp;</td>
					<td width="165"><label><input type="radio" name="vote" value="1"/>&nbsp;&nbsp;看多</label></td>
				</tr>
				<tr>
					<td width="45" style="text-align:right">&nbsp;&nbsp;</td>
					<td width="165"><label><input type="radio" name="vote" value="-1"/>&nbsp;&nbsp;看空</label></td>
				</tr>
				<tr>
					<td width="45" style="text-align:right">&nbsp;&nbsp;</td>
					<td width="165"><label><input type="radio" name="vote" value="0"/>&nbsp;&nbsp;震荡</label></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onclick="setVote()" value="确 定" class="login-button">&nbsp;&nbsp;
					</td>
				</tr>
			</tbody></table>			
			</form>			
</div>
<script type="text/javascript">

function setVote()
{
	var _flag = -2;
	$("input[type='radio']").each(function(i){
		if (this.checked) _flag = $(this).val();
	});

	if (_flag == -2)
	{
		$.jBox.tip('请确认您的选择','info');
		return false;
	}


	$.ajax({
		type: "POST",
		url: '<?php echo site_url("vote");?>',
		dataType: "json",
		data: "vote="+ _flag,
		success: function(d){
			if (d.code == '1')
			{
				$.jBox.tip(d.msg, 'success');
			}
			else
				$.jBox.tip(d.msg, 'error');
		}
	});
}

</script>
