<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Verification Document Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Verify Documents
 * @author    Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Verifym extends CI_Model {
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_user_info_data = 'user_info_data';
	private $_user = 'user';
	private $_cdims_post_mail = 'cdims_post_mail';
	private $_role_assignments = 'role_assignments';

	/**
	 * Get the list of those users whose profile is completed '100%'
	 *
	 * @return array
	*/

	public function get_profile_completed_users($flag){

		// $this->output->enable_profiler(TRUE);

		$this->db->select('u.id,u.firstname,u.lastname,u.docpath,u.email,uid1.data as documentverified, uid2.data as profilepicture');
		$this->db->from($this->db->dbprefix($this->_user).' u');
		$this->db->join($this->db->dbprefix($this->_user_info_data).' uid','u.id = uid.userid','inner');
		$this->db->join($this->db->dbprefix($this->_user_info_data).' uid1','u.id = uid1.userid','inner');
		$this->db->join($this->db->dbprefix($this->_user_info_data).' uid2','u.id = uid2.userid','inner');
		$this->db->where(array('uid.data'=>'100%','uid.fieldid'=>25,'uid1.fieldid'=>26,'uid2.fieldid'=>27));
		if($flag == 'not verified'){
			$this->db->where("( uid1.data = '$flag' OR uid1.data = '') ");
		}else{
			$this->db->where('uid1.data',$flag);
		}
		$this->db->order_by('uid1.data');
		return $this->db->get()->result_array();

		// echo $this->db->get_compiled_select();exit;
	}

	public function verify_user_documents($userid){
		$this->db->where(array('userid'=>$userid,'fieldid'=>26));
		$this->db->set('data','verified');
		return $this->db->update($this->db->dbprefix($this->_user_info_data));
	}

	public function set_rejection_documents($userid){
		$this->db->where(array('userid'=>$userid,'fieldid'=>26));
		$this->db->set('data','rejected');
		return $this->db->update($this->db->dbprefix($this->_user_info_data));
	}

	public function save_rejection_mail($data){
		$this->db->insert( $this->db->dbprefix ( $this->_cdims_post_mail ), $data );		
		return $this->db->insert_id();
	}
	public function save_verified_mail($data){
		$this->db->insert( $this->db->dbprefix ( $this->_cdims_post_mail ), $data );		
		return $this->db->insert_id();
	}

	public function get_emailid($userid){
		$this->db->select('email');
		$this->db->where('id',$userid);
		$this->db->from($this->db->dbprefix($this->_user));
		return $this->db->get()->result_array()[0];
	}
}

	// echo $this->db->select('*')->where('userid',$userid)->get_compiled_select($this->db->dbprefix($this->_user_info_data));
?>