/**
 * 初始化kindeditor
 */
var editor;

function cutimage(procurl, basepath)
{
	KindEditor.ready(function(K) {
		var editor = K.editor({
//			allowFileManager : true
			uploadJson : procurl
		});
		
		// 头像待裁剪上传
		K('#upload_image').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : true,
					clickFn : function(url, title, width, height, border, align) {
						newurl = url.substr(url.indexOf("data"));
//						$('#imgthumb').val(newurl);
//						$('#sourcepic').attr('src', basepath + '/' + newurl);
						$('.reducebox').html('<img id="sourcepic" src="'+ basepath + '/' + newurl+'">');
						//$('.preview').attr('src', basepath + '/' + newurl);
						$("#attach_name").val(newurl);
						var size = $("#psize").val().split("*");						  
						var width = parseInt(size[0]);						  
						var height = parseInt(size[1]);
						editor.hideDialog();
						jQuery(function($){
						  // Create variables (in this scope) to hold the API and image size
						  var jcrop_api, boundx, boundy;

						  $('#sourcepic').Jcrop({
							onChange: updatePreview,
							onSelect: updatePreview,
							setSelect: [0, 0, width, height],
							minSize: [width,height],
							aspectRatio: width/height,
							allowResize: true
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
							  var rx = width / c.w;
							  var ry = height / c.h;
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

	});
}

function postdata(formid, action, callback)
{
	$.jBox.tip('正在处理....', 'loading');
	//alert("#" + formid);
	$("#" + formid).ajaxSubmit(
	{			
		type:"post",
		url:action,
		success:function(data){	
			eval(callback + '((' + data + '))');
		}
	})
}

