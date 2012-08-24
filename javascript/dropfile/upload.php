<?php
	header("content-type : application/json");
	$h = getallheaders();
	$o = new stdClass();
	$types = array("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	if (in_array($h["x-file-type"], $types)) {
		$source = file_get_contents("php://input");
		$new_file=file_put_contents("files/".$h["x-file-name"], $source);
		if (!empty($new_file)){
	 		$directory_name=(dirname(__FILE__));
	 		$o->file_path=$directory_name."/files/".$h["x-file-name"];
	 	}
	 	else {
	 		$o->error="error during uploading the file";
	 	}
	}
	else {
		$o->error="file type not supported";
	}
 	echo json_encode($o);
?>