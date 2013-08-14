(function($){
	//default options
	var d_o={
		/*"script" : "/../wp-content/plugins/wp-events-manager-importer/inc/admin/resources/javascript/dropfile/upload.php"*/
		"url" : ajaxurl+"?action=get_file_info"
		,"success_label": "File which is going to be uploaded : <br/>"
	};

	$.fn.dropfile=function(o){
		if (o) $.extend(d_o,o);
		this.each(function(){
			var elements={};
			elements.path_input = $('<input/>').attr({ type: 'hidden', class: 'dropfile_path', name: 'dropfile[path]' }).appendTo(this);
			elements.type_input=$('<input/>').attr({ type: 'hidden', class: 'dropfile_type', name: 'dropfile[type]' }).appendTo(this);
			elements.alert=$('<p/>').hide().appendTo(this);
			$(this).bind({
			  "dragenter": function(e) {
			    e.preventDefault();
			  }
			  ,"dragover": function(e) {
			   	e.preventDefault();
			   	$(this).addClass("hover");
			  }
			  ,"dragleave": function(e) {
			   	e.preventDefault();
			   	$(this).removeClass("hover");
			  }
			});
			this.addEventListener('drop',function(e){
				e.preventDefault();
				var files= e.dataTransfer.files;
				upload(files,0,$(this),elements);
			});
		});

		function upload(files,index,area,elements){
			var file= files[index];
			var xhr = new XMLHttpRequest();
			area.removeClass("hover");
			xhr.onreadystatechange=function()
			{
				if (xhr.readyState==4 && xhr.status==200)
				{
					var o = JSON.parse(xhr.responseText);
					if (o.error){
						elements.alert.text(o.error).removeClass("success").addClass("error").show();
						return false;
					}
					elements.path_input.val(o.file_path);
					elements.type_input.val(file.type);
					elements.alert.html(d_o.success_label+file.name).removeClass("error").addClass("success").show();
				}
			}
			xhr.open("post", d_o.url, true);
			xhr.setRequestHeader("content-type","multipart/form-data");
			xhr.setRequestHeader("x-file-type",file.type);
			xhr.setRequestHeader("x-file-size",file.size);
			xhr.setRequestHeader("x-file-name",file.name);
			xhr.send(file);
		}

	}
})(jQuery);