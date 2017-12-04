<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
        <form id="form1">
		<INPUT TYPE="hidden" NAME="roomid" value="<?php echo $row['roomid'];?>">
		<INPUT TYPE="hidden" NAME="userid" value="<?php echo $row['userid'];?>">
		<INPUT TYPE="hidden" NAME="cateid" value="<?php echo $row['cateid'];?>">
		<div class="form3">
        <table >
		     <tr>
                <td class="tbtitle">直播室名称(<span style="color:red">*</span>)</td>
                <td>
					<input type="text" name="roomname" id="roomname" value="<?php echo set_value('roomname', $row['roomname']); ?>" />
				</td>
            </tr>
				<tr>
					<td class="tbtitle">直播室简介</td>
					<td>
						<textarea name="roominfo" id="masterinfo" style="height:50px;width:250px"><?php echo set_value('roominfo', $row['roominfo']); ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="tbtitle">申请人简介</td>
					<td>
						<textarea name="userinfo" id="userinfo" style="height:50px;width:250px"><?php echo set_value('userinfo', $row['userinfo']); ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="tbtitle">申请理由</td>
					<td>
						<textarea name="reason" id="reason" style="height:50px;width:250px"><?php echo set_value('reason', $row['reason']); ?></textarea>
					</td>
				</tr>			
			<tr>
			<td class="tbtitle">排序</td>
			<td>
				<input type="text" name="sort" id="sort" value="<?php echo set_value('sort', $row['sort']); ?>" />
				</td>
			</tr>
			<tr>
				<td class="tbtitle">联系人</td>
				<td><input type="text" name="linkman" id="linkman" value="<?php echo set_value('linkman', $row['linkman']); ?>" /></td>
			</tr>
			<tr>
				<td class="tbtitle">联系电话</td>
				<td><input type="text" name="linkphone" id="linkphone" value="<?php echo set_value('linkphone', $row['linkphone']); ?>" /></td>
			</tr>
			<tr>
				<td class="tbtitle">联系QQ</td>
				<td><input type="text" name="linkqq" id="linkqq" value="<?php echo set_value('linkqq', $row['linkqq']); ?>" /></td>
			</tr>
            <tr>
                <td class="tbtitle">当前状态</td>
                <td>
					<label><input type="radio" name="status" value="1" <?php if($row['status'] == '1'){ ?> checked <?php } ?> >已通过审核</label>&nbsp;&nbsp;
					<label><input type="radio" name="status" value="0" <?php if($row['status'] == '0'){ ?> checked <?php } ?> >未通过审核</label>&nbsp;
				</td>
            </tr>
			<tr>
                <td class="tbtitle"></td>
                <td>
					<INPUT TYPE="button" VALUE="确定" ONCLICK="submitSet()" class="btn_b">&nbsp;<INPUT TYPE="reset" class="btn_b">
				</td>
            </tr>
        </table>
		</div>
        </form>
    </div>
<script type="text/javascript">
function submitSet()
{
	postdata('form1', "<?php echo site_url("admin/liveapp/modi/" . $row['roomid']);?>", 'show');
}

</script>

</body>
</html>
