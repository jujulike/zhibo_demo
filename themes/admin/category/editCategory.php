<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">
	<?php if ($act == 'modi') { ?>
		<INPUT TYPE="hidden" NAME="cateid" value="<?php echo $row['cateid'];?>">
	<?php } ?>
  <div class="form3">
    <dl class="lineD">
      <dt>所属类别：</dt>
      <dd>
        <SELECT NAME="parentid">
			<OPTION VALUE="0" SELECTED>顶级分类
			<?php echo $parentcate; ?>
		</SELECT>
    </dl>
	<dl class="lineD">
      <dt>类别名称：</dt>
      <dd>
        <input type="text" name="catename" id="catename" value="<?php echo set_value('catename', $row['catename']); ?>" />
    </dl>
	<dl class="lineD">
      <dt>所属应用：</dt>
      <dd>
        <input type="text" name="func" id="func" value="<?php echo set_value('func', $row['func']); ?>" readonly="true"/>
    </dl>
	<dl class="lineD">
      <dt>别名标识：</dt>
      <dd>
        <input type="text" name="alias" id="alias" value="<?php echo set_value('alias', $row['alias']); ?>" />
    </dl>
	<dl class="lineD">
      <dt>排序：</dt>
      <dd>
        <input type="text" name="sort" id="sort" value="<?php echo set_value('sort', $row['sort']); ?>" />
    </dl>
	<dl class="lineD">
      <dt>描述：</dt>
      <dd>
        <textarea name="info" id="info" style="height:50px;"><?php echo set_value('info', $row['info']); ?></textarea>
    </dl>

     <!--<dl class="lineD">
      <dt>可用平台：</dt>
      <dd>
	  <?php echo $showtype?>
		</dd>
-->
	<dl class="lineD">
      <dt>是否激活：</dt>
      <dd>
        <label><input name="status" type="radio" value="1" <?php if ($row['status'] == '1') {?> checked <?php } ?>>激活</label>
        <label><input name="status" type="radio" value="2" <?php if ($row['status'] == '2') {?> checked <?php } ?>>未激活</label>
    </dl>
	
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="submitSet()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>



<script type="text/javascript">
function submitSet()
{
	postdata('form1', "<?php echo site_url('admin/category' . '/' . $act . '/' . $row['cateid']);?>", 'show');
}

</script>