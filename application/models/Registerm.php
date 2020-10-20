<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Registration Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Register User
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Registerm extends CI_Model {	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_register = 'cdims_register_user';
	private $_order= 'cdims_course_enrolled';
	private $_order_test= 'cdims_course_enrolled_test';
	private $_newsletter= 'cdims_newsletter_subcription';
	private $_course_enrolled= 'cdims_course_enrolled';
	private $_user= 'user';
	private $_coupon_code= 'cdims_coupon_code';
	/**
	 * Store Registraion data to the database
	 *
	 * @return array
	*/
	public function save_member($data){		
		$this->db->insert( $this->db->dbprefix ( $this->_register ), $data );
		$id=$this->db->insert_id();
		$this->db->set('phone1',$data['mobile_no'])->where('id',$data['lms_id'])->update($this->db->dbprefix($this->_user));
		return $id;
	}
	public function generateorder($data){
		$this->db->insert( $this->db->dbprefix ( $this->_order), $data );			
		return $this->db->insert_id();
	}
	public function get_transaction_amount($id){
		return $this->db->select('order_amt')->where('id',$id)->get($this->db->dbprefix ( $this->_order ))->result_array ();

	}
	public function get_transaction_amount_test($id){
		return $this->db->select('order_amt')->where('id',$id)->get($this->db->dbprefix ( $this->_order_test ))->result_array ();

	}
	public function get_transaction_coupon_code($id){
		return $this->db->select('coupon_code')->where('id',$id)->get($this->db->dbprefix ( $this->_order ))->result_array ();

	}
	public function get_coupon_code($coupon_code){
		return $this->db->select('*')
					->where('coupon_code',$coupon_code)
					->where('(is_used=0 or multiple_use=1)')
					->get($this->db->dbprefix ( $this->_coupon_code ))->result_array ();
	}
	public function update_coupon_code_used($coupon_code){
		$data['is_used']=1;		
		return $this->db->where('coupon_code',$coupon_code)->update($this->db->dbprefix ( $this->_coupon_code ),$data);
	}
	public function update_order($data){
		$this->db->where('id',$data['oid']);
		$this->db->set('user_id',$data['user_id']);
		$this->db->set('order_status',$data['status']);
		$this->db->set('c_type',$data['udf3']);
		$this->db->set('course_dates',$data['udf1']);
		$this->db->set('location',$data['udf2']);
		$this->db->set('response',$data['payUresponse']);
		return $this->db->update( $this->db->dbprefix ( $this->_order));
	}
	public function update_order_test($data){
		$this->db->where('id',$data['oid']);
		$this->db->set('user_id',$data['user_id']);
		$this->db->set('order_status',$data['status']);
		$this->db->set('c_type',$data['udf3']);
		$this->db->set('course_dates',$data['udf1']);
		$this->db->set('location',$data['udf2']);
		$this->db->set('response',$data['payUresponse']);
		return $this->db->update( $this->db->dbprefix ( $this->_order_test));
	}
	public function get_orderDetails($id){
		$data['user_id']=$id;
		$data['order_status']='Successful';
		return $this->db->select('*')->where($data)->get($this->db->dbprefix ( $this->_order ))->result_array ();
	}
	public function check_verify_email($id,$hash){
		$data['lms_id']=$id;
		$data['hash']=$hash;
		return $this->db->select('id')->where($data)->get($this->db->dbprefix ( $this->_register ))->num_rows();
	}
	public function update_verify_email($id){
		$this->db->where('lms_id',$id);
		$this->db->set('verify_email',1);		
		return $this->db->update( $this->db->dbprefix ( $this->_register));
	}
	public function save_subscription($data){		
		$this->db->insert( $this->db->dbprefix ( $this->_newsletter ), $data );		
		return $this->db->insert_id();
	}
	public function re_subscription($email){		
		$this->db->where('emailid',$email);
		$this->db->set('sub_status',1);		
		$this->db->set('article_sub',1);		
		return $this->db->update( $this->db->dbprefix ( $this->_newsletter));
	}
	public function unsubmail($email){
		$this->db->where('emailid',$email);
		$this->db->set('sub_status',0);		
		return $this->db->update( $this->db->dbprefix ( $this->_newsletter));
	}
	public function unsubmail_article($email){
		$this->db->where('emailid',$email);
		$this->db->set('article_sub',0);		
		return $this->db->update( $this->db->dbprefix ( $this->_newsletter));
	}
	
}
?>