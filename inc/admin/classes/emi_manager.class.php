<?php class EMI_Manager{

	private $assocLocationId;

	public function getAssocLocationId () {
		return $this->assocLocationId;
	}

	private function xlsxtimeToDate($xlsxtime) {
		return date_i18n('d/m/Y H:i:s', ($xlsxtime - 25569) * 86400);
	}

	private function getDefault() {
		$locationDetail = array();
		$locationDetail['state_name'] = '...';
		$locationDetail['country'] = '';
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
			$locationDetail['state_name'] = (($address['administrative_area_level_1']['long_name'] != 'false') && ($address['administrative_area_level_1']['long_name'] != '')) ? 
				$address['administrative_area_level_1']['long_name'] : '...';
			$locationDetail['country'] = (($address['country']['short_name'] != 'false') && ($address['country']['short_name'] != '')) ? 
				$address['country']['short_name'] : '...';
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

	/**
	 * Parses a CSV file and translates between field data and Events Manager Importer expected result.
	 *
	 * @param string $filepath Path to the CSV file to be parsed.
	 * @param array $params Options for parsing.
	 * @return array An array of two elements: "events", which is an array containing the events data, and "location", similarly.
	 */
	// TODO: Parameterize mapping from fields in CSV file to elements in return arrays.
	function parseCsv ($filepath, $params = array('null_string' => '\N', 'null_value' => null)) {
		$ret = array(); // Array to be returned.
		// Initialize data arrays.
		$location = array();
		$events = array();

		$f = fopen($filepath, 'r');
		$r = array();
		while (($data = fgetcsv($f)) !== false)
		{
		    $r[] = $data;
		}

		$i_l = 0;
		$i_e = 0;
		foreach ($r as $v) {
			$loc = array();
			$loc['location_id']      = $i_l + 1;
			$loc['location_name']    = $v[1];
			$loc['location_address'] = $v[2];
			if (isset($_POST['geocoding'])) {
				$geodata = $this->getGeocoding("{$loc['location_name']}, {$v[6]}"); // Use postal code?
				$loc['location_town']      = $geodata['city'];
				$loc['location_region']    = $geodata['state_name'];
				$loc['location_country']   = $geodata['country'];
				$loc['location_latitude']  = $geodata['lat'];
				$loc['location_longitude'] = $geodata['lng'];
			} else {
				$loc['location_town']     = $v[4];
				$loc['location_postcode'] = $v[6];
				$loc['location_region']   = $v[5];
				$loc['location_country']  = $v[7];
			}
			$loc['post_content'] = $v[9];
			$location[] = $loc;
			$i_l++;

			$evs = array();
			$evs['event_id']            = $i_e + 1;
			$evs['event_owner']         = 1; // Always the admin?
			$evs['event_name']          = $v[12];
			$evs['event_start_time']    = date('H:i:s', strtotime($v[14]));
			$evs['event_end_time']      = date('H:i:s', strtotime($v[15]));
			$evs['event_start_date']    = date('d/m/Y', strtotime($v[14]));
			$evs['event_end_date']      = date('d/m/Y', strtotime($v[15]));
			$evs['event_all_day']       = ($params['null_string'] === $v[15]) ? 1 : 0; // No end time means "all day".
			// Coerce end date to end of day as time.
//			if ($evs['event_all_day']) {
//				$evs['event_end_date'] = $evs['event_start_date'];
//				$evs['event_end_time'] = '23:59:59';
//			}
			$evs['post_content']        = stripslashes($v[17]);
			$evs['event_rsvp']          = 0;
			$evs['event_rsp_date']      = null;
			$evs['event_spaces']        = null;
			$evs['event_category_id']   = null;
			$evs['event_attributes']    = null;
			$evs['recurrence']          = 0;
			$evs['recurrence_interval'] = null;
			$evs['recurrence_freq']     = null;
			$evs['recurrence_byday']    = null;
			$evs['recurrence_byweekno'] = null;
			$events[] = $evs;
			$i_e++;
		}

		$ret['location'] = $location;
		$ret['events'] = $events;
		return $ret;
	}
}