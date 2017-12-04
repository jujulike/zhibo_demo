<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo base_url($cfg['comm'])?>/js/DatePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url($cfg['comm'])?>/js/kindeditor/themes/default/default.css" />
<script type="text/javascript" language="javascript">
	fulleditor('<?php echo site_url('upload/doUploadImg/news');?>','content');
</script>
<div class="so_main">
 
  <form id="form1" name="form1" action="" method="post">		
		<INPUT TYPE="hidden" NAME="articleid" value="<?php echo $row['id'];?>">
  <div class="form2">
	<!--<dl class="lineD">
      <dt><span>*</span>所属分类：</dt>
      <dd>
         <SELECT NAME="cateid">
			<?php echo $parentcate; ?>
		</SELECT>
    </dl>-->
    <dl class="lineD">
      <dt><span>*</span>专题标题：</dt>
      <dd>
        <input name="title" id="title" type="text" value="<?php echo $row['title'];?>" style="width:600px">
    </dl>
	<dl class="lineD">
      <dt><span>*</span>专题活动日期：</dt>
      <dd>
        <input name="btime" id="btime" type="text" onClick="WdatePicker()" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'etime\')}'})" value="<?php  echo $row['btime']?>" /> 至 
		<input name="etime" id="etime" type="text" onClick="WdatePicker()" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'btime\')}'})" value="<?php echo $row['etime']?>" />
    </dl>
	<dl class="lineD">
      <dt>专题详细：</dt>
      <dd>
        <textarea name="content" id="content" style="width: 600px;height:400px"><?php echo set_value('content', $row['content']); ?></textarea>
    </dl>
	<dl class="lineD">
      <dt>专题引言：</dt>
      <dd>
        <textarea name="desc" id="desc" style="width: 600px;height:200px"><?php echo  $row['desc']; ?></textarea>
    </dl>
	<dl class="lineD">
      <dt style="float:left">主办单位：</dt>
      <dd>
        <input type="text" name="organizer" value="<?php echo $row['organizer']?>" style="width:600px" />
    </dl>
	<dl class="lineD">
      <dt style="float:left">专题模板：</dt>
      <dd>
		<select name="zt_template">
			<?php echo $zt_tempalte?>
		</select>
    </dl>
	<dl class="lineD">
      <dt style="float:left">活动奖品份数：</dt>
      <dd>
        <input type="text" name="reward_number" value="<?php echo $row['reward_number']?>" />
    </dl>
	<!--<dl class="lineD">
      <dt style="float:left">承办单位：</dt>
      <dd>
        <input type="text" name="sponsors" value="<?php echo $row['sponsors']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">官方网站：</dt>
      <dd>
        <input type="text" name="url" value="<?php echo $row['url']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left"><span>*</span>联系人：</dt>
      <dd>
        <input type="text" name="contact" value="<?php echo $row['contact']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left"><span>*</span>联系电话：</dt>
      <dd>
        <input type="text" name="phone" value="<?php echo $row['phone']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">联系手机：</dt>
      <dd>
        <input type="text" name="mobile" value="<?php echo $row['mobile']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">通讯地址：</dt>
      <dd>
        <input type="text" name="postaladdress" value="<?php echo $row['postaladdress']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">邮政编码：</dt>
      <dd>
        <input type="text" name="zip" value="<?php echo $row['zip']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">联系传真：</dt>
      <dd>
        <input type="text" name="fax" value="<?php echo $row['fax']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">电子邮件：</dt>
      <dd>
        <input type="text" name="email" value="<?php echo $row['email']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">联系MSN：</dt>
      <dd>
        <input type="text" name="msn" value="<?php echo $row['msn']?>"/>
    </dl>
	<dl class="lineD">
      <dt style="float:left">联系QQ：</dt>
      <dd>
        <input type="text" name="qq" value="<?php echo $row['qq']?>"/>
    </dl>-->
    <div class="page_btm">
      <input type="button" class="btn_b" value="确定" ONCLICK="editZt()" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<INPUT TYPE="reset" class="btn_b">
    </div>
  </div>
  </form>
</div>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>



<script type="text/javascript">
function editZt()
{
	editor.sync();
	postdata('form1', "<?php echo site_url('admin/zt' . '/'.$action.'/' . $row['id']);?>", 'dd');
}

function dd(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			window.location.href="<?php echo site_url('admin/zt')?>";
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

</script>