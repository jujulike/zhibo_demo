<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片裁剪</title>
		<link href="<?php echo base_url('themes/comm/js/jcrop/css/jquery.Jcrop.css')?>" rel="stylesheet" media="all" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url('themes/comm/js/kindeditor/themes/default/default.css')?>" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url('themes/comm/js/jBox/Skins/Blue/jbox.css')?>"/>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.js')?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/jquery.form.js')?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/jcrop/js/jquery.Jcrop.min.js')?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/kindeditor/kindeditor-min.js')?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/kindeditor/lang/zh_CN.js')?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/jquery.jBox-2.3.min.js')?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/jBox/i18n/jquery.jBox-zh-CN.js')?>"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url('themes/comm/js/cutting.js')?>" type="text/javascript"></script>
</head>
<script type="text/javascript">

var flag = "<?php echo $sourceimage?>";

if (flag != '')
	{
		jQuery(function($){
		  // Create variables (in this scope) to hold the API and image size
		  var jcrop_api;
		  
		  var size = $("#psize").val().split("*");
						  
		  var width = parseInt(size[0]);
		  
		  var height = parseInt(size[1]);
		  $('#sourcepic').Jcrop({
			onChange: updatePreview,
			onSelect: updatePreview,
			setSelect: [0, 0, width, height],
			minSize: [width, height],
			allowResize: true,
			aspectRatio: width/height
		  },function(){
			// Store the API in the jcrop_api variable
			var bounds = this.getBounds();
			boundx = bounds[0];
			boundy = bounds[1];
			jcrop_api = this;
		  });
		

		 function updatePreview(c)
		  {
			if (parseInt(c.w) > 0)
			{
			  var rx = width / c.w;
			  var ry = height / c.h;
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			}
		  };
		});
	}

			cutimage('<?php echo site_url("module/upload/cutting/doUploadImg/header")?>','<?php echo base_url()?>');
			// 预期宽度，预期高度
			function submitImage(aimw, aimh)
			{
				$("#aimw").val(aimw);
				$("#aimh").val(aimh);

				if (($("#x").val() == '') ||
					($("#y").val() == '') ||
					($("#w").val() == '') ||
					($("#h").val() == '') ||
					($("#aimw").val() == '') ||
					($("#aimh").val() == ''))
				{
					$.jBox.tip("请先截图..", 'error');
					return false;
				}


				$.jBox.tip("正在上传...", 'loading');
					// 模拟2秒后完成操作

				postdata('uploadform', "<?php echo site_url('module/upload/cutting/cutting'); ?>" + "/" + aimw + "/" + aimh, 'ret');

			}
			
			function ret(d)
			{
				if (d.code == '1')
				{
					<?php if ((!empty($haspath)) && ($haspath == '1')) { ?>
						$(window.parent.document).find("#<?php echo $element?>").val(d.pic_<?php echo $width?>_<?php echo $height?>);
						$(window.parent.document).find("#<?php echo $source?>").val(d.msg);
						$(window.parent.document).find("#imgshow").html('');
						$(window.parent.document).find("#imgshow").attr('src', '<?php echo base_url()?>' + '/' + d.pic_<?php echo $width?>_<?php echo $height?>);
						 $.jBox.tip('图片上传成功', 'success'); 
						window.setTimeout(function () {window.parent.window.jBox.close();}, 2000);
					<?php } else { ?>
						
					<?php } ?>
				}
				else
				{
					 window.setTimeout(function () { $.jBox.tip('图片上传失败', 'error'); }, 1000);				
				}
			}
		</script>
<body>
<div class="box_card">
	
	<div class="box_cardcon">
		<div class="boxcon1 mt8">
			<div class="clear"></div>
			<!--个人档案 开始-->			
			<div class="boxcon" >
			<form id="uploadform">
			<table>
			<tr>
				<td><div class="cardcon reducebox"  style="overflow:auto;width:500px;height:400px;">
						<?php if ($sourceimage != '') {?><img id="sourcepic" src="<?php echo base_url($sourceimage)?>"><?php } else {?><img id="sourcepic"><?php }?>
					</div>
					<input type="hidden" name="psize" id="psize" value="<?php echo $width?>*<?php echo $height?>">
					<input type="hidden" name="x" id="x">
					<input type="hidden" name="y" id="y">
					<input type="hidden" name="w" id="w">
					<input type="hidden" name="h" id="h">
					<input type="hidden" name="aimw" id="aimw">
					<input type="hidden" name="aimh" id="aimh">
					<input type="hidden" value="<?php echo $sourceimage?>" id="attach_name" name="attach_name">
				</td>
			</tr>
			<tr>
				<td align="center">
					<div style="padding:10px;">
					  <p class="gray"><?php if (empty($flag)) {?><input type="button" class="button3" value="上 传 图 片" id="upload_image">&nbsp;&nbsp;<?php }?><input type="button" value="确 定" onclick="submitImage(<?php echo $width?>, <?php echo $height?>);" class="button3" /></p>
					</div>
				</td>
			<tr>
			</table>		
			</form>
				<!--个人商务名片 结束-->
				<div class="clear"></div>								
			</div>
			
		</div>
	</div>	
</div>   
</body>
</html>
