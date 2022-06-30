<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Express_checkout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// Load helpers
		$this->load->helper('url');

		// Load session library
		$this->load->library('session');
		$this->load->library('email');
		$this->lang->load('content_lang',$this->session->userdata("site_lang"));
		$this->load->helper('cookie');
		$this->load->model('AdminModel','MODEL');
		// Load PayPal library config
		$this->config->load('paypal');

		$rest_id = $this->session->userdata('current_rest_id');
		$rest = $this->db->where("rest_id", $rest_id)->get("tbl_payment_settings")->row();
		$config = array(
			'Sandbox' => $this->config->item('Sandbox'),            // Sandbox / testing mode option.

			'APIUsername' => $rest->paypal_api_username ,    // PayPal API username of the API caller
			'APIPassword' => $rest->paypal_api_password,    // PayPal API password of the API caller
			'APISignature' => $rest->paypal_api_signature,    // PayPal API signature of the API caller
			// 'APIUsername' => $this->config->item('APIUsername'),    // PayPal API username of the API caller
			// 'APIPassword' => $this->config->item('APIPassword'),    // PayPal API password of the API caller
			// 'APISignature' => $this->config->item('APISignature'),    // PayPal API signature of the API caller
			// 'APISubject' => '',                                    // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersion'),        // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
			'DeviceID' => $this->config->item('DeviceID'),
			'ApplicationID' => $this->config->item('ApplicationID'),
			'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
		);

		// Show Errors
		if ($config['Sandbox']) {
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
		}

		// Load PayPal library
		$this->load->library('paypal/paypal_pro', $config);
	}

	/**
	 * Cart Review page
	 */
	function index()
	{
		// Clear PayPalResult from session userdata
		$this->session->unset_userdata('PayPalResult');

		// Clear cart from session userdata
		$this->session->unset_userdata('shopping_cart');

		// For demo purpose, we create example shopping cart data for display on sample cart review pages

		// Example Data - cart item
		$cart['items'][0] = array(
			'id' => '123-ABC',
			'name' => 'Widget',
			'qty' => '2',
			'price' => '9.99',
		);

		// Example Data - cart item
		$cart['items'][1] = array(
			'id' => 'XYZ-456',
			'name' => 'Gadget',
			'qty' => '1',
			'price' => '4.99',
		);

		// Example Data - cart variable with items included
		$cart['shopping_cart'] = array(
			'items' => $cart['items'],
			'subtotal' => 24.97,
			'shipping' => 0,
			'handling' => 0,
			'tax' => 0,
		);

		// Example Data - grand total
		$cart['shopping_cart']['grand_total'] = number_format($cart['shopping_cart']['subtotal'] + $cart['shopping_cart']['shipping'] + $cart['shopping_cart']['handling'], 2);

		// Load example cart data to variable
		$this->load->vars('cart', $cart);

		// Set example cart data into session
		$this->session->set_userdata('shopping_cart', $cart);

		// Example - Load Review Page
		
		$this->load->view('paypal/demos/express_checkout/index', $cart);
	}

	/**
	 * SetExpressCheckout
	 */
	function SetExpressCheckout()
	{
		// Clear PayPalResult from session userdata
		$this->session->unset_userdata('PayPalResult');

		// Get cart data from session userdata
		$cart = $this->session->userdata('shopping_cart');
		
		$SECFields = array(
			'maxamt' => round($cart['shopping_cart']['grand_total'] * 2,2), 					// The expected maximum total amount the order will be, including S&H and sales tax.
			'returnurl' => site_url('paypal/express_checkout/GetExpressCheckoutDetails'), 							    // Required.  URL to which the customer will be returned after returning from PayPal.  2048 char max.
			'cancelurl' => site_url('paypal/express_checkout/OrderCancelled'), 							    // Required.  URL to which the customer will be returned if they cancel payment on PayPal's site.
			// 'hdrimg' => 'https://www.angelleye.com/images/angelleye-paypal-header-750x90.jpg', 			// URL for the image displayed as the header during checkout.  Max size of 750x90.  Should be stored on an https:// server or you'll get a warning message in the browser.
			'logoimg' => base_url('assets/web_assets/images/White-Logo.png'),  					// A URL to your logo image.  Formats:  .gif, .jpg, .png.  190x60.  PayPal places your logo image at the top of the cart review area.  This logo needs to be stored on a https:// server.
			'brandname' => 'My Restopage', 							                                // A label that overrides the business name in the PayPal account on the PayPal hosted checkout pages.  127 char max.
			// 'customerservicenumber' => '816-555-5555', 				                                // Merchant Customer Service number displayed on the PayPal Review page. 16 char max.
		);

		/**
		 * Now we begin setting up our payment(s).
		 *
		 * Express Checkout includes the ability to setup parallel payments,
		 * so we have to populate our $Payments array here accordingly.
		 *
		 * For this sample (and in most use cases) we only need a single payment,
		 * but we still have to populate $Payments with a single $Payment array.
		 *
		 * Once again, the template file includes a lot more available parameters,
		 * but for this basic sample we've removed everything that we're not using,
		 * so all we have is an amount.
		 */
		$Payments = array();
		$Payment = array(
			'amt' => $cart['shopping_cart']['grand_total'], 	// Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
			'currencycode' =>"EUR",
		);

		/**
		 * Here we push our single $Payment into our $Payments array.
		 */
		array_push($Payments, $Payment);

		/**
		 * Now we gather all of the arrays above into a single array.
		 */
		$PayPalRequestData = array(
			'SECFields' => $SECFields,
			'Payments' => $Payments,
		);

		/**
		 * Here we are making the call to the SetExpressCheckout function in the library,
		 * and we're passing in our $PayPalRequestData that we just set above.
		 */
		$PayPalResult = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);

		if(!isset($PayPalResult['ACK']) &&  !$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) || $this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) == "")
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);

			// Load errors to variable
			$this->load->vars('errors', $errors);

			$this->load->view('paypal/express_checkout/paypal_error');
		}
		else
		{
			// Successful call.

			// Set PayPalResult into session userdata (so we can grab data from it later on a 'payment complete' page)
			$this->session->set_userdata('PayPalResult', $PayPalResult);
			
			// In most cases you would automatically redirect to the returned 'RedirectURL' by using: redirect($PayPalResult['REDIRECTURL'],'Location');
			// Move to PayPal checkout
			redirect($PayPalResult['REDIRECTURL'], 'Location');
		}
	}

	/**
	 * GetExpressCheckoutDetails
	 */
	function GetExpressCheckoutDetails()
	{

		// Get cart data from session userdata
		$cart = $this->session->userdata('shopping_cart');

		// Get PayPal data from session userdata
		$SetExpressCheckoutPayPalResult = $this->session->userdata('PayPalResult');
		$PayPal_Token = $SetExpressCheckoutPayPalResult['TOKEN'];

		/**
		 * Now we pass the PayPal token that we saved to a session variable
		 * in the SetExpressCheckout.php file into the GetExpressCheckoutDetails
		 * request.
		 */
		$PayPalResult = $this->paypal_pro->GetExpressCheckoutDetails($PayPal_Token);

	
		if(!isset($PayPalResult['ACK']) &&  !$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) || $this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) == "")
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);

			// Load errors to variable
			$this->load->vars('errors', $errors);

			$this->load->view('paypal/express_checkout/paypal_error');
		}
		else
		{
			// Successful call.

			/**
			 * Here we'll pull out data from the PayPal response.
			 * Refer to the PayPal API Reference for all of the variables available
			 * in $PayPalResult['variablename']
			 *
			 * https://developer.paypal.com/docs/classic/api/merchant/GetExpressCheckoutDetails_API_Operation_NVP/
			 *
			 * Again, Express Checkout allows for parallel payments, so what we're doing here
			 * is usually the library to parse out the individual payments using the GetPayments()
			 * method so that we can easily access the data.
			 *
			 * We only have a single payment here, which will be the case with most checkouts,
			 * but we will still loop through the $Payments array returned by the library
			 * to grab our data accordingly.
			 */
			$cart['paypal_payer_id'] = isset($PayPalResult['PAYERID']) ? $PayPalResult['PAYERID'] : '';
			$cart['phone_number'] = isset($PayPalResult['PHONENUM']) ? $PayPalResult['PHONENUM'] : '';
			$cart['email'] = isset($PayPalResult['EMAIL']) ? $PayPalResult['EMAIL'] : '';
			$cart['first_name'] = isset($PayPalResult['FIRSTNAME']) ? $PayPalResult['FIRSTNAME'] : '';
			$cart['last_name'] = isset($PayPalResult['LASTNAME']) ? $PayPalResult['LASTNAME'] : '';

			foreach($PayPalResult['PAYMENTS'] as $payment) {
				$cart['shipping_name'] = isset($payment['SHIPTONAME']) ? $payment['SHIPTONAME'] : '';
				$cart['shipping_street'] = isset($payment['SHIPTOSTREET']) ? $payment['SHIPTOSTREET'] : '';
				$cart['shipping_city'] = isset($payment['SHIPTOCITY']) ? $payment['SHIPTOCITY'] : '';
				$cart['shipping_state'] = isset($payment['SHIPTOSTATE']) ? $payment['SHIPTOSTATE'] : '';
				$cart['shipping_zip'] = isset($payment['SHIPTOZIP']) ? $payment['SHIPTOZIP'] : '';
				$cart['shipping_country_code'] = isset($payment['SHIPTOCOUNTRYCODE']) ? $payment['SHIPTOCOUNTRYCODE'] : '';
				$cart['shipping_country_name'] = isset($payment['SHIPTOCOUNTRYNAME']) ? $payment['SHIPTOCOUNTRYNAME'] : '';
			}
			

			// $cart['shopping_cart']['shipping'] = 0;
			$cart['shopping_cart']['handling'] = 0;

			$cart['shopping_cart']['grand_total'] = number_format($cart['shopping_cart']['subtotal']
				+ $cart['shopping_cart']['shipping']
				+ $cart['shopping_cart']['handling'],2)
				- $cart['discount'];
			$cart['shopping_cart']['grand_total'] = $cart['shopping_cart']['grand_total'] < 0 ? 0 : $cart['shopping_cart']['grand_total'];
				
			$this->session->set_userdata('shopping_cart', $cart);

			// Load example cart data to variable
			$this->load->vars('cart', $cart);

			// Example - Load Review Page
			
			$rest_id = $this->session->userdata('current_rest_id');
			
			$menu_mode = $this->session->userdata('menu_mode');
			$iframe = $this->session->userdata('iframe');
			$rest_url_slug = $this->db->where('rest_id',$rest_id)->get('tbl_restaurant')->row()->rest_url_slug;
			
			$session_lang = $this->session->userdata("site_lang");
			if ($session_lang == ""){
				$session_lang = "french";
			}
			$cart['site_lang']=$session_lang;
			$cart['myRestId']=$rest_id;
			$cart['rest_url_slug']=$rest_url_slug;
			$cart['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$cart['iframe']=$iframe;
			$cart['menu_mode']=$menu_mode;

			// ====================================================================================================
			$lang_title_field = "item_name_" . $session_lang;

			$carts_array = array();
			$carts_item_id_array = array();
			$carts_item_price_array = array();
			$carts_item_qty_array = array();
			$carts_item_extra_array = array();
			if (null !== $this->input->cookie('jfrost_carts')){
				$carts_array = explode(",", $this->input->cookie("jfrost_carts"));

				foreach ($carts_array as $key => $value) {
					$cart_each_item_info = explode(":", $value);
					$cart_each_item_id = $cart_each_item_info[0];
					$cart_each_item_price_index = $cart_each_item_info[1];
					$cart_each_item_price_qty = $cart_each_item_info[2];
					$cart_each_item_extra_id = $cart_each_item_info[3];

					$carts_item_id_array[] = $cart_each_item_id;
					$carts_item_price_array[] = $cart_each_item_price_index;
					$carts_item_qty_array[] = $cart_each_item_price_qty;
					$carts_item_extra_array[] = explode("|",$cart_each_item_extra_id);
				}
			}
			$carts = $carts_array;
			$carts_str = implode(",",$carts_item_id_array);
			$cart_item_details = array();
			$cart_price = array();
			$cart_qty = array();
			foreach ($carts_item_id_array as $c_key_item => $c_value_item) {
				if ($cart_item_detail = $this->db->query("select * from tbl_menu_card as mc join tbl_category as c on mc.category_id = c.category_id where rest_id = $rest_id and c.category_status = 'active' and  item_status <> 'Not Available' and menu_id = $c_value_item")->row()){
					$cart_item_details[] = $cart_item_detail;
					$cart_price[] = $carts_item_price_array[$c_key_item];
					$cart_qty[] = $carts_item_qty_array[$c_key_item];
				}
			}
			$cart['carts_item_extra_array']	= $carts_item_extra_array;
			$cart['carts']	= $carts;
			$cart['cart_item_details']	= $cart_item_details;
			$cart['cart_price']	= $cart_price;
			$cart['cart_qty']	= $cart_qty;
			
			$min_order = 0;
			$delivery_cost = 0;
			if ($dparea = $this->db->query("select * from tbl_delivery_areas where rest_id = $rest_id AND status = 'active'")->row()){
				$min_order = $dparea->min_order_amount;
				$delivery_cost = $dparea->delivery_charge;
			}
			$cart['min_order']	= $min_order;
			$cart['delivery_cost']	= $delivery_cost;
			// ====================================================================================================
			if (null !== $this->session->userdata('order_id')){
				$order_id =  $this->session->userdata('order_id');
				$register_user_id =  $this->session->userdata('register_user_id');
				$toUpdatedata = array(
					"order_payout_status" => "paid",
				);
				$order = $this->db->where("order_id",$order_id)->update("tbl_orders",$toUpdatedata);
				if ($order_id > 0){
					// modify by Jfrost ,must be commented in localhost
					$order = $this->db->where("order_id",$order_id)->get("tbl_orders")->row();
					$dp_option = $order->order_type;

					$this->send_order_email_to_user($register_user_id,$order_id);
					$this->send_order_email_to_restaurant($register_user_id,$order_id);

					$this->sendNewOrderReservationNotification($dp_option,$order_id);
				}
			}
			$this->DoExpressCheckoutPayment();

			$this->load->view('paypal/express_checkout/review', $cart);
		}
	}

	/**
	 * DoExpressCheckoutPayment
	 */
	function DoExpressCheckoutPayment()
	{
		/**
		 * Now we'll setup the request params for the final call in the Express Checkout flow.
		 * This is very similar to SetExpressCheckout except that now we can include values
		 * for the shipping, handling, and tax amounts, as well as the buyer's name and
		 * shipping address that we obtained in the GetExpressCheckoutDetails step.
		 *
		 * If this information is not included in this final call, it will not be
		 * available in PayPal's transaction details data.
		 *
		 * Once again, the template for DoExpressCheckoutPayment provides
		 * many more params that are available, but we've stripped everything
		 * we are not using in this basic demo out.
		 */

		// Get cart data from session userdata
		$cart = $this->session->userdata('shopping_cart');

		// Get cart data from session userdata
		$SetExpressCheckoutPayPalResult = $this->session->userdata('PayPalResult');
		$PayPal_Token = $SetExpressCheckoutPayPalResult['TOKEN'];

		$DECPFields = array(
			'token' => $PayPal_Token, 								// Required.  A timestamped token, the value of which was returned by a previous SetExpressCheckout call.
			'payerid' => $cart['paypal_payer_id'], 							// Required.  Unique PayPal customer id of the payer.  Returned by GetExpressCheckoutDetails, or if you used SKIPDETAILS it's returned in the URL back to your RETURNURL.
		);

		$Payments = array();
		$Payment = array(
			'amt' => number_format($cart['shopping_cart']['grand_total'],2), 	    // Required.  The total cost of the transaction to the customer.  If shipping cost and tax charges are known, include them in this value.  If not, this value should be the current sub-total of the order.
			'itemamt' => number_format($cart['shopping_cart']['subtotal'],2),       // Subtotal of items only.
			'currencycode' => 'EUR', 					                            // A three-character currency code.  Default is USD.
			'shippingamt' => number_format($cart['shopping_cart']['shipping'],2), 	// Total shipping costs for this order.  If you specify SHIPPINGAMT you mut also specify a value for ITEMAMT.
			'handlingamt' => number_format($cart['shopping_cart']['handling'],2), 	// Total handling costs for this order.  If you specify HANDLINGAMT you mut also specify a value for ITEMAMT.
			// 'taxamt' => number_format($cart['shopping_cart']['tax'],2), 			// Required if you specify itemized L_TAXAMT fields.  Sum of all tax items in this order.
			'shiptoname' => $cart['shipping_name'], 					            // Required if shipping is included.  Person's name associated with this address.  32 char max.
			'shiptostreet' => $cart['shipping_street'], 					        // Required if shipping is included.  First street address.  100 char max.
			'shiptocity' => $cart['shipping_city'], 					            // Required if shipping is included.  Name of city.  40 char max.
			'shiptostate' => $cart['shipping_state'], 					            // Required if shipping is included.  Name of state or province.  40 char max.
			'shiptozip' => $cart['shipping_zip'], 						            // Required if shipping is included.  Postal code of shipping address.  20 char max.
			'shiptocountrycode' => $cart['shipping_country_code'], 				    // Required if shipping is included.  Country code of shipping address.  2 char max.
			'shiptophonenum' => $cart['phone_number'],  				            // Phone number for shipping address.  20 char max.
			'paymentaction' => 'Sale', 					                                // How you want to obtain the payment.  When implementing parallel payments, this field is required and must be set to Order.
		);

		/**
		 * Here we push our single $Payment into our $Payments array.
		 */
		array_push($Payments, $Payment);

		/**
		 * Now we gather all of the arrays above into a single array.
		 */
		$PayPalRequestData = array(
			'DECPFields' => $DECPFields,
			'Payments' => $Payments,
		);

		/**
		 * Here we are making the call to the DoExpressCheckoutPayment function in the library,
		 * and we're passing in our $PayPalRequestData that we just set above.
		 */
		$PayPalResult = $this->paypal_pro->DoExpressCheckoutPayment($PayPalRequestData);

		/**
		 * Now we'll check for any errors returned by PayPal, and if we get an error,
		 * we'll save the error details to a session and redirect the user to an
		 * error page to display it accordingly.
		 *
		 * If the call is successful, we'll save some data we might want to use
		 * later into session variables, and then redirect to our final
		 * thank you / receipt page.
		 */
		if(!isset($PayPalResult['ACK']) &&  !$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) || $this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) == "")
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);

			// Load errors to variable
			$this->load->vars('errors', $errors);

			$this->load->view('paypal/express_checkout/paypal_error');
		}
		else
		{
			// Successful call.
			/**
			 * Once again, since Express Checkout allows for multiple payments in a single transaction,
			 * the DoExpressCheckoutPayment response is setup to provide data for each potential payment.
			 * As such, we need to loop through all the payment info in the response.
			 *
			 * The library helps us do this using the GetExpressCheckoutPaymentInfo() method.  We'll
			 * load our $payments_info using that method, and then loop through the results to pull
			 * out our details for the transaction.
			 *
			 * Again, in this case we are you only working with a single payment, but we'll still
			 * loop through the results accordingly.
			 *
			 * Here, we're only pulling out the PayPal transaction ID and fee amount, but you may
			 * refer to the API reference for all the additional parameters you have available at
			 * this point.
			 *
			 * https://developer.paypal.com/docs/classic/api/merchant/DoExpressCheckoutPayment_API_Operation_NVP/
			 */
			foreach($PayPalResult['PAYMENTS'] as $payment)
			{
				$cart['paypal_transaction_id'] = isset($payment['TRANSACTIONID']) ? $payment['TRANSACTIONID'] : '';
				$cart['paypal_fee'] = isset($payment['FEEAMT']) ? $payment['FEEAMT'] : '';
			}

			// Set example cart data into session
			$this->session->set_userdata('shopping_cart', $cart);

			$cart = $this->session->userdata('shopping_cart');
			if (null !== $this->session->userdata('order_id')){
				$order_id =  $this->session->userdata('order_id');
				$this->db->where('order_id',$order_id)->update('tbl_orders',array('order_transaction'=>$cart['paypal_transaction_id'] ));
			}
			if(empty($cart)) redirect('paypal/express_checkout');


			// Successful Order
			// redirect('paypal/express_checkout/OrderComplete');
		}
	}
	/**
	 * Refund_transaction
	 */
	function Refund_transaction()
	{
		$order_id = $_POST['order_id'];
		$order = $this->db->where('order_id',$order_id)->where('order_payment_method','paypal')->get('tbl_orders')->row();
		$transactionID = $order->order_transaction;
		$RTFields = array(
					'transactionid' => $transactionID, 							// Required.  PayPal transaction ID for the order you're refunding.
					'payerid' => '', 									// Encrypted PayPal customer account ID number.  Note:  Either transaction ID or payer ID must be specified.  127 char max
					'refundtype' => 'Full', 							// Required.  Type of refund.  Must be Full, Partial, or Other.
					'refundsource' => 'any', 							// Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
				);	
					
		$PayPalRequestData = array('RTFields' => $RTFields);
		
		$PayPalResult = $this->paypal_pro->RefundTransaction($PayPalRequestData);
		
		if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK']))
		{
			$errors = array('Errors'=>$PayPalResult['ERRORS']);
			$this->load->view('paypal/samples/error',$errors);
		}
		else
		{
			$toUpdatedata = array(
				"order_status" => "canceled",
			);
			$order = $this->db->where("order_id",$order_id)->update("tbl_orders",$toUpdatedata);
			die(json_encode(array("status"=>1,"transactionID"=>$transactionID,"orderID"=>$order_id)));
		}
	}
	/**
	 * Order Complete - Pay Return Url
	 */
	function OrderComplete()
	{
		// Get cart from session userdata
		$cart = $this->session->userdata('shopping_cart');

		$order_id = $this->session->userdata('order_id');
		$register_user_id = $this->session->userdata('register_user_id');
		
        $this->db->where('order_id',$order_id)->update('tbl_orders',array('order_transaction'=>$cart['paypal_transaction_id'] ));

		if(empty($cart)) redirect('paypal/express_checkout');

		// Set cart data into session userdata
		$this->load->vars('cart', $cart);
		
		// Successful call.  Load view or whatever you need to do here.
		$this->load->view('paypal/express_checkout/payment_complete');
	}

	/**
	 * Order Cancelled - Pay Cancel Url
	 */
	function OrderCancelled()
	{
		// Clear PayPalResult from session userdata
		$this->session->unset_userdata('PayPalResult');

		// Clear cart from session userdata
		$this->session->unset_userdata('shopping_cart');

		// Successful call.  Load view or whatever you need to do here.
		$this->load->view('paypal/express_checkout/order_cancelled');
	}
	public function send_order_email_to_user($register_user_id,$order_id){
		$order = $this->db->where("order_id",$order_id)->get("tbl_orders")->row();
		$customer = $this->db->where("customer_id",$register_user_id)->get("tbl_customers")->row();
		$email = $customer->customer_email;

		$cart = $this->session->userdata('shopping_cart');
		$stripe = $this->session->userdata('shopping_cart_stripe');

		$tres = '';
		$rest = $this->db->where("restaurant_id",$cart['shopping_cart']['rest_id'])->get('tbl_restaurant_details')->row();
		$rest_currency_symbol = $order->order_currency;

		if (null !== $this->input->cookie('jfrost_carts')){
			$carts_array = explode(",", $this->input->cookie("jfrost_carts"));

			foreach ($carts_array as $key => $value) {
				$cart_each_item_info = explode(":", $value);
				$cart_each_item_id = $cart_each_item_info[0];
				$cart_each_item_price_index = $cart_each_item_info[1];
				$cart_each_item_price_qty = $cart_each_item_info[2];
				$cart_each_item_extra_id = $cart_each_item_info[3];

				$carts_item_id_array[] = $cart_each_item_id;
				$carts_item_price_array[] = $cart_each_item_price_index;
				$carts_item_qty_array[] = $cart_each_item_price_qty;
				$carts_item_extra_array[] = explode("|",$cart_each_item_extra_id);
			}
		}
		$item_extra_arr = array();
		foreach($cart['shopping_cart']['items'] as $item_key => $cart_item) {
			$item_extra_arr = explode(",",$cart_item['extra']);
			$item_extra_str = "";
			$ex_p = 0;
			foreach ($item_extra_arr as $ekey => $evalue) {
				if ($evalue !== ""){
					$extra_id = explode(":",$evalue)[0];
					$extra_price = explode(":",$evalue)[1];
					if (in_array($extra_id,$carts_item_extra_array[$item_key])){
						$extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
						$extra_name = $extra_food ->food_extra_name;
						$item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name . "</span> : $rest_currency_symbol " . $extra_price  . "<br>";
						$ex_p += floatval($extra_price); 
					}
				}
			}
			$tres .= '<tr>
				<td style="border: 1px solid #ddd;">'.$cart_item['id'] .'</td>
				<td style="border: 1px solid #ddd;">'. $cart_item['name'] .' : '.$rest_currency_symbol.' '. number_format(($cart_item['price'] - $ex_p),2) .'</td>
				<td style="border: 1px solid #ddd;">'. $item_extra_str .'</td>
				<td class="center" style="border: 1px solid #ddd;"> '.$rest_currency_symbol.' '. number_format($cart_item['price'],2) .'</td>
				<td class="center" style="border: 1px solid #ddd;">'. $cart_item['qty'] .'</td>
				<td class="center" style="border: 1px solid #ddd;"> '.$rest_currency_symbol.' '. round($cart_item['qty'] * $cart_item['price'],2) .'</td>
			</tr>';
		}
		$tax_cost = 0;
		$tax_str = "";
		foreach ($cart['shopping_cart']['tax'] as $tax_id => $tax_food_value) { 
			if ($tax_id > 0 && $cart['shopping_cart']['rest_id']){
				$tax = $this->db->where("rest_id",$cart['shopping_cart']['rest_id'])->where("id",$tax_id)->get('tbl_tax_settings')->row();
				$tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100;
				$tax_str = "
				<tr>
					<td><strong> Tax ( ".$tax->tax_percentage."% )</strong></td>
					<td> $rest_currency_symbol ". number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ."</td>
				</tr>";
			}else{
			}
		}
		$delivery_tax_str = "
			<tr>
				<td><strong>Delivery Tax ( ".$rest->delivery_tax."% )</strong></td>
				<td> $rest_currency_symbol ".number_format($cart['shopping_cart']['shipping'] * $rest->delivery_tax /100 ,2,".",",")." </td>
			</tr>";
		$shipping_str = "";
		if 	($cart['_order_type'] == "Delivery"){
			$shipping_str = $tax_str
			.'
				<tr>
					<td><strong>Delivery ( incl Tax )</strong></td>
					<td> '.$rest_currency_symbol.' '. number_format($cart['shopping_cart']['shipping'],2) .'</td>
				</tr>
			'.$delivery_tax_str;
		}
		$message =  '<!DOCTYPE html>
			<html lang="en">
				<head>
						<meta charset="utf-8" />
						<title>My Restopage</title>
						<meta name="viewport" content="width=device-width, initial-scale=1.0">
						<meta http-equiv="X-UA-Compatible" content="IE=edge" />
						<!-- App favicon -->
						<link rel="shortcut icon" href="assets/images/favicon.ico">
				</head>
		
				<body style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;"
					bgcolor="#f6f6f6">
		
				<table class="body-wrap"
					style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"
					bgcolor="#f6f6f6">
					<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
						<td class="container" width="100%"
								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 100% !important; clear: both !important; margin: 0 auto;"
								valign="top" colspan="2">
								<div class="content" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 100%; display: block; margin: 0 auto; padding: 20px;text-align: center;">
										<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
													style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
													>
												
												<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
														<td class="content-wrap"
																style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
																valign="top">
																<meta itemprop="name" content="Confirm Email"
																			style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
																<table width="100%" cellpadding="0" cellspacing="0"
																			style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																		<tr>
																				<td style="text-align: center">
																						<a href="#" style="display: block;margin-bottom: 10px;"> <img src="'. base_url("assets/web_assets/images/restrologo.png").'" height="20" alt="logo"/></a> <br/>
																				</td>
																		</tr>
																		
																		<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																			<td class="content-block"
																					style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;margin-top: 30px;"
																					valign="top">
																					Thanks for your order on my.restopage.eu
																			</td>
																		</tr>
																</table>
																<h4> Menu-'.$order_id.'</h4>
																<table class="table table-bordered" style="width:100% ; border: 1px solid #ddd;">
																	<thead>
																		<tr>
																			<th>ID</th>
																			<th>Name</th>
																			<th class="center">Extra</th>
																			<th class="center">Price</th>
																			<th class="center">QTY</th>
																			<th class="center">Total</th>
																		</tr>
																	</thead>
																	<tbody>
																	'. $tres .'
																	</tbody>
																</table>
																<div class="row clearfix">
																	<div class="col-md-4 column" style="width: 45%;float: left;">
																		<p><strong>Shipping Information</strong></p>
																		<p>
																			'.
																				$cart['_name'] . '<br />' .
																				$cart['_address'] . '<br />' .
																				$cart['_floor'] . ', ' . $cart['_city'] . '  ' . $cart['_postcode'] . '<br />' .
																				$cart['_email']  . '<br />' .
																				$cart['_phone_number']  . '<br />' .
																				$cart['_company_name']
																			.'
																		</p>
																	</div>
																	<div class="col-md-4 column" style="width: 45%;float: right;padding-top: 13px;">
																		<table class="table" style="width: 100%">
																			<tbody>
																			<tr>
																				<td><strong>Subtotal ( incl Tax )</strong></td>
																				<td> '.$rest_currency_symbol.' '. number_format($cart['shopping_cart']['subtotal'],2) .'</td>
																			</tr>
																			'.$shipping_str.'
																			<tr>
																				<td><strong>Discount</strong></td>
																				<td> '.$rest_currency_symbol.' '. number_format($cart['discount'],2) .'</td>
																			</tr>
																			<tr>
																				<td><strong>Grand Total ( incl Tax )</strong></td>
																				<td> '.$rest_currency_symbol.' '. number_format($cart['shopping_cart']['grand_total'],2) .'</td>
																			</tr>
																			<tr>
																				<td><strong>Order Type</strong></td>
																				<td class="text-capitalize">'. $cart['_order_type'].'</td>
																			</tr>
																			<tr>
																				<td><strong>Payment Method</strong></td>
																				<td class="text-capitalize">'. $cart['_payment_method'].'</td>
																			</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
																
														</td>
												</tr>
										</table>
								</div>
						</td>
					</tr>
				</table>
			</body>
		</html>';

		$this->email->set_mailtype("html");
		$this->email->from('info@restopage.eu','My Restopage');
		$this->email->to($email);
		$this->email->subject("New Order");
		$this->email->message($message);
		return  $this->email->send();
	
	}
	public function send_order_email_to_restaurant($register_user_id,$order_id){
		$order = $this->db->where("order_id",$order_id)->get("tbl_orders")->row();
		$customer = $this->db->where("customer_id",$register_user_id)->get("tbl_customers")->row();
		$email = $customer->customer_email;
		$rest_id = $this->session->userdata('current_rest_id');
		$rest_email = $this->db->where("rest_id",$rest_id)->get("tbl_restaurant")->row()->rest_email;
		// $rest_email = "glensshepherd@yandex.com";
		$cart = $this->session->userdata('shopping_cart');
		$stripe = $this->session->userdata('shopping_cart_stripe');

		$tres = '';
		$rest = $this->db->where("restaurant_id",$cart['shopping_cart']['rest_id'])->get('tbl_restaurant_details')->row();
		$rest_currency_symbol = $order->order_currency;
		if (null !== $this->input->cookie('jfrost_carts')){
			$carts_array = explode(",", $this->input->cookie("jfrost_carts"));

			foreach ($carts_array as $key => $value) {
				$cart_each_item_info = explode(":", $value);
				$cart_each_item_id = $cart_each_item_info[0];
				$cart_each_item_price_index = $cart_each_item_info[1];
				$cart_each_item_price_qty = $cart_each_item_info[2];
				$cart_each_item_extra_id = $cart_each_item_info[3];

				$carts_item_id_array[] = $cart_each_item_id;
				$carts_item_price_array[] = $cart_each_item_price_index;
				$carts_item_qty_array[] = $cart_each_item_price_qty;
				$carts_item_extra_array[] = explode("|",$cart_each_item_extra_id);
			}
		}
		$item_extra_arr = array();
		foreach($cart['shopping_cart']['items'] as $item_key => $cart_item) {
			$item_extra_arr = explode(",",$cart_item['extra']);
			$item_extra_str = "";
			$ex_p = 0;
			foreach ($item_extra_arr as $ekey => $evalue) {
				if ($evalue !== ""){
					$extra_id = explode(":",$evalue)[0];
					$extra_price = explode(":",$evalue)[1];
					if (in_array($extra_id,$carts_item_extra_array[$item_key])){
						$extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
						$extra_name = $extra_food ->food_extra_name;
						$item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name . "</span> : $rest_currency_symbol " . $extra_price  . "<br>";
						$ex_p += floatval($extra_price); 
					}
				}
			}
			$tres .= '<tr>
				<td style="border: 1px solid #ddd;">'.$cart_item['id'] .'</td>
				<td style="border: 1px solid #ddd;">'. $cart_item['name'] .' : '.$rest_currency_symbol.' '. number_format(($cart_item['price'] - $ex_p),2) .'</td>
				<td style="border: 1px solid #ddd;">'. $item_extra_str .'</td>
				<td class="center" style="border: 1px solid #ddd;"> '.$rest_currency_symbol.' '. number_format($cart_item['price'],2) .'</td>
				<td class="center" style="border: 1px solid #ddd;">'. $cart_item['qty'] .'</td>
				<td class="center" style="border: 1px solid #ddd;"> '.$rest_currency_symbol.' '. round($cart_item['qty'] * $cart_item['price'],2) .'</td>
			</tr>';
		}
		$tax_cost = 0;
		$tax_str = "";
		foreach ($cart['shopping_cart']['tax'] as $tax_id => $tax_food_value) { 
			if ($tax_id > 0 && $cart['shopping_cart']['rest_id']){
				$tax = $this->db->where("rest_id",$cart['shopping_cart']['rest_id'])->where("id",$tax_id)->get('tbl_tax_settings')->row();
				$tax_cost += floatval($tax->tax_percentage) * floatval($tax_food_value) / 100;
				$tax_str = "
				<tr>
					<td><strong> Tax ( ".$tax->tax_percentage."% )</strong></td>
					<td> $rest_currency_symbol ". number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ."</td>
				</tr>";
			}else{
			}
		}

		$delivery_tax_str = "
			<tr>
				<td><strong>Delivery Tax ( ".$rest->delivery_tax."% )</strong></td>
				<td> $rest_currency_symbol ".number_format($cart['shopping_cart']['shipping'] * $rest->delivery_tax /100 ,2,".",",")." </td>
			</tr>";
		$shipping_str = "";
		if 	($cart['_order_type'] == "Delivery"){
			$shipping_str = $tax_str
			.'
				<tr>
					<td><strong>Delivery ( incl Tax )</strong></td>
					<td> '.$rest_currency_symbol.' '. number_format($cart['shopping_cart']['shipping'],2) .'</td>
				</tr>
			'.$delivery_tax_str;
		}

		$message =  '<!DOCTYPE html>
			<html lang="en">
				<head>
						<meta charset="utf-8" />
						<title>My Restopage</title>
						<meta name="viewport" content="width=device-width, initial-scale=1.0">
						<meta http-equiv="X-UA-Compatible" content="IE=edge" />
						<!-- App favicon -->
						<link rel="shortcut icon" href="assets/images/favicon.ico">
				</head>
		
				<body style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;"
					bgcolor="#f6f6f6">
		
				<table class="body-wrap"
					style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;"
					bgcolor="#f6f6f6">
					<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
						<td class="container" width="100%"
								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 100% !important; clear: both !important; margin: 0 auto;"
								valign="top" colspan="2">
								<div class="content" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 100%; display: block; margin: 0 auto; padding: 20px;text-align: center;">
										<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
													style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
													>
												
												<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
														<td class="content-wrap"
																style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
																valign="top">
																<meta itemprop="name" content="Confirm Email"
																			style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
																<table width="100%" cellpadding="0" cellspacing="0"
																			style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																		<tr>
																				<td style="text-align: center">
																						<a href="#" style="display: block;margin-bottom: 10px;"> <img src="'. base_url("assets/web_assets/images/restrologo.png").'" height="20" alt="logo"/></a> <br/>
																				</td>
																		</tr>
																		
																		<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																			<td class="content-block"
																					style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;margin-top: 30px;"
																					valign="top">
																					There is a new order from '.$customer->customer_name.'. <br> Customer ID: ('.$customer->customer_id.').
																			</td>
																		</tr>
																</table>
																<h4> Menu-'.$order_id.'</h4>
																<table class="table table-bordered" style="width:100% ; border: 1px solid #ddd;">
																	<thead>
																		<tr style="border:1px solid lightgray;background:#ccc;">
																			<th>ID</th>
																			<th>Name</th>
																			<th class="center">Extra</th>
																			<th class="center">Price</th>
																			<th class="center">QTY</th>
																			<th class="center">Total</th>
																		</tr>
																	</thead>
																	<tbody>
																	'. $tres .'
																	</tbody>
																</table>
																<div class="row clearfix">
																	<div class="col-md-4 column" style="width: 45%;float: left;">
																		<p><strong>Shipping Information</strong></p>
																		<p>
																			'.
																				$cart['_name'] . '<br />' .
																				$cart['_address'] . '<br />' .
																				$cart['_floor'] . ', ' . $cart['_city'] . '  ' . $cart['_postcode'] . '<br />' .
																				$cart['_email']  . '<br />' .
																				$cart['_phone_number']  . '<br />' .
																				$cart['_company_name']
																			.'
																		</p>
																	</div>
																	<div class="col-md-4 column" style="width: 45%;float: right;padding-top: 13px;">
																		<table class="table" style="width: 100%">
																			<tbody>
																			<tr>
																				<td><strong>Subtotal ( incl Tax )</strong></td>
																				<td> '.$rest_currency_symbol.' '. number_format($cart['shopping_cart']['subtotal'],2) .'</td>
																			</tr>
																			'.$shipping_str.'
																			<tr>
																				<td><strong>Discount</strong></td>
																				<td> '.$rest_currency_symbol.' '. number_format($cart['discount'],2) .'</td>
																			</tr>
																			<tr>
																				<td><strong>Grand Total ( incl Tax )</strong></td>
																				<td> '.$rest_currency_symbol.' '. number_format($cart['shopping_cart']['grand_total'],2) .'</td>
																			</tr>
																			<tr>
																				<td><strong>Order Type</strong></td>
																				<td class="text-capitalize">'. $cart['_order_type'].'</td>
																			</tr>
																			<tr>
																				<td><strong>Payment Method</strong></td>
																				<td class="text-capitalize">'. $cart['_payment_method'].'</td>
																			</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
																
														</td>
												</tr>
										</table>
								</div>
						</td>
					</tr>
				</table>
			</body>
		</html>';

		$this->email->set_mailtype("html");
		$this->email->from('info@restopage.eu','My Restopage');
		$this->email->to($rest_email);
		$this->email->subject("New Order");
		$this->email->message($message);
		return  $this->email->send();
	
	}
	public function sendNewOrderReservationNotification($dp_option,$order_id){
		$notification = array();
		$arrNotification= array();			
		$arrData = array();											
		if (strtolower($dp_option) == "reservation"){
			$reservation = $this->db->where("id",$order_id)->get("tbl_reservations")->row();
			$arrNotification["body"] = "There is a new reservation at ".$reservation->created_at. " from ".$reservation->first_name . " " .$reservation->last_name; 
			$rest_id = $reservation->rest_id;
		}else{
			$order = $this->db->where("order_id",$order_id)->join("tbl_customers","tbl_customers.customer_id = tbl_orders.order_customer_id")->get("tbl_orders")->row();
			$rest_id = $order->order_rest_id;
			$arrNotification["body"] = "There is new ".strtolower($dp_option) . " order at ".$order->order_date . " from ". $order->customer_name;
		}
		$arrNotification["title"] = "New ".strtoupper($dp_option);
		$arrNotification["sound"] = "default";
		$arrNotification["type"] = 1;

		$this->sendFCMNotification(
			$rest_id
			,$arrNotification
		);
	}
	private function sendFCMNotification($rest_id, $notification,$device_type ="Android"){
		$SERVER_API_KEY = 'AAAAHYKzACo:APA91bGYbUV9uoItqSwjP2DWdOFIwo4oMlSFSRT7UxLSwgbajxk1wOw5D1WuuxD2H3Lu5sQUJamHGCo0axS0IUVCygsi2mHIlL9bq4eKOzSuRBpm3g0FLmxHOp2-8kTj0N3-Mepoubqe';
  
		// payload data, it will vary according to requirement
		if ($myRest = $this->db->where("restaurant_id",$rest_id)->get("tbl_restaurant_details")->row()){
			$device_tokens = array();
			if ($myRest->device_tokens !== ""){
				$device_tokens = explode(",",$myRest->device_tokens);
			}
			foreach ($device_tokens as $value) {
				$registatoin_id = $value;
				// $registatoin_ids = "cpPdFBYvQ0qsV77i2adbDQ:APA91bEswZSdPFA2DhRCzV6XgBq2YoV-pevyi09JLLRAgZrEhxMaxH3imyEUpCIbleobYJIUC3S7HAerJN4WUKJKJhWPHqtAgMESnfeFBozWtXzZWajQlIYFna93PMQGnJWo8GQKMG8C";
				
				if($device_type == "Android"){
					$fields = array(
						'to' => $registatoin_id,
						'notification' => $notification,
						'priority'=>'high'
					);
				}else{
					$fields = array(
						'to' => $registatoin_id,
						'data' => $notification
					);
				}
				$dataString = json_encode($fields);

				$headers = [
					'Authorization:key=' . $SERVER_API_KEY,
					'Content-Type:application/json',
				];
				ob_start();
				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
				// curl_setopt($ch, CURLOPT_POST, true);
				// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
				
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
				curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);

				$result = curl_exec($ch);
				
				if ($result === FALSE) {
					die('Curl failed: ' . curl_error($ch));
				}
				curl_close($ch);
				$res = ob_end_clean();
			}
		}
	}
}