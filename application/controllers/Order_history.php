<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Rajesh Nadar <rajesh.nadar@camplus.co.in>
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Order_history extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session'));	
		$this->load->model('orderhistorym');
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		/*if($this->session->userdata('user_id')!=2){
			$this->load->view('web/header');
			$this->load->view('web/downtime');
			$this->load->view('web/footer');
			return;
		}*/
		$data=keyword_desc();
		$audit_log=array('page'=>"Order History",'action'=>'3','description'=>'Navigated to the order history.');
		$this->authorize->audit_log($audit_log);
		
		$userid = $this->session->userdata('user_id');
		
		$orderdata = $this->orderhistorym->get_payment_details($userid);

		/*print_r(json_encode($orderdata));
		exit;*/

		foreach ($orderdata as $order) {
			if(!empty($order['response'])){
				$trn_response  = json_decode($order['response']);
				$bnk_ref_num = $trn_response->bank_ref_num;
				$product_info = $trn_response->productinfo;
				$back_door_access = $trn_response->back_door_access;
				$arr = array(
								'transaction_id'=>$order['transaction_id'],
								'orderdatetime'=>date('d-m-Y',strtotime($order['orderdatetime'])),
								'order_amt'=>$order['order_amt'],
								'product_info'=>$product_info,
								'bank_ref_num'=>$bnk_ref_num,
								'back_door_access'=>$back_door_access
							);
				$data['orderdata'][] = $arr;
			}
		}
		/*print_r(json_encode($data));
		exit;*/

		$this->load->view('web/header',$data);
		$this->load->view('web/order_history');
		$this->load->view('web/footer');
	}
	public function print_invoice($transaction_id=""){
		if($transaction_id==""){
			redirect('order-history','refresh');
		}
		$data = $this->orderhistorym->get_transaction_details_for_print($transaction_id);
		$data=$data[0];
		
		$data['base_value']=round($data['order_amt']/1.18,2);
		$data['sgst']=round($data['base_value']*0.09,2);
		$data['cgst']=round($data['base_value']*0.09,2);
		$data['total']=round( ($data['base_value']+$data['sgst']+$data['cgst']));
		$data['igst']=$data['sgst']+$data['cgst'];
		$data['in_words']=ucwords($this->getIndianCurrency($data['total']));
		$user_data=$this->orderhistorym->get_user_details($data['user_id']);
		$user_data=$user_data[0];
		if(empty($data['address'])){
			$data['address']=$user_data['address'];
		}
		if(empty($data['billing_name'])){
			$data['billing_name']=ucwords($user_data['firstname']." ".$user_data['lastname']);
		}
		$data['state_name']=$user_data['state_name'];		
		$data['response']  = json_decode($data['response'],true);
		
		/*echo "<pre>";
		print_r($data);
		exit;*/
		
		//print_r($trn_response);
		if(empty($data)){
			$this->session->set_flashdata('no_data_to_print', 'Incorrect transaction ID! ');
			redirect('order-history','refresh');
		}
			
		$this->load->library('pdf');
		$pdf = @$this->pdf->load();				
		$pdf_data=$this->load->view('web/invoice_template',$data,true);
		$pdf->WriteHTML($pdf_data);
		@$pdf->Output("invoice".$trn_response['txnid'].".pdf",'D');
		
	}

	private function getIndianCurrency($number)
	{
	    $decimal = round($number - ($no = floor($number)), 2) * 100;
	    $hundred = null;
	    $digits_length = strlen($no);
	    $i = 0;
	    $str = array();
	    $words = array(0 => '', 1 => 'one', 2 => 'two',
	        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
	        7 => 'seven', 8 => 'eight', 9 => 'nine',
	        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
	        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
	        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
	        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
	        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
	        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
	    $digits = array('', 'hundred','thousand','lakh', 'crore');
	    while( $i < $digits_length ) {
	        $divider = ($i == 2) ? 10 : 100;
	        $number = floor($no % $divider);
	        $no = floor($no / $divider);
	        $i += $divider == 10 ? 1 : 2;
	        if ($number) {
	            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
	            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
	            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
	        } else $str[] = null;
	    }
	    $Rupees = implode('', array_reverse($str));
	    $paise = ($decimal) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
	    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
	}

}
?>