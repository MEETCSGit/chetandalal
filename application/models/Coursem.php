<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Course Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Course
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Coursem extends CI_Model {
	 
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_course = 'cdims_course_request';
	
	public function save_course_request($data){
		$this->db->insert( $this->db->dbprefix ( $this->_course), $data );	
		return $this->db->affected_rows();
	}	

}
?>