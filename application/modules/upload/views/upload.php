<?php 





//echo "<pre>";
//print_r($upload);
?>


<link rel="stylesheet" href="<?php echo base_url("assets/kindeditor/themes/default/default.css")?>" />
<script src="<?php echo base_url("assets/kindeditor/kindeditor.js")?>"></script>
<script src="<?php echo base_url("assets/kindeditor/lang/zh_CN.js")?>"></script>

<script>
uploadimage('<?php echo site_url('upload/doUploadImg/papers');?>','<?php echo base_url();?>');

function uploadimage(procurl, basepath)
{

			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true,
					uploadJson : procurl
				});

			K('#cancelimg').click(function() {
				$('#imgthumb').val('');
				$('#imgshow').attr('src', basepath + '/' + 'themes/images/public/noimg.jpg');
			});




				// 企业证件上传
				K('#paper_upload').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							showRemote : false,
							imageUrl : K('#papers_path').val(),
							clickFn : function(url, title, width, height, border, align) {
								newurl = url.substr(url.indexOf("data"));
								$('#papers_path').val(newurl);
								$('#papers_company').attr('style', 'background:url(' + basepath + '/' + newurl + ')');
								editor.hideDialog();
							}
						});
					});
				});


				// 身份证件上传
				K('#cert_upload').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							showRemote : false,
							imageUrl : K('#cert_path').val(),
							clickFn : function(url, title, width, height, border, align) {
								newurl = url.substr(url.indexOf("data"));
								$('#cert_path').val(newurl);
								$('#cert_person').attr('style', 'background:url(' + basepath + '/' + newurl + ')');
								editor.hideDialog();
							}
						});
					});
				});

				// 企业logo上传
				K('#logo_upload').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							showRemote : false,
							imageUrl : K('#papers_path').val(),
							clickFn : function(url, title, width, height, border, align) {
								newurl = url.substr(url.indexOf("data"));
								$('#papers_path').val(newurl);
								$('#papers_logo').attr('src', basepath + newurl);
								//K('#papers_logo').attr('style', 'float:left;margin-left:15px;width:210px;height:240px;background:url(' + url + ')');
								editor.hideDialog();
							}
						});
					});
				});

				// 企业商标证书上传
				K('#logocert_upload').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							showRemote : false,
							imageUrl : K('#papers_path').val(),
							clickFn : function(url, title, width, height, border, align) {
								newurl = url.substr(url.indexOf("data"));
								$('#papers_path').val(newurl);
								$('#papers_logocert').attr('src', basepath + newurl);
								//K('#papers_logo').attr('style', 'float:left;margin-left:15px;width:210px;height:240px;background:url(' + url + ')');
								editor.hideDialog();
							}
						});
					});
				});
			});

}

		</script>


<?php if (($upload_name !='logo') && ($upload_name !='上传身份证') && ($upload_name !='商标证书图片上传')) { ?><p class="upload_pic_btn"><input type="button" class="button2_big6" value="<?php echo $upload_name?>" style=" font-weight:700;" id="paper_upload" /></p><?php }?>

<?php if ($upload_name =='上传身份证') { ?><p class="upload_pic_btn"><input type="button" class="button2_big5" value="<?php echo $upload_name?>" style=" font-weight:700;" id="paper_upload" /></p><?php }?>

<?php if ($upload_name =='商标证书图片上传') { ?><p class="upload_pic_btn2"><input type="button" class="button2_big5" value="商标证书图片上传" style=" font-weight:700;" id="logocert_upload" /></p><?php }?>
<!--
<script type="text/javascript" src="<?php echo base_url('assets/')?>/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/swfupload/swfupload.queue.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/swfupload/fileprogress.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/swfupload/handlers.js')?>"></script>
<script type="text/javascript">
		var swfu;
		window.onload = function() {
			var settings = {
				upload_url: "<?php echo site_url('module/upload/upload/upload')?>",	// Relative to the SWF file
				flash_url : "<?php echo base_url('assets/swfupload/swfupload.swf')?>",
				post_params: {"PHPSESSID" : "<?php echo $this->session->userdata('session_id'); ?>",'upload_model':"<?php echo $upload['upload_model']?>"},
				file_size_limit : "<?php echo $upload['maxSize']?> KB",
				file_types : "<?php echo $upload['allowedTypes']?>",
				file_types_description : "All Files",
				file_post_name:"userfile",
				file_upload_limit : 1,
				file_queue_limit : 0,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "<?php echo base_url('assets/swfupload/images/TestImageNoText_65x29.png')?>",	// Relative to the Flash file
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">浏览</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
			   // The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : <?php echo $upload['uploadSuccess']?>,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
				
			};

			swfu = new SWFUpload(settings);
	     };
	</script>




<div id="content">
	
		
		<div class="fieldset flash" id="fsUploadProgress">
	    </div>
		<div id="divStatus" style="display: none;">0 个文件已上传</div>
        <div>
            <span id="spanButtonPlaceHolder"></span>
            <input id="btnCancel" type="button" style="display: none;" value="取消所有上传" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
        </div>

	
</div>


-->
