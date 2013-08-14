<?php class EMI {

	//a general class 
	function __construct(){

	}

	function get_notice(){
		return get_option("emi_notice");
	}

	function set_notice($new_notice){
		update_option("emi_notice",$new_notice);
	}

	function createPost($post_array){
		$post_id = wp_insert_post($post_array);
	//insert test
		if (empty($post_id)){return $post_id;}
		$Post = new EMI_Post($post_id);
		$Post->status = $post_array["post_status"];
		return $Post;
	}

	function getWordpressFormat($data){
		$format_array=array();
		foreach($data as $element){
			$format=(is_numeric($element))?"%d":"%s";
			array_push($format_array,$format);
		}
		return $format_array;
	}
}