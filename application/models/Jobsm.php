<?php 
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

	/**
	 * Registration Model - Model
	 *
	 * @category  Model
	 * @package   Models
	 * @subpackage Jobs 
	 * @author    Akshay Dusane <akshay.dusane@camplus.co.in>
	 * @copyright 2016 Meetcs.com
	 * @version   1.0.0
	 */

	class Jobsm extends CI_Model
	{
		
		private $_city_table='mst_city';
		private $_state='mst_state';
		private $_country='mst_country';

		function __construct()
		{
			$this->load->database();
		}

		public function getSearchFields(){
			$data['country'] = $this->db->select('id,country_name as name')->get($this->db->dbprefix ( $this->_country))->result_array();
			$data['state'] = $this->db->select('id,state_name as name,country_id as cmp_id')->get($this->db->dbprefix ( $this->_state ))->result_array();
			$data['city'] = $this->db->select('city_name as id,city_name as name,state_id as cmp_id')->get($this->db->dbprefix ( $this->_city_table ))->result_array();
			return $data;
		}
	}