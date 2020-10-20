<?php
/**
 * API Helper - Helper
 *
 * @category Helper
 * @package Helper
 * @subpackage APIHelper
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2016 Meetcs.com
 * @version 1.0.0
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );



/**
 * Transpose of an array
 *
 * @param array $data
 *        	Array to be transposed
 *        	
 * @return array
 */
function transpose($data = array()) {
	if (is_object ( $data ))
		$data = get_object_vars ( $data );
	
	if (! is_array ( $data ))
		return $data;
	
	$new_data = array ();
	foreach ( $data as $key => $record )
		foreach ( $record as $index => $value )
			$new_data [$index] [$key] = $value;
	return $new_data;
}

/**
 * GET array to GET string
 *
 * @param array $getArr
 *        	Array to be converted to GET string(query string)
 *        	
 * @return string
 */
function getArrToString($getArr = array()) {
	if (empty ( $getArr ))
		return null;
	
	array_walk ( $getArr, function (&$a, $b) {
		$a = "$b=$a";
	} );
	
	return implode ( "&", $getArr );
}

/**
 * Personal Function for formatted debugging
 * I am not a fan of print_r so this!
 *
 * @param string|array $str
 *        	Anything that needs to be formatted. Mostly arrays.
 * @return void
 */
function pdump($str = null) {
	echo "<pre>";
	var_dump ( $str );
	echo "</pre>";
}

/**
 * Per page results dropdown
 * Just HTML with intelligence
 *
 * @param string $perpageval
 *        	Value of Page results per page
 */
function resultsperpage($perpageval = null,$name="perpage") {

	echo '<div class="col-md-2">Show <select class="form-control" name="perpage" id="perpage" onchange="this.form.submit()">';
	$pages = array (
			5,
			10,
			20,
			50,
			100 
	);
	foreach ( $pages as $eachpage ) {
		$selected = ($eachpage == ( int ) $perpageval) ? "selected" : "";
		echo '<option value="' . $eachpage . '" ' . $selected . '>' . $eachpage . '</option>';
	}
	
	echo '</select>entries</div>';
}
function displaypaginationtext($offset = 0, $per_page, $total_rows, $msgtext = "Showing %s to %s of %s results") {
	$offset = ($offset - 1) * $per_page;
	$result_start = $offset + 1;
	if ($result_start == 0)
		$result_start = 1;
	$result_end = $result_start + $per_page - 1;
	
	if ($result_end < $per_page)
		$result_end = $per_page;
	else if ($result_end > ($total_rows))
		$result_end = ($total_rows);
	if($result_start<=0)
		$result_start=1;
	//echo "Showing $result_start to $result_end of " . ($total_rows) . " results";
	return sprintf($msgtext,$result_start,$result_end,$total_rows);
}

/**
 * Redirect with Success/Fail message
 *
 * @param string $link
 *        	The link to which the redirect occurs
 * @param string $msg
 *        	The message to be flashed after redirection
 */
function redirectwithmsg($link = null, $msg = null) {
	$CI = & get_instance ();
	$CI->session->set_flashdata ( 'message', $msg );
	redirect ( $link, "refresh" );
}

function getIpAddress(){
	if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;
}

function keyword_desc(){
	$data['keyword']="Forensic Practice,Fraud Investigation,Risk assessment,CA, Chartered Accountant,Forensic Accountant, Forensic Services,Fraudulent Claims,Mumbais top Forensic Accountant,Mumbais top Forensic Accounting course,Top 10 Forensic auditing, Forensic auditing,Gujarat Forensic Sciences University,GFSU,Forensic Sciences Training workshops,Fraud Detection services";
	$data['description']="Fraud Detection | Forensic auditing | Risk Assessment | B Training services | Training workshops | Certification Courses through Gujarat Forensic Sciences University, Asia's first university dedicated to forensic sciences (GFSU) and ACFE";
	return $data;
}

function moodle_site(){
	$data['name'] = base_url()."lms";
	return $data;
}

function moodle_site1(){
	$data= base_url()."lms";
	return $data;
}

function get_course_details(){
	$course['course_1']['c_id']="1";
	$course['course_1']['c_name']="Fraud Investigation";
	$course['course_2']['c_id']="2";
	$course['course_2']['c_name']="Forensic Investigation";
	$course['course_3']['c_id']="3";
	$course['course_3']['c_name']="Risk Assessment";
	return $course;
}

/**
 * populate data base on the value in rating report
 *
 * @param string $rating_id
 *        	The rating id of that module
 * @param string $rating_value
 *        	The Value of Rating
 * @param string $id
 *        	The id of module
 */
function check($rating_id,$rating_value,$id){
	if($rating_id==NULL)
        $data="<td>".number_format((float)$rating_value, 0, '.', '')."%</td>";
      else
        $data="<td><a href='#' class='userlist' data-toggle='modal' data-target='#userlistmodal' onclick='getUser(".$id.",".$rating_id.")'>".number_format((float)$rating_value, 2, '.', '')."%<a></td>"; 
    
    return $data;
}
