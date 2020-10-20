<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Auth Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Lauth User
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2016 Meetcs.com
 * @version   1.0.0
 */

class Lauthm extends CI_Model {
	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_customer_registration = 'customer_registration';	
	private $_registration = 'cdims_register_user';	
	private $_login_log="login_log";
	private $_user = 'user';
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->database();
	}

	/**
	 * Check login details of the admin user.
	 *
	 * @return array
	*/
	public function login($count=0){		
		$this->db->select('username,password,is_admin');
		$this->db->from($this->db->dbprefix($this->_samaj_admin_login ));
		$this->db->where (" username",$this->input->post('username')) ;
		$this->db->where (" password",$this->input->post('password')) ;
		$this->db->where (" is_admin=1");
		if(!$count){
			$data['data']= $this->db->get ()->result_array();
			return $data;
		}
		$data= $this->db->get ()->num_rows();
		return $data;
	}
	public function web_login($count=0){		
		$this->db->select('id,name,email_id,phone, password');
		$this->db->from($this->db->dbprefix($this->_customer_registration ));
		$this->db->where (" email_id",$this->input->post('email_id'));		
		$this->db->where (" is_verified=1");
		$this->db->where (" is_active=1");
		if(!$count){
			$data['data']= $this->db->get ()->result_array();			
			return $data;
		}
		$data= $this->db->get()->num_rows();		
		return $data;
	}
	public function updatepass($id){		
		$data['password']=$this->input->post('newpass');
		$this->db->where('id', $id);
		return $this->db->update($this->db->dbprefix($this->_member_registration),$data);
	}
	public function verifyAccount($id,$hash){
		$data['is_verified']=1;
		$this->db->where('id', $id);
		$this->db->where('hash', $hash);
		$this->db->update($this->db->dbprefix($this->_customer_registration),$data);
	}
	public function getUserRole($id){
		$sql="SELECT distinct(u.email) email,u.id, group_concat(r.roleid) roleid,u.firstname, u.lastname,u.username,u.phone1,u.phone2 ,u.password,u.address, u.city,u.country FROM mdl_user u, mdl_role_assignments r, mdl_context cx, mdl_course c WHERE u.id = r.userid AND r.contextid = cx.id and u.deleted=0 AND cx.instanceid = c.id and u.id=".$id;
		return $this->db->query($sql)->result_array();
	}
	public function getoldpass($id){
		$this->db->select('password');
		$this->db->where('id', $id);
		return $this->db->get($this->db->dbprefix($this->_member_registration))->result_array();
	}
	public function storeLog($data){		
		$this->db->insert($this->db->dbprefix($this->_login_log),$data);
	}
	public function getuserdetails($lms_id){
		$this->db->select('mobile_no,first_name,email,last_name');		
		$this->db->where('lms_id',$lms_id);	
		$this->db->where('verify_email',1);
		return $this->db->get($this->db->dbprefix($this->_registration))->result_array();
	}
	
	public function get_profile_completion($userid){
		return $this->db->select('address,city,state_name,country_name,pincode')
				->where('id',$userid)
				->get($this->db->dbprefix($this->_user))
				->result_array();
	}
}
?>