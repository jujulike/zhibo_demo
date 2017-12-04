<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="<?php echo base_url($cfg['comm'])?>/js/kindeditor/themes/default/default.css" />
<script type="text/javascript" language="javascript">
	uploadimage('<?php echo site_url('upload/doUploadImg/pages');?>','<?php echo base_url();?>');
</script>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="id" value="<?php echo $row['id'];?>">
  <div class="form4">
    <dl class="lineD">
      <dt>Logo名称：</dt>
      <dd>
        <input name="title" id="title" type="text" value="<?php echo $row['title'];?>">
    </dl>
	<dl class="lineD">
      <dt>Logo图片：</dt>
      <dd>
        <INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="<?php echo $row['imgthumb']?>">				
				      <img id="imgshow" width="130" height="120" src="<?php if ($row['imgthumb'] != '') echo base_url($row['imgthumb']); else echo base_url('themes/admin/css/images/noimg.jpg') ?>"/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="imagesupload" title="上传图片">上传图片</a>&nbsp;<a href="###" id="cancelimg">取消图片</a>
    </dl>
	<dl class="lineD">
      <dt>Logo简介：</dt>
      <dd>
        <textarea name='desc'><?php echo $row['desc'];?></textarea>
    </dl>
	<dl class="lineD">
      <dt>是否激活：</dt>
      <dd>
        <label><input name="status" type="radio" value="1" <?php if ($row['status'] == '1') {?> checked <?php } ?>>激活</label>
        <label><input name="status" type="radio" value="0" <?php if ($row['status'] == '0') {?> checked <?php } ?>>未激活</label>
    </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="editLogo()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>



<script type="text/javascript">
function editLogo()
{
	postdata('form1', "<?php echo site_url('admin/setting' . '/'.$action.'/' . $row['id']);?>", 'show');
}

</script>