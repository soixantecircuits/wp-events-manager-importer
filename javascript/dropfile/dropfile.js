(function($){
	//default options
	var d_o={
		"script" : "/../wp-content/plugins/wp-events-manager-importer/javascript/dropfile/upload.php"
	};

	$.fn.dropfile=function(o){
		if (o) $.extend(d_o,o);
		this.each(function(){
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
				upload(files,$(this),0);
			});
		});

		function upload(files,area,index){
			var file= files[index];
			var xhr = new XMLHttpRequest();
			area.removeClass("hover");
			xhr.onreadystatechange=function()
			{
				if (xhr.readyState==4 && xhr.status==200)
				{

					var o = JSON.parse(xhr.responseText);
					if (o.error){
						console.debug(o);
						$('<p/>').append(o.error).addClass("error").appendTo(area);
						return false;
					}
					var path_input = $('<input/>').attr({ type: 'hidden', class: 'dropfile_path', name: 'dropfile[path]' }).val(o.file_path).appendTo(area);
					var type_input = $('<input/>').attr({ type: 'hidden', class: 'dropfile_type', name: 'dropfile[type]' }).val(file.type).appendTo(area);
					$(".emi_form").submit();
				}
			}
			xhr.open("post",d_o.script,true);
			xhr.setRequestHeader("content-type","multipart/form-data");
			xhr.setRequestHeader("x-file-type",file.type);
			xhr.setRequestHeader("x-file-size",file.size);
			xhr.setRequestHeader("x-file-name",file.name);
			xhr.send(file);
		}

	}
})(jQuery);