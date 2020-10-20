<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Registration Report Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Report
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Registration_reportm extends CI_Model {	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_register = 'cdims_register_user';
	private $_order= 'cdims_course_enrolled';
	private $_newsletter= 'cdims_newsletter_subcription';
	private $_course_enrolled= 'cdims_course_enrolled';
	private $_user= 'user';	
	private $_user_enrolments= 'user_enrolments';	
	private $_enrol= 'enrol';	
	
	
	public function getUserRegistrationData(){

		$this->db->select("e.user_id,e.gstin_no,u.city,e.order_amt, concat(r.first_name,' ',r.last_name)Name,r.email Email, r.mobile_no Phone,e.orderdatetime,concat(e.id,'_',e.transaction_id)Transaction_ID,back_door_access ");
		$this->db->from($this->db->dbprefix($this->_course_enrolled)."  as e");
		$this->db->join($this->db->dbprefix($this->_register)."  as r", ' r.lms_id=e.user_id', 'inner');
		$this->db->join($this->db->dbprefix($this->_user)."  as u", ' r.lms_id=u.id', 'inner');
		
		$this->db->where('c_type',"olc");
		$this->db->where('e.order_status',"successful");
		$this->db->where('e.order_amt > 1');
		$this->db->where('e.orderdatetime >= "2017-04-11"');
		$this->db->where('e.course_id', 2);
		$data['registration_paid_olc'] = $this->db->get()->result_array();

		$this->db->select("e.user_id,e.gstin_no,u.city,e.order_amt, concat(r.first_name,' ',r.last_name)Name,r.email Email, r.mobile_no Phone,e.orderdatetime,concat(e.id,'_',e.transaction_id)Transaction_ID,back_door_access ");
		$this->db->from($this->db->dbprefix($this->_course_enrolled)."  as e");
		$this->db->join($this->db->dbprefix($this->_register)."  as r", ' r.lms_id=e.user_id', 'inner');
		$this->db->join($this->db->dbprefix($this->_user)."  as u", ' r.lms_id=u.id', 'inner');
		
		$this->db->where('c_type',"olc");
		$this->db->where('e.order_status',"successful");
		$this->db->where('e.order_amt > 1');
		$this->db->where('e.orderdatetime >= "2017-04-11"');
		$this->db->where('e.course_id', 10);
		$data['registration_paid_olc_cfacfi'] = $this->db->get()->result_array();

		$this->db->select("e.user_id,ifnull(e.order_status,'Bounced')status, e.c_type,u.city,e.order_amt, concat(r.first_name,' ',r.last_name)Name,r.email Email, r.mobile_no Phone,e.orderdatetime,concat(e.id,'_',e.transaction_id)Transaction_ID ");
		$this->db->from($this->db->dbprefix($this->_course_enrolled)."  as e");
		$this->db->join($this->db->dbprefix($this->_register)."  as r", ' r.lms_id=e.user_id', 'inner');
		$this->db->join($this->db->dbprefix($this->_user)."  as u", ' r.lms_id=u.id', 'inner');		
		//$this->db->where('c_type',"olc");
		$this->db->where('e.order_amt > 1');
		$this->db->where('u.id not in ("2","1336","1503")');
		$this->db->group_start();
		$this->db->where('e.order_status in ("Canceled","tampered")');
		$this->db->or_where('e.order_status is null');
		$this->db->group_end();		
		$this->db->where('e.orderdatetime >= "2017-04-11"');
		$data['transaction_failure'] = $this->db->get()->result_array();

		$this->db->select("e.user_id,u.city,e.order_amt, concat(r.first_name,' ',r.last_name)Name,r.email Email, r.mobile_no Phone,e.orderdatetime,concat(e.id,'_',e.transaction_id)Transaction_ID ");
		$this->db->from($this->db->dbprefix($this->_course_enrolled)."  as e");
		$this->db->join($this->db->dbprefix($this->_register)."  as r", ' r.lms_id=e.user_id', 'inner');
		$this->db->join($this->db->dbprefix($this->_user)."  as u", ' r.lms_id=u.id', 'inner');

		$this->db->where('c_type',"crc");
		$this->db->where('e.order_status',"successful");
		$this->db->where('e.order_amt > 1');
		$this->db->where('e.orderdatetime >= "2017-04-11"');
		$data['registration_paid_crc'] = $this->db->get()->result_array();

		$this->db->select("e.address,e.user_id,u.city,e.order_amt, concat(r.first_name,' ',r.last_name)Name,r.email Email, r.mobile_no Phone,e.orderdatetime,concat(e.id,'_',e.transaction_id)Transaction_ID ");
		$this->db->from($this->db->dbprefix($this->_course_enrolled)."  as e");
		$this->db->join($this->db->dbprefix($this->_register)."  as r", ' r.lms_id=e.user_id', 'inner');
		$this->db->join($this->db->dbprefix($this->_user)."  as u", ' r.lms_id=u.id', 'inner');
		$this->db->where('c_type',"git");
		$this->db->where('e.order_status',"successful");
		$this->db->where('e.order_amt > 1');
		$this->db->where('e.orderdatetime >= "2017-04-11"');
		$data['registration_paid_git'] = $this->db->get()->result_array();

		$this->db->select("reg.*");
		$this->db->from($this->db->dbprefix($this->_register).' reg');
		$this->db->join($this->db->dbprefix($this->_user).' u', 'reg.lms_id = u.id', 'inner');
		$this->db->where('deleted', 0);
		$this->db->order_by("reg.id", "asc");
		$data['registred_on_site'] = $this->db->get()->result_array();

		$this->db->select("emailid ,case sub_status when 1 then 'Subscribed' else 'Un- Subscribed' end sub_status ");
		$this->db->from($this->db->dbprefix($this->_newsletter));
		$data['news_letter'] = $this->db->get()->result_array();
		//$this->output->enable_profiler(TRUE);

		return $data;
	}

	public function getModuleRating($course_id){
		$rating_data=array();
		$data=array();
		$query = $this->db->query("SELECT c.id,c.name ,c.course, 
				(select SUBSTRING_INDEX(group_concat(o.id),',',1) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=1 and a.choiceid=c.id) 1_Rating_id ,
				(select(count(*) / (select count(*) from mdl_choice_answers ca where ca.choiceid=c.id)) * 100 from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=1 and a.choiceid=c.id) 1_Rating ,
				(select SUBSTRING_INDEX(group_concat(o.id),',',1) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=2 and a.choiceid=c.id) 2_Rating_id ,
				(select(count(*) / (select count(*) from mdl_choice_answers ca where ca.choiceid=c.id)) * 100 from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=2 and a.choiceid=c.id) 2_Rating ,
				(select SUBSTRING_INDEX(group_concat(o.id),',',1) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=3 and a.choiceid=c.id) 3_Rating_id ,
				(select(count(*) / (select count(*) from mdl_choice_answers ca where ca.choiceid=c.id)) * 100 from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=3 and a.choiceid=c.id) 3_Rating ,
				(select SUBSTRING_INDEX(group_concat(o.id),',',1) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=4 and a.choiceid=c.id) 4_Rating_id ,
				(select(count(*) / (select count(*) from mdl_choice_answers ca where ca.choiceid=c.id)) * 100 from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=4 and a.choiceid=c.id) 4_Rating ,
				(select SUBSTRING_INDEX(group_concat(o.id),',',1) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=5 and a.choiceid=c.id) 5_Rating_id ,
				(select(count(*) / (select count(*) from mdl_choice_answers ca where ca.choiceid=c.id)) * 100 from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=5 and a.choiceid=c.id) 5_Rating,
				(select count(*) from mdl_choice_answers ca where ca.choiceid=c.id ) count_rating ,
				(SELECT count(*) from mdl_feedback f
				INNER JOIN mdl_feedback_item fi ON f.id=fi.feedback INNER JOIN mdl_feedback_value fv ON fi.id=fv.item where substring(c.name,13,3)=substring(f.name,8,3) AND f.course = $course_id Group by f.id order by f.name) as feedback_count
 
				FROM  mdl_choice c WHERE c.course = $course_id");

			foreach ($query->result_array() as $row)
			{
		        $rating_data['id']=$row['id'];
		        $rating_data['name']= $row['name'];
		        $rating_data['course']= $row['course'];
		        $rating_data['1_Rating_id']=$row['1_Rating_id'];
		        $rating_data['1_Rating']=$row['1_Rating'];
		        $rating_data['2_Rating_id']=$row['2_Rating_id'];
		        $rating_data['2_Rating']=$row['2_Rating'];
		        $rating_data['3_Rating_id']=$row['3_Rating_id'];
		        $rating_data['3_Rating']=$row['3_Rating'];
		        $rating_data['4_Rating_id']=$row['4_Rating_id'];
		        $rating_data['4_Rating']=$row['4_Rating'];
		        $rating_data['5_Rating_id']=$row['5_Rating_id'];
		        $rating_data['5_Rating']=$row['5_Rating'];
		        $rating_data['count_rating']=$row['count_rating'];
		        $rating_data['feedback_count']=$row['feedback_count'];
		        array_push($data, $rating_data);
			}
			return $data;
	}

	 /*public function getUserNameRating($choice_data,$option_data){
	 	$data=array();
		$query = $this->db->query("SELECT u.firstname,u.lastname,c.name,u.email from mdl_user u INNER JOIN mdl_choice_answers ca ON u.id=ca.userid INNER JOIN  mdl_choice c ON ca.choiceid=c.id Where ca.choiceid=" .$choice_data." and ca.optionid=".$option_data);		
		foreach ($query->result_array() as $row)
		{
	        $user_data['firstname']=$row['firstname'];
	        $user_data['lastname']= $row['lastname'];
	        $user_data['name']= $row['name'];
	        $user_data['email']= $row['email'];
	        array_push($data, $user_data);
		}
		return $data;

	}*/
	public function getUserNameRating(){
		$choice_data=$this->input->post('choice_data');
		$option_data=$this->input->post('option_data');
	 	$data=array();
		$query = $this->db->query("SELECT u.id,u.firstname,u.lastname from mdl_user u INNER JOIN mdl_choice_answers ca ON u.id=ca.userid Where ca.choiceid=" .$choice_data." and ca.optionid=".$option_data);		
		foreach ($query->result_array() as $row)
		{
	        $user_data['uid']=$row['id'];
	        $user_data['firstname']=$row['firstname'];
	        $user_data['lastname']= $row['lastname'];
	        array_push($data, $user_data);
		}
		return $data;

	}

	public function getAllModuleUser(){
		$choice_data=$this->input->post('choice_data');		
	 	$data=array();
		$query = $this->db->query("SELECT firstname, lastname FROM mdl_choice_answers ca INNER JOIN mdl_user u ON ca.userid=u.id WHERE ca.choiceid=" .$choice_data);	
			
		foreach ($query->result_array() as $row)
		{
	        $user_data['firstname']=$row['firstname'];
	        $user_data['lastname']= $row['lastname'];
	        array_push($data, $user_data);
		}
		return $data;

	}

	public function getModule($choice_id){
		$data=array();
		$query = $this->db->query("SELECT substring(name,6,11) as name from mdl_choice Where id=".$choice_id);		
		$res=$query->result();
		$module=$res[0]->name;
		return $module;
	}

	public function getFeedback($userid,$module){	
		$data=array();		
		$query = $this->db->query("SELECT f.name,fv.value,u.id,u.firstname,u.lastname,fi.name as feedback_question from mdl_feedback f INNER JOIN mdl_feedback_item fi ON f.id=fi.feedback inner join mdl_feedback_value fv on fi.id=fv.item inner join mdl_feedback_completed fc on fv.completed=fc.id inner JOIN mdl_user u on fc.userid=u.id where u.id=".$userid." and locate('".$module."',f.name)>0 order by f.name");	
			
		$res=$query->result();
		$data=$res[0];
		return $data;
	}

	public function getAllFeedback(){	
		$module=$this->input->post('module');			
		$course=$this->input->post('course');			
		$data=array();		
		$query = $this->db->query("SELECT concat(u.firstname,' ',u.lastname) as username,f.name,fv.value,u.id,u.firstname,u.lastname,fi.name as feedback_question, fc.timemodified from mdl_feedback f 
								INNER JOIN mdl_feedback_item fi ON f.id=fi.feedback 
								inner join mdl_feedback_value fv on fi.id=fv.item 
								inner join mdl_feedback_completed fc on fv.completed=fc.id 
								inner JOIN mdl_user u on fc.userid=u.id 
								where locate('".$module."',f.name)>0 AND f.course = ".$course." order by f.name");	
			
		$data=$query->result_array();
		return $data;
	}

	public function downloadDocsm(){
		$this->db->select('ue.userid, CONCAT_WS("_", u.firstname, u.lastname) as name, u.email, u.docpath');
		$this->db->from($this->db->dbprefix($this->_user_enrolments).' ue');
		$this->db->join($this->db->dbprefix($this->_enrol).' e', 'ue.enrolid = e.id AND e.courseid = 2 AND enrol = "manual" ', 'inner');
		$this->db->join($this->db->dbprefix($this->_user).' u', 'ue.userid = u.id', 'inner');
		$this->db->where('u.docpath IS NOT NULL');
		$this->db->order_by('ue.userid', 'DESC');
		// $this->db->limit(3);

		// echo $this->db->get_compiled_select();exit;

		return $this->db->get()->result_array();

	}

}
?>