<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Coupon code Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage  User
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Couponcodem extends CI_Model {	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_register = 'cdims_register_user';
	private $_order= 'cdims_course_enrolled';
	private $_user= 'user';
	private $_cpupon_code= 'cdims_coupon_code';
	/**
	 * Store Coupon code data to the database
	 *
	 * @return array
	*/
	public function save_coupon_data($data){		
		$this->db->insert( $this->db->dbprefix ( $this->_cpupon_code ), $data );			
		return $this->db->insert_id();
	}
	public function get_coupon_data(){		
		return $this->db->select('e.*,concat(u.firstname," ",u.lastname)Name')
				->from( $this->db->dbprefix ( $this->_cpupon_code )." as e" )
				->join( $this->db->dbprefix ( $this->_user )." as u", ' e.created_by=u.id', 'inner' )
				->get()->result_array();
	}
	
	public function delete_coupon_code($data){
		$this->db->where('id',$data['oid']);
		$this->db->set('user_id',$data['user_id']);
		$this->db->set('order_status',$data['status']);
		$this->db->set('c_type',$data['udf3']);
		$this->db->set('course_dates',$data['udf1']);
		$this->db->set('location',$data['udf2']);
		$this->db->set('response',$data['payUresponse']);
		return $this->db->update( $this->db->dbprefix ( $this->_order));
	}
	
	
}
?>