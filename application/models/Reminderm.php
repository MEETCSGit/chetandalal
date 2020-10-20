<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Verification Document Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Reminder Mails
 * @author    Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Reminderm extends CI_Model {
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_user_info_data = 'user_info_data';
	private $_user = 'user';
	private $_cdims_post_mail = 'cdims_post_mail';
	private $_role_assignments = 'role_assignments';

	public function check_non_verified_users(){
		$this->db->select('u.id,uid1.data as documentverified, uid2.data as profilepicture');
		$this->db->from($this->db->dbprefix($this->_user).' u');
		$this->db->join($this->db->dbprefix($this->_user_info_data).' uid','u.id = uid.userid','inner');
		$this->db->join($this->db->dbprefix($this->_user_info_data).' uid1','u.id = uid1.userid','inner');
		$this->db->join($this->db->dbprefix($this->_user_info_data).' uid2','u.id = uid2.userid','inner');
		$this->db->where(array('uid.data'=>'100%','uid.fieldid'=>25,'uid1.fieldid'=>26,'uid2.fieldid'=>27));
		$this->db->where("(uid1.data = 'not verified' OR uid1.data = '' )");
		$this->db->order_by('uid1.data');
		// echo $this->db->get_compiled_select();exit;
		return $this->db->get()->num_rows();
	}

	public function get_web_admin_users(){
		$this->db->select('u.email');
		$this->db->from($this->db->dbprefix($this->_user).' u');
		$this->db->join($this->db->dbprefix($this->_role_assignments).' ra','u.id = ra.userid','inner');
		$this->db->where('ra.roleid',9);
		// $this->db->where('u.email','akshaydusane@gmail.com');
		return $this->db->get()->result_array();

		// echo $this->db->get_compiled_select();
	}

	public function save_reminder_mail($data){
		$this->db->insert( $this->db->dbprefix ( $this->_cdims_post_mail ), $data );		
		return $this->db->insert_id();
	}	
}

?>