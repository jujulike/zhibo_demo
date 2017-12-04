/**
 * 初始化kindeditor
 */
var editor;

function simpleditor(url,areaId)
{
	var kindItems = ['fontname', 'fontsize', '|', 'forecolor', 'hilitecolor','copy','paste','plainpaste','wordpaste', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'image', 'link','source']

	KindEditor.ready(function(K) {
		editor = K.create('#'+areaId, {
			resizeType : 1,
//			allowFileManager : true,
			allowPreviewEmoticons : false,
			allowImageUpload : true,
			uploadJson : url,
			items : kindItems
		});
	});
}

function fulleditor(url,areaId)
{
	var kindItems = ['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'clearhtml', 'quickformat', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
        'anchor', 'link', 'unlink'
		]

	KindEditor.ready(function(K) {
		editor = K.create('#'+areaId, {
//			allowFileManager : true,
			uploadJson : url,
			items : kindItems
		});
	});
}

			
function initKind(url,areaId){

	var kindItems = ['fontname', 'fontsize', '|', 'forecolor', 'hilitecolor','copy','paste','plainpaste','wordpaste', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'emoticons', 'image', 'link','source']

	KindEditor.ready(function(K) {
		editor = K.create('#'+areaId, {
			resizeType : 1,
//			allowFileManager : true,
			allowPreviewEmoticons : false,
			allowImageUpload : true,
			uploadJson : url,
			items : kindItems
		});
	});
}

function uploadimage(procurl, basepath)
{
	KindEditor.ready(function(K) {
		var editor = K.editor({
//			allowFileManager : true
			uploadJson : procurl
		});
		K('#imagesupload').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : K('#imgthumb').val(),
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
						$('#imgthumb').val(newurl);
						$('#imgshow').attr('src', basepath + '/' + newurl);
						editor.hideDialog();
					}
				});
			});
		});

		K('#cancelimg').click(function() {
			$('#imgthumb').val('');
			$('#imgshow').attr('src', basepath + '/' + 'themes/images/public/noimg.jpg');
		});

	});
}

function postdata(formid, action, callback)
{
	$.jBox.tip('正在处理....', 'loading');
	window.setTimeout(function(){$.jBox.closeTip()}, 5000);
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
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			parent.window.location.reload();
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
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
		$.jBox.tip(d.msg,'error');
	}
}

function shake(ele,cls,times){
	var i = 0, t = false, o = ele.attr("class")+" ", c = "", times = times||2;
	if(t) return;
	t= setInterval(function(){
		i++;
		c = i%2 ? o+cls : o;
		ele.attr("class",c);
		if(i==2*times){
			clearInterval(t);
			ele.removeClass(cls);
		}
	},200);
};


