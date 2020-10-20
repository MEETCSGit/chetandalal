<?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
	/**
	 * Home
	 *
	 * @category  Model
	 * @package   Models
	 * @subpackage Home
	 * @author    Akshay Dusane <akshay.dusane@camplus.co.in>
	 * @copyright 2017 Meetcs.com
	 * @version   1.0.0
	 */

	class Homem extends CI_Model {

		private $_user_enrolments = 'user_enrolments';

		public function get_enrollment($user_id){
			$this->db->select('FROM_UNIXTIME(timestart,"%D %M %Y") as start_date, FROM_UNIXTIME(timeend,"%D %M %Y") as end_date');
			$this->db->from($this->db->dbprefix($this->_user_enrolments));
			$this->db->where(array('userid'=>$user_id, 'enrolid'=>1, 'timeend !='=>0));
			return $this->db->get()->result_array();
		}
	}