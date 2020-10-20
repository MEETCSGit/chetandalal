<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Audit log Model - Model
 * @category  Model
 * @package   Models
 * @subpackage Audit log User
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Audit_logm extends CI_Model {	
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_audit_log = 'cdims_audit_logs';
	/**
	 * Store Audit Log data to the database
	 *
	 * @return array
	*/
	public function save_audit_log($data){		
		return $this->db->insert( $this->db->dbprefix ( $this->_audit_log ), $data );		
	}
}
?>