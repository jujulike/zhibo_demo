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
	//alert(url);
	//alert(areaId); 
	var kindItems = ['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'clearhtml', 'quickformat', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
        'anchor', 'link', 'unlink'
		]
//alert( kindItems);
		

	KindEditor.ready(function(K) {
			//html = K('#'+areaId).val(); 
			//alert(html);
		editor = K.create('#'+areaId, {
//			allowFileManager : true,
			filterMode : false,
			uploadJson : url,
			items : kindItems
		});
	});
}


function fulleditor1(url,areaId)
{
	//alert(url);
	//alert(areaId); 
	var kindItems = ['source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'clearhtml', 'quickformat', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
        'anchor', 'link', 'unlink'
		]
//alert( kindItems);



	KindEditor.ready(function(K) {

		//var str = $('#'+areaId).val();
		editor = K.create('#'+areaId, {

//			allowFileManager : true,
			uploadJson : url,
			items : kindItems,
		//	afterChange : function(){changeImg();},
			afterFocus : function(){
				this.sync();
				var str = $('#'+areaId).val();
				FocusImg(str);},
			afterBlur  : function(){
					this.sync();
					var str = $('#'+areaId).val();
					BlurImg(str);}
			
		});
		//editor.focus();
		
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

		// 普通图片上传
		K('#imagesupload').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
						$('#imgthumb').val(newurl);
						$('#imgshow').attr('src', basepath + '/' + newurl);
						editor.hideDialog();
					}
				});
			});
		});

		// 多张图片上传
		K('#multimagesupload').click(function() {
			var i=1;
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#imgthumb').val(),
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
						var j = 0;
						for (i=1; i <=5 ; i++ )
						{
							if ($("#imgthumb"+i).val() == '')
							{
								$('#imgthumb'+i).val(newurl);
								$('#imgshow'+i).attr('src', basepath + '/' + newurl);
								break;
							}
							else
							{
								j=j+1;
							}
						}

						if (j == 5)
						{
							alert('图片最多只能上传5张！');
							return false;
						}

//						$('#imgthumb').val(newurl);
//						$('#imgshow').attr('src', basepath + '/' + newurl);
						editor.hideDialog();
					}
				});
			});
		});

		K('#J_selectImage').click(function() {
					editor.loadPlugin('multiimage', function() {
						editor.plugin.multiImageDialog({
							clickFn : function(urlList) {
								var div = K('#J_imageView');
								var newurl;
								div.html('');
								var oldurl='';
								var oldthumburl = '';
								var thumburl = '';
								K.each(urlList, function(i, data) {
									oldurl = data.url;
									if (data.thumb_url !='')
									{

										div.append('<img id="'+i+'" src="' + data.thumb_url + '">');
									}
									else
									{
										div.append('<img id="'+i+'" src="' + data.url + '">');
									}
									newurl = oldurl.substr(oldurl.indexOf("upload"));
									if (data.thumb_url !='')
									{
										oldthumburl = data.thumb_url;
										thumburl = oldthumburl.substr(oldthumburl.indexOf("upload"));
										div.append('<input type="hidden" name="attachpath[]" value="'+thumburl+'">');
									}
									else
									{
										div.append('<input type="hidden" name="attachpath[]" value="">');
									}
									div.append('<span id="cancel'+i+'"><a href="###" onclick="cancel(this)" rel="'+i+'">删除</a></span>');
									div.append('<input type="hidden" name="imgsource[]" value="'+newurl+'">');
								});
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
			$('#imgshow').attr('src', basepath + 'themes/admin/css/images/noimg.jpg');
		});

		// 普通图片上传
		K('#imagesupload1').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("upload"));
						$('#imgthumb1').val(newurl);
						$('#imgshow1').attr('src', basepath + '/' + newurl);
						editor.hideDialog();
					}
				});
			});
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
					if (width=='' && height == '')
					{
						$('#imgthumb').val(newurl);
						$('#imgshow').attr('src', basepath + '/' + newurl);
					}
					else
					{
						$.jBox("iframe:"+murl+"/"+width+"/"+height+"/"+newurl, {
							title: "上传图片",
							width: 500,
							height: 550,
							iframeScrolling: 'no',
							buttons: {'关闭': true}
							});
					}
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

function postdata(formid, action, callback)
{
	$.jBox.tip('正在处理....', 'loading');
	$("#" + formid).ajaxSubmit(
	{			
		type:"post",
		url:action,
		success:function(data){	
			eval(callback + '((' + data + '))');
		}
	})
}

// 用来替换postdata
function pd(form, action, callback)
{
	$.jBox.tip('正在处理....', 'loading');
	$(form).ajaxSubmit(
	{			
		type:"post",
		url:action,
		success:function(data){	
			eval(callback + '((' + data + '))');
		}
	})
}

/*
function loginsuccess(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			if (d.tourl != undefined)
			{
				alert(d.tourl);
//				parent.window.location.href=d.tourl;
			}
			else
			{
				alert('close');
				top.$.jBox.close();
			}

		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}
*/
function show(d)
{
	$("#_valid").val(d.code);
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {
			if (($("#pagecur",parent.document.body).val() == undefined) || ($("#pagecount",parent.document.body).val() == undefined))
			{
				parent.window.location.reload();

			}
			else
			{
				window.parent.gopage($("#pagecur",parent.document.body).val(), $("#pagecount",parent.document.body).val());
			}
		}, 1000);
	}else{
		$.jBox.tip(d.msg,'error');
	}
}

function wshow(d)
{
	if(d.code == '1'){
		$.jBox.tip(d.msg, 'success');
		window.setTimeout(function () {

			if (($("#pagecur").val() != '') && ($("#pagecount").val() != ''))
			{
				if (($("#pagecur").val() == undefined) ||
					($("#pagecount").val() == undefined))
				{
					window.location.reload();
				}
				else
					gopage($("#pagecur").val(), $("#pagecount").val());
			}
			else
			{
				window.location.reload();
			}
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


function gopage(num, total){
	$('#pagecur').val(num);
	$('#pagecount').val(total);
	if ((($("#pagecur").val() != '') && ($("#pagecount").val() != '')) && ((num != undefined) && (total != undefined)))
	{
		$('#formpage').attr('action',$("#action").val());
		$('#formpage').submit();
	}
	else
	{
		window.location.reload();
	}
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