<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $this->load->view('admin/public/meta');?>
<script type="text/javascript" src="<?php echo base_url('assets/kindeditor/kindeditor-min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/kindeditor/lang/zh_CN.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/initkind.js')?>"></script>
<script type="text/javascript" language="javascript">
	uploadimage('<?php echo site_url('upload/doUploadImg/pages');?>','<?php echo base_url();?>');
	fulleditor('<?php echo site_url('upload/doUploadImg/pages');?>','content');
</script>
</head>

<body>
<div id="append"></div>
<div class="container">
	<div style="color: #f00;"></div>
<div class="hastabmenu" >
    <div  class="tabcontentcur" style="width:680px;">
        <form id="form1" name="form1" method="post">		
			<input type="hidden" name="pagesid" value="<?php echo $row['pagesid']?>"/>
        <table width="680" >
		
            <tr>
                <td width="77" class="tbtitle">标题<span style=" color:#ff0000">*</span></td>
                <td >
					<input type="text" name="title" value="<?php echo $row['title']?>" style="width: 300px;"/>				</td>
					<td width="362" rowspan="4">
					&nbsp;&nbsp;
						<INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="<?php echo $row['imgthumb']?>">				
				      <img id="imgshow" width="130" height="120" src="<?php if ($row['imgthumb'] != '') echo base_url($row['imgthumb']); else echo base_url('themes/images/public/noimg.jpg') ?>"/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="imagesupload" title="上传图片">上传图片</a>&nbsp;<a href="###" id="cancelimg">取消图片</a> </td>
            </tr>          

			<tr>
                <td class="tbtitle">关键字&nbsp;</td>
                <td><input type="text" name="keywords" value="<?php echo $row['keywords']?>" style="width: 300px;"/>		</td>
            </tr>         
            <tr>
                <td class="tbtitle">简介(SEO)</td>
                <td><textarea name="desc" id="desc" style="width: 300px;"><?php echo set_value('desc', $row['desc']); ?></textarea>	</td>
            </tr>

			<tr>
                <td class="tbtitle">作者</td>
                <td>
					<input type="text" name="author" value="<?php echo $row['author']?>" style="width: 100px;"/></td>
            </tr>			
            <tr>
                <td class="tbtitle">内容</td>
                <td colspan="3">
					<textarea name="content" id="content" style="width: 600px;"><?php echo set_value('content', $row['content']); ?></textarea>				</td>
            </tr>
			<tr>
                <td class="tbtitle">状态<span style=" color:#ff0000">*</span></td>
                <td colspan="3">
					<label><input type="radio" name="status" value="1" <?php if ($act == 'add') {?>checked <?php } ?><?php if($row['status'] == '1'){ ?> checked <?php } ?> >有效</label>&nbsp;&nbsp;
					<label><input type="radio" name="status" value="0" <?php if($row['status'] == '0'){ ?> checked <?php } ?> >无效</label>&nbsp;				</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3">
   
                    <input type="button" name="submit_button" id="btn_submit" value="提交" class="btn" onclick="submitSet()" />                </td>
            </tr>
        </table>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
function submitSet()
{
	editor.sync();
	postdata('form1', "<?php echo site_url('admin/pages' . '/' . $act . '/' . $row['cateid']);?>", 'show');
}

</script>

</body>
</html>
