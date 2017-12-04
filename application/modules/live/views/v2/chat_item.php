<?php 
if (!empty($chatlist)) {
	foreach($chatlist as $k => $v) {
?>

		<div id="audit_<?php echo $v['chatid']?>" class="talk  public member">		<span>
			<?php if($v['level']==0){?>
			<img class="roleimg" src="/themes/v2/static/images/15hy.png" title="普通会员">
			<?php }elseif($v['level']==1){?>
			<img class="roleimg" src="/themes/v2/static/images/14byVIP.png" title="白银VIP">
			<?php }elseif($v['level']==2){?>
			<img class="roleimg" src="/themes/v2/static/images/13hjVIP.png" title="黄金VIP">
			<?php }elseif($v['level']==3){?>
			<img class="roleimg" src="/themes/v2/static/images/12bjVIP.png" title="铂金会员">
			<?php }elseif($v['level']==4){?>
			<img class="roleimg" src="/themes/v2/images/visitorlist_icon_member2.png" title="钻石会员">
			<?php }elseif($v['level']==5){?>
			<img class="roleimg" src="/themes/v2/static/images/10zzVIP.png" title="至尊会员">
			<?php }elseif($v['level']==6){?>
			<img class="roleimg" src="/themes/v2/static/images/9cz.png" title="财主会员">
			<?php }elseif($v['level']==7){?>
			<img class="roleimg" src="/themes/v2/static/images/8th.png" title="土豪会员">

			<?php }elseif($v['level']==-2){?>
			<img class="roleimg" src="/themes/v2/static/images/1gly.png" title="房间管理员">
			<?php }elseif($v['level']==-3){?>
			<img class="roleimg" src="/themes/v2/static/images/6lszl.png" title="老师助理">
			<?php }elseif($v['level']==-4){?>
			<img class="roleimg" src="/themes/v2/static/images/7khjl.png" title="客服经理">
			<?php }elseif($v['level']==-6){?>
			<img class="roleimg" src="/themes/v2/images/visitorlist_icon_member2.png" title="讲师">

			<?php }else{?>
			<img class="roleimg" src="/themes/v2/static/images/17yk.png" title="游客">
			<?php } ?>
		</span>
		<div class="talk_name">
			<a href="javascript:void(0)" class="u_mor" rid="224" uid="4405" ondblclick="javascript:$('#sendMsgInput').val('@'+$(this).html()+': ');"><?php echo $v['chatname']?></a>
			<?php if($v['touname']) { ?>
				<i style="float:left;color:#FFF;font-style:normal;margin-right:5px;background-color: #EC781A; padding: 0 4px; border-radius: 4px;">对</i><a href="javascript:void(0)" class="u_mor" ondblclick="javascript:$('#sendMsgInput').val('@'+$(this).html()+': ');"><?php echo $v['touname']?></a>
				<i style="float:left;color:#FFF;font-style:normal;margin-right:10px;">说：</i>
			<?php } ?>
			<a class="time"><?php echo date("[H:i]", $v['ctime'])?></a>
			<?php if ($v['status'] == 0) { ?>
				<a id="chataudit" href="javascript:void(0)" onclick="chataudit(<?php echo $v['chatid'] ?>, 1)">审核消息</a>
			<?php } ?>
		</div>		<div class="clear"></div>		
		<div class="talk_hua">
		<p>
		<?php
			$content=$v['chatcontent'];
			if(empty($v['sourceimg'])){
				$content=preg_replace('/\[img=(.*?)\]/','<img src="$1">',$content);
			}else{
				$content=preg_replace('/\[img=(.*?)\]/','<img src="$1" title="点击看大图" onclick="talk_pic(\''.$v['sourceimg'].'\')">',$content);
			}
			 echo @$content;
		 ?>
		 </p>
		 </div>
		 <div class="clear"></div>
		 </div>
	<?php }?>
	<script type="text/javascript">
		$("#lastchatid").val('<?php echo empty($v["chatid"]) ? 0 : $v["chatid"]?>');
	</script>
<?php
} elseif ($nextid > 0) {
    echo '<script type="text/javascript">';
    echo '$("#lastchatid").val(' . $nextid . ');';
    echo '</script>';
}
?>
