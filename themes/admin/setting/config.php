<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="<?php echo base_url($cfg['comm'])?>/js/kindeditor/themes/default/default.css" />
<script type="text/javascript" language="javascript">
	uploadimage('<?php echo site_url('upload/doUploadImg/pages');?>','<?php echo base_url();?>');
</script>

<div class="so_main">
  <div class="page_tit">站点配置</div>
  
  <div class="form2">
  	<form id="configform" name="configform">
	<?php foreach ($list as $k=>$v ) {?>
    <dl class="lineD">
      <dt><?php echo $v['confnote']?>：</dt>
      <dd>
		<?php if ($v['fieldtype'] == 'text') {?>
			<input name="<?php echo $v['confkey']?>" type="<?php echo $v['fieldtype']?>" value="<?php echo $v['confval']?>" size="60">
		<?php } else if ($v['fieldtype'] == 'textarea') {?>
			<textarea cols="50" rows="3" name="<?php echo $v['confkey']?>"><?php echo $v['confval']?></textarea>
		<?php }  else if ($v['fieldtype'] == 'img') {?>
			<INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="<?php echo $v['confval']?>">
				      <img id="imgshow" width="130" height="120" src="<?php if ($v['confval'] != '') echo base_url($v['confval']); else echo base_url('themes/admin/css/images/noimg.jpg') ?>"/><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="imagesupload" title="上传图片">上传图片</a>&nbsp;<a href="###" id="cancelimg">取消图片</a>
		<?php } else if ($v['fieldtype'] == 'checkbox') { ?> 
		<input type="checkbox" name="<?php echo $v['confkey']?>" <?php if ($v['confval'] == '1') { ?> checked="true" <?php }?> value="1" />
		<?php } else if ($v['fieldtype'] == 'radio') {?>  
		<input type="radio" name="<?php echo $v['confkey']?>" <?php if ($v['confval'] == '0') { ?> checked="checked" <?php }?> value="0">否
		<input type="radio" name="<?php echo $v['confkey']?>" <?php if ($v['confval'] == '1') { ?> checked="checked" <?php }?> value="1">是
		<?php } else if ($v['fieldtype'] == 'select') {?> 
			<select name="<?php echo $v['confkey']?>">
				<?php foreach ($setting[$v['confkey']] as $k2 => $v2) { ?>
				<option value="<?php echo $v2['id'] ?>" <?php if ($v['confval'] == $v2['id']) { ?>selected<?php } ?>><?php echo $v2['name'] ?></option>
				<?php } ?>
			</select>
		<?php }?>
		<?php if (!empty($v['memo'])) echo  "说明：" . $v['memo'] ?>
      </dd>  
    </dl>
	<?php } ?>

    <div class="page_btm">
      <input type="button" class="btn_b" onclick="submitSet(<?php echo $settingid?>)"   value="确定" />
    </div>
    </form>
  </div>
</div>
<script type="text/javascript">
function submitSet(id)
{
	postdata('configform', "<?php echo site_url("admin/setting/index");?>"+"/"+id, 'wshow');
}

</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>