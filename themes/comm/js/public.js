function uploadImage(bid,procurl,basepath)
{
	KindEditor.ready(function(K) {
		var uploadbutton = K.uploadbutton({
			button : K('#'+bid)[0],
			fieldName : 'imgFile',
			url : procurl,
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = data.url;
					var newurl = url.substr(url.indexOf("upload"));
					//$('#sourceimage').val(newurl);
					var thumb = data.thumb_url;
					var newthumb = thumb.substr(thumb.indexOf("upload"));
					$("#show_img").html('图片上传成功！'+"<a href='"+url+"' target='_blank'>查看原图</a>");
					$("#imgthumb").val(newthumb);
					$("#sourceimg").val(newurl);

				} else {
					layer.alert(data.message);
				}
			},
			afterError : function(str) {
				layer.alert('自定义错误信息: ' + str);
			}
		});
		uploadbutton.fileBox.change(function(e) {
			uploadbutton.submit();
		});
	});
}

function postdata(formid, action, callback)
{
//	$.jBox.tip('正在处理....', 'loading');
	layer.load(2);
	$("#" + formid).ajaxSubmit(
	{			
		type:"post",
		url:action,
		success:function(data){	
			eval(callback + '((' + data + '))');
		}
	})
}


function show(d)
{
	if(d.code == '1'){
		//$.jBox.tip(d.msg, 'success');
		layer.msg(d.msg,2,1);
		window.setTimeout(function () {
			parent.window.location.reload();
		}, 1000);
	}else{
		layer.alert(d.msg);
//		$.jBox.tip(d.msg,'error');
	}
}

function wshow(d)
{
	if(d.code == '1'){
//		$.jBox.tip(d.msg, 'success');
		layer.alert(d.msg);
		window.setTimeout(function () {
			window.location.reload();
		}, 1000);
	}else{
		layer.alert(d.msg);
//		$.jBox.tip(d.msg,'error');

	}
}

function noshow(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
	}else{
		$.jBox.tip(d.msg,'error');
	}

	$.jBox.close();
}



function enter(d)
{
	if(d.code == '1'){
//		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			window.location.href = d.tourl;
		}, 1000);
	}else{
		layer.msg(d.msg,2,0);
	}
}


function gopage(num, total){
	$('#pagecur').val(num);
	$('#pagecount').val(total);
	$('#formpage').attr('action',$("#action").val());
	$('#formpage').submit();
}

function showload()
{
	$.layer({
		type : 3,
		time : 1,
		shade : ['','','',false],
		offset:['500px' , ''],
		loading : {type : 2}
	}); 
}

$(document).ready(function(){
	// 子菜单切换
	$(".menu_sub").find("a").click(function()
	{
		var classname = "selected";
		var element = $(this).parent().get(0).tagName;
		$(".menu_sub").find(element).each(function(){
			$(this).removeClass(classname);
			$($(this).find("a").attr("rel")).hide();
		});

		$(this).parent().addClass(classname);
		$($(this).attr('rel')).show();
	});

	// tab的切换
	$(".menu_tab").find("a").click(function()
	{
		var classname = "cur";
		$(".menu_tab").find("a").each(function(){
			$(this).removeClass(classname);
			$($(this).attr("rel")).hide();
		});

		$(this).addClass(classname);
		$($(this).attr('rel')).show();
	});

});


  (function($){
	$.fn.insert=function(text){
		var _o=$(this).get(0);
		if($.browser.msie){
			_o.focus();
			sel=document.selection.createRange();
			sel.text=text;
			sel.select();
		}else if(_o.selectionStart || _o.selectionStart == '0'){
			var startPos=_o.selectionStart;
			var endPos=_o.selectionEnd;
			var restoreTop=_o.scrollTop;
			_o.value=_o.value.substring(0, startPos) + text + _o.value.substring(endPos,_o.value.length);
			if (restoreTop>0){
				_o.scrollTop=restoreTop;
			}
			_o.focus();
			_o.selectionStart=startPos+text.length;
			_o.selectionEnd=startPos+text.length;
		}
	};
})(jQuery);


