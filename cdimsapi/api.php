<?php
require_once ("Rest.inc.php");
/**
 * API class for the CDIMS Payment Gateway app.
 * This API handles the authentication, validation and data options of the app.
 *
 * @category API
 * @package API
 * @author Rajeshkumar Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2017 MEETCS.com
 * @version 1.0.0
 */
class API extends REST {
	public $data = "";

	private $config = array();
	private $amt=12000;
	public function __construct($config=array()) {
		if(!$config['DEVDEBUG'])
			error_reporting(0);
		$this->config = $config;		
		parent::__construct ($config);

	}

	/**
	 * Public method to access API.
	 * This method dynamically calls the method based on the query string
	 *
	 * @return void 
	 */
	public function processApi() {
		/**
		 * Settings made accordingly in the .htaccess file
		 * whatever is passed comes in rquest
		 * Single param allowed. Replacing / by nothing. If method does not exist show nothing
		 */		
		$func = strtolower ( trim ( str_replace ( "/", "", $_REQUEST ['rquest'] ) ) );

		$allow_this = array (
				'login',
				'get_access_key',
				'get_transaction_id',
				'success',
				'failure',
				'get_transaction_data',
				'get_amount_data'
		);		
		if ((( int ) method_exists ( $this, $func ) > 0) && in_array($func,$allow_this))
			$this->$func ();
		else
			$this->response ('', 404 ); // If the method not exist with in this class, response would be "Page not found".
	}
	/**
	 * Encode array/object into JSON
	 * 
	 * @param object|array $data Pass an array or object that needs to be converted to JSON
	 * 
	 * @return JSON Data in JSON encoded format
	 */
	private function json($data) {
		if (is_array ( $data ) || is_object($data)) {
			return json_encode ( $data );
		}
	}
	/**
	 * This function loads single result as an object.
	 *
	 * @param string $sql
	 *        	The query to be run.
	 * @return object The object obtained after running the query
	 */
	private function loadObject($sql = null) {
		
		if (! $sql)
			return false;
		$pdo = $this->getDBO ();
		$stmt = $pdo->query ( $sql );
	
		if (! $stmt)
			return false;
		$pdo = null;
		return $stmt->fetchObject();
	}
	/**
	 *	Simple login for the ANM
	 *	method used POST
	 *  username : <USERNAME>
	 *  password : <PASSWORD>
	 *	imei : <IMEI NUMBER>
	 */
	private function login(){
		// Cross validation if the request method is POST else it will return "Not Acceptable" status
		if($this->get_request_method() != "POST"){
			$this->response('Not Acceptable',406);
		}
		$uname = $this->_request['username'];
		$pwd = $this->_request['password'];	
		/*
		*	Method to validate and return single or two IMEI numbers
		*/
			
  		$used_in = $this->validateIMEI($this->_request['imei']);//This line will check the IMEI no. and will return the IMEI no. if it is valid.  
  		if(empty($used_in) || !$used_in){
  			$error = array('status' => false, "response" => "INVALID_DATA");
			$this->response($this->json($error),400);
  		}		
  		
		$showdata  = (@trim ( $this->_request['showdata']) == 'true' || (@trim ( $this->_request['showdata'] )) && (@trim ( $this->_request['showdata']) != 'false')) ? true : false;
		$hash = @trim ( $this->_request ['hash'] ) ? @trim ( $this->_request ['hash'] ) : false;
		$data = array();
		
		/**
		 * Checking empty fields first
		 */
		if (! $uname && ! $pwd) {
			$error = array('status' => false, "response" => "EMPTY_FIELDS");
			$this->response($this->json($error),400);
		}
		if (! $uname) {
			$error = array('status' => false, "response" => "EMPTY_USERNAME");
			$this->response($this->json($error),400);
		}
		if (! $pwd) {
			$error = array('status' => false, "response" => "EMPTY_PASSWORD");
			$this->response($this->json($error),400);
		}

		/*******************************/		
		$pdo = $this->getDBO ();
		$sql="SELECT id,username,name,user_type_id from  ".$this->config['PREFIX']."users where username=" . $pdo->quote ( $uname ) ." and password=".$pdo->quote ( $pwd );	
		$result = $this->loadObject ( $sql);		
		/**
		 * LoadObject method returns boolean false if no results 
		 */
		if(!is_object($result)){
			$data = array('status' => false, "response" => "AUTHENTICATION_FAILED");
			$this->response($this->json($data),400);
		}
		$data = array('status' => true, "response" => "AUTHENTICATION_SUCCESS");

		/**
		 * If showdata flag is set, include the round data 
		 */
		if (is_object ( $result ) && $showdata) {			
			$result->round = $pdo->query ( "SELECT * from ".$this->config['PREFIX']."rounds where isopen=1" )
					->fetch( PDO::FETCH_ASSOC );
			$data["data"] = $result;
		}
		$this->response($this->json($data),200);
	}
	private function check_server_status(){
		if($this->get_request_method() != "POST"){
			$this->response('Not Acceptable',406);
		}
		$checkserver="cdims";
		if($checkserver==$this->_request['value']){
			$data = array('status' => true,"response" => "CONNECTED_SERVER");			
			$this->response($this->json($data),200);
		}
		$this->response('',404);
	}
	private function get_access_key(){

		if($this->get_request_method() != "POST"){
			$this->response('',404);
		}		
		$token = @$this->_request['token'];	
		if(empty($token)){			
			$this->response('',404);
		}		
		$pdo = $this->getDBO ();
		$sql="SELECT userid from  ".$this->config['PREFIX']."external_tokens where token=" .$pdo->quote( $token );	
		$data['identifier']=md5(base64_encode(date('Ymd')).$token.uniqid());
		$result = $this->loadObject ( $sql);
		$data['uid']=$result->userid;
		$sql=" INSERT INTO  ".$this->config['PREFIX']."cdims_api_access_key (userid,access_key)  values ('".$data['uid']."','".$data['identifier']."');";
		$this->loadObject ( $sql);
		$data['status'] =true;			
		$this->response($this->json($data),200);		
	}
	private function update_identifier($uid=0,$identifier=0){
		if($this->get_request_method() != "POST"){
			$this->response('',404);
		}
		try {
			$pdo = $this->getDBO ();
			$sql=" UPDATE  ".$this->config['PREFIX']."cdims_api_access_key set is_used=1 where userid='".$uid."'and access_key='".$identifier."'";			
			$result= $this->loadObject ($sql);
						
		} catch (Exception $e) {
			$this->response($this->json($e->getMessage()),200);	
		}		
	}
	private function storeTransaction($data){
		$sql="INSERT into ".$this->config['PREFIX']."cdims_course_enrolled (".implode(",",array_keys($data)).") values('".implode("','",array_values($data))."')";
		$pdo = $this->getDBO ();
		$result = $pdo->query($sql);		
		return $pdo->lastInsertId();
	}
	private function getUserDetails($userid){				
		try {
			if($this->get_request_method() != "POST"){
				$this->response('',404);
			}			
			$sql=" SELECT firstname,lastname,phone1,email from ".$this->config['PREFIX']."user  where id=".$userid;	
			//print_r($sql);	
			
			return $this->loadObject($sql);
		}catch (Exception $e) {
			$this->response($this->json($e->getMessage()),200);	
		}
	}
	private function get_transaction_id(){
		if($this->get_request_method() != "POST"){
			$this->response('',404);
		}
		$identifier = @$this->_request['identifier'];	
		$uid = @$this->_request['uid'];	
		if(empty($identifier) || empty($uid) ){	
			$this->response('',404);
		}
		$sql=" SELECT is_used from  ".$this->config['PREFIX']."cdims_api_access_key  where access_key='".$identifier."'";
		$result= $this->loadObject ($sql); // check access key status 		
		if(empty($result)){
			$this->response('',404);
		}
		if($result->is_used){
			$this->response('',404); //Send error if access_key is used
		}
		$sql=" UPDATE  ".$this->config['PREFIX']."cdims_api_access_key set is_used=1 where userid='".$uid."'and access_key='".$identifier."'";	
		$result= $this->loadObject ($sql); // update access key once used
		$data=array();
		try {
			$o_data['course_id']=3;
			$o_data['order_amt']=$this->amt;
			$o_data['user_id']=$uid;
			$o_data['c_type']="olc";
			$o_data['request_from']="2";
			$o_data['transaction_id']=$uid."_".$o_data['course_id']."_".substr(hash('sha256', uniqid().mt_rand() . microtime()), 0, 20);
			$data['udf3']="olc";
			$data['udf1']=$uid;
			$data['udf2']='';
			$data['productinfo']="Online Course";
			$data['amount']=$this->amt;	

			$oid=$this->storeTransaction($o_data);
			$userDetails=$this->getUserDetails($uid);

			$data['o_id']=$oid;
			$data['MERCHANT_KEY']="G1DDBd";//live
			//$data['MERCHANT_KEY']="Oshjxq";//test
			$data['SALT']="xAJTzWR3";//live
			//$data['SALT']="DPDBHpbu";//test		
			$data['txnid']=$data['o_id']."_".$o_data['transaction_id'];
			$data['host']="https://secure.payu.in/_payment";
			$data['user_id']=$uid;
			$data['firstname']=$userDetails->firstname;			
			$data['phone']=$userDetails->phone1;
			$data['email']=$userDetails->email;

			$hashSequence=$data['MERCHANT_KEY']."|".$data['txnid']."|".$data['amount']."|".$data['productinfo']."|".$data['firstname']."|".$data['email']."|".@$data['udf1']."|".@$data['udf2']."|".$data['udf3']."||||||||".$data['SALT'];
			$data['hash']=strtolower(hash('sha512', $hashSequence));
			unset($data['SALT']);
			unset($data['MERCHANT_KEY']);
			$data['status']="true";
			$data['success']=base_url()."/cdims-api/success";
			$data['failure']=base_url()."/cdims-api/failure";
			$data['cancel']=base_url()."/cdims-api/cancel";
			$data['response']="Valid";
			$this->response($this->json($data),200);
						
		} catch (Exception $e) {
			$this->response($this->json($e->getMessage()),200);	
		}
	}	
	private function get_transaction_data(){
		if($this->get_request_method() != "POST"){
			$this->response('',404);
		}			
		if(empty(@$this->_request['txnid']) || @$this->_request['txnid']==""){
			$this->response('',404);
		}
		$t_id=explode('_', $this->_request['txnid']);		
		$sql=" SELECT response from  ".$this->config['PREFIX']."cdims_course_enrolled  where id='".$t_id[0]."'";
		$result= $this->loadObject ($sql);
		$result=json_decode($result->response,true);
		$data['status']=$result['status'];
		$data['txnid']=$result['txnid'];
		$data['amount']=$result['amount'];
		$data['productinfo']=$result['productinfo'];
		$data['unmappedstatus']=$result['unmappedstatus'];
		$data['bank_ref_num']=$result['bank_ref_num'];
		$data['error_Message']=$result['error_Message'];		
		$this->response($this->json($data),200);
	}	
	private function get_amount_data(){
		if($this->get_request_method() != "POST"){
			$this->response('',404);
		}
		$identifier = @$this->_request['identifier'];	
		$uid = @$this->_request['uid'];	
		if(empty($identifier) || empty($uid) ){	
			$this->response('',404);
		}
		$sql=" SELECT is_used from  ".$this->config['PREFIX']."cdims_api_access_key  where access_key='".$identifier."'";
		$result= $this->loadObject ($sql); // check access key status 		
		if(empty($result)){
			$this->response('',404);
		}
		if($result->is_used){
			$this->response('',404); //Send error if access_key is used
		}
		$sql=" UPDATE  ".$this->config['PREFIX']."cdims_api_access_key set is_used=1 where userid='".$uid."'and access_key='".$identifier."'";	
		$result= $this->loadObject ($sql); // update access key once used
		$data['amount']=$this->amt;
		$this->response($this->json($data),200);
	}
}
// Initiate Library
$api = new API (include dirname(__FILE__).'/config.inc.php');
$api->processApi ();

?>
