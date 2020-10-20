<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Registration Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Business Directory
 * @author    Atul Adhikari <atul.adhikari@camplus.co.in>
 * @copyright 2016 Meetcs.com
 * @version   1.0.0
 */

class Businessm extends CI_Model {


	/**
	 * Define the table name
	 *
	 * @var string
	 */
	
	private $_business_category='business_mst_category';
	private $_business_details='business_directory_details';
	private $_city_table='mst_city';
	private $_state='mst_state';
	private $_country='mst_country';
	private $_business_addr_viewed='business_address_viewed';
	private $_business_contct_viewed='business_contact_viewed';
	private $_business_business_viewed='business_track_clicking';

	public function record_count() {
		$this->db->select('d.id');
		$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
		$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
		$this->db->where('d.isactive=1 AND d.deleted=0');
		$query = $this->db->get();
        $rowcount = $query->num_rows();
        return $rowcount;
    }
	public function getAllBusiness($limit, $start){
		$this->db->select('d.id,d.title,d.description,ci.city_name,d.pincode,d.shop_no,d.street_name,d.area,d.landmark,d.address,teli_co.country_name,teli_s.state_name,d.mobile_no,d.landline_no,d.email,d.banner_img,d.latitude,d.longitude,d.website,d.created_by');
		$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
		$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
		$this->db->where('d.isactive=1 AND d.deleted=0');
		if($start==0)
			$this->db->limit($limit);
		else
			$this->db->limit($start,$limit);
		$this->db->order_by('d.id', 'RANDOM');
		$data=$this->db->get()->result_array();
		//$this->output->enable_profiler(TRUE);
		return $data;
	}
	public function getBusinessDetails($id){
		$data['allbusinessdata']=array();
		$this->db->select('d.id,d.title,d.description,d.business_category_id,ci.city_name,d.pincode,d.shop_no,d.street_name,d.area,d.landmark,d.address,teli_co.country_name,teli_s.state_name,d.mobile_no,d.landline_no,d.email,d.banner_img,d.latitude,d.longitude,d.website');
		$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
		$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
		$this->db->where('d.isactive=1 AND d.deleted=0 AND d.id='.$id);
		$data['businessdata']=$this->db->get()->result_array();

		$cat_id=$data['businessdata']['0']['business_category_id'];
		$busi_id=$data['businessdata']['0']['id'];


		$this->db->select('d.id,d.title,d.description,ci.city_name,d.pincode,d.shop_no,d.street_name,d.area,d.landmark,d.address,d.mobile_no,d.landline_no,d.email,d.banner_img,d.latitude,d.longitude,d.website');
		$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
		$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
		$this->db->where('d.isactive=1 AND d.deleted=0 and d.business_category_id='.$cat_id.' and d.id <>'.$busi_id);
		$this->db->limit(4);
		$this->db->order_by('d.id', 'RANDOM');
		$data_business=$this->db->get()->result_array();		
		$total_records=count($data_business);
		array_push($data['allbusinessdata'], $data_business);
		if($total_records<=4){
			$this->db->select('d.id,d.title,d.description,ci.city_name,d.shop_no,d.street_name,d.area,d.landmark,d.pincode,d.address,d.mobile_no,d.landline_no,d.email,d.banner_img,d.latitude,d.longitude,d.website');
			$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
			$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
			$this->db->where('d.isactive=1 AND d.deleted=0 and d.id <>'.$busi_id);
			$this->db->limit(4-$total_records);
			$this->db->order_by('d.id', 'RANDOM');
			$data_business=$this->db->get()->result_array();
			
		}
		array_push($data['allbusinessdata'], $data_business);
		/*print_r($data['allbusinessdata']);
		exit();*/
		return $data;
	}
	public function getSearchField(){
		$data['category'] = $this->db->select('id,name as name')->get($this->db->dbprefix ( $this->_business_category))->result_array ();
		$data['country'] = $this->db->select('id,country_name as name')->get($this->db->dbprefix ( $this->_country))->result_array ();
		$data['state'] = $this->db->select('id,state_name as name,country_id as cmp_id')->get($this->db->dbprefix ( $this->_state ))->result_array ();
		$data['city'] = $this->db->select('id,city_name as name,state_id as cmp_id')->get($this->db->dbprefix ( $this->_city_table ))->result_array ();
		return $data;
	}
	public function getFilterBusiness($limit, $start,$inputData){

			if($this->authorize->checkAliveSession()){
				$loginStatus="1";
			}
			else{
				$loginStatus="0";
			}
			$search_query=$this->session->userdata('business_search');
			$this->db->select('d.id,d.title,d.description,d.business_category_id,ci.city_name,d.pincode,d.shop_no,d.street_name,d.area,d.landmark,d.address,teli_co.country_name,teli_s.state_name,d.mobile_no,d.landline_no,d.email,d.banner_img,d.latitude,d.longitude,d.website');
			$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
			$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->where('d.isactive=1 AND d.deleted=0 '.$search_query);
			if($start==0)
				$this->db->limit($limit);
			else
				$this->db->limit($limit,$start);
			/*$this->output->enable_profiler(TRUE);*/
			$data['searchData']=$this->db->get()->result_array();
			$data['baseurl']=base_url();
			$data['res_code']=1;
			$data['method']='setSearchBusiness';
			$data['loginStatus']=$loginStatus;
			$data['links']=$inputData['links'];
			$data['pagermessage']=$inputData['pagermessage'];
			return $data;
	}
	public function getFilterBusinessRowCount(){
			$search_query=$this->session->userdata('business_search');
			if($this->authorize->checkAliveSession()){
				$loginStatus="1";
			}
			else{
				$loginStatus="0";
			}			
			$this->db->select('d.id,d.title,d.description,d.business_category_id,ci.city_name,d.pincode,d.shop_no,d.street_name,d.area,d.landmark,d.address,teli_co.country_name,teli_s.state_name,d.mobile_no,d.landline_no,d.email,d.banner_img,d.latitude,d.longitude,d.website');
			$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
			$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->where('d.isactive=1 AND d.deleted=0 '.$search_query);
			$query = $this->db->get();
	        $rowcount = $query->num_rows();
	        return $rowcount;
	}
	public function userdata($id){
		$this->db->select('created_by');
		$this->db->from(($this->db->dbprefix ( $this->_business_details)));
		$this->db->where('deleted=0 AND id='.$id);
		$data=$this->db->get()->result_array();
		return $data;

	}

	public function saveBusiness($file_data){		
		$data=array(
				'business_category_id'=>$this->input->post('category'),
				'title'=>$this->input->post('name'),
				'description'=>$this->input->post('desc'),
				'yearofest'=>$this->input->post('yearofest'),
				'contactperson'=>$this->input->post('contactperson'),
				'city'=>$this->input->post('city'),
				'pincode'=>$this->input->post('pincode'),
				'shop_no'=>$this->input->post('shopno'),
				'street_name'=>$this->input->post('streetName'),
				'area'=>$this->input->post('area'),
				'landmark'=>$this->input->post('landmark'),				
				'mobile_no'=>$this->input->post('mobile'),
				'landline_no'=>$this->input->post('landline'),
				'email'=>$this->input->post('email'),
				'website'=>$this->input->post('website'),
				'latitude'=>$this->input->post('latitude'),
				'longitude'=>$this->input->post('longitude'),
				'created_by'=>$this->session->userdata('user_id'),
				'created_date'=>date('Y-m-d H:i:s')
			);
			$res_data=array();
			$res_data['insert']=$this->db->insert($this->db->dbprefix ( $this->_business_details),$data);
			$res_data['update']=0;
			$register_id=$this->db->insert_id();
			$res_data['business_id']=$register_id;
			if(!empty($file_data['userfile']['name'])){
				$data['banner_img']='assets/img/business/'.$register_id."_".time().$file_data['userfile']['name'];	
				$res_data['userfile']['path']=	$data['banner_img'];	
				$res_data['userfile']['name']=	$register_id."_".time().$file_data['userfile']['name'];	
			}
			$this->db->where('id', $register_id);
			$this->db->update($this->db->dbprefix($this->_business_details),$data);
			$data['hash']=md5(time().$register_id);
			$res_data['hash']=$data['hash'];
			return  $res_data;
		}
		public function updateBusiness($file_data,$id){
		
			$data=array(
				'business_category_id'=>$this->input->post('category'),
				'title'=>$this->input->post('name'),
				'description'=>$this->input->post('desc'),
				'yearofest'=>$this->input->post('yearofest'),
				'contactperson'=>$this->input->post('contactperson'),
				'city'=>$this->input->post('city'),
				'pincode'=>$this->input->post('pincode'),
				'shop_no'=>$this->input->post('shopno'),
				'street_name'=>$this->input->post('streetName'),
				'area'=>$this->input->post('area'),
				'landmark'=>$this->input->post('landmark'),				
				'mobile_no'=>$this->input->post('mobile'),
				'landline_no'=>$this->input->post('landline'),
				'email'=>$this->input->post('email'),
				'website'=>$this->input->post('website'),
				'latitude'=>$this->input->post('latitude'),
				'longitude'=>$this->input->post('longitude'),
				'modified_by'=>$this->session->userdata('user_id'),
				'modified_date'=>date('Y-m-d H:i:s')
			);
			$res_data=array();
			$this->db->where('id', $id);
			$res_data['update']=$this->db->update( $this->db->dbprefix ( $this->_business_details ), $data);
			$res_data['insert']=0;
			if(!empty($file_data['userfile']['name'])){
				$data['banner_img']='assets/img/business/'.$id."_".time().$file_data['userfile']['name'];	
				$res_data['userfile']['path']=	$data['banner_img'];	
				$res_data['userfile']['name']=	$id."_".time().$file_data['userfile']['name'];	
			}
			$this->db->where('id', $id);
			$this->db->update($this->db->dbprefix($this->_business_details),$data);
			return $res_data;
		}
		public function getBusinessLatLng($id){
			$this->db->select("latitude,longitude");
			$this->db->from($this->db->dbprefix ( $this->_business_details));
			$this->db->where("id=".$id);
			$data=$this->db->get()->result_array();
			return $data;
		}
		public function insertClickRecord($inputData,$tablename){
			$where=" ipaddress='".$inputData['ipaddress']."' AND business_profile_id=".$inputData['business_id']." AND created_date>DATE_SUB(NOW(),INTERVAL 10 MINUTE)";
			$this->db->select("id");
			$this->db->from($this->db->dbprefix ( $this->$tablename));
			$this->db->where($where);
			$count=$this->db->get()->num_rows();
			if($count==0){
				$insertData=array('ipaddress'=>$inputData['ipaddress'],
					'business_profile_id'=>$inputData['business_id'],
					'viewed_by'=>$inputData['userid'],
					'created_date'=>date("Y-m-d H:i:s"));
				$res_data=array();
				$res_data=$this->db->insert($this->db->dbprefix ( $this->$tablename),$insertData);
				
				return $res_data;
			}
		}
		public function activateAccount($id){
			$data['isactive']=1;
			$this->db->where('id', $id);
			return $this->db->update($this->db->dbprefix($this->_business_details),$data);		
		}

		public function updatedata_fetch($id){
			$this->db->select('d.id,d.title,d.business_category_id,teli_ci.state_id,d.city,d.description,ci.city_name,d.pincode,d.shop_no,d.street_name,d.area,d.landmark,d.yearofest,d.contactperson,d.address,teli_co.country_name,teli_s.state_name,d.mobile_no,d.landline_no,d.email,d.banner_img,d.latitude,d.longitude,d.website,d.created_by');
			$this->db->from(($this->db->dbprefix ( $this->_business_details)).' as d ');
			$this->db->join(($this->db->dbprefix ( $this->_business_category)).' as teli_c ', 'teli_c.id = d.business_category_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->where('d.isactive=1 AND d.deleted=0 AND d.id='.$id);		
			$data=$this->db->get()->result_array();
			return $data;
		}
	}
?>