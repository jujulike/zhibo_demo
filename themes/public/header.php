
<script type="text/javascript">

function setLiveMaster()
{
	$.jBox("iframe:<?php echo site_url('live/setMaster');?>", {title: "开设直播主题",iframeScrolling: 'no',height: 250,width: 450,buttons: { '关闭': true }});
}

function goroom(url)
{
//	window.top.location.href=url;
	window.open(url,"_blank")
}
</script>
	