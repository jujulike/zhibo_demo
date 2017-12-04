<script>
$(document).ready(function(){
var str = '<div class="imagecancel" style="position:absolute;background:white;margin:10px" onclick="del(this)"><a href="###" id="dimage"  style="color:#ffb900">取消图片</a>';
$(".imageshow").hover(
	function(){
		if ($("#"+$(this).attr("rel")).val() != '')
			$(this).prepend(str + "<input type='hidden' class='dvalue' value='"+ $(this).attr("rel") +"'/></div>");
	},
	function(){
		$(this).find(".imagecancel").remove();
	}
);


 });
 
function del(e)
{
	
	$("#"+ $(e).find(".dvalue").val()).val('');
	$("div[rel='"+ $(e).find(".dvalue").val()+"']").find("img").attr('src','<?php echo base_url("themes/admin/css/images/noimg.jpg")?>');
		
}
</script>


<?php for ($i=0;$i<$limit;$i++) {?>
<INPUT TYPE="hidden" NAME="imgthumb<?php echo ($i+1)?>" id="imgthumb<?php echo ($i+1)?>" value="<?php echo $imgthumb[$i]?>">
<INPUT TYPE="hidden" NAME="source_imgthumb<?php echo ($i+1)?>" id="source_imgthumb<?php echo ($i+1)?>" value="<?php echo $imgthumb[$i]?>">
<?php }?>
<div style="height:80px">
	<?php for ($i=0;$i<$limit;$i++) {?>
 <div rel="imgthumb<?php echo ($i+1)?>" class="imageshow" style="float:left;width:80px;height:70px;border:1px #ABADB3 solid;margin-right:8px">
	<img id="imgshow<?php echo ($i+1)?>" width="80px" height="70px" src="<?php if(!empty($imgthumb[$i])) {  echo base_url($imgthumb[$i]); } else {echo base_url('themes/admin/css/images/noimg.jpg');}?>"/>
 </div>
 <?php }?>
 </div>
<div style="height:30px"><a href="###" id="multimagesupload" title="上传图片" style="color:#ffb900">上传图片</a>&nbsp;（图片最多上传<?php echo $limit?>张，最大请不要超过1M。）</div>
		