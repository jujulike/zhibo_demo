<script type="text/javascript" src="http://abc.91mp.com/project/eysystem/eyoung/themes/comm/js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="http://abc.91mp.com/project/eysystem/eyoung/themes/comm/js/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="http://abc.91mp.com/project/eysystem/eyoung/themes/comm/js/kindeditor/themes/default/default.css" />
<script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				K('#J_selectImage').click(function() {
					editor.loadPlugin('multiimage', function() {
						editor.plugin.multiImageDialog({
							clickFn : function(urlList) {
								var div = K('#J_imageView');
								div.html('');
								K.each(urlList, function(i, data) {
									div.append('<img src="' + data.url + '">');
									alert(data.url);
								});
								editor.hideDialog();
							}
						});
					});
				});
			});
		</script>
		<input type="button" id="J_selectImage" value="批量上传" />
		<div id="J_imageView"></div>