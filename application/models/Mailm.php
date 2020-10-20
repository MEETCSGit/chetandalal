<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Registration Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Register User
 * @author    Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Mailm extends CI_Model {	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_cdims_newsletter_subcription = 'cdims_newsletter_subcription';
	private $_cdims_post_mail = 'cdims_post_mail';
	private $_cdims_news_subs_view = 'cdims_news_subs_view';
	private $_cdims_article_subs_view = 'cdims_article_subs_view';	
	private $_cdims_test_mail_view = 'cdims_test_mail_view';

	private $_register = 'cdims_register_user';
	private $_course_enrolled= 'cdims_course_enrolled';
	private $_user = 'user';

	/**
	 * Store Registraion data to the database
	 *
	 * @return array
	*/

	public function insert_mail(){
		// insert type, to, content, by
	}

	public function get_subscribed_users(){
		return $this->db->query('select * from a_temp ')->result_array();
	}

	public function check_subscription($emailid,$mailtype){

		$this->db->select('mu.firstname, mns.emailid as email');
		$this->db->from($this->db->dbprefix($this->_cdims_newsletter_subcription).' mns');
		$this->db->join($this->db->dbprefix($this->_user).' mu','mu.email = mns.emailid','inner');
		
		if($mailtype==1){
			// $_view_name = $this->_cdims_article_subs_view;
			$this->db->where(array('mns.emailid'=>$emailid,'mns.article_sub'=>1));
		}
		else{
			// $_view_name = $this->_cdims_news_subs_view;
			$this->db->where(array('mns.emailid'=>$emailid,'mns.sub_status'=>1));
		}

		// $_view_name = $this->_cdims_test_mail_view;

		$result = $this->db->get();

		return $result->result_array();
	}

	public function save_mail($data){
		// print_r(json_encode($data));
		$this->db->insert( $this->db->dbprefix ( $this->_cdims_post_mail ), $data );		
		return $this->db->insert_id();
	}

	public function get_email_ids($mailtype){


		
		/*$this->db->select('mu.firstname, mns.emailid as email');
		$this->db->from($this->db->dbprefix($this->_cdims_newsletter_subcription).' mns');
		$this->db->join($this->db->dbprefix($this->_user).' mu','mu.email = mns.emailid','inner');*/

		$this->db->select('emailid as email');
		$this->db->from($this->db->dbprefix($this->_cdims_newsletter_subcription));
		

		if($mailtype==1){
			// $_view_name = $this->_cdims_article_subs_view;
			$this->db->where('article_sub',1);
		}
		else if ($mailtype==2){
			// $_view_name = $this->_cdims_news_subs_view;
			$this->db->where('sub_status',1);
		}

		// echo $this->db->get_compiled_select();exit;

		// $_view_name = $this->_cdims_test_mail_view;

		$result = $this->db->get();

		return $result->result_array();
	}

	public function get_all_email_ids(){
		$result = $this->db ->select('firstname, lastname, email')
							->where('deleted',0)
							->from($this->db->dbprefix($this->_user))
							->get()->result_array();


		// echo $this->db->get_compiled_select();exit;
		return $result;
	}

	public function get_user_details($email){
		$result = $this->db ->select('firstname, email')
							->where(array('email'=>$email,'deleted'=>0))
							->get($this->db->dbprefix($this->_user))
							->result_array();

		return $result;
	}

	public function get_registered_user_details($email){
		$result = $this->db ->select('email as emailid')
							->where('deleted',0)
							->get($this->db->dbprefix($this->_user))
							->result_array();

		return $result;
	}

	public function get_paid_user(){
		$this->db->select("e.user_id,u.city,e.order_amt, concat(r.first_name,' ',r.last_name)Name,r.email Email, r.mobile_no Phone,e.orderdatetime,concat(e.id,'_',e.transaction_id)Transaction_ID ");
		$this->db->from($this->db->dbprefix($this->_course_enrolled)."  as e");
		$this->db->join($this->db->dbprefix($this->_register)."  as r", ' r.lms_id=e.user_id', 'inner');
		$this->db->join($this->db->dbprefix($this->_user)."  as u", ' r.lms_id=u.id', 'inner');
		
		$this->db->where('c_type',"olc");
		$this->db->where('e.order_status',"successful");
		$this->db->where('e.order_amt > 1');
		$this->db->where('e.orderdatetime >= "2017-04-11"');
		return $this->db->get()->result_array();
	}

	/*public function save_subscription($data){		
		$this->db->insert( $this->db->dbprefix ( $this->_newsletter ), $data );		
		return $this->db->insert_id();
	}*/

	// $this->db->select('id')->where($data)->get($this->db->dbprefix ( $this->_register ))->num_rows();
	
}
?>