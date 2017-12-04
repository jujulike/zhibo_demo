<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="<?php echo base_url($cfg['comm'])?>/js/kindeditor/themes/default/default.css" />
<script type="text/javascript" language="javascript">
	uploadimage('<?php echo site_url('upload/doUploadImg/pages');?>','<?php echo base_url();?>');
	fulleditor('<?php echo site_url('upload/doUploadImg/pages');?>','content');
</script>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="pageid" value="<?php echo $row['pageid'];?>">
  <div class="form2">
	<dl class="lineD">
      <dt>分类名称：</dt>
      <dd>
         <SELECT NAME="cateid">
			<OPTION VALUE="0" SELECTED>顶级分类
			<?php echo $parentcate; ?>
		</SELECT>
    </dl>
    <dl class="lineD">
      <dt>标题：</dt>
      <dd>
        <input name="title" id="title" type="text" value="<?php echo $row['title'];?>"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>图片：</dt>
      <dd>
        <INPUT TYPE="hidden" NAME="imgthumb" id="imgthumb" value="<?php echo $row['imgthumb']?>">				
				      <img id="imgshow" width="130" height="120" src="<?php if ($row['imgthumb'] != '') echo base_url($row['imgthumb']); else echo base_url('themes/admin/css/images/noimg.jpg') ?>"/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="imagesupload" title="上传图片">上传图片</a>&nbsp;<a href="###" id="cancelimg">取消图片</a>
    </dl>
	<dl class="lineD">
      <dt>简介：</dt>
      <dd>
        <textarea name='desc'><?php echo $row['desc'];?></textarea>
    </dl>
	<dl class="lineD">
      <dt>内容：</dt>
      <dd>
        <textarea name="content" id="content" style="width: 600px;"><?php echo set_value('content', $row['content']); ?></textarea>
    </dl>
	<!--<dl class="lineD">
      <dt>模板选择：</dt>
      <dd>
        <SELECT NAME="templateid">
			<?php echo $template; ?>
		</SELECT>
    </dl>-->
	<dl class="lineD">
      <dt style="float:left">作者：</dt>
      <dd>
        <input type="text" name="author" value="<?php echo $row['author']?>"/>
    </dl>
	<dl class="lineD">
	<dt style="float:left">关键字：</dt>
      <dd>
        <input type="text" name="keywords" value="<?php echo $row['keywords']?>"/>
	</dl>
	<dl class="lineD">
      <dt>排序：</dt>
      <dd>
        <input name="sort" id="sort" type="text" value="<?php echo $row['sort'];?>"/>
    </dl>
	<dl class="lineD">
      <dt>是否激活：</dt>
      <dd>
        <label><input name="status" type="radio" value="1" <?php if ($row['status'] == '1') {?> checked <?php } ?>>激活</label>
        <label><input name="status" type="radio" value="0" <?php if ($row['status'] == '0') {?> checked <?php } ?>>未激活</label>
    </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="editPage()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>



<script type="text/javascript">
function editPage()
{
	editor.sync();
	postdata('form1', "<?php echo site_url('admin/pages' . '/'.$action.'/' . $row['pageid']);?>", 'dd');
}

function dd(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			window.location.href="<?php echo site_url('admin/pages/')?>";
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

</script>