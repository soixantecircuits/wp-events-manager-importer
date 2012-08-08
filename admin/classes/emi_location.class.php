<?php class EMI_Location extends EMI{
		protected $location_id;
		protected $db_post_id = '';
		protected $db_blog_id = 0;
		protected $db_location_slug = '';
		protected $db_location_name = 'Sans Titre';
		protected $db_location_address = '';
		protected $db_location_town = '';
		protected $db_location_state = '';
		protected $db_location_postcode = '';
		protected $db_location_region = '';
		protected $db_location_country = 'EI';
		protected $db_location_latitude = 0;
		protected $db_location_longitude = 0;
		protected $db_post_content = '';
		protected $db_location_owner = '';

		protected $Post;
		protected $post_status="publish";

		function __construct($datas){
			parent::__construct();
			$this->hydrate($datas);
		}

		private function hydrate($datas){
			foreach ($datas as $key=>$value){
				$this->$key=$value;
			}
		}

		function get_attribute($attribute){
			return $this->$attribute;
		}

		function get_post_attribute($attribute){
			return $this->Post->$attribute;
		}

		public function set_location_id($id){
			$location_id=$id;
		}

		public function save(){
			global $wpdb;
		//create the post
			$post_array=array(
				"post_type"=>EM_POST_TYPE_LOCATION
				,"post_title"=>$this->db_location_name
				,"post_content"=>$this->db_post_content
				,"post_status"=>$this->post_status
			);
			$this->Post = $this->createPost($post_array);
			if (empty($this->Post)){return 2;}
			$this->db_location_slug=$this->Post->post_name;
		//first we get a location array READY TO BE INSERTED
			$location_array=$this->get_location_array($this->Post);
			if (empty($location_array)){return 3;}
		//insert in em locations table
			$location_update=$this->update(false,$this->Post->ID,$location_array);
			(bool)($location_update);
			if (empty($location_update)){return 4;}
		//add posts metas
			$this->add_post_metas($this->Post);
			return 1;
		}

		public function update($location_id,$post_id,$data){
			if (empty($location_id)&&empty($post_id)||empty($data)){return false;}
			global $wpdb;
			$wpdb->show_errors();
			$table = EM_LOCATIONS_TABLE ;

			if (empty($location_id)&&!empty($post_id)){
	    		$where = array(
	    			"post_id" => $post_id
	    		);  
	    		$where_format = array(
	    			"%d"
	    		);
			}
			if (!empty($location_id)&&empty($post_id)){
				$where = array(
	    			"post_id" => $post_id
	    		);  
	    		$where_format = array(
	    			"%d"
	    		);
			}
	    	$data_formats =$this->getWordpressFormat($data);
			return $wpdb->update( 
					$table
					,$data
					,$where
					,$data_formats
					,$where_format
			);
		}

		function get_location_array($Post){
			$location_array=array();
			foreach(get_object_vars($this) as $key => $value){
				$oldkey=$key;
				$key=preg_replace('#^db_(.+)#',"$1", $key);
				if ($key!=$oldkey){
					$location_array[$key]=$value;
				}
			}
			if(empty($Post)){return $location_array;}
			$location_array["post_id"]=$Post->ID;
			$location_array["location_status"]=$this->get_location_status($Post->status);
			return $location_array;
		}

		function add_post_metas($Post){
			$location_array=$this->get_location_array($Post);
			$location_array["location_id"]=$this->get_location_id($Post->ID);
			foreach ($location_array as $key => $value) {
				update_post_meta($this->Post->ID, "_".$key, $value);	
			}
		}

		function get_location_status($status){
			switch($status){
				case "publish":
					return 1;
				break;
				case "pending":
					return 0;
				break;
				default :
					return 1;
				break;
			}
		}

		function get_location_id($post_id){
			global $wpdb;
			if ($post_id){
				$query=$wpdb->prepare('SELECT location_id FROM '.EM_LOCATIONS_TABLE.' WHERE post_id = %d',$post_id);
				$post_id=$wpdb->get_var($query);
				$this->location_id=$post_id;
				return $this->location_id;			
			}
			else {
				return $this->location_id;
			}
		}

		function exist(){
			global $wpdb;
			$query =$wpdb->prepare('SELECT location_id FROM '.EM_LOCATIONS_TABLE.' WHERE location_name = %s', $this->db_location_name);
			return $wpdb->get_var($query);
		}

		function get_similis(){
			global $wpdb;
			$query =$wpdb->prepare('SELECT * FROM '.EM_LOCATIONS_TABLE.' WHERE location_name = %s', $this->db_location_name);
			$similis= $wpdb->get_results($query);
			$similis_array=array();
			foreach($similis as $simili){
				$simili_array=array();
				foreach ($simili as $key=>$value){
					$simili_array["db_".$key]=$value;
				}
				$simili_array["location_id"]=$simili_array["db_location_id"];
				$Simili=new EMI_Location($simili_array);
				array_push($similis_array, $Simili);
			}
			return($similis_array);
		}

		function delete(){
			global $wpdb;
			if (!empty($this->location_id)){
				$query = $wpdb->prepare('DELETE FROM '.EM_LOCATIONS_TABLE.' WHERE location_id = %d', $this->location_id);
			}
			if (!empty($this->db_post_id)){
				wp_delete_post($this->db_post_id);
			}
			$wpdb->query($query);
		}

		function get_error($code){
		switch($code) :
			case 1 :
				return __("L'emplacement a été sauvegardé avec succès","emi");
			break;
			case 2 :
				return __("Impossible de créer l'article lié à l'emplacement","emi");
			break;
			case 3:
				return __("Erreur lors de la création du tableau de l'emplacement","emi");
			break;
			case 4 : 
				return __("Erreur lors de l'insertion dans la base de donnée des emplacements","emi");
			break;
			default :
				return __("Erreur lors de la sauvegarde de l'emplacement","emi");
			break;
		endswitch;
	}
}?>
