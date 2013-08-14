<?php class EMI_Post extends EMI{

	public $ID;
	public $post_author;
	public $post_date;
	public $post_date_gmt;
	public $post_content;
	public $post_title;
	public $post_excerpt;
	public $post_status;
	public $comment_status;
	public $ping_status;
	public $post_password;
	public $post_name;
	public $to_ping;
	public $pinged;
	public $post_modified;
	public $post_modified_gmt;
	public $post_content_filtered;
	public $post_parent;
	public $guid;
	public $menu_order;
	public $post_type;
	public $post_mime_type;
	public $comment_count;
	public $ancestors;
	public $filter;

	function __construct($post_id){
		parent::__construct(); 
		$this->set_post_att($post_id);
	}

	function set_post_att($post_id){
		$post=get_post($post_id);
		if (!empty($post)){
			foreach ($post as $key => $value) {
				$this->$key=$value;
			}
		}
	}
}