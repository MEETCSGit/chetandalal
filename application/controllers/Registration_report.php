<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Registration Report
 * @author Rajesh Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Registration_report extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

    private $docfilepaths = array(
		'docbc'=>'assets/docs/birthcertificate/',
		'docaddr'=>'assets/docs/addressprf/',
		'docgrad'=>'assets/docs/gradcert/',
		'docnamechng'=>'assets/docs/namechange/'
	);

	function __construct() {		
		parent::__construct();
		if(!$this->authorize->checkAliveSession()){
			redirect('home','refresh');
		}else if($this->session->userdata('web_admin')!=9){
			redirect('home','refresh');
		}
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session','Excel'));

		$this->load->model('registration_reportm');

		error_reporting(-1);
		ini_set('display_errors', 1);		
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		$audit_log=array('page'=>"Registeration Report",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);	
		$data=keyword_desc();
		$this->load->model('registration_reportm');
		$data['register_data']=$this->registration_reportm->getUserRegistrationData();		
		$data['rating_count_forensic']=$this->registration_reportm->getModuleRating(2);
		$data['rating_count_excel']=$this->registration_reportm->getModuleRating(8);		
		$data['rating_count_cfacfi']=$this->registration_reportm->getModuleRating(10);	
		$data['hideHeader']=1;
		$data['pageid'] = 8;						
		$this->load->view('web/header',$data);		
		$this->load->view('web/report_registration');		
		$this->load->view('web/footer');
	}

	/*public function download_user_rating($choice_data,$option_data){
		$this->load->model('registration_reportm');
		$data=$this->registration_reportm->getUserNameRating($choice_data,$option_data);

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator($this->session->userdata("firstname")." ".$this->session->userdata("lastname"))
									 ->setLastModifiedBy($this->session->userdata("firstname")." ".$this->session->userdata("lastname"))
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Chetan Dalal rating user data")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Rating");


		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Module')
		            ->setCellValue('B1', 'Firstname')
		            ->setCellValue('C1', 'Lastname')
		            ->setCellValue('D1', 'Email');

		for($i=0;$i<sizeof($data);$i++){
			$row=$i+2;
			$objPHPExcel->setActiveSheetIndex(0)
		            	->setCellValue('A'.$row, $data[$i]['name'])
			            ->setCellValue('B'.$row, $data[$i]['firstname'])
			            ->setCellValue('C'.$row, $data[$i]['lastname'])
			            ->setCellValue('D'.$row, $data[$i]['email']);

		}
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('User Rating');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		$filename=str_replace(" ","_",$data["0"]["name"])."_rating";

		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		
	}*/
	public function download_user_rating(){
		$this->load->model('registration_reportm');
		$data=$this->registration_reportm->getUserNameRating();
		$choice_data=$this->input->post('choice_data');
		$response['res_code']=1;
		$response['modal_code']=2;
		$response['method']='userRating';
		$response['userdata']=$data;
		$response['choice_data']=$choice_data;
		print_r(json_encode($response));
		exit();
	}
	public function getAllModuleUser(){
		$this->load->model('registration_reportm');
		$data=$this->registration_reportm->getAllModuleUser();
		$response['res_code']=1;
		$response['method']='userRating';
		$response['userdata']=$data;
		print_r(json_encode($response));
		exit();
	}
	public function getAllFeedback(){
		$this->load->model('registration_reportm');
		$data=$this->registration_reportm->getAllFeedback();
		$response['res_code']=1;
		$response['modal_code']=1;
		$response['method']='userRating';

		$response['userdata']=$data;
		print_r(json_encode($response));
		exit();
	}
	public function getFeedback(){
		$userid=$this->input->post('userid');
		$choice_id=$this->input->post('choice_data');
		$data=array();
		$this->load->model('registration_reportm');
		$module=$this->registration_reportm->getModule($choice_id);
		$feedbackData=$this->registration_reportm->getFeedback($userid,$module);
		if(sizeof($feedbackData)==0){
			$response['res_code']=1;      		
        	$response['message']="No Feedback from user.";
        	$response['method']="RegInfoMsg";
        	print_r(json_encode($response));
			exit();
		}
		$response['heading']="";
		$response['feedback']="<b style='font-size: 21px;'><em>".$feedbackData->name." from ".$feedbackData->firstname." ".$feedbackData->lastname."</em></b><br /><br /><b>".$feedbackData->feedback_question."</b><br/ > <br/ > ".$feedbackData->value;
		$response['res_code']=1;      		    	
    	$response['method']="feedbackalert";
    	print_r(json_encode($response));
		exit();
		
	}

	function check($rating_id,$rating_value,$id){
		if($rating_id==NULL)
	        $data="<td>".number_format((float)$rating_value, 0, '.', '')."%</td>";
	      else
	        $data="<td><a href='#' class='userlist' data-toggle='modal' data-target='#userlistmodal' onclick='getUser(".$id.",".$rating_value.")'>".number_format((float)$rating_value, 2, '.', '')."%<a></td>"; 
	    
	    return $data;
	}

	public function downloadDocs(){
		$doc_res = $this->registration_reportm->downloadDocsm();
		// print_r(json_encode($doc_res));exit;

		$_destination = 'assets/docs/alldocs/';

		$ar_files = scandir($this->docfilepaths['docgrad']);
		$ar_files = array_slice($ar_files, 2);

		/*echo '<pre>';
		print_r($ar_files);
		echo '</pre>';*/

		foreach ($ar_files as $file) {
			$ar = explode('_', $file);
			// print_r($ar);
			$key = array_search($ar[0], array_column($doc_res, 'userid'));

			if($key){
				// print_r($doc_res[$key]['name'].'_'.$ar[1]);

				copy($this->docfilepaths['docgrad'].$file, $_destination.$doc_res[$key]['name'].'_'.$ar[1]);
			}
		}
		// exit;
	}
}
?>