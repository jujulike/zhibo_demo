<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">在线预约列表</div>
  <!-------- 广告列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a  class="btn_a"  onclick="delMore()"><span>删除</span></a>
  </div>
  <div class="list">
  	  <form id="form1" name="form1" action="" method="post">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" width="50px">真实姓名</th>
	<th class="line_l" width="100px">电话</th>
    <th class="line_l" width="150px">身份证号码</th>
	<th class="line_l" width="120px">邮箱</th>
	<th class="line_l" width="120px">地址</th>
	<th class="line_l" width="150">注册金额</th>
	<th class="line_l" width="100">服务时间</th>
	<th class="line_l" width="100">注册时间</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="id[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['id']; ?>"></td>
		<td><?php echo $v['name']; ?></td>
	    <td><?php echo $v['phone']; ?></td>
		<td><?php echo $v['cardnumber']; ?></td>
		<td><?php echo $v['email']; ?></td>
	    <td><?php echo $v['address']; ?></td>
		<td><?php echo $v['regmoney']; ?></td>
		<td><?php echo $v['servertime']; ?></td>
		<td><?php echo date("m-d H:i", $v['ctime']); ?></td>
	    <td>
			<a href="javascript:delContent(<?php echo $v['id']; ?>);">删除</a>
		</td>
			</tr>
		<?php }?>
	</table>
</form>
  </div>
<td colspan="9"><div class="page">记录:<?php echo $pagecount; ?> 条&nbsp;&nbsp;<?php echo $page;?></div></td>

  <div class="Toolbar_inbox">
	<div class="page right"></div>
	<a  class="btn_a"  onclick="delMore()"><span>删除</span></a>
  </div>
</div>
<script>
	//鼠标移动表格效果
	$(document).ready(function(){
		$("tr[overstyle='on']").hover(
		  function () {
		    $(this).addClass("bg_hover");
		  },
		  function () {
		    $(this).removeClass("bg_hover");
		  }
		);
	});
	
	function checkon(o){
		if( o.checked == true ){
			$(o).parents('tr').addClass('bg_on') ;
		}else{
			$(o).parents('tr').removeClass('bg_on') ;
		}
	}
	
	function checkAll(o){
		if( o.checked == true ){
			$('input[name="id[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="id[]"]').removeAttr('checked');
			$('tr[overstyle="on"]').removeClass("bg_on");
		}
	}
	

	function folder(type, _this) {
		$('#search_'+type).slideToggle('fast');
		if ($(_this).html() == '展开') {
			$(_this).html('收起');
		}else {
			$(_this).html('展开');
		}
		
	}


	//删除
	function delContent(id)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/service/del');?>"+"/"+id, 
			function(d){
				var data = eval('('+d+')');
				wshow(data);
			});
		else if (v == 'cancel')
//			jBox.tip(v, 'info');
		return true; //close
	};

	$.jBox.confirm("确定删除该申请吗？", "提示", submit);

	}

	function delMore()
	{
		postdata('form1', "<?php echo site_url('admin/service/delMore');?>", 'wshow');
	}

</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>