<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
        <form id="form1">		
		<INPUT TYPE="hidden" NAME="roomid" value="<?php echo $row['roomid'];?>">
		<INPUT TYPE="hidden" NAME="userid" value="<?php echo $row['userid'];?>">
		<div class="form3">
        <table width="300" >
		     <tr>
                <td width="100" class="tbtitle">直播室名称</td>
                <td width="200">
					<input type="text" name="roomname" id="roomname" value="<?php echo set_value('roomname', $row['roomname']); ?>" />				</td>
               <!-- <td width="208" rowspan="5"><INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="<?php echo $row['imgthumb']?>">				
				<img id="imgshow" width="130" height="120" src="<?php if ($row['imgthumb'] != '') echo base_url($row['imgthumb']); else echo base_url('themes/images/public/noimg.jpg') ?>"/><br/>
				&nbsp;&nbsp;<a href="#" id="imagesupload" title="上传头像">上传直播室图像</a>&nbsp;&nbsp;<a href="#" id="cancelimg">取消图像</a>&nbsp;</td>-->
	        </tr>
            <tr>
                <td class="tbtitle">所属栏目</td>
                <td>
				<SELECT NAME="cateid">
					<OPTION VALUE="" SELECTED>
					<?php echo $cateid;?>
				</SELECT>				</td>
            </tr>
            <tr>
                <td class="tbtitle">排序</td>
                <td>
					<input type="text" name="sort" style="width:30px;" id="sort" value="<?php echo set_value('sort', $row['sort']); ?>" />&nbsp;关注度&nbsp;<input type="text" name="hits" id="hits" value="<?php echo set_value('hits', $row['hits']); ?>" style="width:30px;" />				</td>
            </tr>
				<tr>
					<td class="tbtitle">播主</td>
					<!--<td><?php echo $row['name'] . '(' . $row['username'] . ')'; ?></td>-->
					<td><?php foreach ($row['master'] as $k => $v) { echo $v . '<br>';}?></td>
			    </tr>
				<!--
				<?php if ($row['user_imgthumb'] != '') { ?>
				<tr>
				  <td class="tbtitle">&nbsp;</td>
		          <td><img src="<?php echo base_url($row['user_imgthumb'])?>"  width="130" height="120" /></td>
				</tr>
				<?php } ?> -->          
            <tr>
                <td class="tbtitle">直播室介绍</td>
                <td colspan="2">
					<label>
					<textarea name="roominfo" id="textarea" style="height:200px;width:160px"><?php echo set_value('roominfo', $row['roominfo']); ?></textarea>
			  </label></td>
            </tr>
			<tr>
                <td class="tbtitle">直播室密码</td>
                <td colspan="2">
					<input type="text" name="roompass" id="roompass" value="<?php echo set_value('roompass', $row['roompass']); ?>" />			</td>
            </tr>	
 <tr>
                <td class="tbtitle">是否关闭</td>
                <td colspan="2">
					<label><input type="radio" name="status" value="1" <?php if($row['status'] == '1'){ ?> checked <?php } ?> >开启</label>&nbsp;&nbsp;
					<label><input type="radio" name="status" value="-1" <?php if($row['status'] == '0'){ ?> checked <?php } ?> >关闭</label>&nbsp;				</td>
            </tr>			
			<tr>
                <td class="tbtitle"></td>
                <td colspan="2">
					<INPUT TYPE="button" class="btn_b" VALUE="确定" ONCLICK="submitSet()">&nbsp;<INPUT TYPE="reset" class="btn_b">				</td>
            </tr>
        </table>
		</div>
        </form>
    </div>
<script type="text/javascript">
function submitSet()
{
	postdata('form1', "<?php echo site_url("admin/liveroom/modi/" . $row['roomid']);?>", 'show');
}

</script>

</body>
</html>
