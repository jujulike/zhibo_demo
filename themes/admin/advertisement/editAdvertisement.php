<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="<?php echo base_url($cfg['comm'])?>/js/kindeditor/themes/default/default.css" />
<script type="text/javascript" language="javascript">
	uploadbutton("<?php echo site_url('upload/doUploadImg/userimgthumb');?>",'<?php echo base_url();?>','<?php echo site_url('module/upload/cutting/showpage2/imgthumb/sourceimage')?>');
	fulleditor('<?php echo site_url('upload/doUploadImg/news');?>','content');
	function cancelimg() 
	{
		$('#imgthumb').val('');
		$('#sourceimage').val('');
		$('#imgshow').attr('src', '<?php echo base_url("themes/admin/css/images/noimg.jpg")?>');
	}

</script>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="advertid" value="<?php echo $row['advertid'];?>">
  <div class="form4">
	<dl class="lineD">
      <dt>分类名称：</dt>
      <dd>
         <SELECT NAME="cateid">
			<OPTION VALUE="0" SELECTED>顶级分类
			<?php echo $parentcate; ?>
		</SELECT>
    </dl>
    <dl class="lineD">
      <dt>广告名称：</dt>
      <dd>
        <input name="title" id="title" type="text" value="<?php echo $row['title'];?>"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>广告链接：</dt>
      <dd>
        <input name="link" id="link" type="text" value="<?php echo $row['link'];?>">
    </dl>
	<dl class="lineD">
      <dt>广告位尺寸：</dt>
      <dd>
       <input name="width" id="width" type="text" value="<?php echo $row['width'];?>" style="width:40px">&nbsp;*&nbsp;
	   <input name="height" id="height" type="text" value="<?php echo $row['height'];?>" style="width:40px">&nbsp;px
    </dl>
	<dl class="lineD">
      <dt>图片：</dt>
      <dd>
        <INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="<?php echo $row['imgthumb']?>">
		<INPUT TYPE="hidden" NAME="sourceimage" id="sourceimage" value="<?php echo $row['sourceimage']?>">	
				      <img id="imgshow" src="<?php if ($row['imgthumb'] != '') echo base_url($row['imgthumb']); else echo base_url('themes/admin/css/images/noimg.jpg') ?>"/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="uploadButton" value="上传图片" title="上传图片">上传图片</a>&nbsp;<a href="###" id="cancelimg" onclick="cancelimg()">取消图片</a>
    </dl>
	<dl class="lineD">
      <dt>广告简介：</dt>
      <dd>
        <textarea  style="width: 600px;"  name='desc' id="content"><?php echo $row['desc'];?></textarea>
    </dl>
	<dl class="lineD">
      <dt>是否公开：</dt>
      <dd>
        <label><input name="ispublic" type="radio" value="1" <?php if ($row['ispublic'] == '1') {?> checked <?php } ?>>公开</label>
        <label><input name="ispublic" type="radio" value="0" <?php if ($row['ispublic'] == '0') {?> checked <?php } ?>>未公开</label>
    </dl>
	<dl class="lineD">
      <dt>广告类别：</dt>
      <dd>
        <SELECT NAME="adtype">
			<OPTION VALUE="" SELECTED>
			<?php echo $adtype; ?>
		</SELECT>
    </dl>
	<dl class="lineD">
      <dt>排序：</dt>
      <dd>
        <input name="sort" id="sort" type="text" value="<?php echo $row['sort'];?>">
    </dl>
	<dl class="lineD">
      <dt>是否激活：</dt>
      <dd>
        <label><input name="status" type="radio" value="1" <?php if ($row['status'] == '1') {?> checked <?php } ?>>激活</label>
        <label><input name="status" type="radio" value="0" <?php if ($row['status'] == '0') {?> checked <?php } ?>>未激活</label>
    </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="editAdvertisement()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>



<script type="text/javascript">
function editAdvertisement()
{
	editor.sync();
	postdata('form1', "<?php echo site_url('admin/advertisement' . '/'.$action.'/' . $row['advertid']);?>", 'retdo');
}

function retdo(d)
{
	if (d.code == '1')
	{
		$.jBox.tip('修改成功', 'success');
		window.setTimeout(function () {
			window.location.href="<?php echo site_url('admin/advertisement/tlist/'.$alias)?>";
		}, 1000);
	}
	else
	{
		$.jBox.tip('修改失败', 'error');
	}
}

function uploadPhoto()
{
	var width = $("#width").val();
	var height = $("#height").val();
	var sourceimage = "<?php echo base64_encode($row['sourceimage']);?>";

	if (width == '' || width == 0)
	{
		$.jBox.tip('请输入图片尺寸', 'error'); 
		return false;
	}

	if (height == '' || height == 0)
	{
		$.jBox.tip('请输入图片尺寸', 'error'); 
		return false;
	}

	$.jBox("iframe:<?php echo site_url('module/upload/cutting/showpage')?>" + "/imgthumb/sourceimage/"+width+"/"+height+"/"+sourceimage, {
		title: "上传图片",
		width: 800,
		height: 550,
		iframeScrolling: 'no',
		buttons: {'关闭': true}
		
	});	
}

</script>