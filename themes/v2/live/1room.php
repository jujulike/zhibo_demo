<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view($cfg['tpl'] . 'public/meta');?>

</head>

<body>
<div  id="main">
<!---------------------------顶部 -------------------------------------------------->
<?php $this->load->view($cfg['tpl'] . 'public/header');?>
<!---------------------------内容区 #main -------------------------------------------------->

  <div id="content" class="cfix">
    <div id="contentLeft">
      <div class="leftTabBg  cfix">
<!--        <p><img src="<?php echo base_url($cfg['tpl'])?>/images/a1.jpg" /></p>-->
 <?php if (!empty($vote_result)) {?>
        <div class="fr cfix">
          <div class="voteTitle">多空投票</div>
          <div class="vote"> <a class="v1" href="javascript:setVote(2)"><div id="kz"><?php echo $vote_result[2]['v']?>%</div><span>看涨</span></a> <a  class="v2" href="javascript:setVote(1)"><div id="pz"><?php echo $vote_result[1]['v']?>%</div><span>盘整</span></a> <a class="v3"  href="javascript:setVote(0)"><div  id="kk"><?php echo $vote_result[0]['v']?>%</div><span>看空</span></a>
		  </div>
        </div>
	<?php } ?>
        <div class="mt10 cfix">
          <div class="fl zhuboSwith"><a href="#" title="播主"><img src="<?php echo base_url($cfg['tpl'])?>/images/tab1_icon2.png"  /></a><a href="#"  title="在线用户"><img src="<?php echo base_url($cfg['tpl'])?>/images/tab1_icon1.png"  /></a></div>
          <!--<div class="tab1 cfix fl ml15"> <a class="on" href="javascript:;">自由发言</a> <a href="javascript:;">主席模式</a> <a href="javascript:;">麦序模式</a>
             
          </div>-->
        </div>
      </div><div class="cfix"></div>
	  <?php $this->load->module('live/useronline/userlist', array(array($roominfo['cateid']), array($roominfo), array($hostinfo)));?>
      <div class="peopleNumber">已有 <span id="usertotal">0</span>人参与</div>
	 
    </div>
    <div id="contentRight" class="cfix" >
      
      <div id="contentRightBox" class="cfix" >
<div id="previewimage" style="margin:0 auto;display:none"></div>
<div id="talkface">
	   <div id="rightHead" class="cfix">
	 <img src="<?php echo base_url($cfg['tpl'])?>/images/kf.png" width="35" height="36" /><span class="fb"> QQ客服咨询：</span>
		<?php if (!empty($adlist[130])) { foreach ($adlist[130] as $k => $v) {?>
		<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $v['link']?>&amp;site=qq&amp;menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $v['link']?>:41" alt="<?php echo $v['title']?>" title="请加QQ：<?php echo $v['link']?>"></a>
		<?php } }?>	 
      </div>
	<div class="talkList">
        <?php $this->load->module('live/content/getlivedata', array(array($roominfo['cateid']), array($roominfo), array($hostinfo)));?>
        <div id="videoShow">
          <div class="blockcc" id="videoShowContent">
            <div class="tab2 cfix">
              <div class="fr">
			  <?php if(!empty($adlist[168])) {
				  foreach ($adlist[168] as $k => $v) { ?>
				  <a href="<?php echo @$v['link'] ?>" target="_blank"> <?php echo $v['title'] ?> </a> 
			  <?php } } ?>
			  </div>
              <div class="fl"> <a href="###" class="a1">视频直播</a> <a href="javascript:LoadVideo()" class="a2">刷新</a> </div>
            </div>
            <div class="tabContent" style="position: relative;z-index:1">
				<?php if ($cfg['open_camera_model'] == '1') {?>
					<iframe src="<?php echo $cfg['thirdparty_url_player'] ?>" width="100%" height="300"></iframe>
					<?php if ($userinfo['ismaster'] == $masterinfo['roomid']) { ?>
					<div style="width:90%;font:18px/40px '微软雅黑';16px;text-align:center;">
					<a title="去直播" href="<?php echo $cfg['thirdparty_url_live'] ?>" target="_blank" style="background:none repeat scroll 0 0 #b29205"><span style="margin:8px;color:red">去直播</span></a>
					</div>
					<?php } ?>
				<?php } else { ?>
				<div style="z-index:5" class="kzzsx">
					<a title="点击刷新" href="javascript:LoadVideo();">双击视频可放大,<span style="color:red">收看异常请刷新</span></a>
				</div>
				<div  id="video_player">
				<embed width="100%" height="360" align="middle" type="application/x-shockwave-flash" wmode="transparent"   allowfullscreen="true" allowscriptaccess="never" quality="high" src="http://yy.com/s/<?php echo $cfg['yy_channel']; ?><?php if (!empty($cfg['yy_subchannel'])) { echo "/".$cfg['yy_subchannel'];}?>/yyscene.swf">		
				</div>
				<?php } ?>
            </div>
          </div>
          <div class="mt15 blockcc" id="rightTabContent">
            <div class="tab3">
			<a href="javascript:;" class="on" data-role="d1">公告</a>
			<a href="javascript:;" data-role="d2">简介</a>
			  <?php if(!empty($adlist[169])) {
				  foreach ($adlist[169] as $k => $v) { ?>
				  <a href="<?php echo $v['link'] ?>" target="_blank"> <?php echo $v['title'] ?> </a> 
			  <?php } } ?>
			</div>
			<div class="tabContent tabdata" data-role="d1"  id="gonggao"  style=" display:block"> 
					<?php if (!empty($adlist[167])) {
								foreach ($adlist[167] as $k => $v) { ?>
									<span style="display:none"><?php echo $v['desc']; ?></span>
					<?php }}?>
			</div>
			<script type="text/javascript">
			var _n = 0;
			var iID;
			function gongaoSwitch()
			{
				if ($('#gonggao').find('span').size() <= _n) _n = 0;
				$('#gonggao').find('span').eq(_n).show('slow').siblings('span').hide('slow');
				_n = _n+1;
			}
			
			clearInterval(iID); 
			gongaoSwitch();
			iID = setInterval(gongaoSwitch, 10000);
			</script>
            <div class="tabContent tabdata" data-role="d2"> <?php echo $roominfo['roominfo']?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="cfix"></div>
   <div id="foot" class="cfix">
	<?php $this->load->view($cfg['tpl'] . 'public/footer');?>
	</div>
<script>

$(document).keyup(function(event){
	if(event.keyCode ==13){
		$(".sendBtn").trigger("click");
	}
});

	$('#face').SinaEmotion($('#postAreatext'));

// 测试本地解析
function out(){
	var inputText = $('#postAreatext').val();
	$('#out').html(AnalyticEmotion(inputText));
}

function LoadVideo() {
	var videoId = "<?php echo $cfg['yy_channel']?>";
	<?php if (!empty($cfg['yy_subchannel'])) { ?>
		videoId = videoId + "/" + "<?php echo $cfg['yy_subchannel'] ?>";
	<?php }?>
	var videoHtml = "<embed src='http://yy.com/s/"+videoId+"/yyscene.swf' quality='high' width='100%'";
		videoHtml += " height='360' align='middle' allowscriptaccess='always' allowfullscreen='true'";
		videoHtml += " mode='transparent' wmode='transparent' type='application/x-shockwave-flash'></embed>";
	$("#video_player").html(videoHtml);
} 		

function setVote(_flag)
{
	$.ajax({
		type: "POST",
		url: '<?php echo site_url("vote") ?>',
		dataType: "json",
		data: "vote="+ _flag,
		success: function(d){
			if (d.code == '1')
			{
				layer.msg(d.msg, 2, 1);
				$("#kz").html(d.kz);
				$("#pz").html(d.pz);
				$("#kk").html(d.kk);
			}
			else
				layer.msg(d.msg, 2, 0);
		}
	});
}



(function($){
	$(window).load(function(){
		$("#visitorListScrollbar").mCustomScrollbar();		
	});
})(jQuery);

useronline();

window.onload = function()
{
	$("#chat").find(".speakText").find("span").each(function(){
		var _s = $(this).html();
		if (_s.indexOf('[') != -1)
		{
			var _t = AnalyticEmotion($(this).html());
			$(this).html(_t); 
		}
	});
}


</script>
</body>
</html>
