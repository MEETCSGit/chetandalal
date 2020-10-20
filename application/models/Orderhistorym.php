<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Order History Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Order History
 * @author    Akshay Dusane <akshay.dusane@camplus.co.in>
 * @author    Rajesh Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Orderhistorym extends CI_Model {	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_cdims_course_enrolled = 'cdims_course_enrolled';
	private $_user = 'user';

	/**
	 * Get Payment Information from database 
	 *
	 * @return array
	*/

	public function get_payment_details($userid){
		return $this->db->select('transaction_id,course_id,orderdatetime,order_amt,response,back_door_access')
					  ->where(array('user_id'=>$userid,'order_status'=>'Successful'))
					  ->get($this->db->dbprefix($this->_cdims_course_enrolled))->result_array();
	}
	public function get_transaction_details_for_print($transaction_id){
		$userid = $this->session->userdata('user_id');
		return $this->db->select('user_id, address, billing_name, reverse_charge, gstin_no,transaction_id, course_id, orderdatetime, order_amt, response')
					  ->where(array(/*'user_id'=>$userid,*/
					  				'order_status'=>'Successful',
					  				'transaction_id'=>$transaction_id,
					  				)
					  		)
					  ->get($this->db->dbprefix($this->_cdims_course_enrolled))->result_array();
	}
	public function get_user_details($userid){
		return $this->db->select('firstname,lastname,address,city,country_name,state_name')
					  ->where(array('id'=>$userid))
					  ->get($this->db->dbprefix($this->_user))->result_array();
	}
}

	// echo $this->db->select('*')->where('userid',$userid)->get_compiled_select($this->db->dbprefix($this->_user_info_data));
?>