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
	var kindItems = ['source', '|', 'undo', 'redo', '|',  'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'clearhtml', 'quickformat', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 
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

function uploadimage3(procurl, basepath,limit)
{
	KindEditor.ready(function(K) {
		var editor = K.editor({
//			allowFileManager : true
			uploadJson : procurl
		});

		// 普通图片上传
		K('#imagesupload3').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : K('#imgthumb3').val(),
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
						$('#imgthumb3').val(newurl);
						$('#imgshow3').attr('src', basepath + '/' + newurl);
						editor.hideDialog();
					}
				});
			});
		});

		K('#cancelimg3').click(function() {
			$('#imgthumb3').val('');
			$('#imgshow3').attr('src',basepath + 'themes/glasses/usercenter/images/uppic.gif');
		});
	});
}


function uploadimage2(procurl, basepath,limit)
{
	KindEditor.ready(function(K) {
		var editor = K.editor({
//			allowFileManager : true
			uploadJson : procurl
		});

		// 普通图片上传
		K('#imagesupload2').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : K('#imgthumb2').val(),
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
						$('#imgthumb2').val(newurl);
						$('#imgshow2').attr('src', basepath + '/' + newurl);
						editor.hideDialog();
					}
				});
			});
		});

		K('#cancelimg2').click(function() {
			$('#imgthumb2').val('');
			$('#imgshow2').attr('src', basepath + 'themes/glasses/usercenter/images/uppic.gif');
		});
	});
}



function uploadimage1(procurl, basepath,limit)
{
	KindEditor.ready(function(K) {
		var editor = K.editor({
//			allowFileManager : true
			uploadJson : procurl
		});

		// 普通图片上传
		K('#imagesupload1').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : K('#imgthumb1').val(),
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
						$('#imgthumb1').val(newurl);
						$('#imgshow1').attr('src', basepath + '/' + newurl);
						editor.hideDialog();
					}
				});
			});
		});

		K('#cancelimg1').click(function() {
			$('#imgthumb1').val('');
			$('#imgshow1').attr('src',basepath + 'themes/glasses/usercenter/images/uppic.gif');
		});
	});
}


function uploadbutton(procurl,basepath,murl)
{
	KindEditor.ready(function(K) {
		var uploadbutton = K.uploadbutton({
			button : K('#uploadButton')[0],
			fieldName : 'imgFile',
			url : procurl,
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = data.url;
					var newurl = url.substr(url.indexOf("upload"));
					$('#sourceimage').val(newurl);
					var width = $("#width").val();
					var height = $("#height").val();
					$.jBox("iframe:"+murl+"/"+width+"/"+height+"/"+newurl, {
						title: "上传图片",
						width: 500,
						height: 550,
						iframeScrolling: 'no',
						buttons: {'关闭': true}
						});
				} else {
					alert(data.message);
				}
			},
			afterError : function(str) {
				alert('自定义错误信息: ' + str);
			}
		});
		uploadbutton.fileBox.change(function(e) {
			uploadbutton.submit();
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

		// 普通图片上传
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
		
		// 头像待裁剪上传
		K('#upload_header').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
//						$('#imgthumb').val(newurl);
//						$('#sourcepic').attr('src', basepath + '/' + newurl);
						$('.reducebox').html('<img id="sourcepic" src="'+ basepath + '/' + newurl+'">');
						$('.preview').attr('src', basepath + '/' + newurl);
						$("#attach_name").val(newurl);
						editor.hideDialog();
						jQuery(function($){
						  // Create variables (in this scope) to hold the API and image size
						  var jcrop_api, boundx, boundy;

						  $('#sourcepic').Jcrop({
							onChange: updatePreview,
							onSelect: updatePreview,
							aspectRatio: 1
						  },function(){
							// Use the API to get the real image size
							var bounds = this.getBounds();
							boundx = bounds[0];
							boundy = bounds[1];
							// Store the API in the jcrop_api variable
							jcrop_api = this;
						  });

						  function updatePreview(c)
						  {
							if (parseInt(c.w) > 0)
							{
							  var rx = 100 / c.w;
							  var ry = 100 / c.h;

							  $('.preview').css({
								width: Math.round(rx * boundx) + 'px',
								height: Math.round(ry * boundy) + 'px',
								marginLeft: '-' + Math.round(rx * c.x) + 'px',
								marginTop: '-' + Math.round(ry * c.y) + 'px'
							  });

								jQuery('#x').val(c.x);
								jQuery('#y').val(c.y);
								jQuery('#w').val(c.w);
								jQuery('#h').val(c.h);
							}
						  };
						});
					}
				});
			});
		});		

		K('#cancelimg').click(function() {
			$('#imgthumb').val('');
			$('#imgshow').attr('src', basepath + '/images/public/noimg.jpg');
		});

		K('#cancelimg2').click(function() {
			$('#imgthumb').val('');
			$('#imgshow').attr('src', basepath + 'themes/glasses/usercenter/images/blank.gif');
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
		layer.msg(d.msg,1,1);
		window.setTimeout(function () {
			parent.window.location.reload();
		}, 1000);
	}else{
		layer.msg(d.msg);
//		$.jBox.tip(d.msg,'error');
	}
}

function wshow(d)
{
	if(d.code == '1'){
//		$.jBox.tip(d.msg, 'success');
		layer.msg(d.msg,1,1);
		window.setTimeout(function () {
			window.location.reload();
		}, 1000);
	}else{
		layer.msg(d.msg);
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





function resetImage(ImgD,iwidth,iheight){
	//参数(图片,允许的宽度,允许的高度)
	var image=new Image();
	image.src=ImgD.src;
	if(image.width>0 && image.height>0){
	if(image.width/image.height>= iwidth/iheight){
		if(image.width>iwidth){  
		ImgD.width=iwidth;
		ImgD.height=(image.height*iwidth)/image.width;
		}else{
		ImgD.width=image.width;  
		ImgD.height=image.height;
		}
		ImgD.alt=image.width+"×"+image.height;
		}
	else{
		if(image.height>iheight){  
		ImgD.height=iheight;
		ImgD.width=(image.width*iheight)/image.height;        
		}else{
		ImgD.width=image.width;  
		ImgD.height=image.height;
		}
		ImgD.alt=image.width+"×"+image.height;
		}
	}
}
