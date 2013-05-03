var uploader
function uploader_init(){
	var settings={
		runtimes : 'html5,flash',
		browse_button : 'pickfiles',
		container: 'uploader',
		max_file_size : '10mb',
		url : upload_url,
		flash_swf_url : '/Public/js/plupload/plupload.flash.swf',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip,rar"},
			{title : "Office files", extensions : "doc,dox,xls,xlsx,ppt,pptx,pdf"}
		]
	};

	uploader = new plupload.Uploader(settings);
	uploader.init();
	if($("#uploader .tbody").length>0){
		$("#uploader .tbody .loading").css("width","100%");
		$("#uploader .thead").show();
		$("#uploader .tbody").each(function(){
			id=$(this).attr("filename");
			filename=$(this).attr("filename");
			size=$(this).attr("size");
			file=new plupload.File(id,filename,size);
			file.status=plupload.DONE;
			count=uploader.files.length;
			uploader.files[count]=file;
		})		
	}
	uploader.bind('FilesAdded', function(up, files) {
		$("#uploader li.thead").show();
		for(var i in files){
			html='<li class="tbody" id="'+files[i].id+'">\n';
			html+='<div class="loading"></div>\n';
			html+='<div class="data">\n';
			html+='<span class="del text-center"><a class="link del">删除</a></span>\n';
			html+='<span class="size text-right">'+plupload.formatSize(files[i].size)+'</span>';
			html+='<span class="auto autocut">'+files[i].name+'</span>';
			html+='</li>';
			html+='</div>\n';
			$('#file_list').append(html);
		}
	});

	uploader.bind('UploadProgress', function(up, file){
		$("#"+file.id).find("a.del").hide();
		$("#"+file.id).find('.loading').css("width",file.percent+"%");
	});

	uploader.bind('FileUploaded', function(up,file,data){
		//alert(data.response);
		var myObject = eval('(' + data.response + ')');
		if($("#add_file").length!=0){
			$("#add_file").val($("#add_file").val()+myObject.id+";")
		}
		$("#"+file.id).attr("add_file",myObject.id);
		if($("#save_name").length!=0){
			$("#save_name").val($("#save_name").val()+myObject.savename+";")
		}
		$("#"+file.id).find("a.del").show();
	});

	$('#uploadfiles').click(function(){
		uploader.start();
		return false;
	});

	$("#uploader a.del").live('click',function(){
		if (confirm("确定要删除吗？")){
			id=$(this).parents("li").attr("id");
			file=uploader.getFile(id);
			add_file=$(this).parents("li").attr("id");
			$("#add_file").val($("#add_file").val().replace(add_file + ";", ""));			
			if(add_file.length>0){
				$(this).parents("li").remove();
				sendAjax(del_url, 'id=' + $(this).attr("id"));
			}else{
				uploader.removeFile(file);
				$(this).parents("li").remove();
			}
		}
	});
}