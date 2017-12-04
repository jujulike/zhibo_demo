
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
<meta name="keyword" content=""/>
<title>讲师投票</title>
<script type="text/javascript" src="/themes/v2/static/js/jquery-1.9.js"></script>
<script type="text/javascript" src="/themes/v2/static/js/malertbox.js"></script>

<style>
*{margin:0;padding:0;}
html{height:100%; }
body{background:#fff;font-family:microsoft yahei,Helvetica,arial,sans-serif;font-size:14px;color:#888;}
.grap{width:800px;margin:0 auto;}
.grap h1{text-align:center;color:#ff0;font-size:36px;background:url(/themes/v2/static/images/tbg.gif) center no-repeat;}
li i{font-style:normal;}
.grap h1 i{font-size:14px;font-style:normal;font-weight:normal;margin-left:10px;color:#E8C2C6;}
.vote{clear:both;padding:25px;border:2px solid #B20000;border-radius:15px;}
.vote li{height:115px; padding-top:15px;border-bottom:1px solid #ddd;list-style-type:none;}
.vote li a{float:right;width:100px; height:100px;display:block;background:url(/themes/v2/static/images/vote.gif) no-repeat;font-size:0px;overflow:hidden;text-indent:-50px;}
.vote li a:hover{background:url(/themes/v2/static/images/voon.gif) no-repeat;}
.vote li a.voted{background:url(/themes/v2/static/images/voted.gif) no-repeat;}
.vote li p{float:left;width:620px;}
.v_name{height:35px;line-height:35px;font-size:18px;color:#333;}
.v_name i{float:right;padding-right:10px;font-style:normal;color:#B20000;}
.percent_container{height:28px;background:#eee;position:relative;margin-top:8px;}
.percent_line{position:absolute;left:0;top:0;height:28px;background:#B20000;display:block;}
.w33{width:33%;}
.w20{width:20%;}
.w10{width:10%;}
.v_text{margin-top:8px;height:27px;line-height:27px;}
.v_text span{margin-right:25px;}
.malertbox{border:#ccc 1px solid\9;}
img{border: none}
</style>

</head>

<script>
var sum = <?php echo $sum ?>;
$(function(){

	calpercent();

	
});
function calpercent(){
		$('ul li').each(function(){
			var count = parseInt($(this).find('.count').text());
			var amount = parseInt($(this).find('.amount').text());
			
			var percent= sum ? Math.round(amount/sum*10000)/100: 1;
			percent = percent+'%';
			$(this).find('.percent').html(percent);
			$(this).find('.percent_line').css('width',percent);
		
		});
}
function vote(t){
		$.post('/index.php/vote/jsvote/post/',{'vote_user':t},function(data){
			if( data.status == 1){
				var num = $('#t'+t).find('.count').text();
				num = parseInt(num);
				$('#t'+t).find('.count').text( num+1);
				$('#t'+t).find('a').addClass('voted').attr('href','javascript:void(0)');

				num = $('#t'+t).find('.amount').text();
				num = parseInt(num);
				$('#t'+t).find('.amount').text( num+1);
				sum+=1;
				calpercent();
			}else if(data.status == -1){
				malertbox( data.msg);
			}else{
				alert( data.msg);
			}
		},'json');
}

</script>
<body>
<div class="grap">
<span style="position:absolute;right:30px;"><b style="color:#f00;">名师一对一：</b> <br/>
<a  href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $adlist[130][0]['link']; ?>&amp;site=qq&amp;menu=yes"  target="_blank"><img src="http://wpa.qq.com/pa?p=2:<?php echo $adlist[130][0]['link']; ?>:41" alt="名师一对一快速通道" title="请加QQ：<?php echo $adlist[130][0]['link']; ?>" class="qqimg"></a>
</span>
<h1><?php switch (date('m')) {case '1': echo '一';break;case '2':echo '二';break;case '3':echo '三';break;case '4':echo '四';break;case '5':echo '五';break;case '6':echo '六';break;case '7':echo '七';break;case '8':echo '八';break;case '9':echo '九';break;case '10':echo '十';break;case '11':echo '十一';break;case '12':echo '十二';break;
} ?>月份讲师投票</h1>
<!--
<a style="position:absolute;left:20px;top:20px;text-decoration:none;font-size:16px;color:#f00;" href="/News/TeacherVote/history/room_id/7.html">《查看历史排名》</a>-->
<div class="vote">
<ul id='vote'>

<?php foreach ($votejss as $v) { ?>

<li id="t<?php echo $v['userid'] ?>"><a <?php if ($v['daypost']==0) echo 'href="javascript:vote('.$v['userid'].')"'; else echo 'class="voted"'; ?>></a>
<p class="v_name"><i class="percent"></i><?php echo $v['name'] ?></p>
<p class="percent_container"><span class="percent_line"></span></p>
<p class="v_text"><span>今日获赞：<i class="count"><?php echo $v['day'] ?></i></span><span>本月累计：<i class="amount"><?php echo $v['cc'] ?></i></span></p></li>

<?php } ?>

</ul>




</div>
</div>


</body>
</html>