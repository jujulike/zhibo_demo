<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
  <div class="form4">
    <dl class="lineD">
      <dt>提问者：</dt>
      <dd>
        <?php echo $row['questionname'];?>&nbsp;&nbsp;&nbsp;&nbsp;提问时间：<?php echo date("Y-m-d H:i:s",$row['ctime']);?>
    </dl>
	<dl class="lineD">
      <dt>问题：</dt>
      <dd>
        <?php echo $row['questioncontent'];?>
    </dl>
	<?php if (!empty($row['mtime'])) {?>
	<dl class="lineD">
      <dt>回答者：</dt>
      <dd>
        <?php echo $row['answername'];?>&nbsp;&nbsp;&nbsp;&nbsp;回答时间：<?php echo date("Y-m-d H:i:s",$row['mtime']);?>
    </dl>
	<dl class="lineD">
      <dt>回答：</dt>
      <dd>
        <?php echo $row['answercontent'];?>
    </dl>
	<?php } else {?>
	<dl class="lineD">
      <dt>回答：</dt>
      <dd>
        未回答
    </dl>
	<?php }?>
    <div class="page_btm">
      <INPUT TYPE="button" class="btn_b" value="返回" onclick="window.location='<?php echo site_url('admin/qacontent')?>'">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>