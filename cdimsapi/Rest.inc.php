<?php
	/**
	 * Class to act as a base class for the API. 
	 * 
	 */
	class REST {
		
		public $_allow = array();
		public $_content_type = "application/json;charset=utf-8";
		public $_request = array();		
		private $_method = "";		
		private $_code = 200;
		protected $_config = array();
		
		public function __construct($config=array()){
			date_default_timezone_set("Asia/Kolkata");
			$this->_config = $config;
			$this->inputs();
		}
		/**
		 * Protected method to get DBO Object using PDO.
		 *
		 * @return object Returns the Database PDO object
		 */
		protected function getDBO() {

			try {
				$dbh = new PDO ( "mysql:host=" .$this->_config['DB_SERVER']. ";dbname=" . $this->_config['DB_NAME'], $this->_config['DB_USER'], $this->_config['DB_PASSWORD'], array (
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
				));
					
			} catch (PDOException $e) {

				$error = array('status' => "DB_CONNECTION_FAILED", "response" => "Please try again after some time");
				if($this->_config['DEVDEBUG'])
					$error = array('status' => "DB_CONNECTION_FAILED", "response" => $e->getMessage());
				//$this->response($this->json($error),404);
				$this->_code =404;
				$this->set_headers();
				echo json_encode($error);
				exit;
			}
			return $dbh;
		}
		/**
		 * Get Referring URL 
		 * 
		 * @return string
		 */
		public function get_referer(){
			return $_SERVER['HTTP_REFERER'];
		}
		
		/**
		 * Gives the fianl response to the consumer. And also tracks the hits.
		 * 
		 * @param string $data JSON encoded string that is displayed to the consumer
		 * @param int $status Status code that needs be shown
		 */
		public function response($data,$status){
			$this->_code = ($status)?$status:200;
			$this->set_headers();
			echo $data;
			$this->tracklog($data);
			exit;
		}
		/**
		 * Default standard messages. Can be used if a mesage code needs a default status message
		 * 
		 * @return string
		 */
		private function get_status_message(){
			$status = array(
						100 => 'Continue',  
						101 => 'Switching Protocols',  
						200 => 'OK',
						201 => 'Created',  
						202 => 'Accepted',  
						203 => 'Non-Authoritative Information',  
						204 => 'No Content',  
						205 => 'Reset Content',  
						206 => 'Partial Content',  
						300 => 'Multiple Choices',  
						301 => 'Moved Permanently',  
						302 => 'Found',  
						303 => 'See Other',  
						304 => 'Not Modified',  
						305 => 'Use Proxy',  
						306 => '(Unused)',  
						307 => 'Temporary Redirect',  
						400 => 'Bad Request',  
						401 => 'Unauthorized',  
						402 => 'Payment Required',  
						403 => 'Forbidden',  
						404 => 'Not Found',  
						405 => 'Method Not Allowed',  
						406 => 'Not Acceptable',  
						407 => 'Proxy Authentication Required',  
						408 => 'Request Timeout',  
						409 => 'Conflict',  
						410 => 'Gone',  
						411 => 'Length Required',  
						412 => 'Precondition Failed',  
						413 => 'Request Entity Too Large',  
						414 => 'Request-URI Too Long',  
						415 => 'Unsupported Media Type',  
						416 => 'Requested Range Not Satisfiable',  
						417 => 'Expectation Failed',  
						500 => 'Internal Server Error',  
						501 => 'Not Implemented',  
						502 => 'Bad Gateway',  
						503 => 'Service Unavailable',  
						504 => 'Gateway Timeout',  
						505 => 'HTTP Version Not Supported');
			return ($status[$this->_code])?$status[$this->_code]:$status[500];
		}
		/**
		 * Returns the Request method. Used to modify/cross check request methods
		 * 
		 * @return string The method that will be returned. Can be POST, GET, PUT, DELETE
		 */
		public function get_request_method(){
			return $_SERVER['REQUEST_METHOD'];
		}
		/**
		 * Diffentiates input-gathering method as per the request method 
		 */
		private function inputs(){

			switch($this->get_request_method()){
				case "POST":
					switch(strtolower($_SERVER["CONTENT_TYPE"])){
						case "application/json":
						case "application/json; charset=utf-8":
							$this->_request = json_decode(file_get_contents("php://input"),TRUE);	
							$this->_request = $this->cleanInputs($this->_request);
							break;
						case "application/x-www-form-urlencoded":						
						case "application/x-www-form-urlencoded;charset=utf-8":						
							$this->_request = $_POST;	
							$this->_request = $this->cleanInputs($this->_request);
							break;
						case "text/html":						
							$this->_request = $_POST;	
							$this->_request = $this->cleanInputs($this->_request);
							break;
						case "application/xhtml+xml":						
							$this->_request = $_POST;	
							$this->_request = $this->cleanInputs($this->_request);
							break;
						default:
							$this->response('',406);
							/**
							 * Below method was used before to keep backwards compatibility.
							 * But the Android Dev team has successfully managed to implement the new API.
							 * Hence deprecated.
							 */
							// $this->_request = $this->cleanInputs($_POST);
							break;
					} 
					/*****Temp*****
					$this->_request = (array)json_decode(file_get_contents("php://input"));
					$this->_request = $this->cleanInputs($this->_request);
					****************/
					break;
				case "GET":
				case "DELETE":
					$this->_request = $this->cleanInputs($_GET);
					break;
				case "PUT":
					parse_str(file_get_contents("php://input"),$this->_request);
					$this->_request = $this->cleanInputs($this->_request);
					break;
				default:
					$this->response('',406);
					break;
			}
			
		}		
		/**
		 * Sanitize the input data. Recursively. 
		 * 
		 * @param array|object $data
		 * @return Ambigous <string, multitype:Ambigous <string, multitype:NULL > >
		 */
		private function cleanInputs($data){
			$clean_input = array();
			if(is_array($data)){
				foreach($data as $k => $v){
					$clean_input[$k] = $this->cleanInputs($v);
				}
			}else{
				if(get_magic_quotes_gpc()){
					$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			return $clean_input;
		}		
		/**
		 * Set headers for the response
		 */
		protected function set_headers(){
			header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
			/**
			 * Temporarily allowing access to all
			 */
			header('Access-Control-Allow-Origin: *');
			header("Content-Type:".$this->_content_type);
		}
		/**
		 * Track the hits to the response in a local file AND database
		 * 
		 * @param string $response The response is the response received by the client who consumes the service.
		 * @param string $hiturl Deprecated.
		 * 
		 * @return void
		 */
		private function tracklog($response = null, $hiturl = false) {
			$my_file = 'tracklog.txt';
			if ($hiturl)
				$my_file = 'putlog.txt';
			$handle = fopen ( $my_file, 'a' ) or die ( 'Cannot open file:  ' . $my_file );
		
			$data = array (
					'timestamp' => date ( "Y-m-d H:i:s" ),
					'method'=>$_SERVER['REQUEST_METHOD'],
					'content_type'=>@$_SERVER["CONTENT_TYPE"],
					'ip' => $_SERVER ['REMOTE_ADDR'],
					'response' => $response,
					'processedrequestdata' => json_encode($this->_request),
					'rawrequest'=>json_encode($_REQUEST),
					'rawinput'=>file_get_contents("php://input"),
					'browser' => @$_SERVER ['HTTP_USER_AGENT'],
					'referrer' => @$_SERVER ['HTTP_REFERER']
			);
		
			$line = implode ( "|", $data );
			fwrite ( $handle, "\n" . $line );
			fclose($handle);

			$pdo = $this->getDBO();

			$QUERY="INSERT INTO ".$this->_config['PREFIX']."cdims_api_tracklog 
											( 
												timestamp, method, content_type, 
												ip, response, processedrequestdata, rawrequest, 
												rawinput, browser, referrer
											)
								values (
											".$pdo->quote($data['timestamp']).",".$pdo->quote($data['method']).",
											".$pdo->quote($data['content_type']).",".$pdo->quote($data['ip']).",
											".$pdo->quote($data['response']).",".$pdo->quote($data['processedrequestdata']).",
											".$pdo->quote($data['rawrequest']).",".$pdo->quote($data['rawinput']).",
											".$pdo->quote($data['browser']).",".$pdo->quote($data['referrer'])."
										)";

			$pdo->query($QUERY);
		}
	}	
?>