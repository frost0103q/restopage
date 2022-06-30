<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    
class Stripe extends CI_Controller {
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
    parent::__construct();
    $this->load->library("session");
    $this->load->helper('url');
    }
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index()
    {
        $this->load->view('stripePayment/index');
    }
        
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function payment()
    {
        require_once('application/libraries/stripe-php/init.php');
        
        $stripeSecret = $this->config->item('stripe_secret');

        if ($rest_id = $this->session->userdata('current_rest_id') || $rest_id = $this->input->post('rest_id')){
            if($rest = $this->db->where("rest_id", $rest_id)->get("tbl_payment_settings")->row()){
                $stripeSecret = $rest->stripe_secret_key;
                \Stripe\Stripe::setApiKey($stripeSecret);
                
                $order_id = $this->input->post('order_id');
                $duration_time = $this->input->post('duration_time');
                if ($temp_stripe = $this->db->where('order_id',$order_id)->get('tbl_stripe_order_temp')->row()){
                    $amount = 100 * $temp_stripe->amount;
                    $tokenId = $temp_stripe->tokenId;
        
                    $stripe = \Stripe\Charge::create ([
                            "amount" => intval($amount),
                            "currency" => "eur",
                            "source" => $tokenId,
                            "description" => "Restopage Payment",
                    ]);
                        
                    // after successfull payment, you can store payment related information into your database
                    
                    // $cart = $this->session->userdata('shopping_cart');
                    // $cart["stripe"] = $stripe;
                    
                    $shopping_cart_stripe['transaction_id'] = isset($stripe['id']) ? $stripe['id'] : '';
                    $shopping_cart_stripe['balance_transaction'] = isset($stripe['balance_transaction']) ? $stripe['balance_transaction'] : '';
                    $shopping_cart_stripe['payment_method'] = isset($stripe['payment_method']) ? $stripe['id'] : '';
                    $shopping_cart_stripe['billing_details']['city'] = isset($stripe['billing_details']['address']['city']) ? $stripe['billing_details']['address']['city'] : '';
                    $shopping_cart_stripe['billing_details']['country'] = isset($stripe['billing_details']['address']['country']) ? $stripe['billing_details']['address']['country'] : '';
                    $shopping_cart_stripe['billing_details']['line1'] = isset($stripe['billing_details']['address']['line1']) ? $stripe['billing_details']['address']['line1'] : '';
                    $shopping_cart_stripe['billing_details']['line2'] = isset($stripe['billing_details']['address']['line2']) ? $stripe['billing_details']['address']['line2'] : '';
                    $shopping_cart_stripe['billing_details']['postal_code'] = isset($stripe['billing_details']['address']['postal_code']) ? $stripe['billing_details']['address']['postal_code'] : '';
                    $shopping_cart_stripe['billing_details']['state'] = isset($stripe['billing_details']['address']['state']) ? $stripe['billing_details']['address']['state'] : '';
                    $shopping_cart_stripe['billing_details']['email'] = isset($stripe['billing_details']['email']) ? $stripe['billing_details']['email'] : '';
                    $shopping_cart_stripe['billing_details']['phone'] = isset($stripe['billing_details']['phone']) ? $stripe['billing_details']['phone'] : '';
                    $shopping_cart_stripe['billing_details']['name'] = isset($stripe['billing_details']['name']) ? $stripe['billing_details']['name'] : '';
                    
                    $order_transaction = $shopping_cart_stripe['transaction_id'];
                    $toUpdatedata = array(
                        "order_payout_status" => "paid",
                        "order_status" => "accepted",
                        'order_transaction'=>$order_transaction ,
                        'order_duration_time'=>$duration_time ,
                    );
                    $status = 1;
                }else{
                    $order_transaction = "";
                    $toUpdatedata = array(
                        "order_payout_status" => "paid",
                        "order_status" => "accepted",
                        'order_duration_time'=>$duration_time ,
                    );
                    $status = 2;
                }
                $this->db->where('order_id',$order_id)->update("tbl_orders",$toUpdatedata);
                $this->db->where('order_id',$order_id)->delete("tbl_stripe_order_temp");
        
                // $this->session->set_userdata('shopping_cart_stripe', $shopping_cart_stripe);
        
                $data = array('status' => $status, "transactionID" => $order_transaction ,'data'=> $shopping_cart_stripe, 'error' =>'You already got paid for this order.') ;
            }else{
                $data = array('status' => 0);
            }
        }else{
            $data = array('status' => 0);
        }
        echo json_encode($data);
    }
    // refund
    public function refund(){
        require_once('application/libraries/stripe-php/init.php');
        
        $stripeSecret = $this->config->item('stripe_secret');
        $sessData= unserialize($this->session->userdata('rest_user_Data'));
        $rest_id = $sessData[0]->rest_id;
        $rest = $this->db->where("rest_id", $rest_id)->get("tbl_payment_settings")->row();
        $order_id =$_POST['order_id'];

        $order = $this->db->where('order_id',$order_id)->where('order_payment_method','stripe')->get('tbl_orders')->row();
		$transactionID = $order->order_transaction;
        $amount = $order->order_amount;

        $stripeSecret = $rest->stripe_secret_key;
        \Stripe\Stripe::setApiKey($stripeSecret);

        $toUpdatedata = array(
            "order_status" => "canceled",
        );
        
        try {
            $refund = \Stripe\Refund::create([
                'charge' => $transactionID,
                'amount' => floatval($amount) * 100,  // For 10 $
            ]);
            
            die(json_encode(array("status"=>$this->db->where('order_id',$order_id)->update("tbl_orders",$toUpdatedata),"transactionID"=>$transactionID,"orderID"=>$order_id)));
        } catch(\Stripe\Exception\InvalidRequestException $e) {
            $this->db->where('order_id',$order_id)->update("tbl_orders",$toUpdatedata);
            die(json_encode(array("status"=>2,"error"=> $e->getError()->message.'\n')));
        }        
    }
}