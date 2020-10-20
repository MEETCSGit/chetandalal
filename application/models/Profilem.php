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

class Profilem extends CI_Model {	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_user_info_data = 'user_info_data';
	private $_user = 'user';
	private $_cdims_mst_country='cdims_mst_country';
	private $_cdims_mst_state='cdims_mst_state';
	private $_cdims_register_user='cdims_register_user';
	private $_quiz_attempts='quiz_attempts';
	private $_quiz='quiz';
	
	
	// private $_city='mst_city';

	
	public function get_countries(){
		$data['country'] = $this->db->select('id,country as name')
									->get($this->db->dbprefix($this->_cdims_mst_country))
									->result_array();
		return $data;
	}

	public function get_states($countryid){
		$data['states'] = $this->db->select('id,name')
									->where('country_id',$countryid)
									->get($this->db->dbprefix($this->_cdims_mst_state))
									->result_array();
		return $data;
	}

	/**
	 * Store Registraion data to the database
	 *
	 * @return array
	*/

	public function update_profile($fieldidarr, $data, $userid){

		foreach ($fieldidarr as $field) {

			$whr = array('userid'=>$userid, 'fieldid'=>$field);
			$res = $this->db->where($whr)->get($this->db->dbprefix($this->_user_info_data));
			if($res->num_rows()){
				if(!in_array($field, array(28,29))){				
					$this->db->where($whr);
					$this->db->update($this->db->dbprefix($this->_user_info_data),array('data'=>$data[$field]));
				}
				// echo $this->db->last_query();
			}else{
				$insdata = array('userid'=>$userid, 'fieldid'=>$field, 'data'=>$data[$field]);
				$this->db->insert($this->db->dbprefix($this->_user_info_data),$insdata);
			}

		}
		

		$this->db->where('id',$userid);
		$this->db->set('phone1',$data['phone1']);
		$this->db->set('dob',$data['dateofbirth']);
		$this->db->set('state_name',$data['state_name']);
		$this->db->set('country_name',$data['country_name']);
		$this->db->set('pincode',$data['pincode']);
		$this->db->set('address',$data['address']);
		$this->db->set('docpath',$data['docpath']);
		return $this->db->update($this->db->dbprefix($this->_user));
		// return $this->db->query($sql);
	}

	public function get_profile($userid){
		$result = $this->db->select('email,middlename,dob,state_name,country_name,pincode,docpath')
						->where('id',$userid)
						->get($this->db->dbprefix($this->_user))
						->result_array();
		$data['middlename']=$result[0]['middlename'];
		$data['dob']=$result[0]['dob'];
		$data['state_name']=$result[0]['state_name'];
		$data['country_name']=$result[0]['country_name'];
		$data['pincode']=$result[0]['pincode'];
		$data['docpath']=$result[0]['docpath'];
		$data['email']=$result[0]['email'];
		return $data;
		
	}

	public function set_profile_completed($userid){
		$this->db->where(array('userid'=>$userid,'fieldid'=>25));
		$this->db->set('data','100%');
		return $this->db->update($this->db->dbprefix($this->_user_info_data));
	}


	public function get_doc_paths($userid){
		return $this->db->select('docpath')->where('id',$userid)
				->get($this->db->dbprefix($this->_user))
				->result_array()[0];

	}

	public function get_profile_picture_path($userid){
		return $this->db->select('data as profilepicture')
						->where(array('userid'=>$userid,'fieldid'=>27))
						->get($this->db->dbprefix($this->_user_info_data))
						->result_array();
	}

	/**
	 * Update the CI table : firstname, lastname, phone no
	 *
	*/

	public function update_ci_register($userid,$fname,$lname,$phone){
		$this->db->where('lms_id',$userid);
		$this->db->set('first_name',$fname);
		$this->db->set('last_name',$lname);
		$this->db->set('mobile_no',$phone);
		$this->db->update($this->db->dbprefix($this->_cdims_register_user));
	}

	/**
	 * Set documentverified flag to 'not verified' incase of rejection of document 
	 *
	*/	

	public function update_document_verified($userid){
		$this->db->where(array('userid'=>$userid, 'fieldid'=>26));
		$this->db->set('data','not verified');
		$this->db->update($this->db->dbprefix($this->_user_info_data));	
	}

	/* For user history module*/
	public function get_quiz($userid){
		$this->db->select('COUNT(*) attempts,quiz.name,quiz.id, (attempts.sumgrades / quiz.sumgrades * quiz.grade)grade');

		$this->db->from(($this->db->dbprefix($this->_quiz_attempts))." as attempts");
		$this->db->join(($this->db->dbprefix($this->_quiz))." as quiz",'attempts.quiz=quiz.id',"inner");
		$this->db->where(array('attempts.userid'=>$userid,'state'=>'finished'));
		return $this->db->group_by('quiz.name,attempts.userid')
						->get()
						->result_array();
	
	}
	/*for rateing history*/
	public function get_rating($userid){
		return $this->db->query('SELECT c.id,c.name , 
				
				(select count(*) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=1 and a.choiceid=c.id and a.userid='.$userid.') 1_Rating ,
              
				(select count(*)from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=2 and a.choiceid=c.id and a.userid='.$userid.') 2_Rating ,
              
				(select count(*) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=3 and a.choiceid=c.id and a.userid='.$userid.') 3_Rating ,
                
				
                
				(select count(*) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=4 and a.choiceid=c.id and a.userid='.$userid.') 4_Rating ,
                
			
				(select count(*) from mdl_choice_answers a
				INNER join mdl_choice_options o on a.optionid=o.id
				where char_length(o.text)=5 and a.choiceid=c.id and a.userid='.$userid.') 5_Rating
 
				FROM  mdl_choice c')->result_array();
	}

	/*public function get_profile_completion($userid){
		return $this->db->select('address,city,state_name,country_name,pincode')
				->where('id',$userid)
				->get($this->db->dbprefix($this->_user))
				->result_array();
	}*/


	/*$sql = "UPDATE mdl_user_info_data 
				SET data = (
		                        CASE 	
		                        	WHEN fieldid = ".$fieldidarr[0]." THEN '".$data[$fieldidarr[0]]."'
                                    WHEN fieldid = ".$fieldidarr[1]." THEN '".$data[$fieldidarr[1]]."'
                                    WHEN fieldid = ".$fieldidarr[2]." THEN '".$data[$fieldidarr[2]]."'
                                    WHEN fieldid = ".$fieldidarr[3]." THEN '".$data[$fieldidarr[3]]."'
                                    WHEN fieldid = ".$fieldidarr[4]." THEN '".$data[$fieldidarr[4]]."'
                                    WHEN fieldid = ".$fieldidarr[5]." THEN '".$data[$fieldidarr[5]]."'
                                    WHEN fieldid = ".$fieldidarr[6]." THEN '".$data[$fieldidarr[6]]."'
                                    WHEN fieldid = ".$fieldidarr[7]." THEN '".$data[$fieldidarr[7]]."'
                                    WHEN fieldid = ".$fieldidarr[8]." THEN '".$data[$fieldidarr[8]]."'
                                    WHEN fieldid = ".$fieldidarr[9]." THEN '".$data[$fieldidarr[9]]."'
	                         	END
	                      	) 
				WHERE userid = ".$userid;

		// echo $sql;
		// exit;

		$this->db->query($sql);*/
	
}
?>