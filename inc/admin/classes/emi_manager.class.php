<?php class EMI_Manager{

	private $assocLocationId;

	public function getAssocLocationId () {
		return $this->assocLocationId;
	}

	/*
	private function slugify ($text) {
  		// replace non letter or digits by -
  		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  		// trim
  		$text = trim($text, '-');
  		// transliterate
  		if (function_exists('iconv')) {
    		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  		}
  		// lowercase
  		$text = strtolower($text);
  		// remove unwanted characters
  		$text = preg_replace('~[^-\w]+~', '', $text);
  		// default output
  		if (empty($text)) {
    		return 'n-a';
  		}
		 
  		return $text;
	}
	*/

	private function xlsxtimeToDate($xlsxtime) {
		return date_i18n('d/m/Y H:i:s', ($xlsxtime - 25569) * 86400);
	}

	private function getDefault() {
		$locationDetail = array();

		//$locationDetail['state'] = '...';
		$locationDetail['state_name'] = '...';
		$locationDetail['country'] = '';
		//$locationDetail['country_name'] = '...';
		$locationDetail['lat'] = '...';
		$locationDetail['lng'] = '...';

		return $locationDetail;
	}

	private function getGeocoding($r) {
		$host = "http://maps.googleapis.com/";
		$geocoding = json_decode(file_get_contents($host.'maps/api/geocode/json?sensor=false&address='.urlencode($r)));
		if( (isset ($geocoding->status)) && ($geocoding->status == 'OK') ) {
			$locationDetail = array();
			$geometry = $geocoding->results[0]->geometry;
			$address_components = $geocoding->results[0]->address_components;
			$address = array();
			foreach ($address_components as $components) {
				$address[$components->types[0]] = array ('short_name' => $components->short_name, 'long_name' =>  $components->long_name);
			}

			$address['lat'] = (String) $geometry->location->lat;
			$address['lng'] = (String) $geometry->location->lng;

			$locationDetail['city'] = (($address['locality']['long_name'] != 'false') && ($address['locality']['long_name'] != '')) ? 
				$address['locality']['long_name'] : '...';
			//$locationDetail['state'] = (($address['administrative_area_level_1']['short_name'] != 'false') && ($address['administrative_area_level_1']['short_name'] != '')) ? 
				//$address['administrative_area_level_1']['short_name'] : '...';
			$locationDetail['state_name'] = (($address['administrative_area_level_1']['long_name'] != 'false') && ($address['administrative_area_level_1']['long_name'] != '')) ? 
				$address['administrative_area_level_1']['long_name'] : '...';
			$locationDetail['country'] = (($address['country']['short_name'] != 'false') && ($address['country']['short_name'] != '')) ? 
				$address['country']['short_name'] : '...';
			//$locationDetail['country_name'] = (($address['country']['long_name'] != 'false') && ($address['country']['long_name'] != '')) ? 
				//$address['country']['long_name'] : '...';

			$locationDetail['lat'] = (($address['lat'] != 'false') && ($address['lat'] != '')) ? 
				$address['lat'] : '...';
			$locationDetail['lng'] = (($address['lng'] != 'false') && ($address['lng'] != '')) ? 
				$address['lng'] : '...';
			return $locationDetail;
		} else {
			return $this->getDefault();
		}
	}

	public function getLocationArray ($xlsx, $geocoding = false) {
		$this->assocLocationId = array( '' => 0 );
		$em_locations = array();

		$id = 0;
		foreach($xlsx->rows() as $k=> $r) {
			if ($id == 0) { $id++; continue; }
			$locationDetail = ($geocoding ? $this->getGeocoding($r[1]) : $this->getDefault());
			$exploded = explode("-", $r[1]);
			array_push($em_locations, array(
				'location_id' => $id,
				'location_name' => isset($exploded[1]) ? $exploded[1] : null,
				'location_address' => '...',
				'location_town' => isset($locationDetail['city']) ? $locationDetail['city'] : (isset($exploded[1]) ? $exploded[1] : '...') ,
				'location_postcode' => isset($exploded[0]) ? $exploded[0] : '...',
				'location_region' => $locationDetail['state_name'],
				'location_country' => $locationDetail['country'],
				'location_latitude' => $locationDetail['lat'],
				'location_longitude' => $locationDetail['lng'],
				'post_content' => null,

			));
			$this->assocLocationId[($r[1])] = $id;
			$id++;
		}
		return $em_locations;
	}

	public function getEventArray ($xlsx) {
		$em_events = array();

		$id = 0;
		foreach($xlsx->rows() as $k=> $r) {
			if ($id == 0) {
				$id++;
			} else {
				$timeExploded = explode(' ', $this->xlsxtimeToDate($r[2]));
				array_push($em_events, array(
					'event_id' => $id,
					'event_owner' => 1,
					'event_name' => isset($r[0]) ? $r[0] : '...',
					'event_start_time' => isset($timeExploded[1]) ? $timeExploded[1] : '08:00:00',
					'event_end_time' => isset($timeExploded[1]) ? $timeExploded[1] : '18:00:00',
					'event_all_day' => 1,
					'event_start_date' => isset($timeExploded[0]) ? $timeExploded[0] : '01/01/1970',
					'event_end_date' => isset($timeExploded[0]) ? $timeExploded[0] : '01/01/1970',
					'post_content' => '...',
					'event_rsvp' => 0,
					'event_rsvp_date' => null,
					'event_rsvp_time' => "00:00:00",
					'event_spaces' => 0,
					'event_category_id' => null,
					'event_attributes' => /*array()*/ null,
					'recurrence' => 0,
					'recurrence_interval' => null,
					'recurrence_freq' => null,
					'recurrence_byday' => null,
					'recurrence_byweekno' => null,
				));
				$id++;
			}
		}
		return $em_events;
	}
}
?>
