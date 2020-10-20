<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Registration Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Count User
 * @author    Rajeshkumar Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2016 Meetcs.com
 * @version   1.0.0
 */

class Countm extends CI_Model {
	 
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_register = 'member_registration';
	
	/**
	 * Daily Registration Count.
	 *
	 * @var string
	 */
	public function dailyCount($date){
		$date=$date?$date:" CURDATE()  ";
		$this->db->select('volunteer_id,count(1) count');
		$this->db->where('volunteer_id <> "0"');
		$this->db->where(" DATE_FORMAT( created_on, '%Y-%m-%d' ) = DATE_FORMAT('".$date."'   , '%Y-%m-%d' ) ");
		$this->db->group_by('volunteer_id');
		return $this->db->get($this->db->dbprefix($this->_register))->result_array();

	} 
	public function totalsumDCount($vol_id,$date){
		$date=$date?$date:" CURDATE()  ";
		//print_r($date);
		$this->db->select('count(1)  count');
		$this->db->where('volunteer_id in ('.$vol_id.')');	
		$this->db->where(" DATE_FORMAT( created_on, '%Y-%m-%d' ) = DATE_FORMAT( '".$date."'  , '%Y-%m-%d' ) ");
		return $this->db->get($this->db->dbprefix($this->_register))->result_array();
	
	}
	public function totalSumCount($vol_id){
		$this->db->select('count(1) count');
		$this->db->where('volunteer_id in ('.$vol_id.')');		
		return $this->db->get($this->db->dbprefix($this->_register))->result_array();
	}
	public function totalCount($vol_id){
		//$this->output->enable_profiler(TRUE);
		$this->db->select('volunteer_id,count(1) count');
		$this->db->where('volunteer_id in ('.$vol_id.')');
		$this->db->group_by('volunteer_id');
		return $this->db->get($this->db->dbprefix($this->_register))->result_array();
		
	} 
	public function moneypaid($vol_id){
		$this->db->select('volunteer_id,count(1) count');
		$this->db->where('volunteer_id in ('.$vol_id.')');
		$this->db->where('is_money_paid',1);
		$this->db->group_by('volunteer_id');
		return $this->db->get($this->db->dbprefix($this->_register))->result_array();
	}
	public function sevendays(){
		$sql="SELECT DATE_FORMAT( created_on, '%Y-%m-%d' )date, count(1) count
				FROM `teli_member_registration`
				WHERE  DATE_FORMAT( created_on, '%Y-%m-%d' )  >= DATE(NOW()) - INTERVAL 6 DAY
				GROUP BY DATE_FORMAT( created_on, '%Y-%m-%d' )
				order by date desc";
		return $this->db->query($sql)->result_array();
	}
	public function sevendaystotal(){
		$sql="SELECT  count(1) count
		FROM `teli_member_registration`
		WHERE  DATE_FORMAT( created_on, '%Y-%m-%d' )  >= DATE(NOW()) - INTERVAL 6 DAY";
		return $this->db->query($sql)->result_array();
	}
	

}
?>