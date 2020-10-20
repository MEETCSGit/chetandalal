<?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
	/**
	 * Registration Model - Model
	 *
	 * @category  Model
	 * @package   Models
	 * @subpackage Individual Directory
	 * @author    Atul Adhikari <atul.adhikari@camplus.co.in>
	 * @copyright 2016 Meetcs.com
	 * @version   1.0.0
	 */

	class Individualm extends CI_Model {

		/**
		 * Define the table name
		 *
		 * @var string
		 */
		
		private $_member_registration='member_registration';
		private $_city_table='mst_city';
		private $_state='mst_state';
		private $_country='mst_country';

		public function record_count() {
			$this->db->select('r.id');
			$this->db->from(($this->db->dbprefix ( $this->_member_registration)).' as r ');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = r.present_cityid', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->order_by('id', 'RANDOM');
			$this->db->where('r.is_verified=1 and r.is_active=1');
			$query = $this->db->get();
	        $rowcount = $query->num_rows();
	        return $rowcount;
	        //return $this->db->count_all("Country");
	    }
		public function getAllIndiviual($limit, $start){			
			$this->db->select('r.id,r.first_name,r.middle_name,r.last_name,teli_ci.city_name,s.state_name,teli_co.country_name,r.profile_image_path,r.gender,r.latitude,r.longitude');
			$this->db->from(($this->db->dbprefix ( $this->_member_registration)).' as r ');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = r.present_cityid', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->order_by('id', 'RANDOM');
			$this->db->where('r.is_verified=1 and r.is_active=1');
			if($start==0)
				$this->db->limit($limit);
			else
				$this->db->limit($limit,$start);
			$data=$this->db->get()->result_array();
			return $data;
		}

		public function sendMessage(){
			$id=$this->input->post('receiver_id');
			$subject=$this->input->post('txtSubject');
			$user_message=$this->input->post('txtMessage');

			$this->db->select("first_name,middle_name,last_name,emailid");
			$this->db->from($this->db->dbprefix ( $this->_member_registration));
			$this->db->where('id='.$id);

			//$this->output->enable_profiler(TRUE);
			$data['receiver_info']=$this->db->get()->result_array();
			$data['subject']=$subject;
			$data['user_message']=$user_message;
			return $data;
		}
		public function getSearchField(){
			$data['country'] = $this->db->select('id,country_name as name')->get($this->db->dbprefix ( $this->_country))->result_array ();
			$data['state'] = $this->db->select('id,state_name as name,country_id as cmp_id')->get($this->db->dbprefix ( $this->_state ))->result_array ();
			$data['city'] = $this->db->select('id,city_name as name,state_id as cmp_id')->get($this->db->dbprefix ( $this->_city_table ))->result_array ();
			return $data;
		}
		public function getFilterIndividual($limit, $start,$inputData){			
			if($this->authorize->checkAliveSession()){
				$loginStatus="1";
			}
			else{
				$loginStatus="0";
			}
			$search_query=$this->session->userdata('search');
			$this->db->distinct();
			$this->db->select('r.id,r.first_name,r.middle_name,r.last_name,teli_ci.city_name,s.state_name,r.landmark,r.present_pincode pincode,teli_co.country_name,r.profile_image_path,r.gender,r.longitude lng,r.latitude lat');
			$this->db->from(($this->db->dbprefix ( $this->_member_registration)).' as r ');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = r.present_cityid', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->where('r.is_verified=1 and r.is_active=1 '.$search_query);
			if($start==0)
				$this->db->limit($limit);
			else
				$this->db->limit($limit,$start);
			$query = $this->db->get();
			$data=$query->result_array();	
			$data['searchData']=$query->result_array();	
			$data['baseurl']=base_url();
			$data['res_code']=1;
			$data['method']='setSearchIndividual';
			$data['loginStatus']=$loginStatus;
			$data['links']=$inputData['links'];
			$data['pagermessage']=$inputData['pagermessage'];
			return $data;
		}
		public function getFilterRowCount(){			
			$search_query=$this->session->userdata('search');
			$this->db->distinct();
			$this->db->select('r.id,r.longitude lng,r.latitude lat');
			$this->db->from(($this->db->dbprefix ( $this->_member_registration)).' as r ');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = r.present_cityid', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->where('r.is_verified=1 and r.is_active=1 '.$search_query);
			//$this->output->enable_profiler(TRUE);	
			$query = $this->db->get();
	        $rowcount = $query->num_rows();
	        return $rowcount;
		}
		public function getLanLon($limit=0,$start=0)
		{			
			$search_query=$this->session->userdata('search');
			$this->db->select('r.longitude lng,r.latitude lat');
			$this->db->from(($this->db->dbprefix ( $this->_member_registration)).' as r ');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = r.present_cityid', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->where('r.is_verified=1 and r.is_active=1 '.$search_query);
			if($start==0)
				$this->db->limit($limit);
			else
				$this->db->limit($limit,$start);
			
			$data=$this->db->get()->result_array();
			return $data;
		}
	}
?>