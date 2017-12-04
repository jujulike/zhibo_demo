<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
	<form id="form1">	
		<INPUT TYPE="hidden" NAME="roomid" value="<?php echo $row['roomid'];?>">
		<INPUT TYPE="hidden" NAME="userid" value="<?php echo $row['userid'];?>">
		<div class="form3">
        <table >
		     <tr>
                <td class="tbtitle">直播主题(<span style="color:red">*</span>)</td>
                <td>
					<input type="text"  style="width:250px" name="mastertitle" id="mastertitle" value="<?php echo set_value('mastertitle', $row['mastertitle']); ?>" />
				</td>
            </tr>
           
				<tr>
					<td class="tbtitle">直播主题介绍</td>
					<td>
						<textarea name="masterinfo" id="masterinfo" style="height:100px; width:250px"><?php echo set_value('masterinfo', $row['masterinfo']); ?></textarea>
					</td>
				</tr>
            <tr>
                <td class="tbtitle">关注度</td>
                <td>
					<input type="text" name="hits" id="hits" value="<?php echo set_value('hits', $row['hits']); ?>" />
				</td>
            </tr>
            <tr>
                <td class="tbtitle">当前状态</td>
                <td>
				<label><input type="radio" name="status" value="0" <?php if($row['status'] == '0'){ ?> checked <?php } ?> >未开始</label>&nbsp;		
				<label><input type="radio" name="status" value="1" <?php if($row['status'] == '1'){ ?> checked <?php } ?> >进行中</label>&nbsp;&nbsp;
				<label><input type="radio" name="status" value="2" <?php if($row['status'] == '2'){ ?> checked <?php } ?> >已结束</label>&nbsp;
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
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
<script type="text/javascript">
function submitSet()
{
	postdata('form1', "<?php echo site_url("admin/livemaster/edit/" . $row['masterid']);?>", 'show');
}

</script>

</body>
</html>
