<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="page_tit">广告管理</div>
  <!-------- 搜索用户 -------->
  
  <!-------- 广告列表 -------->
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a href="<?php echo site_url('admin/advertisement/add/' . $func . '/' .$alias)?>" class="btn_a"><span>添加广告</span></a>
	<a href="<?php echo site_url('admin/category/tlist/' . $func . '/' . $alias)?>" class="btn_a"><span>分类列表</span></a>

  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
		<input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
    	<label for="checkbox"></label>
	</th>
    <th class="line_l" width="50px">ID</th>
	<th class="line_l" width="250px">分类名称</th>
    <th class="line_l" width="250px">标题</th>
	<th class="line_l" width="50px">排序</th>
    <th class="line_l">状态</th>
    <th class="line_l">操作</th>
  </tr>
	  </tr>
	  <form id="form1" name="form1" action="" method="post">
	  <?php foreach ($list as $k=>$v) {?>
	  <tr overstyle='on' id="user_1">
	  	<td><input type="checkbox" name="advertid[]" id="checkbox2" onclick="checkon(this)" value="<?php echo $v['advertid']; ?>"></td>
			    <td><?php echo $v['advertid']; ?></td>
	    <td><?php if (!empty($v['cateinfo'])) echo $v['cateinfo']['catename']; ?></td>
	    <td><?php echo $v['title']; ?></td>
		<td><?php echo $v['sort']; ?></td>
	    <td><?php if ($v['status'] == '1') { ?><B>激活</B><?php } else { ?><B style="color:red">未激活</B><?php } ?></td>
	    <td>
			<a href="<?php echo site_url('admin/advertisement/editAdvertisement/' . $v['advertid'] . '/' . $func . '/' .$alias)?>">编辑</a>
			<a href="javascript:copyAdvertisement(<?php echo $v['advertid']; ?>,'<?php echo $alias?>');">复制</a>
			<a href="javascript:delAdvertisement(<?php echo $v['advertid']; ?>,'<?php echo $alias?>');">删除</a>
					</td>
			</tr>
		<?php }?>
		</form>
	</table>
  </div>
<td colspan="9"><div class="page">记录:<?php echo $pagecount; ?> 条&nbsp;&nbsp;<?php echo $page;?></div></td>

  <div class="Toolbar_inbox">
	<div class="page right"></div>
	<a target="_blank" href="<?php echo site_url('admin/advertisement/add/' . $func . '/' .$alias)?>" class="btn_a"><span>添加广告</span></a>
	<a  class="btn_a"  onclick="delMoreAdvertisement('<?php echo $alias?>')"><span>删除广告</span></a>
	<a href="<?php echo site_url('admin/category/tlist/' . $func . '/' . $alias)?>" class="btn_a"><span>分类列表</span></a>
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
			$('input[name="advertid[]"]').attr('checked','true');
			$('tr[overstyle="on"]').addClass("bg_on");
		}else{
			$('input[name="advertid[]"]').removeAttr('checked');
			$('tr[overstyle="on"]').removeClass("bg_on");
		}
	}

	//获取已选择用户的ID数组
	function getChecked() {
		var uids = new Array();
		$.each($('table input:checked'), function(i, n){
			uids.push( $(n).val() );
		});
		return uids;
	}

	
	function folder(type, _this) {
		$('#search_'+type).slideToggle('fast');
		if ($(_this).html() == '展开') {
			$(_this).html('收起');
		}else {
			$(_this).html('展开');
		}
		
	}

	// 添加
	function add(func,alias) {
//	$.jBox("get:<?php echo site_url('admin/user/add')?>");
	$.jBox("iframe:<?php echo site_url('admin/advertisement/add')?>" + "/"+func+"/"+alias, {
			title: "广告添加",
			iframeScrolling: 'auto',
			height: 570,
			width: 450,
			buttons: { '关闭': true }
		});
		}

	//编辑
	function editAdvertisement(advertid,func,alias)
	{
		$.jBox.open('iframe:<?php echo site_url("admin/advertisement/editAdvertisement");?>'+"/"+advertid+"/"+func+"/"+alias, "广告修改", 450, 570, { buttons: { '关闭': true} });
	}

	//复制
	function copyAdvertisement(advertid,alias)
	{
			$.get("<?php echo site_url('admin/advertisement/copyAdvertisement');?>"+"/"+advertid+"/"+alias, 
			function(data){
				var d = eval('(' + data + ')');
				wshow(d);
			});
	}

	//删除
	function delAdvertisement(advertid,alias)
	{
	var submit = function (v, h, f) {
		if (v == 'ok')
			$.get("<?php echo site_url('admin/advertisement/delAdvertisement');?>"+"/"+advertid+"/"+alias, 
			function(data){
				var d = eval('(' + data + ')');
				wshow(d);
			});
		else if (v == 'cancel')
//			jBox.tip(v, 'info');
		return true; //close
	};

	$.jBox.confirm("确定删除该广告吗？", "提示", submit);

}

	function delMoreAdvertisement(alias)
	{
		postdata('form1', "<?php echo site_url('admin/advertisement/delMoreAdvertisement');?>"+"/"+alias, 'wshow');
	}

</script>


<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>