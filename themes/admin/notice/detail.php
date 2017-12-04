<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="<?php echo base_url($cfg['comm'])?>/js/kindeditor/themes/default/default.css" />
<script type="text/javascript" language="javascript">
	fulleditor('<?php echo site_url('upload/doUploadImg/notice');?>','content');
</script>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="articleid" value="<?php echo $row['noticeid'];?>" >
  <div class="form2">
    <dl class="lineD">
      <dt>公告标题：</dt>
      <dd>
        <input name="title" id="title" type="text" style="width:600px" value="<?php echo $row['title'];?>"><span>*</span>
    </dl>
	<dl class="lineD">
      <dt>公告链接：</dt>
      <dd>
        <input name="link" id="link" type="text" style="width:600px" value="<?php echo $row['link'];?>">不填则公告详细内容已对话框弹出
    </dl>
	<dl class="lineD">
      <dt>详细内容：</dt>
      <dd>
        <textarea name="content" id="content" style="width: 600px;height:400px"><?php echo set_value('content', $row['content']); ?></textarea>
    </dl>
	<dl class="lineD">
      <dt style="float:left">作者：</dt>
      <dd>
        <input type="text" name="author" value="<?php echo $row['author']?>"/>
    </dl>
	<!--<dl class="lineD">
      <dt>排序：</dt>
      <dd>
        <input name="sort" id="sort" type="text" value="<?php echo $row['sort'];?>"/>
    </dl>-->
	<dl class="lineD">
      <dt>是否激活：</dt>
      <dd>
        <label><input name="status" type="radio" value="1" <?php if ($row['status'] == '1') {?> checked <?php } ?>>激活</label>
        <label><input name="status" type="radio" value="0" <?php if ($row['status'] == '0') {?> checked <?php } ?>>未激活</label>
    </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="editArticle()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>



<script type="text/javascript">
function editArticle()
{
	editor.sync();
	postdata('form1', "<?php echo site_url('admin/notice' . '/'.$action.'/' . $row['noticeid']);?>", 'dd');
}

function dd(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			window.location.href="<?php echo site_url('admin/notice/')?>";
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

</script>