<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Reportactivity extends CI_Controller {
	/**	
	 *
	 * @return void
	 */

	private $totalnooffields = 50; //this is suppose to be dynamic
	private $totalnoofratingfields = 27; //this is suppose to be dynamic
	private $totalnooffeedbackfields = 27; //this is suppose to be dynamic

	function __construct() {		
		parent::__construct();
		$this->load->database();	
		$this->load->helper(array('api_helper','url','security'));
		$this->load->library(array('session','authorize','gcharts','email'));
		$this->load->model('reportactivitym');
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	
	public function index() {
		$resqs = $this->reportactivitym->get_report_quiz_scorm();

		// print_r(json_encode($resqs));exit;
		$mail_log = array();

		$mailsubject = 'CDIMS: User Activities Report';
		$i=0;
		foreach ($resqs as $qsuser) {
    		$mailcontent = $this->getMailBody($qsuser);
    		/*echo $mailcontent;exit;*/
    		$to_mail = $qsuser['email'];
    		$this->mail_to_users($to_mail, $mailsubject, $mailcontent); //live
    		// $this->mail_to_users('akshaydusane@gmail.com', $mailsubject, $mailcontent); //test
    		$mail_log[$i]['type']=7;
    		$mail_log[$i]['user_selection']=1;
    		$sent_mailid['to'] = $to_mail;
    		$mail_log[$i]['sent_mail_ids']= json_encode($sent_mailid);
    		$mail_log[$i]['subject'] = $mailsubject;
    		$mail_log[$i]['content'] = $mailcontent;
    		$mail_log[$i]['created_by'] = 0; // bot is sending mails
    		$i++;
    		// exit;
		}
		$this->saveSentMails($mail_log);
	}

	private function getMailBody($userdetails){
		$body = 'Dear <b>'.ucfirst(strtolower($userdetails['firstname'])).' '.ucfirst(strtolower($userdetails['lastname'])).'</b>';
		
		$body.= '<br/><br/><br/>How are you? We thought of checking upon you, since we haven\'t connected for the sometime now. We trust all is well.';
		
		/*$body .= '<br/><p>This has reference to the email sent out yesterday pertaining to course completion.There was a coding mistake and hence some of you might have received it as an error.';
		$body .= '<br/><p>However, there is a silver-lining to the same. As you might be aware that for those users who complete their Certification successfully upto 31st Oct \' 2017, stand a chance to win the coveted book titled <b>"Novel and Conventional Methods of Audit, Investigation and Fraud Detection"</b> by Mr. Chetan Dalal.</p>';
		$body .= '<b><p>5 lucky winners shall receive a copy of the book autographed by Mr. Chetan Dalal himself. So Hurry up !!</p></b>';*/

		if($userdetails['lastlogintime'] != '1970-01-01'){
			$body.= '<br/><b>Last logged on</b>: '.date('d, M Y',strtotime($userdetails['lastlogintime']));
		}else{
			$body.= '<br/>Login status: You have never logged in.';
		}
		// $body.= '<br/><br/>Your Course Completion <b>progress</b>';
		// $body.= '<ul>';
		$body.= '<br/><br/><h3>Your Course completion (in %) : '.intval($userdetails['Activities']).'% (Attempted Quiz + Video Tutorials)</h3>';
		// $body.= '</ul>';
		$body.= '<br/>Please let us know on <a href="mailto: helpdesk@chetandalal.com">helpdesk@chetandalal.com</a> in case you are facing any issue in accessing the course material or taking the quizzes. ';
		$body.= '<br/><br/>Also, we request you to fill the <b>feedback</b> and <b>rating</b> for each module. This will help us to improve our course.<br/> ';
		$body.= '<ul>';
		$body.= '<li><h3>Rating : '.$userdetails['Rating'].' / '.$this->totalnoofratingfields.'</h3></li>';
		$body.= '<li><h3>Feedback : '.$userdetails['Feedback'].' / '.$this->totalnooffeedbackfields.'</h3></li>';
		$body.= '</ul>';

		return $body;
	}


	private function mail_to_users($to_mail, $subject, $content){
		$config['priority'] = 1;
		$this->email->initialize($config);	
		// $this->email->from('akshaydusane@gmail.com', 'chetandalal.com'); // test
		$this->email->from('helpdesk@chetandalal.com', 'chetandalal.com'); //live
		
		$this->email->subject($subject);
		$this->email->to($to_mail);

		$mailbody['username'] = substr($to_mail, 0, strpos($to_mail, '@'));
		$mailbody['content'] = $content;

		$template_email=$this->load->view('web/reportactivity_view',$mailbody,true);

		$this->email->message($template_email);
		$this->email->send();  //test
		/*if($this->email->send())
			echo 'mail sent successfully.';
		else
			echo 'mail sent failure.';*/
		
		// echo $this->email->print_debugger();

	}

	private function drawChart(){
		$this->gcharts->load('ColumnChart');

		$this->gcharts->DataTable('UserActivity')
					  ->addColumn('string', 'UserActivity', 'class')
                      ->addColumn('number', 'Ratings', 'Ratings')
                      ->addColumn('number', 'Feedback', 'Feedback')
                      ->addRow(array('UserActivity',$resqs[0]['Rating'],$resqs[0]['Feedback']));
      	
      	$config = array('title' => $resqs[0]['email']);

    	$this->gcharts->ColumnChart('UserActivity')->setConfig($config);
	}

	private function saveSentMails($log_data){
		// print_r(json_encode($log_data));exit;
		$this->reportactivitym->save_mail($log_data);
	}

}

?>