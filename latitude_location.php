<?php
	public function find_country ( $limit = 10 ) {
		$this->load->database();
		
		$this->db->limit( $limit );
		
		$this->db->select('id, lat,lng,loc_cc');
		$this->db->from('photos');
		
		$this->db->where("lat is not null");
		$this->db->where("lat not in (0) ");
		
		$this->db->where("lng is not null");
		$this->db->where("lng not in (0) ");
		
		$this->db->where('loc_cc is null');
		$this->db->limit( $limit );
		$this->db->order_by( "RAND(id)" );
		
		$query = $this->db->get();
		
		$arr = $query->result_array();
		if(! $arr){
			echo "All GEO location discovered. <br />\n";
			return true;
		}
		
		foreach($arr as $row){
			$lat = $row['lat'];
			$lng = $row['lng'];
			$rid = $row['id'];
			
			echo "$lat, $lng";
			
			$url = "http://ws.geonames.org/countryCode?type=json&lat=$lat&lng=$lng";
			$content = file_get_contents ($url);
			
			$loc_cc = '';

			if($content){
				$ojson = json_decode( $content );
				if(! empty($ojson->countryCode)){
					$loc_cc = $ojson->countryCode;
				}
			}
			
			if(! $loc_cc ){
				// Try the alternate countrySubdivision
				// Find closest country
				// Can't find countryCode of this one -->	http://ws.geonames.org/countryCode?lat=-34.0595&lng=151.082
				
				$url = "http://ws.geonames.org/countrySubdivisionJSON?maxRows=10&radius=40&lat=$lat&lng=$lng";
				$content = file_get_contents ($url);
				if($content){
					$ojson = json_decode( $content );
					if(! empty($ojson->countryCode)){
						$loc_cc = $ojson->countryCode;
					}
				}
				
				if(! $content ){
					echo " = no content received... <br/>";
					break;
				}
			}
			
			if( $loc_cc ) {
				if( strlen( $loc_cc ) > 2 ){
					//maybe encountered some error!
					$loc_cc = '-';
					echo " = Err?";
					//continue;
				}
			}
			
			$is_au = $loc_cc == 'AU' ? 1 : 0;
			
			$data = array(
				'is_au' => $is_au
				, 'loc_cc' => $loc_cc
				);
			$this->db->where('id', $rid );
			$this->db->update( 'photos', $data);
			
			
			usleep( rand( 300, 800 ) );	//be polite to the API server
		}
	}