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

	class Causem extends CI_Model {


		/**
		 * Define the table name
		 *
		 * @var string
		 */
		private $_cause_category='cause_category';
		private $_city_table='mst_city';
		private $_state='mst_state';
		private $_country='mst_country';
		private $_cause='cause_fundraiser';
		private $_payment='cause_payments';
		private $_user= 'member_registration';

		public function getSearchField(){
			$data['category'] = $this->db->select('id,name as name')->get($this->db->dbprefix ( $this->_cause_category))->result_array ();
			$data['country'] = $this->db->select('id,country_name as name')->get($this->db->dbprefix ( $this->_country))->result_array ();
			$data['state'] = $this->db->select('id,state_name as name,country_id as cmp_id')->get($this->db->dbprefix ( $this->_state ))->result_array ();
			$data['city'] = $this->db->select('id,city_name as name,state_id as cmp_id')->get($this->db->dbprefix ( $this->_city_table ))->result_array ();
			return $data;
		}

		public function savecause($file_details,$id=0){
			$res_data=array();
			$res_data['insert']=false;
			$res_data['update']=false;
			$data=array(
					'title'=>$this->input->post('name'),
					'goal'=>$this->input->post('goal'),					
					'video_link'=>$this->input->post('video_url'),
					'enddate'=>$this->input->post('endDate'),
					'cause_category_id'=>$this->input->post('category'),
					'short_description'=>$this->input->post('desc'),
					'fundraiser_story'=>$this->input->post('story',FALSE),
					'city'=>$this->input->post('city'),
					'beneficiary'=>$this->input->post('beneficiary'),
					'beneficiary_name'=>$this->input->post('beneficiary_name'),
					'beneficiary_relation'=>$this->input->post('beneficiary_rel'),
					'created_by'=>$this->session->userdata('user_id'),
					'created_date'=>date('Y-m-d H:i:s')
				);
			if($id>0){
				unset($data['created_by']);
				unset($data['created_date']);
				$data['modified_by']=$this->session->userdata('user_id');
				$data['modified_date']=date('Y-m-d H:i:s');
			}
			
			if($id==0){
				$res_data['insert']=$this->db->insert($this->db->dbprefix ( $this->_cause),$data);
			}
			else{
				$register_id = $id;
				$this->db->where('id', $register_id);
				$res_data['update']=$this->db->update ( $this->db->dbprefix ( $this->_cause ), $data );
			}			
			$register_id=$this->db->insert_id();
			$res_data['cause_id']=$register_id;
			if(!empty($file_details['fundraiser_pic']['name'])){
				$data['cause_image_path']='assets/img/causeimg/'.$register_id."_".time().$file_details['fundraiser_pic']['name'];	
				$res_data['fundraiser_pic']['path']=$data['cause_image_path'];	
				$res_data['fundraiser_pic']['name']=$register_id."_".time().$file_details['fundraiser_pic']['name'];
				$res_data['fundraiser']=$register_id."_".time().$file_details['fundraiser_pic']['name'];
				$this->db->where('id', $register_id);
				$res_data['update']=$this->db->update($this->db->dbprefix($this->_cause),$data);
			}
			if(!empty($file_details['beneficiary_pic']['name'])){
				$data['beneficiary_picture']='assets/img/causeimg/'.$register_id."_".time().$file_details['beneficiary_pic']['name'];	
				$res_data['beneficiary_pic']['path']=$data['beneficiary_picture'];	
				$res_data['beneficiary_pic']['name']=$register_id."_".time().$file_details['beneficiary_pic']['name'];	
				$this->db->where('id', $register_id);
				$res_data['update']=$this->db->update($this->db->dbprefix($this->_cause),$data);
			}
			return $res_data;
		}
		public function getAllCategories(){			
			$data = $this->db->select('id,name as name')->get($this->db->dbprefix ( $this->_cause_category))->result_array ();
			return $data;
		}
		
		public function getAllCauses($c_id){

			$this->db->select('c.id, cc.id as c_id, cc.name as category, c.title, c.goal, c.cause_image_path, datediff(c.enddate, CURDATE()) days, c.short_description, c.created_by, u.first_name, u.last_name, c.created_by,count(p.id) as supporter,sum(p.paid_amt) amt');
			$this->db->from(($this->db->dbprefix ( $this->_cause)).' as c');
			$this->db->join(($this->db->dbprefix ( $this->_cause_category)).' as cc', 'c.cause_category_id = cc.id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_payment)).' as p', 'c.id = p.cause_fundraiser_id', 'left outer');	
			$this->db->join(($this->db->dbprefix ( $this->_user)).' as u', 'c.created_by=u.id', 'inner');
			if($c_id!=0){
				$this->db->where('c.is_verified=1 AND c.is_deleted=0 AND cc.id='.$c_id);
			}
			else{
				$this->db->where('c.is_verified=1 AND c.is_deleted=0');
			}
			$this->db->group_by('p.cause_fundraiser_id, c.id');
			$this->db->order_by('c.id', 'RANDOM');
			$data=$this->db->get()->result_array();
			$this->output->enable_profiler(TRUE);
			return $data;
		}
		public function getCauseDetails($id,$limit, $start){
			$data['allcategorydata']=array();
			//$this->db->select('c.id,cc.id as c_id,cc.name as category,c.title,c.goal,c.cause_image_path,datediff(c.enddate,CURDATE()) days,c.short_description,c.created_by,u.first_name,u.last_name,c.created_by,sum(p.paid_amt) amt');
			$this->db->select('c.id,cc.id as c_id,cc.name as category,c.title,c.goal,DATE_FORMAT(c.enddate," %d %b %Y") as enddate,c.cause_image_path,datediff(c.enddate,CURDATE()) days,c.short_description,c.fundraiser_story,c.created_by,u.first_name,u.last_name,c.created_by,sum(p.paid_amt) amt,c.video_link');
			$this->db->from(($this->db->dbprefix ( $this->_cause)).' as c');
			$this->db->join(($this->db->dbprefix ( $this->_cause_category)).' as cc', 'cc.id = c.cause_category_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_payment)).' as p', 'p.cause_fundraiser_id = c.id', 'left');	
			$this->db->join(($this->db->dbprefix ( $this->_user)).' as u', 'u.id = c.created_by', 'inner');
			$this->db->where('c.is_verified=1 AND c.is_deleted=0 AND c.id='.$id);
			$this->db->group_by('c.id');
			$data['causedata']=$this->db->get()->result_array();

			$this->db->select('mr.first_name firstname, mr.last_name lastname, mr.profile_image_path img, cp.paid_amt amt');
			$this->db->from(($this->db->dbprefix ( $this->_payment)).' as cp');
			$this->db->join(($this->db->dbprefix ( $this->_user)).' as mr', 'mr.id = cp.user_id', 'inner');
			$this->db->where('cp.transcation_status=1 AND cp.cause_fundraiser_id='.$id);
			if($start==0)
				$this->db->limit($limit);
			else
				$this->db->limit($start,$limit);
			$data['supportors']=$this->db->get()->result_array();

			$cat_id=$data['causedata']['0']['c_id'];

			$this->db->select('c.id,cc.id as c_id,cc.name as category,c.title,c.goal,c.cause_image_path,datediff(c.enddate,CURDATE()) days,c.short_description,c.created_by,u.first_name,u.last_name,c.created_by,sum(p.paid_amt) amt, count(p.id) as supporter');
			$this->db->from(($this->db->dbprefix ( $this->_cause)).' as c');
			$this->db->join(($this->db->dbprefix ( $this->_cause_category)).' as cc', 'cc.id = c.cause_category_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_payment)).' as p', 'p.cause_fundraiser_id = c.id', 'left');	
			$this->db->join(($this->db->dbprefix ( $this->_user)).' as u', 'u.id = c.created_by', 'inner');
			$this->db->where('c.is_verified=1 AND c.is_deleted=0 and cc.id='.$cat_id.' and c.id<>'.$id);
			$this->db->limit(4);
			$this->db->order_by('c.id', 'RANDOM');
			$this->db->group_by('p.cause_fundraiser_id');	
			$data_category=$this->db->get()->result_array();
			$total_records=count($data_category);
			array_push($data['allcategorydata'], $data_category);
			if($total_records<=4){
				$this->db->select('c.id,cc.id as c_id,cc.name as category,c.title,c.goal,c.cause_image_path,datediff(c.enddate,CURDATE()) days,c.short_description,c.created_by,u.first_name,u.last_name,c.created_by,sum(p.paid_amt) amt,count(p.id) as supporter ');
				$this->db->from(($this->db->dbprefix ( $this->_cause)).' as c');
				$this->db->join(($this->db->dbprefix ( $this->_cause_category)).' as cc', 'cc.id = c.cause_category_id', 'inner');
				$this->db->join(($this->db->dbprefix ( $this->_payment)).' as p', 'p.cause_fundraiser_id = c.id', 'left');	
				$this->db->join(($this->db->dbprefix ( $this->_user)).' as u', 'u.id = c.created_by', 'inner');
				$this->db->where('c.is_verified=1 AND c.is_deleted=0 and c.id<>'.$id);
				$this->db->limit(4-$total_records);
				$this->db->order_by('c.id', 'RANDOM');
				$this->db->group_by('p.cause_fundraiser_id');	
				$data_category=$this->db->get()->result_array();
			}
			//$this->output->enable_profiler(TRUE);
			array_push($data['allcategorydata'], $data_category);
			return $data;
		}
		public function getCauseData($id){
			//$this->db->select('c.id,c.title,c.goal,c.cause_image_path,c.enddate,c.video_link,c.cause_category_id,c. short_description,c.city,c.beneficiary,c.beneficiary_name,c.beneficiary_relation,teli_s.id as stateid,teli_co.id as countryid');
			$this->db->select('c.id,c.title,c.goal,c.cause_image_path,c.enddate,c.video_link,c.cause_category_id,c. short_description,c.fundraiser_story,c.city,c.beneficiary,c.beneficiary_name,c.beneficiary_relation,teli_s.id as stateid,teli_co.id as countryid');
				
			$this->db->from(($this->db->dbprefix ( $this->_cause)).' as c');
			$this->db->join(($this->db->dbprefix ( $this->_city_table)).' as teli_ci ', 'teli_ci.id = c.city', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_state)).' as teli_s ', 'teli_s.id = teli_ci.state_id', 'inner');
			$this->db->join(($this->db->dbprefix ( $this->_country)).' as teli_co ', 'teli_co.id = s.country_id', 'inner');
			$this->db->where('c.id='.$id);
			$data=$this->db->get()->result_array();
			return $data;
		}
		function supporter_count($id){
			$this->db->select('cp.id');
			$this->db->from(($this->db->dbprefix ( $this->_payment)).' as cp');
			$this->db->join(($this->db->dbprefix ( $this->_user)).' as mr', 'mr.id = cp.user_id', 'inner');
			$this->db->where('cp.transcation_status=1 AND cp.cause_fundraiser_id='.$id);
			$query = $this->db->get();
        	$rowcount = $query->num_rows();
			return $rowcount;
		}

	}
?>