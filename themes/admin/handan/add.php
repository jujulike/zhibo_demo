<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/DatePicker/WdatePicker.js"></script>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="id" value="<?php echo $row['id'];?>">
		<INPUT TYPE="hidden" NAME="masterid" value="<?php if (empty($row['masterid'])) echo $masterid; else echo $row['masterid'] ;?>">
		
  <div class="form3">
    <dl class="lineD">
      <dt>商品名称</dt>
      <dd>
	  <select name="handan_product">
		<?php foreach ($handan_product as $k => $v) { ?>
			<option value="<?php echo $v['name'] ?>" <?php if ($v['name'] == $row['handan_product']) { ?>selected<?php } ?>><?php echo $v['name'] ?></option>
		<?php } ?>
	  </select>
	  </dd>
	 </dl>
    <dl class="lineD">
      <dt>开仓时间</dt>
      <dd><input name="opentime"  type="text" value="<?php if (!empty($row['opentime'])) { echo $row['opentime']; } else { echo date("Y-m-d H:i:s"); } ?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',disabledDates:['%y-%M-%d {%H-1}\:..\:..','%y-%M-%d {%H+1}\:..\:..']})"></dd>
	 </dl>

    <dl class="lineD">
      <dt>类型</dt>
      <dd>
	  <select name="handan_type">
		<?php foreach ($handan_type as $k => $v) { ?>
			<option value="<?php echo $v['name'] ?>" <?php if ($v['name'] == $row['handan_type']) { ?>selected<?php } ?>><?php echo $v['name'] ?></option>
		<?php } ?>
	  </select>
	  </dd>
	 </dl>
    <dl class="lineD">
      <dt>仓位</dt>
      <dd><input name="position"  type="text" value="<?php echo $row['position'] ?>">&nbsp;%</dd>
	 </dl>
    <dl class="lineD">
      <dt>开仓价</dt>
      <dd><input name="openprice"  type="text" value="<?php echo $row['openprice'] ?>"></dd>
	 </dl>
    <dl class="lineD">
      <dt>止损价</dt>
      <dd><input name="stopprice"  type="text" value="<?php echo $row['stopprice'] ?>"></dd>
	 </dl>
    <dl class="lineD">
      <dt>止盈价</dt>
      <dd><input name="stopsurplus"  type="text" value="<?php echo $row['stopsurplus'] ?>"></dd>
	 </dl>
    <dl class="lineD">
      <dt>平仓时间</dt>
      <dd><input name="closetime"  type="text" value="<?php if (!empty($row['closetime'])) { echo $row['closetime']; } else{ echo date("Y-m-d H:i:s"); } ?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',disabledDates:['%y-%M-%d {%H-1}\:..\:..','%y-%M-%d {%H+1}\:..\:..']})"></dd>
	 </dl>
    <dl class="lineD">
      <dt>平仓价</dt>
      <dd><input name="closeprice"  type="text" value="<?php echo $row['closeprice'] ?>"></dd>
	 </dl>
    <dl class="lineD">
      <dt>获利点数</dt>
      <dd><input name="earnpoint"  type="text" value="<?php echo $row['earnpoint'] ?>"></dd>
	 </dl>
	 <dl class="lineD">
      <dt>备注</dt>
      <dd><input name="bak"  type="text" value="<?php echo $row['bak'] ?>"></dd>
	 </dl>
	 <dl class="lineD">
      <dt>分析师</dt>
      <dd><input name="author"  type="text" value="<?php echo $row['author'] ?>"></dd>
	 </dl>
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="act()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>

<script type="text/javascript">
function act()
{
	postdata('form1', "<?php echo site_url('admin/handan/act/' . $masterid .  '/' . $row['id']);?>", 'retdo');
}

function retdo(d)
{
	if (d.code == '1')
	{
		$.jBox.tip('修改成功', 'success');
		window.setTimeout(function () {
			parent.location.href="<?php echo site_url('admin/handan/tlist/' . $masterid)?>";
		}, 1000);
	}
	else
	{
		$.jBox.tip('修改失败', 'error');
	}
}
</script>