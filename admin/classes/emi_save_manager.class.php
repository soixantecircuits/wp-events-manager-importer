<?php class EMI_Save_Manager extends EMI{

	function save_event($event,$method,$show_errors){
		//we save the location
		$location_array = $event["location"];
		if (!empty($location_array["db_location_name"])){
			$Location = new Emi_Location($location_array);
			$location_exist=$Location->exist();
			if (empty($location_exist)||$method=="append"){
				$location_save=$Location->save();
			}
			if($location_save>1&&$show_errors){
				echo $location_array["db_location_name"].": ".$Location->get_error($location_save);
			}
		}
		$event_array = $event["event"];

		if (!empty($event_array["db_event_name"])){
			if (!empty($Location)){
				$location_id = $Location->get_location_id(false);
			}
			else {
				$location_id=0;
			}
			$Event = new EMI_Event($event_array,$location_id);
			$event_exist = $Event->exist();
			if (empty($event_exist)||$method=="append"){
				$event_save=$Event->save();
			}
			if ($event_save>1&&$show_errors){
				echo $event_array["db_event_name"].": ".$Event->get_error($event_save);
				return false;
			}
			else if (empty($event_save)){
				return false;
			}
			return true;
		}
	}

	function delete_event($event){
		$location_array = $event["location"];
		if (!empty($location_array["db_location_name"])){
			$Location = new EMI_Location($location_array);
			$similis = $Location->get_similis();
			foreach ($similis as $simili) {
				$simili->delete();
			}
		}
		$event_array = $event["event"];
		if (!empty($event_array["db_event_name"])){
			$Event = new Emi_Event($event_array,0);
			$similis = $Event->get_similis();
			foreach ($similis as $simili) {
				$simili->delete();
			}
		}
	}

	function save_events($events_data,$method,$show_errors){
		if (empty($events_data)||empty($method)){return false;}
		switch ($method){
			//clean
			case "clean":
				foreach ($events_data as $event) {
					$this->delete_event($event);
				}
			break;
			//clean & update
			case "cleanupdate":
				foreach ($events_data as $event) {
					$this->delete_event($event);
					$this->save_event($event,"append",false);
				}
			break;		
			default :
				foreach ($events_data as $event){
					$this->save_event($event,$method,$show_errors);
				}
			break;
		}
	}
}?>