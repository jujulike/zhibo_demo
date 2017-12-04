<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit"><a href="<?php echo site_url('admin/zt/listApply/'.$zt_id)?>">返回申请列表</a></div>
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="zt_id" value="<?php echo $zt_id;?>">
  <div class="form2">
	<dl class="lineD">
      <dt><span>*</span>客户类型：</dt>
      <dd>
         <SELECT NAME="user_type">
			<option value="1" <?php if ($row['user_type'] == '1'){?>selected="selected"<?php }?>>新客户</option>
			<option value="2" <?php if ($row['user_type'] == '2'){?>selected="selected"<?php }?>>老客户</option>
		</SELECT>
    </dl>
    <dl class="lineD">
      <dt><span>*</span>真实姓名：</dt>
      <dd>
        <input name="real_name" id="real_name" type="text" value="<?php echo $row['real_name'];?>">
    </dl>
	<dl class="lineD">
      <dt>手机号码：</dt>
      <dd>
        <input name="mobile" id="mobile" type="text" value="<?php echo $row['mobile'];?>">
    </dl>
	<dl class="lineD">
      <dt>身份证号码：</dt>
      <dd>
        <input name="card_no" id="card_no" type="text" value="<?php echo $row['card_no'];?>">
    </dl>
	<dl class="lineD">
      <dt>QQ：</dt>
      <dd>
        <input name="qq" id="qq" type="text" value="<?php echo $row['qq'];?>">
    </dl>
	<dl class="lineD">
      <dt>预计入金：</dt>
      <dd>
        <input name="push_money" id="push_money" type="text" value="<?php echo $row['push_money'];?>">万
    </dl>
	<dl class="lineD">
      <dt style="float:left"><span>*</span>颁发的奖品：</dt>
      <dd>
        <textarea name="note"><?php echo $row['note']?></textarea>
    </dl>
	<dl class="lineD">
      <dt>申请状态：</dt>
      <dd>
        <input type="radio" name="status" value="1" <?php if ($row['status'] == '1'){?>checked="checked"<?php }?>>已颁发
		<input type="radio" name="status" value="0" <?php if ($row['status'] != '1'){?>checked="checked"<?php }?>>未颁发
    </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="editApply()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>



<script type="text/javascript">
function editApply()
{
	postdata('form1', "<?php echo site_url('admin/zt' . '/'.$action.'/' . $row['id']);?>", 'dd');
}

function dd(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			window.location.href="<?php echo site_url('admin/zt/listApply/'.$zt_id)?>";
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

</script>