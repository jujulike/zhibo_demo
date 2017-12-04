<?php $this->load->view($cfg['tpl_admin'] . 'public/header')?>
<div class="so_main">
  <div class="Toolbar_inbox">
  	<div class="page right"></div>
	<a  class="btn_a" href="<?php echo site_url("handan/tlist") . '/' . $masterid . '/day' ?>"><span>今日喊单</span></a>
	<a  class="btn_a" href="<?php echo site_url("handan/tlist") . '/' . $masterid . '/curweek' ?>"><span>本周喊单</span></a>
	<a  class="btn_a" href="<?php echo site_url("handan/tlist") . '/' . $masterid . '/lastweek' ?>"><span>上周喊单</span></a>
	<a  class="btn_a" href="<?php echo site_url("handan/tlist") . '/' . $masterid . '/curmonth' ?>"><span>当月喊单</span></a>
	<a  class="btn_a" href="<?php echo site_url("handan/tlist") . '/' . $masterid . '/all' ?>"><span>全部</span></a>
  </div>
  <div class="list">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th class="line_l" width="8%">分析师</th>
	<th class="line_l" width="8%">商品名称</th>
	<th class="line_l" width="14%">开仓时间</th>
	<th class="line_l" width="8%">类型</th>
	<th class="line_l" width="5%">开仓价</th>
    <th class="line_l" width="5%">止损价</th>
    <th class="line_l" width="5%">止盈价</th>
    <th class="line_l" width="14%">平仓时间</th>
    <th class="line_l" width="5%">平仓价</th>
    <th class="line_l" width="8%">获利点数</th>
  </tr>
		<?php if(!empty($list)) {?>
	  <?php foreach ($list as $k=>$v) {?>
		<tr overstyle='on' id="user_1">
		<td><?php echo $v['author']; ?></td>
		<td><?php echo $v['handan_product']; ?></td>
		<td><?php echo $v['opentime']; ?></td>
		<td><?php echo $v['handan_type']; ?></td>
		<td><?php echo $v['openprice']; ?></td>
		<td><?php echo $v['stopprice']; ?></td>
		<td><?php echo $v['stopsurplus']; ?></td>
		<td><?php echo $v['closetime']; ?></td>
		<td><?php echo $v['closeprice']; ?></td>
		<td><?php echo $v['earnpoint']; ?></td>
		</tr>
		<?php } }?>
	</table>
  </div>

<td colspan="9"><div class="page">记录:<?php if(!empty($pagecount)){  echo $pagecount;} else {echo '0';} ?> 条&nbsp;&nbsp;<?php if(!empty($page)){ echo $page;}?></div></td>

<script type="text/javascript">
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

</script>
<?php $this->load->view($cfg['tpl_admin'] . 'public/footer')?>
