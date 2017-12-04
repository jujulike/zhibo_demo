
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
.newtitle{border:1px solid #ddd; padding:2px 5px; height:20px; line-height:20px; width:150px}
.red{color:red}
.newtextarea{border:1px solid #ddd; padding:2px 5px; height:70px; line-height:20px; width:300px}
-->
</style>
<body>
<!---------------------------顶部 -------------------------------------------------->

<!---------------------------内容区 #main -------------------------------------------------->
<div class="login clearfix">
			<form name="regform" id="regform">
			<INPUT TYPE="hidden" NAME="userid" value="<?php echo $row['userid'];?>">
			<table border="0" class="box-login">
			<tbody>
			<tr>
					<td width="100" style="text-align:right">直播房间名称(<span class="red">*</span>)：</td>
					<td width="165"><input type="text" name="roomname"  class="newtitle"></td>
				</tr>
			<tr>
				<td style="text-align:right">所属栏目(<span class="red">*</span>)：</td>
				<td>
				<?php foreach ($native as $k => $v) {?>
				<label><INPUT TYPE="radio" NAME="cateid" value="<?php echo $v['cateid']?>" /><?php echo $v['catename']?></label>&nbsp;
				<?php }?>
				</td>
			</tr>
			<tr>
				<td style="text-align:right;">直播时间段：</td>
				<td>
					<SELECT NAME="btime" id="btime">
					<OPTION VALUE="" SELECTED>   
					<OPTION VALUE="0">0
					<OPTION VALUE="1">1
					<OPTION VALUE="2">2
					<OPTION VALUE="3">3
					<OPTION VALUE="4">4
					<OPTION VALUE="5">5
					<OPTION VALUE="6">6
					<OPTION VALUE="7">7
					<OPTION VALUE="8">8
					<OPTION VALUE="9">9
					<OPTION VALUE="10">10
					<OPTION VALUE="11">11
					<OPTION VALUE="12">12
					<OPTION VALUE="13">13
					<OPTION VALUE="14">14
					<OPTION VALUE="15">15
					<OPTION VALUE="16">16
					<OPTION VALUE="17">17
					<OPTION VALUE="18">18
					<OPTION VALUE="19">19
					<OPTION VALUE="20">20
					<OPTION VALUE="21">21
					<OPTION VALUE="22">22
					<OPTION VALUE="23">23
				</SELECT>-
				<SELECT NAME="etime" id="etime">
					<OPTION VALUE="">   
				</SELECT>
				</td>
			</tr>
			<tr>
				<td style="text-align:right">直播间简介：</td>
				<td><TEXTAREA NAME="roominfo" ROWS="4" COLS="" class="newtextarea" ></TEXTAREA></td>
			</tr>		
			
			<tr>
				<td style="text-align:right">申请人简介：</td>
				<td><TEXTAREA NAME="userinfo" ROWS="4" COLS="" class="newtextarea" ></TEXTAREA></td>
			</tr>		

			<tr>
				<td style="text-align:right">申请理由：</td>
				<td><TEXTAREA NAME="reason" ROWS="4" COLS="" class="newtextarea" ></TEXTAREA></td>
			</tr>	
			<tr>
				<td style="text-align:right">联系人：</td>
				<td><input type="text" class="newtitle" name="linkman"  value="<?php echo $row['name'];?>" ></td>
			</tr>				
			
			<tr>
				<td style="text-align:right">联系电话：</td>
				<td><input type="text" class="newtitle" name="linkphone"  style="width:120px;" value="<?php echo $row['phone'];?>" >
				QQ<input type="text" class="newtitle" style="width:120px;" name="qq" value="<?php echo $row['qq'];?>" ></td>
			</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="padding-top:15px"><input type="button" onclick="roomapp()" value=" 申 请 " class="login-button">&nbsp;&nbsp;</td>
				</tr>

			</tbody></table>			
			</form>
<script type="text/javascript">
function roomapp()
{
	postdata('regform', '<?php echo site_url("live/roomapp");?>', 'show');
}



$(document).ready(function(){

	$("#btime").change(function(){
		var hour = $(this).val();
		var optstr = '';
		for(var i = hour; i <= 23; i++)
		{
			optstr = optstr + "<option value='" + i +"'>" + i;
		}

		$("#etime").html(optstr);
	});
});
</script>

</body>
</html>
