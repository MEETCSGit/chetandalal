<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Registration Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Events
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2016 Meetcs.com
 * @version   1.0.0
 */

class Evnetsm extends CI_Model {
	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_samajik_sanstha = 'samajik_sanstha';	
	private $_city="mst_city";
	private $_country="mst_country";
	private $_state="mst_state";
	private $_designation="samajik_sanstha_designation";
	private $_event_type="event_type";
	private $_events="events";
	private $_event_category="event_category";
	private $_member="member_registration";
	private $_sansthamember="samajik_sanstha_member";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	/**
	*multi array Function  
	*Array will contain Country,state,city,Designation
	*@return Array
	*/
	public function setCountryStateCity(){
		$data['country'] = $this->db->select('id,country_name as name')->get($this->db->dbprefix ( $this->_country))->result_array ();
		$data['state'] = $this->db->select('id,state_name as name,country_id as cmp_id')->get($this->db->dbprefix ( $this->_state ))->result_array ();
		$data['city'] = $this->db->select('id,city_name as name,state_id as cmp_id')->get($this->db->dbprefix ( $this->_city ))->result_array ();
		$data['event_type'] = $this->db->select('id,type name')->get($this->db->dbprefix ( $this->_event_type ))->result_array ();
		$data['event_category'] = $this->db->select('id,name')->get($this->db->dbprefix ( $this->_event_category ))->result_array ();
		return $data;		
	}
	
	public function getallsanstha($perpage = 10, $offset = 0, $count = false,$data=''){
		$this->db->select('d.id,d.name title,d.year_of_esta,d.plot_no_shop_no,ci.city_name,d.pincode,
			d.road_no,d.area,d.landmark,teli_co.country_name,teli_s.state_name,d.mobile_no,d.landline_no,d.emailid,d.banner_img,d.lat,d.lng,d.website,d.created_by,d.contact_person');
		$this->db->from(($this->db->dbprefix ( $this->_samajik_sanstha)).' as d ');		
		$this->db->join(($this->db->dbprefix ( $this->_city)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
		$this->db->where('d.isactive=1 AND d.deleted=0');
		$search_query="";
		
		$country=$this->input->post('country_name');			
		$state=$this->input->post('state_name');
		$city=$this->input->post('city_name');
		$name=$this->input->post('sansthaname');
		
		if($country=="" || 
			$state=="" || 
			$city=="" ||
			$name==""
			){
			$country=@$this->session->userdata('sercountry');			
			$state=@$this->session->userdata('serstate');
			$city=@$this->session->userdata('sercity');
			$name=@$this->session->userdata('sername');
		}

		if(!empty($country) || !empty($name)){
			$search_query="";
			if(!empty($name)){
				$this->db->like(" d.name",$name);
			}
			if(!empty($country)){
				$this->db->where(" teli_co.id",$country);
			}
			if(!empty($state)){
				$this->db->where(" teli_s.id=",$state);
			}
			if(!empty($city)){
				$this->db->where(" teli_ci.id=",$city);
			}			
		}
		if ($count) {
			return $this->db->get ()->num_rows ();
		}
		$this->db->limit ( $perpage, $offset );
		$data=$this->db->get()->result_array();
		return $data;		
	}	
	public function storeEventData($file_details,$id=0){
		$data=array(
			'name'=>trim($this->input->post('name',TRUE)),
			'year_of_esta'=>trim($this->input->post('yearofest')),
			'registration_no'=>trim($this->input->post('regno')),
			'designation'=>trim($this->input->post('designation')),
			
			'contact_person'=>trim($this->input->post('cperson')),
			'landline_no'=>trim($this->input->post('landline')),
			'mobile_no'=>trim($this->input->post('mobile')),				
			'emailid'=>trim($this->input->post('email')),
			'website'=>trim($this->input->post('website')),
			'facebookweb'=>trim($this->input->post('facebookweb')),
			'twitterweb'=>trim($this->input->post('twitterweb')),

			'plot_no_shop_no'=>trim($this->input->post('shopno')),
			'road_no'=>trim($this->input->post('streetName')),
			'area'=>trim($this->input->post('area')),
			'landmark'=>trim($this->input->post('landmark')),

			'country'=>trim($this->input->post('country')),
			'state'=>trim($this->input->post('state')),
			'city'=>trim($this->input->post('city')),
			'pincode'=>trim($this->input->post('pincode')),

			'lat'=>trim($this->input->post('latitude')),
			'lng'=>trim($this->input->post('longitude')),
			'created_by'=>$this->session->userdata('user_id'),	
			'created_date'=>date('Y-m-d H:i:s')				
		);
		$image_for_upload=array();
		if($id==0){	
			$image_for_upload['insert']=$this->db->insert ( $this->db->dbprefix ( $this->_samajik_sanstha), $data );
			$image_for_upload['update']=0;
			$insert_id = $this->db->insert_id();

			$data1=array(
				'sanstha_id'=>$insert_id,
				'member_id'=>$this->session->userdata('user_id'),
				'designation_id'=>$this->input->post('designation'),
				'created_by'=>$this->session->userdata('user_id'),
				'created_date'=>date('Y-m-d H:i:s')
			);		
			$this->db->insert ( $this->db->dbprefix( $this->_sansthamember), $data1 );
			//print_r($data1);
		}else{	
			$this->db->where('id', $id);
			$image_for_upload['insert']=$this->db->update( $this->db->dbprefix ( $this->_samajik_sanstha ), $data );
			$image_for_upload['update']=1;			
		}
		//generate image path for upload and store it in database.
		if(!empty($file_details['scanCopy']['name'])){
			$data['doc_path']='assets/img/sanstha/doc/'.$insert_id."_".time().$file_details['scanCopy']['name'];	
			$image_for_upload['scanCopy']['path']=	$data['doc_path'];	
			$image_for_upload['scanCopy']['name']=	$insert_id."_".time().$file_details['scanCopy']['name'];
		}
		if(!empty($file_details['bannerImage']['name'])){
			$data['banner_img']='assets/img/sanstha/banner/'.$insert_id."_".time().$file_details['bannerImage']['name'];	
			$image_for_upload['bannerImage']['path']=	$data['banner_img'];	
			$image_for_upload['bannerImage']['name']=	$insert_id."_".time().$file_details['bannerImage']['name'];
		}
		if(!empty($file_details['scanCopy']['name']) || !empty($file_details['bannerImage']['name']) ){		
			$this->db->where('id', $insert_id);
			$this->db->update($this->db->dbprefix($this->_samajik_sanstha),$data);
		}
		return $image_for_upload;
	}
	public function getSansthadetails($id){		
		$this->db->select('d.id,d.banner_img,d.designation,d.facebookweb,d.twitterweb,d.registration_no,teli_ci.id city_id,teli_s.id state_id,teli_co.id country_id,d.name title,d.year_of_esta,d.plot_no_shop_no,ci.city_name,d.pincode,
			d.road_no,d.area,d.landmark,teli_co.country_name,teli_s.state_name,d.mobile_no,d.landline_no,d.emailid,d.banner_img,d.lat,d.lng,d.website,d.created_by,d.contact_person');
		$this->db->from(($this->db->dbprefix ( $this->_samajik_sanstha)).' as d ');		
		$this->db->join(($this->db->dbprefix ( $this->_city)).' as teli_ci ', 'teli_ci.id = d.city', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
		$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
		$this->db->where('d.isactive=1 AND d.deleted=0');
		$this->db->where('d.id',$id);
		$data['sansthadetail']=$this->db->get()->result_array();
		$data['designation'] = $this->db->select('id,name')->get($this->db->dbprefix ( $this->_designation ))->result_array ();

		$sql="SELECT r.id,r.profile_image_path,upper(concat(r.first_name,' ',r.middle_name,' ',r.last_name)) profilename,d.name designation,d_order FROM teli_member_registration r
				inner join teli_samajik_sanstha_member m on r.id=m.member_id
				inner join teli_samajik_sanstha s on s.id=m.sanstha_id
				inner join teli_samajik_sanstha_designation d on m.designation_id=d.id
				WHERE d.isactive=1 and m.deleted=0 and r.is_verified=1 and r.is_active=1 and s.id=".$id." order by d.d_order asc";
		$data['members']=$this->db->query($sql)->result_array();
		//$this->output->enable_profiler(TRUE);
		return $data;
	}	
	/**
	*multi array Function  
	*Array will contain Country,state,city,Designation
	*@return Array
	*/	
	public function getmemberdata(){
		$this->db->select('upper(concat(first_name," ",middle_name," ",last_name)) as name, id,profile_image_path,emailid' )->from($this->db->dbprefix($this->_member));
		if ($this->input->get ( 'q' )) {
			$this->db->limit(10);
			$this->db->where("is_verified",1);
			$this->db->where("is_active",1);
			$this->db->where ( "first_name LIKE '%" . $this->input->get ( 'q' ) . "%'" );
			$this->db->or_where ( "middle_name LIKE '%" . $this->input->get ( 'q' ) . "%'" );
			$this->db->or_where ( "last_name LIKE '%" . $this->input->get ( 'q' ) . "%'" );
			$this->db->or_where ( "emailid LIKE '%" . $this->input->get ( 'q' ) . "%'" );
		}
		return $this->db->get ()->result_array ();
	}
	public function getofficeBearers($id){
		$data=array(
			'sanstha_id'=>$id,
			);
		return $this->db->select('member_id')->from($this->db->dbprefix($this->_sansthamember))->where($data)->get()->result_array();
	}
	public function storeofficeBearers($id){
		$data=array(
			'sanstha_id'=>$id,
			'member_id'=>$this->input->post('addmember'),
			'designation_id'=>$this->input->post('designation'),
			'created_by'=>$this->session->userdata('user_id'),
			'created_date'=>date('Y-m-d H:i:s')
		);		
		return $this->db->insert ( $this->db->dbprefix ( $this->_sansthamember), $data );
	}
	public function checkExistingOfficeBearers(){
		$data=array(			
			'member_id'=>$this->input->post('addmember'),
			//'designation_id'=>$this->input->post('designation'),
			'deleted'=>0			
		);
		$this->db->select('id');
		$this->db->from($this->db->dbprefix ( $this->_sansthamember));	
		$this->db->where($data);
		return $this->db->get()->num_rows();
	}
	public function checkfordesignation($id){
		$data=array(						
			'designation_id'=>$this->input->post('designation'),
			'sanstha_id'=>$id,
			'deleted'=>0			
		);
		$this->db->select('id');
		$this->db->from($this->db->dbprefix ( $this->_sansthamember));	
		$this->db->where($data);
		return $this->db->get()->num_rows();
	}
	
}
?>