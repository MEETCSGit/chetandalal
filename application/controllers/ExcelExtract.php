<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class ExcelExtract extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		//if(!$this->authorize->checkAliveSession()){ // This page is only for the developer.
			redirect('home','refresh');
		//}

		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library('excel');
		$this->load->model("registerm");
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {

		$audit_log=array('page'=>"ExcelExtract",'action'=>'5','description'=>'Registred user with excel');
		$this->authorize->audit_log($audit_log);

		$file = "./assets/uploads/cdims_user_data.xlsx";		
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

		$users = array();
		$invalidusers = array();

		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
    		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

    		$orgusr[$row][] = $data_value;
    		
    		// echo " ".$column." ".$row." ".$data_value."<br>";
    		// $usr['emailid'] = $data_value;
		}

		/*print_r(json_encode($orgusr));
		exit;*/
		$total = 0;
		$countvalid = 0;
		$countinvalid = 0;
		$valid = array();
		$invalid = array();
		foreach ($orgusr as $u) {
			$total++;
			// print_r(json_encode($u));
			if(!( empty($u[0]) or empty($u[1])) ){

				$countvalid++;
				$usr['emailid'] = $u[0];

				if(strpos($u[1],' ')){
					$usr['firstname'] = explode(" ", $u[1])[0];
					$usr['lastname'] = explode(" ", $u[1])[1];
				}else{
					$usr['firstname'] = $u[1];
					$usr['lastname'] = $u[1];
				}
	    		array_push($valid, $usr);
			}else{
				$countinvalid++;
				array_push($invalid, $u);
			}
		}

		$users['valid'] = $valid;
		$users['invalid'] = $invalid;
		$users['countvalid']=$countvalid;
		$users['countinvalid']=$countinvalid;
		$users['total']=$total;

		// print_r(json_encode($users));

		$this->createUserRest($users);
	}

	public function createUserRest($users){
		$audit_log=array('page'=>"ExcelExtract",'action'=>'5','description'=>'Registred user with excel can be bulk at '.date('d-m-Y H:i:s'));
		$this->authorize->audit_log($audit_log);
		$errusr = 0;
		$succusr = 0;

		$this->load->library('curl');

		$site = moodle_site();
		$token = '799ed071b21aef609de0fa42df0900a7';
		$domainname = $site['name']; 
		$functionname = 'core_user_create_users';
		$restformat = 'json';

		$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';

		// $reqcount = 0;

		foreach ($users['valid'] as $user) {

			$moodleuser = new stdClass();
			$moodleuser->username = $user['emailid'];
			$moodleuser->password = 'elearning';
			$moodleuser->firstname = $user['firstname'];
			$moodleuser->lastname = $user['lastname'];
			$moodleuser->email = $user['emailid'];
			$moodleuser->auth = 'manual';

			$mdusers = array($moodleuser);
			$params = array('users' => $mdusers);

			// sleep(1000);
			$restres = $this->curl->simple_post($serverurl, $params, array(CURLOPT_RETURNTRANSFER=>1));

			$restres=json_decode($restres,true);
			print_r($restres);
		
			if(isset($restres['exception'])){
				$errusr++;
				// print_r(json_encode($restres));

			}else{
				$succusr++;
				print_r(json_encode($restres));
				$data['first_name']=$user['firstname'];
				$data['last_name']= $user['lastname'];
				$data['email']= $user['emailid'];
				$data['lms_id']= $restres[0]['id'];

				$this->registerm->save_member($data);
			}
		}
		// echo "Success : ".$succusr." Error : ".$errusr;
	}
}
?>