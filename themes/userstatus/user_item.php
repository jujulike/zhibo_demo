<?php 
if (!empty($mnhy)) { 
foreach($mnhy as $k => $v) {?>
<li id="u_<?php echo $v['userid'] ?>" uid="" rid="" name="<?php echo $v['name']?>" ip="undefined" <?php if($v['role'] == '1') echo 'style="display: none;" class="manager"'; ?>>
	<span style="float:left;">
		<?php  if($v['level']=='0'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/15hy.png" title="普通会员">
			<?php } else if($v['level']=='1'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/14byVIP.png" title="白银VIP">
			<?php } else if($v['level']=='2'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/13hjVIP.png" title="黄金VIP">
			<?php } else if($v['level']=='3'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/12bjVIP.png" title="铂金会员">
			<?php } else if($v['level']=='4'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/14byVIP.png" title="钻石会员">
			<?php }elseif($v['level']==5){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/10zzVIP.png" title="至尊会员">
			<?php }elseif($v['level']==6){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/9cz.png" title="财主会员">
			<?php }elseif($v['level']==7){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/images/8th.png" title="土豪会员">
			<?php } ?>

	</span>		<a href="javascript:void(0)" class="f_left"><?php echo $v['name']?></a>
        
        	<span style="float:right">
		<?php  if($v['level']=='0'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/15hy.png" title="普通会员">
			<?php } else if($v['level']=='1'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/14byVIP.png" title="白银VIP">
			<?php } else if($v['level']=='2'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/13hjVIP.png" title="黄金VIP">
			<?php } else if($v['level']=='3'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/12bjVIP.png" title="铂金会员">
			<?php } else if($v['level']=='4'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/14byVIP.png" title="钻石会员">
			<?php }elseif($v['level']==5){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/10zzVIP.png" title="至尊会员">
			<?php }elseif($v['level']==6){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/9cz.png" title="财主会员">
			<?php }elseif($v['level']==7){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>themes/v2/static/djimages/8th.png" title="土豪会员">
			<?php } ?>
		<?php 
                }
                ?>
		
	</span>	
</li>
		<?php 
                }
                ?>

<?php
if (!empty($useronline)) { 
foreach($useronline as $k => $v){?>
		<?php if (!empty($userstatus[$v['userid']]['vtime'])
					&& ($userstatus[$v['userid']]['vtime'] > time())
					&& ($userstatus[$v['userid']]['status'] == '1')
				) { continue; } ?>


<li id="u_<?php echo $v['userid'] ?>" uid=""  rid="<?php echo $v['userid']?>" chatname="<?php echo $v["name"]?>" name="<?php echo $v['name']?>" ip="undefined" <?php if($v['role'] == '1' && $v["level"]>7){ echo 'style="display: none;" class="manager qwname"';}else{ echo 'class="qwname"';} ?>>
	<span style="float:left;">
		<?php if ($v['role'] == '1') {
                    if($v['level']=='0'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/15hy.png" title="普通会员">
			<?php } else if($v['level']=='1'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/14byVIP.png" title="白银VIP">
			<?php } else if($v['level']=='2'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/13hjVIP.png" title="黄金VIP">
			<?php } else if($v['level']=='3'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/12bjVIP.png" title="铂金会员">
			<?php } else if($v['level']=='4'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/14byVIP.png" title="钻石会员">
			<?php }elseif($v['level']==5){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/10zzVIP.png" title="至尊会员">
			<?php }elseif($v['level']==6){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/9cz.png" title="财主会员">
			<?php }elseif($v['level']==7){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/8th.png" title="土豪会员">
			<?php }elseif($v['level']=='8'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/1gly.png" title="房间管理员">
			<?php } else if($v['level']=='9'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/6lszl.png" title="老师助理">
			<?php } else if($v['level']=='10'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/7khjl.png" title="客服经理">
			<?php } else if($v['level']=='11'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/images/visitorlist_icon_member2.png" title="讲师">
			<?php } else {?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/images/visitorlist_icon_member2.png" title="客服">
			<?php } ?>
		<?php } else if ($v['role'] == '0') {
                        if($v['level']=='0'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/15hy.png" title="普通会员">
			<?php } else if($v['level']=='1'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/14byVIP.png" title="白银VIP">
			<?php } else if($v['level']=='2'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/13hjVIP.png" title="黄金VIP">
			<?php } else if($v['level']=='3'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/12bjVIP.png" title="铂金会员">
			<?php } else if($v['level']=='4'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/14byVIP.png" title="钻石会员">
			<?php }elseif($v['level']==5){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/10zzVIP.png" title="至尊会员">
			<?php }elseif($v['level']==6){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/9cz.png" title="财主会员">
			<?php }elseif($v['level']==7){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/8th.png" title="土豪会员">
			<?php } ?>
		<?php  } else if ($v['role'] == '-1') {?>
		<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/17yk.png" title="游客">
		<?php }?>

	</span>		<a href="javascript:void(0)" class="f_left"><?php echo $v['name']?></a>
        
        	<span style="float:right">
		<?php if ($v['role'] == '1') { 
                        if($v['level']=='0'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/15hy.png" title="普通会员">
			<?php } else if($v['level']=='1'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/14byVIP.png" title="白银VIP">
			<?php } else if($v['level']=='2'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/13hjVIP.png" title="黄金VIP">
			<?php } else if($v['level']=='3'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/12bjVIP.png" title="铂金会员">
			<?php } else if($v['level']=='4'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/14byVIP.png" title="钻石会员">
			<?php }elseif($v['level']==5){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/10zzVIP.png" title="至尊会员">
			<?php }elseif($v['level']==6){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/9cz.png" title="财主会员">
			<?php }elseif($v['level']==7){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/8th.png" title="土豪会员">
			<?php }elseif($v['level']=='8'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/1gly.png" title="房间管理员">
			<?php } else if($v['level']=='9'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/6lszl.png" title="老师助理">
			<?php } else if($v['level']=='10'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/7khjl.png" title="客服经理">
			<?php } else if($v['level']=='11'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/images/visitorlist_icon_member2.png" title="讲师">
			<?php } else {?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/images/visitorlist_icon_member2.png" title="客服">
			<?php } ?>
		<?php } else if ($v['role'] == '0') { if($v['level']=='0'){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/15hy.png" title="普通会员">
			<?php } else if($v['level']=='1'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/14byVIP.png" title="白银VIP">
			<?php } else if($v['level']=='2'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/13hjVIP.png" title="黄金VIP">
			<?php } else if($v['level']=='3'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/12bjVIP.png" title="铂金会员">
			<?php } else if($v['level']=='4'){ ?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/14byVIP.png" title="钻石会员">
			<?php }elseif($v['level']==5){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/10zzVIP.png" title="至尊会员">
			<?php }elseif($v['level']==6){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/9cz.png" title="财主会员">
			<?php }elseif($v['level']==7){?>
			<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/8th.png" title="土豪会员">
			<?php } ?>
		<?php  } else if ($v['role'] == '-1') {?>
		<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/17yk.png" title="游客">
		<?php }?>

	</span>	
</li>


<?php }
}?>

<?php if (!empty($moniuser)) { 
		foreach ($moniuser as $k => $v) { ?>

		 <li id="" uid="" rid="" name="游客<?php echo $v ?>" ip="undefined">
                     <span style="float:left;">
		 	<img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/17yk.png" title="游客">
                     </span>
                     <a href="javascript:void(0)" class="f_left">游客<?php echo $v ?></a>
                     <span style="float:right"><img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/17yk.png" title="游客"></span>	
                 </li>
		
<?php }
} ?>

<?php if (!empty($qwmoniuser)) {
		foreach ($qwmoniuser as $k => $v) {
                    ?>

                        <li id="" uid="" rid="" name="游客<?php echo $v ?>" ip="undefined">
                            <span style="float:left;">
                               <img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/images/17yk.png" title="游客">
                            </span>
                            <a href="javascript:void(0)" class="f_left">游客<?php echo $v ?></a>
                            <span style="float:right"><img class="roleimg" src="<?php echo $_SESSION["css"]?>/themes/v2/static/djimages/17yk.png" title="游客"></span>	
                        </li>	
                   <?php 
		}
		$qwtotal=$qwtotal+count($qwmoniuser);	               
} ?>
<script>
$("#usertotal").html(<?php echo (count($useronline) + count($moniuser) +$qwtotal+count($mnhy));?>);
</script>
