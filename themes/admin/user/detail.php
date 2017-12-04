<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
	<form id="form1">
		<INPUT TYPE="hidden" NAME="view" value="manage/user/modi_user">
		<INPUT TYPE="hidden" NAME="userid" value="<?php echo $row['userid'];?>">
		<INPUT TYPE="hidden" NAME="passwd" value="<?php echo $row['passwd'];?>">
	<div class="form3">
        <table width="280" >	
		
            <tr>
                <td width="100" class="tbtitle">用户帐号<span style=" color:#ff0000">*</span></td>
                <td width="180">
			  <input type="text" name="username" id="username" readonly value="<?php echo $row['username'];?>" />				</td>
               <!-- <td width="205" rowspan="4"><INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="<?php echo $row['imgthumb']?>">				
				<img id="imgshow" width="130" height="120" src="<?php if ($row['imgthumb'] != '') echo base_url($row['imgthumb']); else echo base_url('themes/images/public/noimg.jpg') ?>"/><br/>
				&nbsp;&nbsp;<a href="#" id="imagesupload" title="上传头像">上传头像</a>&nbsp;&nbsp;<a href="#" id="cancelimg">取消头像</a> &nbsp;</td>-->
            </tr>
            <tr>
                <td class="tbtitle">用户密码<span style=" color:#ff0000">*</span></td>
                <td>
					<input type="password" name="newpasswd" id="newpasswd"  value="<?php echo set_value('newpasswd'); ?>" /><Br/>密码不改则留空				</td>
            </tr>
            <tr>
                <td class="tbtitle">确认密码<span style=" color:#ff0000">*</span></td>
                <td>
					<input type="password" name="repasswd" id="repasswd"  value="<?php echo set_value('repasswd'); ?>" />				</td>
            </tr>
				<tr>
					<td class="tbtitle">姓名</td>
					<td>
						<input type="text" name="name" id="name" value="<?php echo set_value('name', $row['name']); ?>" />					</td>
			    </tr>
			<tr>
					<td class="tbtitle">QQ</td>
					<td>
						<input type="text" name="qq" id="qq" value="<?php echo set_value('qq', $row['qq']); ?>" />					</td>
				    <td>&nbsp;</td>
			</tr>

            <tr>
                <td class="tbtitle">电话</td>
                <td>
					<input type="text" name="phone" id="phone"  value="<?php echo set_value('phone', $row['phone']); ?>" />				</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="tbtitle">性别</td>
                <td>
				<label><INPUT TYPE="radio" NAME="gender" value="1" <?php if ($row['gender'] == '1') {?> checked <?php } ?>  />男</label>&nbsp;
				<label><INPUT TYPE="radio" NAME="gender" value="2" <?php if ($row['gender'] == '2') {?> checked <?php } ?>  />女</label>&nbsp;
				<label><INPUT TYPE="radio" NAME="gender" value="0" <?php if ($row['gender'] == '0') {?> checked <?php } ?> />未知</label>				</td>
                <td>&nbsp;</td>
            </tr>
			<!--<tr>
                <td class="tbtitle">用户身份</td>
                <td>
                    <?php echo $ismaster; ?>				</td>
                <td>&nbsp;</td>
			</tr>-->
			<tr>
                <td class="tbtitle">用户等级</td>
                <td>
                    <?php echo $level;?>				</td>
                <td>&nbsp;</td>
			</tr>
			<tr>
                <td class="tbtitle">帐号状况</td>
                <td>
				<label><INPUT TYPE="radio" NAME="status" value="1" <?php if ($row['status'] == '1') {?> checked <?php } ?>  />正常</label>&nbsp;
				<label><INPUT TYPE="radio" NAME="status" value="0" <?php if ($row['status'] == '2') {?> checked <?php } ?>  />屏蔽</label>&nbsp;
				</td>
                <td>&nbsp;</td>
			</tr>
			<tr>
                <td class="tbtitle"></td>
                <td>
					<input type="button" class="btn_b" value="提交" ONCLICK="submitUserModi()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b"></td>
                <td>&nbsp;</td>
			</tr>
        </table>
	 </div>
 </div>
 <?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
<script type="text/javascript">
function submitUserModi()
{
	postdata('form1', '<?php echo site_url("admin/user/modi/" . $row['userid']);?>', 'show');
}

</script>

</body>
</html>
