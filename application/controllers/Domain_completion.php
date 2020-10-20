<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Domain completion mail via cURL
 * @author Atul Adhikari <atul.adhikari@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Domain_completion extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session','form_validation'));	
	}
	/**
	 * profile page
	 *
	 * @return void
	 */
	public function index() {
		$_post=$this->input->post();
		if(empty($_post)){
			return "";
		}
		$mail_data['username']=ucfirst($this->input->post('firstname'))." ".ucfirst($this->input->post('lastname'));
		$mail_data['emailid']=$this->input->post('to');
		$mail_data['content'] ='
                  <div style="width: 100% !important;">
<!--[if !mso]><!--><div style="Margin-right: 10px; Margin-left: 10px;"><!--<![endif]-->
  <div style="line-height: 10px; font-size: 1px">&nbsp;</div>
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px;"><![endif]-->

	<div style="font-size:12px;line-height:14px;color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 16px; line-height: 21px;"><strong>Congratulations </strong> on completing <b>the Domain '.$this->input->post('domain').'.</b>  Wishing you best of luck for the rest of the course.</span></p></div>

  <!--[if mso]></td></tr></table><![endif]-->

                    <div style="width: 100% !important;">
<!--[if !mso]><!--><div style="Margin-right: 10px; Margin-left: 10px;"><!--<![endif]-->
  <div style="line-height: 10px; font-size: 1px">&nbsp;</div>
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px;"><![endif]-->

  

  <!--[if mso]></td></tr></table><![endif]-->

  <div style="line-height: 10px; font-size: 1px">&nbsp;</div>
<!--[if !mso]><!--></div><!--<![endif]-->
                  </div>
                  
                  <div style="width: 100% !important;">
<!--[if !mso]><!--><div style="Margin-right: 10px; Margin-left: 10px;"><!--<![endif]-->
  <div style="line-height: 10px; font-size: 1px">&nbsp;</div>
  <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px;"><![endif]-->

	<div style="font-size:15px;line-height:16px;color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:left;"><p style="margin: 0;font-size: 12px;line-height: 14px"><span style="font-size: 14px; line-height: 16px;">Just a reminder that it is <span style="color:red;text-decoration: underline;font-weight: 600;">mandatory</span> to complete your profile along with uploading your graduation certificate and profile picture to be able to take the final examination. You can reach your Profile page in either of the following ways:<ol><li>Profile page is the first page the system takes you to as soon as you login.</li><li>Click on your name on top right side corner. Click on Profile in the drop-down list to reach your profile page.</li></ol><br />Please ignore, if you have already completed your profile.</span></p></div>

  <!--[if mso]></td></tr></table><![endif]-->

  <div style="line-height: 10px; font-size: 1px">&nbsp;</div>
<!--[if !mso]><!--></div><!--<![endif]-->
                  </div>';


		$config['priority'] = 1;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';

		$this->load->library('email');	
		$this->email->initialize($config);	
		$this->email->from('helpdesk@chetandalal.com', 'chetandalal.com');
				
		$this->email->to($this->input->post('to'));		
		
		$this->email->subject($this->input->post('subject'));
		$template_email=$this->load->view('web/newsletter_mail_template',$mail_data,true);
		$this->email->message($template_email);
		
		$this->email->send();
	}

	
}

?>