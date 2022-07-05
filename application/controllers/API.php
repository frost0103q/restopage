<?php
	class API extends CI_Controller
	{
		function __construct(){
			parent::__construct();
			$this->load->model('AdminModel','MODEL');
			$this->load->helper('cookie');
			$this->load->library('email');
			$this->lang->load('content_lang',$this->session->userdata("site_lang"));
			$this->config->load('paypal');
			// Load PayPal library
			$admin_rest_id = 1;
			$admin_rest = $this->db->where("rest_id", $admin_rest_id)->get("tbl_payment_settings")->row();
			$config_recurring = array(
				'SandboxFlag' => $this->config->item('Sandbox'),            // Sandbox / testing mode option.
	
				'API_UserName' => $admin_rest->paypal_api_username ,    // PayPal API username of the API caller
				'API_Password' => $admin_rest->paypal_api_password,    // PayPal API password of the API caller
				'API_Signature' => $admin_rest->paypal_api_signature,    // PayPal API signature of the API caller
				// 'APIUsername' => $this->config->item('APIUsername'),    // PayPal API username of the API caller
				// 'APIPassword' => $this->config->item('APIPassword'),    // PayPal API password of the API caller
				// 'APISignature' => $this->config->item('APISignature'),    // PayPal API signature of the API caller
				// 'APISubject' => '',                                    // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
				'APIVersion' => $this->config->item('APIVersion'),        // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
				'DeviceID' => $this->config->item('DeviceID'),
				'ApplicationID' => $this->config->item('ApplicationID'),
				'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount'),
				'Currency' => "EUR"
			);
			// Show Errors
			if ($config_recurring['SandboxFlag']) {
				error_reporting(E_ALL);
				ini_set('display_errors', '1');
			}

			// Load PayPal library
			$this->load->library('recurringpayment', $config_recurring);
			$this->load->library('paypal/paypal_pro', $config_recurring);
		}
		public function activateRestaurant(){
			if($this->MODEL->activateThisRest($this->input->post('restaurant_id'))){
				die(json_encode(array("status"=>1)));
			}else{
				die(json_encode(array("status"=>0)));
			}	
		}
		public function deactivateRestaurant(){
			if($this->MODEL->deactivateThisRest($this->input->post('restaurant_id'))){
				die(json_encode(array("status"=>1)));
			}else{
				die(json_encode(array("status"=>0)));
			}	
		}
		public function addNewRestaurant(){
			$response=$this->MODEL->addNewRestaurant($_POST);
			die(json_encode(array("status"=>$response)));
		} 
		public function forgotpassword(){
			$res = $this->db->where("rest_email",$this->input->post('rest_email'))->where("rest_name",$this->input->post('rest_name'))->get('tbl_restaurant')->row();
			if (isset($res)){

				$email = trim($this->input->post('rest_email'));

				if ($this->send_new_password_mail($email)){
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line("Your new password has been sent to your email address").'.</div>');
				}else{
					$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.$this->lang->line("There are some server errors").'.</div>');
				}
			}else{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.$this->lang->line("Restaurant name or Email is not existed").'.</div>');
			}
			redirect(base_url("Home/forgot"));
		} 
		public function contact_us(){
			$rest_id = $this->input->post("rest_id");
			$phone = $this->input->post("phone");
			$mobile = $this->input->post("mobile");
			$user_email = $this->input->post("email");
			$message_content = $this->input->post("message");
			$customer_name = $this->input->post("first_name") && $this->input->post("last_name");
			if($captcha = $this->input->post('g-recaptcha-response')){
				$secretKey = "6LcQbNsaAAAAAKBy2uDDEFwJFJxQRhGMorDwMRoc";
				$ip = $_SERVER['REMOTE_ADDR'];
				// post request to server
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data_captcha = array('secret' => $secretKey, 'response' => $captcha);
			  
				$options = array(
					'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data_captcha)
					)
				);
				$context  = stream_context_create($options);
				$response_captcha = file_get_contents($url, false, $context);
				$responseKeys_captcha = json_decode($response_captcha,true);
				if($responseKeys_captcha["success"]) {
					if ($row = $this->db->where('rest_id', $rest_id)->get('tbl_restaurant')->row()){
						$email = $row->rest_email;
					}
					if ($row_contact = $this->db->where('restaurant_id', $rest_id)->get('tbl_restaurant_details')->row()){
						if($row_contact->rest_contact_email !== "" && $row_contact->rest_contact_email !== null){
							$email = $row->rest_contact_email;
						}
					} 
					if (isset($email) && trim($email) !== ""){
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
										<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
												valign="top"></td>
										<td class="container" width="100%"
												style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
												valign="top">
												<div class="content"
														style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
														<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
																	style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
																	>
																
																<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																		<td class="content-wrap"
																				style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																										Hi there, <span style="font-size:18px">  </span>
																										<p> Customer <em style="color:red;">'.$customer_name.'</em> sent you message.</p>
																								</td>
																						</tr>
																						<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																								<td class="content-block"
																										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																										valign="top">
																										'.$message_content.'
																								</td>
																						</tr>
																						<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																								<td class="content-block"
																										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																										valign="top">
																										<p> His Phone number is '.$phone.'</p>
																										<p> His Mobile number is '.$mobile.'</p>
																										<p> His Email is  '.$email.'</p>
																								</td>
																						</tr>
																				</table>
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
						$this->email->subject("Contact Us");
						$this->email->message($message);
						$status = $this->email->send();
						die(json_encode(array("status"=>1)));
					}else{
						$msg = "There are some server errors";
						die(json_encode(array("status"=>0,'msg'=>$msg)));
					}
				}else{
					$msg = "There might be recaptcha error.";
					die(json_encode(array("status"=>0,'msg'=>$msg)));
				}
			}else{
				$msg = "There might not be recaptcha in a form.";
				die(json_encode(array("status"=>0,'msg'=>$msg)));
			}
		}
		public function changeStatusReservation(){
			$reservation_id = $this->input->post("reservation_id");
			$status = $this->input->post("status");
			if ($status == "accepted" || $status == "pending" || $status == "rejected"){
				if ($reservation = $this->db->where('id', $reservation_id)->get("tbl_reservations")->row()){
					$this->send_reservation_status_notification_to_customer($reservation_id,$status);
					die(json_encode(array("status"=>$this->MODEL->changeStatusReservation($reservation_id,$status))));
				}else{
					die(json_encode(array("status"=>0,"msg"=>"Not exist")));
				}
			}else{
				die(json_encode(array("status"=>0,"msg"=>"Invalid status")));
			}
		}
		public function refund_cash(){
			$order_id = $this->input->post("order_id");
			$order_status = $this->input->post("order_status");
			die(json_encode(array("status"=>$this->db->where("order_id",$order_id)->where("order_payment_method","cash")->update('tbl_orders',array('order_status'=>$order_status,'orderID'=>$order_id)))));
		}
		public function refund_creditcard_door(){
			$order_id = $this->input->post("order_id");
			$order_status = $this->input->post("order_status");
			die(json_encode(array("status"=>$this->db->where("order_id",$order_id)->where("order_payment_method","creditcard_on_the_door")->update('tbl_orders',array('order_status'=>$order_status,'orderID'=>$order_id)))));
		}
		public function check_new_order(){
			$rest_id = $this->input->post("rest_id");
			$new_orders = $this->db->query("SELECT * FROM tbl_orders WHERE order_rest_id = $rest_id AND (order_is_printed <> '1' OR order_is_printed IS NULL);")->result();
			if (count($new_orders) > 0){
				$status = 1;
			}else{
				$status = 0;
			}
			die(json_encode(array("status"=>$status , "new_orders" => $new_orders)));
		}

		public function changeOrderStatus(){
			$order_id = $this->input->post("order_id");
			$rest_id = $this->input->post("rest_id");
			$order_status = $this->input->post("order_status");
			if ($order_status == "accepted"){
				$duration_time = $this->input->post("duration_time");
				$toUpdate = array(
					'order_status'=>$order_status,
					'order_duration_time'=>$duration_time,
				);
				$order_join_customer = $this->db->where("order_id",$order_id)->where("tbl_customers.user_id > 0")->join("tbl_customers","tbl_customers.customer_id = tbl_orders.order_customer_id")->get("tbl_orders")->row();

				if ($order_join_customer){
					$grand_total_no_discount = $order_join_customer->order_amount + $order_join_customer->order_discount;
					$loyalty_point_setting = $this->db->where("rest_id",$rest_id)->get("tbl_loyalty_point_settings")->row();
					$user_id = $order_join_customer->user_id;
					if ($loyalty_point_setting && $loyalty_point_setting->status == "enable" && $loyalty_point_setting->earn_conversion_rate >0){
						 
						$points_earning = $loyalty_point_setting->earn_conversion_rate * $grand_total_no_discount ;
						if ($loyalty_point_setting->earn_rounding_mode == "on"){
							$points_earning = round($points_earning+0.5);
						}else{
							$points_earning = round($points_earning-0.5);
						}

						if ($user_loyalty_points = $this->db->where("rest_id",$rest_id)->where("user_id",$user_id)->get("tbl_customer_loyalty_points")->row()){
							$this->db->set('last_active_order_date', 'NOW()', FALSE);
							$this->db->where("user_id",$user_id)->where("rest_id",$rest_id)->update("tbl_customer_loyalty_points",array("loyalty_points"=>$user_loyalty_points->loyalty_points + $points_earning));
						}else{
							$this->db->set('last_active_order_date', 'NOW()', FALSE);
							$this->db->insert("tbl_customer_loyalty_points",array("loyalty_points"=> $points_earning , "rest_id" =>$rest_id,"user_id"=>$user_id));
						}
					}
				}
				$this->db->set('order_date', 'NOW()', FALSE);
			}else{
				$toUpdate = array(
					'order_status'=>$order_status
				);
			}
			die(json_encode(array("status"=>$this->db->where("order_id",$order_id)->update('tbl_orders',$toUpdate))));
		}

		public function send_reservation_email_to_rest($data){
			$rest_id = $data["rest_id"];
			if ($rest = $this->db->where('rest_id', $rest_id)->get("tbl_restaurant")->row()){
				$rest_email = $rest->rest_email;
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
								<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
										valign="top"></td>
								<td class="container" width="100%"
										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
										valign="top">
										<div class="content"
												 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
												<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
															 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
															 >
														
														<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td class="content-wrap"
																		style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								Hi there, <span style="font-size:18px"> '.$rest->rest_name.' </span>
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								There is a new reservations.
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																								valign="top">
																								<p> Number of People : '.$data["number_of_people"].' </p>
																								<p> Name : '.$data["first_name"].' '.$data["last_name"].' </p>
																								<p> Date : '.$data["date"].' </p>
																								<p> Time : '.$data["time"].' </p>
																								<p> Telephone : '.$data["telephone"].' </p>
																								<p> Email : '.$data["email"].' </p>
																								<p> Remark : '.$data["remark"].' </p>
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block" itemprop="handler" 
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																							valign="top">
																							<a href="'.base_url("Restaurant/Reservation").'" class="btn-primary" itemprop="url"
																								 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Click on to Check</a>
																					</td>
																				</tr>
																		</table>
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
				$this->email->subject("New Reservation");
				$this->email->message($message);
				return  $this->email->send();
			}
    	}
		public function send_reservation_email_to_customer($data){
				
			$rest_id = $data["rest_id"];
			if ($rest = $this->db->where('rest_id', $rest_id)->get("tbl_restaurant")->row()){
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
								<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
										valign="top"></td>
								<td class="container" width="100%"
										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
										valign="top">
										<div class="content"
												 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
												<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
															 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
															 >
														
														<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td class="content-wrap"
																		style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								Hi there,
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								You requrested a new reservation. Please wait for an  acception from restaurant owner.
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																								valign="top">
																								<p> Restaurant : '.$rest->rest_name.' </p>
																								<p> Number of People : '.$data["number_of_people"].' </p>
																								<p> Name : '.$data["first_name"].' '.$data["last_name"].' </p>
																								<p> Date : '.$data["date"].' </p>
																								<p> Time : '.$data["time"].' </p>
																								<p> Telephone : '.$data["telephone"].' </p>
																								<p> Email : '.$data["email"].' </p>
																								<p> Remark : '.$data["remark"].' </p>
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block" itemprop="handler" 
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																							valign="top">
																							<a href="'.base_url("Customer/dashboard").'" class="btn-primary" itemprop="url"
																								 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Dashboard</a>
																					</td>
																				</tr>
																		</table>
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
				$this->email->to($data['email']);
				$this->email->subject("New Reservation");
				$this->email->message($message);
				return  $this->email->send();
			}
		}
		public function send_reservation_status_notification_to_customer($reservation_id,$status){
			$customer = $this->db->where('id', $reservation_id)->get("tbl_reservations")->row();
			$rest_id = $customer ->rest_id;
			if ($rest = $this->db->where('rest_id', $rest_id)->get("tbl_restaurant")->row()){

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
								<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
										valign="top"></td>
								<td class="container" width="100%"
										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
										valign="top">
										<div class="content"
												 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
												<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
															 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
															 >
														
														<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td class="content-wrap"
																		style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								Hi there,
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								Your reservation for the '.$rest->rest_name.' has been '.$status.'.
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																								valign="top">
																								<p> Restaurant : '.$rest->rest_name.' </p>
																								<p> Number of People : '.$customer->number_of_people.' </p>
																								<p> Name : '.$customer->first_name.' '.$customer->last_name.' </p>
																								<p> Date : '.$customer->date.' </p>
																								<p> Time : '.$customer->time.' </p>
																								<p> Telephone : '.$customer->telephone.' </p>
																								<p> Email : '.$customer->email.' </p>
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block" itemprop="handler" 
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																							valign="top">
																							<a href="'.base_url("Customer/dashboard").'" class="btn-primary" itemprop="url"
																								 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Dashboard</a>
																					</td>
																				</tr>
																		</table>
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
				$this->email->to($customer->email);
				$this->email->subject("Reservation ".$status);
				$this->email->message($message);
				return  $this->email->send();
			}
		}
		public function send_new_password_mail($email){
			$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$new_password = substr(str_shuffle($letters), 0, 8);
			$rest_pass = md5(trim($new_password));
			if ($this->db->where('rest_email', $email)->update('tbl_restaurant',array('rest_pass' => $rest_pass))){
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
								<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
										valign="top"></td>
								<td class="container" width="100%"
										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
										valign="top">
										<div class="content"
												 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
												<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
															 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
															 >
														
														<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td class="content-wrap"
																		style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								Hi there, <span style="font-size:18px">  </span>
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																								valign="top">
																								New Password : '.$new_password.'
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block" itemprop="handler" 
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																							valign="top">
																							<a href="'.base_url("Home").'" class="btn-primary" itemprop="url"
																								 style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Login with New Password</a>
																					</td>
																				</tr>
																		</table>
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
				$this->email->subject("Send New Password");
				$this->email->message($message);
				return  $this->email->send();
			}
    	}
		public function send_registration_mail($email,$password){
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
							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
									valign="top"></td>
							<td class="container" width="100%"
									style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
									valign="top">
									<div class="content"
											style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
											<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
														style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
														>
													
													<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
															<td class="content-wrap"
																	style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																						style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																						valign="top">
																						Thanks for your registration on my.restopage.eu
																				</td>
																			</tr>
																			<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																				<td class="content-block"
																						style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																						valign="top">
																						You can login now with your e-mail and password.
																				</td>
																			</tr>
																			<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block"
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; width:100%;"
																							valign="top">
																							<hr>
																							Your E-Mail: : '.$email.' <br>
																							Your Password : '.$password.' <br>
																					</td>
																			</tr>
																			<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block" itemprop="handler" 
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																							valign="top">
																							<a href="'.base_url("Home").'" class="btn-primary" itemprop="url"
																									style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Click here for login.</a>
																					</td>
																			</tr>
																	</table>
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
			$this->email->subject("New Registration");
			$this->email->message($message);
			return  $this->email->send();
		
    	}
		public function resRegister(){
			// $response=$this->MODEL->resRegister($_POST);
			$possibility = true;
			$msg = "";
			if($captcha = $this->input->post('g-recaptcha-response')){
				$secretKey = "6LcQbNsaAAAAAKBy2uDDEFwJFJxQRhGMorDwMRoc";
				$ip = $_SERVER['REMOTE_ADDR'];
				// post request to server
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data_captcha = array('secret' => $secretKey, 'response' => $captcha);
			  
				$options = array(
					'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data_captcha)
					)
				);
				$context  = stream_context_create($options);
				$response_captcha = file_get_contents($url, false, $context);
				$responseKeys_captcha = json_decode($response_captcha,true);
				if($responseKeys_captcha["success"]) {
					if ($this->input->post('rest_pass') !== $this->input->post('rest_confirm_pass')){
						$msg .= "<div>" . $this->lang->line("Password is not matched") . "</div>";
						$possibility = false;
					}
					if ($this->db->where("rest_email",$this->input->post('rest_email'))->get('tbl_restaurant')->num_rows() > 0){
						$msg .="<div>" .$this->lang->line("Email is existed"). "</div>";
						$possibility = false;
					}
					if ($possibility){
						$response=$this->MODEL->addNewRestaurant($_POST);
						if ($response == 1){
							$this->send_registration_mail($this->input->post('rest_email'),$this->input->post('rest_pass'));
							$msg .="<div>" .$this->lang->line("Thanks for your registration"). ".</div>";
							$msg .= "<div>" . $this->lang->line("You can login now with your e-mail and password") . ".</div>";
							$this->session->set_flashdata('msg', '<div class="alert alert-success">'.$msg.'</div><div class=""> <a href="'.base_url("Home").'" class="btn w-100 btn-info my-2" style="color:white; background: #00c2ff;"> Login</a></div>');
						}else{
							$this->session->set_flashdata('msg', '<div class="alert alert-success">'.$this->lang->line("There are some server errors").'.</div>');
						}
					}else{
						$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.$msg.'</div>');
					}
				}else{
					$msg = "Please check the the captcha form.";
					$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.$msg.'</div>');
				}
			}else{
				$msg = "Captcha token is not avaliable.";
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.$msg.'</div>');
			}
			redirect(base_url("Home/register"));
		} 
		public function addNewAllergen(){
			
			if($rest_id=$this->input->post('restaurant_id')){
				$added_by=$rest_id;
			}

			if($id=$this->input->post('added_by')){
		        $added_by=$id;
		    }else{
		        $added_by=0;
			}
			$allergen_name = "";

			if (null !== $this->input->post('allergen_name_english') && trim($this->input->post('allergen_name_english')) !== ""){
				$allergen_name_english = trim($this->input->post('allergen_name_english'));
				$allergen_name = $allergen_name_english;
			}else{
				$allergen_name_english = "";
			}

			if (null !== $this->input->post('allergen_name_germany') && trim($this->input->post('allergen_name_germany')) !== ""){
				$allergen_name_germany = trim($this->input->post('allergen_name_germany'));
				$allergen_name = $allergen_name_germany;
			}else{
				$allergen_name_germany = "";
			}

			if (null !== $this->input->post('allergen_name_french') && trim($this->input->post('allergen_name_french')) !== ""){
				$allergen_name_french = trim($this->input->post('allergen_name_french'));
				$allergen_name = $allergen_name_french;
			}else{
				$allergen_name_french = "";
			}

			$data=array(
                "added_by"				=>	$added_by,
			    "allergen_name_english"	=>	$allergen_name_english,
			    "allergen_name_french"	=>	$allergen_name_french,
				"allergen_name_germany"	=>	$allergen_name_germany,
				"allergen_name"				=>	$allergen_name,
			);
			die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_allergens"))));
		}
		public function addNewKitchen(){
			$kitchen_name = "";
			$kitchen_description = "";
			if (null !== $this->input->post('kitchen_name_english') && trim($this->input->post('kitchen_name_english')) !== ""){
				$kitchen_name_english = trim($this->input->post('kitchen_name_english'));
				$kitchen_name = $kitchen_name_english;
			}else{
				$kitchen_name_english = "";
			}

			if (null !== $this->input->post('kitchen_name_germany') && trim($this->input->post('kitchen_name_germany')) !== ""){
				$kitchen_name_germany = trim($this->input->post('kitchen_name_germany'));
				$kitchen_name = $kitchen_name_germany;
			}else{
				$kitchen_name_germany = "";
			}

			if (null !== $this->input->post('kitchen_name_french') && trim($this->input->post('kitchen_name_french')) !== ""){
				$kitchen_name_french = trim($this->input->post('kitchen_name_french'));
				$kitchen_name = $kitchen_name_french;
			}else{
				$kitchen_name_french = "";
			}
			if (null !== $this->input->post('kitchen_description_english') && trim($this->input->post('kitchen_description_english')) !== ""){
				$kitchen_description_english = trim($this->input->post('kitchen_description_english'));
				$kitchen_description = $kitchen_description_english;
			}else{
				$kitchen_description_english = "";
			}

			if (null !== $this->input->post('kitchen_description_germany') && trim($this->input->post('kitchen_description_germany')) !== ""){
				$kitchen_description_germany = trim($this->input->post('kitchen_description_germany'));
				$kitchen_description = $kitchen_description_germany;
			}else{
				$kitchen_description_germany = "";
			}

			if (null !== $this->input->post('kitchen_description_french') && trim($this->input->post('kitchen_description_french')) !== ""){
				$kitchen_description_french = trim($this->input->post('kitchen_description_french'));
				$kitchen_description = $kitchen_description_french;
			}else{
				$kitchen_description_french = "";
			}

			$data=array(
			    "kitchen_name_english"	=>	$kitchen_name_english,
			    "kitchen_name_french"	=>	$kitchen_name_french,
				"kitchen_name_germany"	=>	$kitchen_name_germany,
				"kitchen_name"			=>	$kitchen_name,
			    "kitchen_description_english"	=>	$kitchen_description_english,
			    "kitchen_description_french"	=>	$kitchen_description_french,
				"kitchen_description_germany"	=>	$kitchen_description_germany,
				"kitchen_description"			=>	$kitchen_description,
			);
			die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_kitchens"))));
		}
		public function addNewCategory(){
			$imageName = "";
			if (file_exists($_FILES['category_image']['tmp_name']) || is_uploaded_file($_FILES['category_image']['tmp_name'])){
				$imageArray=pathinfo($_FILES['category_image']['name']);
				$source_img = $_FILES['category_image']['tmp_name'];
				$imageName = 'Top-Resto-Menu-Item-Imag-'.date('dmyhis').'.'.$imageArray['extension'];
				$destination_img='assets/category_images/'.$imageName;
				// $d = compress($source_img, $destination_img, 90);
				// $condition=array("restaurant_id"=>$sessData[0]->rest_id);
				$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
				if (isset($fileUploadingSetting)){
					$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
					$max_width = $fileUploadingSetting->category->max_width;
					$max_height = $fileUploadingSetting->category->max_height;
					$compression = $fileUploadingSetting->category->compression;
				} else{
					$max_width = 0;
					$max_height = 0;
					$compression = 80;
				}
				$this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false);
			}
		    if($id=$this->input->post('added_by')){
		        $added_by=$id;
		    }else{
		        $added_by=0;
			}
			
			if($rest_id=$this->input->post('restaurant_id')){
				$added_by=$rest_id;
			}
			$category_name = "";
			$category_description = "";

			if (null !== $this->input->post('cat_name_english') && trim($this->input->post('cat_name_english')) !== ""){
				$category_name_english = trim($this->input->post('cat_name_english'));
				$category_name = $category_name_english;
			}else{
				$category_name_english = "";
			}

			if (null !== $this->input->post('cat_name_germany') && trim($this->input->post('cat_name_germany')) !== ""){
				$category_name_germany = trim($this->input->post('cat_name_germany'));
				$category_name = $category_name_germany;
			}else{
				$category_name_germany = "";
			}

			if (null !== $this->input->post('cat_name_french') && trim($this->input->post('cat_name_french')) !== ""){
				$category_name_french = trim($this->input->post('cat_name_french'));
				$category_name = $category_name_french;
			}else{
				$category_name_french = "";
			}

			if (null !== $this->input->post('cat_description_english') && trim($this->input->post('cat_description_english')) !== ""){
				$category_description_english = trim($this->input->post('cat_description_english'));
				$category_description = $category_description_english;
			}else{
				$category_description_english = "";
			}

			if (null !== $this->input->post('cat_description_germany') && trim($this->input->post('cat_description_germany')) !== ""){
				$category_description_germany = trim($this->input->post('cat_description_germany'));
				$category_description = $category_description_germany;
			}else{
				$category_description_germany = "";
			}

			if (null !== $this->input->post('cat_description_french') && trim($this->input->post('cat_description_french')) !== ""){
				$category_description_french = trim($this->input->post('cat_description_french'));
				$category_description = $category_description_french;
			}else{
				$category_description_french = "";
			}

			if (null !== $this->input->post('type_id')){
				$type_id = $this->input->post('type_id');
			}else{
				$type_id = 1;
			}
			$data=array(
                "added_by"				=>	$added_by,
			    "category_name_english"	=>	$category_name_english,
			    "category_name_french"	=>	$category_name_french,
				"category_name_germany"	=>	$category_name_germany,
				"category_name"			=>	$category_name,
			    "category_description_english"	=>	$category_description_english,
			    "category_description_french"	=>	$category_description_french,
				"category_description_germany"	=>	$category_description_germany,
				"category_description"			=>	$category_description,
				"category_image"		=>	$imageName,
				"type_id"				=>  $type_id,
				"category_sort_index"	=>  $this->input->post('category_sort_index')
			);
			die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_category"))));
		}
		public function addNewExtraCategory(){
		    if($id=$this->input->post('added_by')){
		        $added_by=$id;
		    }else{
		        $added_by=0;
			}
			
			if($rest_id=$this->input->post('restaurant_id')){
				$added_by=$rest_id;
			}
			$category_name = "";

			if (null !== $this->input->post('cat_name_english') && trim($this->input->post('cat_name_english')) !== ""){
				$category_name_english = trim($this->input->post('cat_name_english'));
				$category_name = $category_name_english;
			}else{
				$category_name_english = "";
			}

			if (null !== $this->input->post('cat_name_germany') && trim($this->input->post('cat_name_germany')) !== ""){
				$category_name_germany = trim($this->input->post('cat_name_germany'));
				$category_name = $category_name_germany;
			}else{
				$category_name_germany = "";
			}

			if (null !== $this->input->post('cat_name_french') && trim($this->input->post('cat_name_french')) !== ""){
				$category_name_french = trim($this->input->post('cat_name_french'));
				$category_name = $category_name_french;
			}else{
				$category_name_french = "";
			}

			if (null !== $this->input->post('type_id')){
				$type_id = $this->input->post('type_id');
			}else{
				$type_id = 1;
			}
			$data=array(
                "added_by"				=>	$added_by,
			    "extra_category_name_english"	=>	$category_name_english,
			    "extra_category_name_french"	=>	$category_name_french,
				"extra_category_name_germany"	=>	$category_name_germany,
				"extra_category_name"			=>	$category_name,
				"type_id"						=>  $type_id,
				"is_multi_select"				=>  $this->input->post('is_multi_select'),
				"extra_category_sort_index"		=>  $this->input->post('category_sort_index')
			);
			die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_food_extra_category"))));
		}
		public function addNewTax(){
			$rest_id = $this->input->post("rest_id");
			if ($rest_id > 0){
				$data=array(
					"tax_percentage"				=>  $this->input->post("tax_value"),
					"tax_description"				=>  $this->input->post("tax_desc"),
					"rest_id"						=>  $rest_id,
				);			
				die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_tax_settings"))));
			}else{
				die(json_encode(array("status"=>0)));
			}
		}
		public function addNewDeliveryTax(){
			$rest_id = $this->input->post("delivery_rest_id");
			if ($rest_id > 0){
				$data=array(
					"delivery_tax"				=>  $this->input->post("delivery_tax_value"),
				);			
				die(json_encode(array("status"=>$this->db->where("restaurant_id" , $rest_id)->update("tbl_restaurant_details",$data))));
			}else{
				die(json_encode(array("status"=>0)));
			}
		}
		public function addDeliveryArea(){
			$area_name = "";
			if (null !== $this->input->post('areaname_english') && "" !== trim($this->input->post('areaname_english'))){
				$area_name_english = trim($this->input->post('areaname_english'));
				$area_name = $area_name_english;
			}else{
				$area_name_english="";
			}

			if (null !== $this->input->post('areaname_germany') && "" !== trim($this->input->post('areaname_germany'))){
				$area_name_germany = trim($this->input->post('areaname_germany'));
				$area_name = $area_name_germany;
			}else{
				$area_name_germany="";
			}

			if (null !== $this->input->post('areaname_french') && "" !== trim($this->input->post('areaname_french'))){
				$area_name_french = trim($this->input->post('areaname_french'));
				$area_name = $area_name_french;
			}else{
				$area_name_french="";
			}

			$data=array(
				"area_country"						=>	$this->input->post("country_for_postcode"),
				"area_name"							=>	$area_name,
				"area_name_french"					=>	$area_name_french,
				"area_name_germany"					=>	$area_name_germany,
				"area_name_english"					=>	$area_name_english,
				"post_code"							=>  $this->input->post("postcode"),
				"rest_id"							=>  $this->input->post("rest_id"),
				"min_order_amount"					=>  $this->input->post("minimum_order_amount"),
				"delivery_time"						=>  $this->input->post("delivery_time"),
				"delivery_charge"					=>  $this->input->post("delivery_charge"),
				"min_order_amount_free_delivery"	=>  $this->input->post("min_order_amount_free_delivery")
			);			
			die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_delivery_areas"))));
		}
		public function addDeliveryCountry(){
			$rest_id = $this->input->post("rest_id");
			$data=array(
				"rest_id"							=>  $rest_id,
				"countries"							=>  implode(",",$this->input->post("countries")),
			);			
			die(json_encode(array("status"=>$this->MODEL->saveDeliverycountry($data,$rest_id))));
		}
		public function removeCategory(){
			die(json_encode(array("status"=>$this->MODEL->remove_Category($this->input->post('cat_id')))));
		}
		public function removeExtraCategory(){
			die(json_encode(array("status"=>$this->MODEL->remove_ExtraCategory($this->input->post('cat_id')))));
		}
		public function removeArea(){
			die(json_encode(array("status"=>$this->MODEL->remove_Area($this->input->post('area_id')))));
		}
		public function removeOrder(){
			die(json_encode(array("status"=>$this->MODEL->remove_Order($this->input->post('order_id')))));
		}
		public function removeVideoTutorial(){
			die(json_encode(array("status"=>$this->MODEL->remove_Video_Tutorial($this->input->post('video_id')))));
		}
		public function removeAllergen(){
			die(json_encode(array("status"=>$this->MODEL->remove_Allergen($this->input->post('allergen_id')))));
		}
		public function removeKitchen(){
			die(json_encode(array("status"=>$this->MODEL->remove_Kitchen($this->input->post('kitchen_id')))));
		}
		public function removeAnnouncement(){
			die(json_encode(array("status"=>$this->MODEL->remove_Announcement($this->input->post('announcement_id')))));
		}
		public function removeTax(){
			$rest_id = $this->input->post("rest_id");
			$tax_id = $this->input->post("tax_id");
			$res = $this->db->where("rest_id",$rest_id)->where("id",$tax_id)->delete("tbl_tax_settings");
			die(json_encode(array("status"=>$res)));
		}
		public function removeSubCategory(){
			die(json_encode(array("status"=>$this->MODEL->remove_subCategory($this->input->post('subcat_id')))));
		}
		public function removeFoodExtra(){
			die(json_encode(array("status"=>$this->MODEL->remove_foodExtra($this->input->post('extra_id')))));
		}
		public function activateCategory(){
			die(json_encode(array("status"=>$this->MODEL->activate_Category($this->input->post('cat_id')))));
		}
		public function activateExtraCategory(){
			die(json_encode(array("status"=>$this->MODEL->activate_ExtraCategory($this->input->post('cat_id')))));
		}
		public function activateArea(){
			die(json_encode(array("status"=>$this->MODEL->activate_Area($this->input->post('area_id')))));
		}
		public function activateMenuItem(){
			die(json_encode(array("status"=>$this->MODEL->activate_MenuItem($this->input->post('menuId')))));
		}
		public function addSubCategory(){
			$sub_category_name = "";
			if (null !== $this->input->post('sub_cat_name_english') && "" !== trim($this->input->post('sub_cat_name_english'))){
				$sub_category_name_english = trim($this->input->post('sub_cat_name_english'));
				$sub_category_name = $sub_category_name_english;
			}else{
				$sub_category_name_english="";
			}

			if (null !== $this->input->post('sub_cat_name_germany') && "" !== trim($this->input->post('sub_cat_name_germany'))){
				$sub_category_name_germany = trim($this->input->post('sub_cat_name_germany'));
				$sub_category_name = $sub_category_name_germany;
			}else{
				$sub_category_name_germany="";
			}

			if (null !== $this->input->post('sub_cat_name_french') && "" !== trim($this->input->post('sub_cat_name_french'))){
				$sub_category_name_french = trim($this->input->post('sub_cat_name_french'));
				$sub_category_name = $sub_category_name_french;
			}else{
				$sub_category_name_french="";
			}


			if (null !== $this->input->post('category_id')){
				$category_id = $this->input->post('category_id');
			}else{
				$category_id = 1;
			}
			$data=array(
				"sub_category_name_english"		=>	$sub_category_name_english,
				"sub_category_name_french"		=>	$sub_category_name_french,
				"sub_category_name_germany"		=>	$sub_category_name_germany,
				"sub_category_name"				=>	$sub_category_name,
				"category_id"					=>  $category_id
			);			
			die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_sub_category"))));
		}
		public function addFoodExtra(){
			$food_extra_name = "";
			if (null !== $this->input->post('food_extra_name_english') && "" !== trim($this->input->post('food_extra_name_english'))){
				$food_extra_name_english = trim($this->input->post('food_extra_name_english'));
				$food_extra_name = $food_extra_name_english;
			}else{
				$food_extra_name_english="";
			}

			if (null !== $this->input->post('food_extra_name_germany') && "" !== trim($this->input->post('food_extra_name_germany'))){
				$food_extra_name_germany = trim($this->input->post('food_extra_name_germany'));
				$food_extra_name = $food_extra_name_germany;
			}else{
				$food_extra_name_germany="";
			}

			if (null !== $this->input->post('food_extra_name_french') && "" !== trim($this->input->post('food_extra_name_french'))){
				$food_extra_name_french = trim($this->input->post('food_extra_name_french'));
				$food_extra_name = $food_extra_name_french;
			}else{
				$food_extra_name_french="";
			}


			if (null !== $this->input->post('category_id_for_extra')){
				$category_id_for_extra = $this->input->post('category_id_for_extra');
			}else{
				$category_id_for_extra = 1;
			}
			$data=array(
				"food_extra_name_english"		=>	$food_extra_name_english,
				"food_extra_name_french"		=>	$food_extra_name_french,
				"food_extra_name_germany"		=>	$food_extra_name_germany,
				"food_extra_name"				=>	$food_extra_name,
				"category_id"					=>  $category_id_for_extra
			);			
			die(json_encode(array("status"=>$this->MODEL->addNew($data,"tbl_food_extra"))));
		}
		public function deactivateCategory(){
			die(json_encode(array("status"=>$this->MODEL->deactivate_Category($this->input->post('cat_id')))));
		}
		public function deactivateExtraCategory(){
			die(json_encode(array("status"=>$this->MODEL->deactivate_ExtraCategory($this->input->post('cat_id')))));
		}
		public function deactivateArea(){
			die(json_encode(array("status"=>$this->MODEL->deactivate_Area($this->input->post('area_id')))));
		}
		public function activateAddon(){
			$addon_id = $this->input->post("addon_id");
			$rest_id = $this->input->post("rest_id");
			$rest = $this->db->where("restaurant_id",$rest_id)->get("tbl_restaurant_details")->row();
			if ($rest->addon_ids == ""){
				$addon_ids_arr= array($addon_id) ;
			}else{
				$addon_ids_arr = explode(",",$rest->addon_ids);
				if (!in_array($addon_id,$addon_ids_arr)){
					$addon_ids_arr[] = $addon_id ;
				}
			}
			$addon_ids_str = implode(",",$addon_ids_arr);
			$res = $this->db->where("restaurant_id",$rest_id)->update("tbl_restaurant_details",array("addon_ids"=>$addon_ids_str));
			die(json_encode(array("status"=>$res)));
		}
		public function cancelAddon(){
			$addon_id = $this->input->post("addon_id");
			$rest_id = $this->input->post("rest_id");
			$rest = $this->db->where("restaurant_id",$rest_id)->get("tbl_restaurant_details")->row();
			$addon_ids_arr = explode(",",$rest->addon_ids);
			if (in_array($addon_id,$addon_ids_arr)){
				$addon_ids_arr = array_diff( $addon_ids_arr, [$addon_id] )  ;
			}
			$addon_ids_str = implode(",",$addon_ids_arr);
			$_res = $this->db->where("restaurant_id",$rest_id)->update("tbl_restaurant_details",array("addon_ids"=>$addon_ids_str));
			$status = 'inactive';
			if ($this->db->where("addon_id", $addon_id)->where("rest_id", $rest_id)->get("tbl_restaurant_addons")->row()){
				$res = $this->db->where("addon_id", $addon_id)->where("rest_id", $rest_id)->update("tbl_restaurant_addons",array("status" => $status));
			}else{
				$update_data = array(
					'rest_id' 	=>	$rest_id,
					'addon_id' 	=>	$addon_id,
					'status' 	=>	$status
				);
				$res = $this->db->insert("tbl_restaurant_addons" ,$update_data);
			}
			die(json_encode(array("status"=>$res && $_res)));
		}
		public function deactivateMenuItem(){
			die(json_encode(array("status"=>$this->MODEL->deactivate_MenuItem($this->input->post('menuId')))));
		}

		public function restaurantSEOSetting(){
			$rest_id = $this->input->post("rest_id");
			if ($rest_id > 0){
				if (null == ($this->input->post("is_google_analytics"))){
					$seo_titles = array(
						"home_title_french" =>  $this->input->post("home_title_french"),
						"home_title_english" =>  $this->input->post("home_title_english"),
						"home_title_germany" =>  $this->input->post("home_title_germany"),
						"reservation_title_french" =>  $this->input->post("reservation_title_french"),
						"reservation_title_english" =>  $this->input->post("reservation_title_english"),
						"reservation_title_germany" =>  $this->input->post("reservation_title_germany"),
						"menu_title_french" =>  $this->input->post("menu_title_french"),
						"menu_title_english" =>  $this->input->post("menu_title_english"),
						"menu_title_germany" =>  $this->input->post("menu_title_germany"),
					);
					$seo_descriptions = array(
						"home_desc_french" =>  $this->input->post("home_desc_french"),
						"home_desc_english" =>  $this->input->post("home_desc_english"),
						"home_desc_germany" =>  $this->input->post("home_desc_germany"),
						"reservation_desc_french" =>  $this->input->post("reservation_desc_french"),
						"reservation_desc_english" =>  $this->input->post("reservation_desc_english"),
						"reservation_desc_germany" =>  $this->input->post("reservation_desc_germany"),
						"menu_desc_french" =>  $this->input->post("menu_desc_french"),
						"menu_desc_english" =>  $this->input->post("menu_desc_english"),
						"menu_desc_germany" =>  $this->input->post("menu_desc_germany"),
					);
					$data = array(
						"seo_rest_id"										=>  $rest_id,
						"seo_descriptions"									=>  json_encode($seo_descriptions),
						"seo_titles"										=>  json_encode($seo_titles),
					);		
				}else{
					$seo_header_content_english =  $this->input->post("header_seo_content_english");
					$seo_header_content_french =  $this->input->post("header_seo_content_french");
					$seo_header_content_germany =  $this->input->post("header_seo_content_germany");
					$seo_footer_content_english =  $this->input->post("footer_seo_content_english");
					$seo_footer_content_french =  $this->input->post("footer_seo_content_french");
					$seo_footer_content_germany =  $this->input->post("footer_seo_content_germany");
					
					if (trim($seo_header_content_french) !== ""){
						$seo_header_content = $seo_header_content_french;
					}elseif (trim($seo_header_content_germany) !== ""){
						$seo_header_content = $seo_header_content_germany;
					}else{
						$seo_header_content = $seo_header_content_english;
					}
					if (trim($seo_footer_content_french) !== ""){
						$seo_footer_content = $seo_footer_content_french;
					}elseif (trim($seo_footer_content_germany) !== ""){
						$seo_footer_content = $seo_footer_content_germany;
					}else{
						$seo_footer_content = $seo_footer_content_english;
					}
					$data = array(
						"seo_rest_id"										=>  $rest_id,
						"seo_header_content"								=>  $seo_header_content,
						"seo_header_content_english"						=>  $seo_header_content_english,
						"seo_header_content_french"							=>  $seo_header_content_french,
						"seo_header_content_germany"						=>  $seo_header_content_germany,
						"seo_footer_content"								=>  $seo_footer_content,
						"seo_footer_content_english"						=>  $seo_footer_content_english,
						"seo_footer_content_french"							=>  $seo_footer_content_french,
						"seo_footer_content_germany"						=>  $seo_footer_content_germany,
					);		
				}

				$rest_old = $this->db->where("seo_rest_id" ,$rest_id)->get("tbl_seo_settings")->row();
				if ($rest_old){
					$res = $this->db->update("tbl_seo_settings",$data);
				}else{
					$res = $this->db->insert("tbl_seo_settings",$data);
				}
				die(json_encode(array("status"=>$res)));
			}else{
				die(json_encode(array("status"=>0)));
			}
		}
		public function restaurantSocialSetting(){
			$rest_id = $this->input->post("rest_id");
			if ($rest_id > 0){
				$social_media = array(
					"facebook" => array(
						"url" => $this->input->post("facebook_url"),
						"status" => $this->input->post("facebook_status"),
					),
					"twitter" => array(
						"url" => $this->input->post("twitter_url"),
						"status" => $this->input->post("twitter_status"),
					),
					"linkedin" => array(
						"url" => $this->input->post("linkedin_url"),
						"status" => $this->input->post("linkedin_status"),
					),
					"youtube" => array(
						"url" => $this->input->post("youtube_url"),
						"status" => $this->input->post("youtube_status"),
					),
					"vimeo" => array(
						"url" => $this->input->post("vimeo_url"),
						"status" => $this->input->post("vimeo_status"),
					),
					"pinterest" => array(
						"url" => $this->input->post("pinterest_url"),
						"status" => $this->input->post("pinterest_status"),
					),
					"instagram" => array(
						"url" => $this->input->post("instagram_url"),
						"status" => $this->input->post("instagram_status"),
					),
					"reddit" => array(
						"url" => $this->input->post("reddit_url"),
						"status" => $this->input->post("reddit_status"),
					),
				);
				$data = array(
					"rest_id"										=>  $rest_id,
					"social_media"									=>  json_encode($social_media),
				);		
				

				$rest_old = $this->db->where("rest_id" ,$rest_id)->get("tbl_social_settings")->row();
				if ($rest_old){
					$res = $this->db->update("tbl_social_settings",$data);
				}else{
					$res = $this->db->insert("tbl_social_settings",$data);
				}
				die(json_encode(array("status"=>$res)));
			}else{
				die(json_encode(array("status"=>0)));
			}
		}

		public function getTax(){
			$rest_id = $this->input->post("rest_id");
			$tax_id = $this->input->post("tax_id");
			$res = $this->db->where("rest_id",$rest_id)->where("id",$tax_id)->get("tbl_tax_settings")->row();
			die(json_encode(array("res"=>$res)));
		}
		public function updateTax(){
			$tax_id = $this->input->post("delivery_tax_id");
			$tax_percentage = $this->input->post("delivery_tax_percentage");
			$tax_description = $this->input->post("delivery_tax_description");
			$updateData = array(
				'tax_percentage' => $tax_percentage,
				'tax_description' => $tax_description,
			);
			$status = $this->db->where("id",$tax_id)->update("tbl_tax_settings",$updateData);
			die(json_encode(array("status"=>$status)));
		}
		public function setStandardTax(){
			$rest_id = $this->input->post("rest_id");
			$tax_id = $this->input->post("tax_id");
			$res = $this->db->query("UPDATE `tbl_tax_settings` SET is_standard = (id = $tax_id) WHERE rest_id = $rest_id;");
			die(json_encode(array("status"=>$res)));
		}
		public function reservationTable(){
			$number_of_people = $this->input->post("number_of");
			$reservation_date = $this->input->post("reservation_date");
			$reservation_time = $this->input->post("reservation_time");
			$telephone = $this->input->post("phone");
			$email = $this->input->post("email");
			$remark = $this->input->post("remark");
			$first_name = $this->input->post("first_name");
			$last_name = $this->input->post("last_name");

			$rest_id = $this->input->post("rest_id");
			$res = $this->db->where("rest_id",$rest_id)->get('tbl_restaurant')->row();

			$data=array(
				"number_of_people"		=>	$number_of_people,
				"date"					=>	$reservation_date,
				"time"					=>	$reservation_time,
				"telephone"				=>	$telephone,
				"email"					=>  $email,
				"first_name"			=>  $first_name,
				"last_name"				=>  $last_name,
				"rest_id"				=>  $rest_id,
				"remark"				=>  $remark,
			);
			
			// modify by Jfrost ,must be commented in localhost
			$this->send_reservation_email_to_rest($data);
			$this->send_reservation_email_to_customer($data);
			$reservation_id = $this->MODEL->addNewReservation($data);
			$this->sendNewOrderReservationNotification("reservation",$reservation_id);
			die(json_encode(array("status"=>$reservation_id)));
		}

		public function orderpay(){
			$payment_method = $this->input->post("payment_method") ;
			$address = $this->input->post("address") ;
			$postcode = $this->input->post("postcode") ;
			$city = $this->input->post("city") ;
			$floor = $this->input->post("floor") ;
			$name = $this->input->post("name") ;
			$email = $this->input->post("email") ;
			$phone = $this->input->post("phone") ;
			$company_name = $this->input->post("company_name") ;
			$remarks = $this->input->post("remarks") ;
			$dp_option = $this->input->post("dp_option") ;
			$rest_slug = $this->input->post("rest_url_slug") ;
			$is_tip = $this->input->post("is_tip") ;
			$order_remark = $this->input->post("order_remark") ;
			$cart_tip = array();
			if ($is_tip == "on"){
				$tip_amount = $this->input->post("tip_amount") ;
				$tip_note = $this->input->post("tip_note") ;
				$cart_tip = array(
					"amount" 	=> $tip_amount,
					"note" 		=> $tip_note
				);
			}
			
			$cart = array();
			$cart['_phone_number'] = $phone;
			$cart['_email'] = $email;
			$cart['_postcode'] = $postcode;
			$cart['_city'] = $city;
			$cart['_address'] = $address;
			$cart['_floor'] = $floor;
			$cart['_phone_number'] = $phone;
			$cart['_company_name'] = $company_name;
			$cart['_payment_method'] = $payment_method;
			$cart['_name'] = $name;
			$cart['_order_type'] = $this->session->userdata('menu_mode');

			$cart['cart_tip'] = $cart_tip;
			
			if (null !== $this->input->post("order_reservation_time") && $this->input->post("order_reservation_time") == "asap"){
				$order_specification = "real";
				$order_reservation_time = "";
			}else{
				$order_reservation_time = $this->input->post("order_reservation_time");
				$order_specification = "pre";
			}

			$carts_array = array();
			$carts_item_id_array = array();
			$carts_item_price_array = array();
			$carts_item_qty_array = array();
			$carts_item_extra_array = array();
			$carts_item_extra_arr = array();
			$carts_item_id_price_index_arr = array();

			$carts_item_id_str="";
			$carts_item_extra_str="";

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
					$carts_item_extra_arr[] = $cart_each_item_extra_id;
					if ($cart_each_item_id > 0){
						if ($t_temp = $this->db->where("menu_id",$cart_each_item_id)->get("tbl_menu_card")->row()){
							$t_dp_option = $t_temp->item_show_on;
							if (($dp_option == "Delivery" && $t_dp_option % 2 == 1) || ($dp_option == "Pickup" && $t_dp_option > 1)){
								$carts_item_id_price_index_arr[] = $cart_each_item_id . ":" . $cart_each_item_price_index;
							}
						}
					}
				}
			}
			
			if ($current_res = $this->db->where("rest_url_slug",$rest_slug)->get("tbl_restaurant")->row()){
				
				$this->session->unset_userdata('order_id');
				$this->session->unset_userdata('register_user_id');

				$rest_id = $current_res->rest_id;

				$cart_item_details = array();
				$cart_price = 0;
				$cart_qty = 0;
				$total = 0 ;
				$cart['items'] = array();
				$temp = "";
				$stripe = array();
				$food_tax_list = array();
				foreach ($carts_item_id_array as $c_key_item => $c_value_item) {
					$item_extra = "";
					$extra_price_value = 0;
					if (strtolower($dp_option) == "delivery"){
						$item_show_on_condition = " and (item_show_on = 1 or item_show_on = 3)";
					}elseif (strtolower($dp_option)== "pickup"){
						$item_show_on_condition = "and (item_show_on > 1)";
					}else{
						$item_show_on_condition = "and (item_show_on < 4)";
					}
					if ($cart_item_detail = $this->db->query("select * from tbl_menu_card as mc join tbl_category as c on mc.category_id = c.category_id left join tbl_tax_settings as tx on tx.id = mc.item_tax_id where mc.rest_id = $rest_id and c.category_status = 'active' and  item_status <> 'Not Available' $item_show_on_condition and menu_id = $c_value_item")->row()){
						
						$cart_item_details[] = $cart_item_detail;
						$cart_price = $carts_item_price_array[$c_key_item];
						$cart_qty = $carts_item_qty_array[$c_key_item];
						$item_price = $cart_item_detail->item_prices == "" ? "" :explode(",",$cart_item_detail->item_prices)[$cart_price];
						
						$item_extra_arr = array();
						if ($cart_item_detail->item_food_extra !== "" && $cart_item_detail->item_food_extra !== null ){
							$item_extra_p = explode("|",$cart_item_detail->item_food_extra)[$cart_price];
							if ($item_extra_p !== "" && $item_extra_p !== null ){
								$item_extra_p_arr = explode(";",$item_extra_p);
								foreach ($item_extra_p_arr as $ipkey => $ipvalue) {
									if (isset(explode("->",$ipvalue)[1])){
										$item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[1]));
									}else{
										$item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[0]));
									}
								}
								foreach ($item_extra_arr as $ekey => $evalue) {
									if ($evalue !== ""){
										$extra_id = explode(":",$evalue)[0];
										$extra_price = explode(":",$evalue)[1];
										if (in_array($extra_id,$carts_item_extra_array[$c_key_item])){
											$extra_price_value += floatval($extra_price);
										}
									}
								}
							}
						}
						$item_extra = implode(",",$item_extra_arr);
						$cart['items'][$c_key_item] = array(
							'id' => 'Item-'.$cart_item_detail->menu_id,
							'name' => $cart_item_detail->item_name,
							'qty' => $cart_qty,
							'price' => floatval($item_price) + $extra_price_value,
							'extra' => $item_extra,
						);	
						if (isset($food_tax_list[$cart_item_detail->item_tax_id])){
							$food_tax_list[$cart_item_detail->item_tax_id] +=  (floatval($item_price) + $extra_price_value) * intval($cart_qty);
						}else{
							$food_tax_list[$cart_item_detail->item_tax_id] =  (floatval($item_price) + $extra_price_value) * intval($cart_qty);
						}
					}else{
						$item_price = 0;
					}
					$total += (floatval($item_price) + $extra_price_value) * intval($cart_qty);
					// if (strtolower($dp_option) == "delivery"){
						
					// }
				}
				$carts_item_id_str = implode(",",$carts_item_id_price_index_arr);
				$carts_item_extra_str = implode(",",$carts_item_extra_arr);
				$order_qty = implode(",",$carts_item_qty_array);
	
				$min_order = 0;
				$delivery_cost = 0;
				if (strtolower($dp_option) == "delivery" && null !== $this->session->userdata('customer_info')){
					$customer_info = $this->session->userdata('customer_info');
					if ($customer_info["filtered_by"] == "postcode"){
						if ($dparea = $customer_info['area']){
							$min_order = $dparea->min_order_amount;
							$delivery_cost = $dparea->delivery_charge;
							$min_order_amount_free_delivery = $dparea->min_order_amount_free_delivery;
						}
					}else{
						if ( $dparea_zones = $customer_info['area_zone']){
							$min_order = $dparea_zones->minimum_order_amount;
							$delivery_cost = $dparea_zones->delivery_charge;
							$min_order_amount_free_delivery = $dparea_zones->min_order_amount_free_delivery;
						}
					}
					if ($min_order > $total ){
						die(json_encode(array("status"=> -1)));
					}
					if ($min_order_amount_free_delivery <= $total){
						$delivery_cost = 0 ;
					}
				}
				$is_discount = $this->input->post("is_discount") ;
				$discount = 0;
				$loyalty_points = 0;
				$loyalty_point_setting = $this->db->where("rest_id",$rest_id)->get("tbl_loyalty_point_settings")->row();

				if ($is_discount == "yes"){
					$loyalty_points = $this->input->post("loyalty_points") ;
					if ($loyalty_point_setting && $loyalty_point_setting->status=="enable" && $loyalty_point_setting->redemption_conversion_rate >0){
						
						$discount = $loyalty_points / $loyalty_point_setting->redemption_conversion_rate;
					}
				}
				$cart['discount'] = $discount;

				$order_amount = $total + $delivery_cost-$discount;
				$this->session->unset_userdata('shopping_cart');
				if ($payment_method == "paypal"){
				}elseif ($payment_method  == "stripe"){
					// $stripeKey = $this->config->item('stripe_key');
					$rest = $this->db->where("rest_id", $rest_id)->get("tbl_payment_settings")->row();
					$stripeKey = $rest->stripe_public_key;
	
					$stripe = array("stripe_key"=>$stripeKey ,"amount" =>$order_amount,"form_data"=>$this->input->post());
				}else{
				}

				
				// ------------------------------------------------------
				$cart['shopping_cart'] = array(
					'items' => $cart['items'],
					'subtotal' => $total,
					'shipping' =>$delivery_cost,
					'handling' => 0,
					'tax' => $food_tax_list,
					'rest_id' => $rest_id,
				);
				
				
				$cart['shopping_cart']['grand_total'] = number_format($cart['shopping_cart']['subtotal'] + $cart['shopping_cart']['shipping'] + $cart['shopping_cart']['handling'] - $discount, 2);
				$cart['shopping_cart']['grand_total'] = $cart['shopping_cart']['grand_total'] < 0 ? 0 : $cart['shopping_cart']['grand_total'];
				
				$grand_total_no_discount = number_format($cart['shopping_cart']['subtotal'] + $cart['shopping_cart']['shipping'] + $cart['shopping_cart']['handling'] , 2);
				$grand_total_no_discount  = $grand_total_no_discount  < 0 ? 0 : $grand_total_no_discount ;
				$points_earning = 0;

				$this->load->vars('cart', $cart);
				$this->session->set_userdata('shopping_cart', $cart);
				if ($this->session->userdata("customer_Data")){
					$sessUserData=unserialize($this->session->userdata('customer_Data'));
					$user_id = $sessUserData[0]->id;
					if ($tc = $this->db->where("user_id",$user_id)->get("tbl_customers")->row()){
						if ($user_loyalty_points = $this->db->where("user_id",$user_id)->where("rest_id",$rest_id)->get("tbl_customer_loyalty_points")->row()){
						   	if ($user_loyalty_points->loyalty_points < $loyalty_points){
								die(json_encode(array("status"=> -1)));
							}else{
								$this->db->where("user_id",$user_id)->where("rest_id",$rest_id)->update("tbl_customer_loyalty_points",array("loyalty_points"=>$user_loyalty_points->loyalty_points - $loyalty_points));
							}
							$is_exist_customer_account = true;
						}else{
							$is_exist_customer_account = false;
						}
						$register_user_id = $tc->customer_id;
					}else{
						$register_user_id = $this->register_user($address,$postcode,$city ,$floor ,$name ,$email ,$phone ,$company_name,$user_id);
					}
				}else{
					$register_user_id = $this->register_user($address,$postcode,$city ,$floor ,$name ,$email ,$phone ,$company_name);
				}
				$order_currency = "&#8364;";
				if( $rest = $this->db->where("restaurant_id",$rest_id)->get("tbl_restaurant_details")->row()){
					$delivery_tax = $rest->delivery_tax;

					$rest_currency_id = $rest->currency_id;
					$order_currency = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
					$order_currency = $order_currency == "" ? "&#8364;" : $order_currency;
				}
				$order_tax_arr = array(
					"menu" 			=>	$food_tax_list,
					"delivery" 		=>	$delivery_tax
				);

				$order_tax = json_encode($order_tax_arr );
				$order_id = $this->register_order($payment_method,$register_user_id,$order_amount,$order_qty,strtolower($dp_option),$carts_item_id_str,$carts_item_extra_str,$remarks, $rest_id,$delivery_cost,$order_tax,$discount,$order_specification , $order_reservation_time , $order_remark,$order_currency);
				if ($order_id > 0){
					$this->session->set_userdata('order_id', $order_id);
					$this->session->set_userdata('register_user_id', $register_user_id);
				}
				
				if ($payment_method  == "cash" || $payment_method  == "creditcard_on_the_door"){
					if ($order_specification == "pre"){
						$is_open = $this->is_open_rest($order_id,strtolower($dp_option));
						if ($is_open){
							$this->sendNewOrderReservationNotification($dp_option,$order_id);
						}
					}else{
						$this->sendNewOrderReservationNotification($dp_option,$order_id);
					}
					// modify by Jfrost ,must be commented in localhost
					$this->send_order_email_to_user($register_user_id,$order_id);
					$this->send_order_email_to_restaurant($register_user_id,$order_id);
				}

				die(json_encode(array("status"=> 1,"payment_method" => $payment_method, "data"=>$temp,"stripe"=> $stripe , "order_id" =>$order_id )));
			}else{
				die(json_encode(array("status"=> 2)));
			}

		}
		public function stripe_payment(){
			$tokenId = $this->input->post("tokenId") ;
			$amount = $this->input->post("amount") ;
			$order_id = $this->input->post("order_id") ;
			$order_data = array(
				"tokenId" => $tokenId,
				"amount" => $amount,
				"order_id" => $order_id,
			);
			
			$res = $this->db->insert("tbl_stripe_order_temp",$order_data);

			$order_id = $this->session->userdata('order_id');
			$register_user_id = $this->session->userdata('register_user_id');
			if ($order_id > 0){
				// modify by Jfrost ,must be commented in localhost
				$order = $this->db->where("order_id",$order_id)->get("tbl_orders")->row();
				$dp_option = $order->order_type;
				$this->send_order_email_to_user($register_user_id,$order_id);
				$this->send_order_email_to_restaurant($register_user_id,$order_id);
				if ($order->order_specification == "pre"){
					$is_open = $this->is_open_rest($order->rest_id,$order->type);
					if ($is_open){
						$this->sendNewOrderReservationNotification($dp_option,$order_id);
					}
				}else{
					$this->sendNewOrderReservationNotification($dp_option,$order_id);
				}
			}
			
			die(json_encode(array("status"=> $res )));
		}
		public function stripe_cancel(){
			$order_id = $this->input->post("order_id");
			$transactionID = "";
			if ($order = $this->db->where("order_id",$order_id)->get("tbl_stripe_order_temp")){
				$transactionID = "xxxxxxxxxxxx".substr($order->tokenId,'-5');
			}
			$res = $this->db->where("order_id",$order_id)->delete("tbl_stripe_order_temp");
			$toUpdatedata = array(
				"order_status" => "canceled",
			);
			$this->db->where('order_id',$order_id)->update("tbl_orders",$toUpdatedata);
			die(json_encode(array("status"=> $res ,"transactionID"=>$transactionID)));
		}

		public function register_user($address,$postcode,$city ,$floor ,$name ,$email ,$phone ,$company_name,$user_id=null){
			$data = array(
				"customer_email" => $email,
				"customer_phone" => $phone,
				"customer_floor" => $floor,
				"customer_address" => $address,
				"customer_city" => $city,
				"customer_postcode" => $postcode,
				"customer_company_name" => $company_name,
				"customer_name" => $name,
				"user_id" => $user_id,
			);
			return $this->MODEL->addNewTable($data,"tbl_customers");
		}
		
		public function register_order($order_payment_method,$register_user_id,$order_amount,$order_qty,$order_type,$order_item_ids,$order_extra_ids,$remarks, $rest_id,$delivery_cost,$order_tax,$discount,$order_specification , $order_reservation_time, $order_remark,$order_currency){
			$data = array(
				"order_customer_id" => $register_user_id,
				"order_amount" => $order_amount,
				"order_qty" => $order_qty,
				"order_type" => $order_type,
				"order_payment_method" => $order_payment_method,
				"order_item_ids" => $order_item_ids,
				"order_extra_ids" => $order_extra_ids,
				"order_status" => "pending",
				"order_rest_id" => $rest_id,
				"order_delivery_cost" => $delivery_cost,
				"order_tax" => $order_tax,
				"order_discount" => $discount,
				"order_specification" => $order_specification,
				"order_reservation_time" => $order_reservation_time,
				"order_remark" => $order_remark,
				"order_currency" => $order_currency,
			);
			return $this->MODEL->register_order($data);
		}
		public function register_customer($payment_method,$address,$postcode,$city ,$floor ,$name ,$email ,$phone ,$company_name){
			$this->register_user($address,$postcode,$city ,$floor ,$name ,$email ,$phone ,$company_name);
			
			// modify by Jfrost ,must be commented in localhost
			$this->send_register_customer_email($payment_method,$address,$postcode,$city ,$floor ,$name ,$email ,$phone ,$company_name);
			$this->send_register_customer_email_to_admin($payment_method,$address,$postcode,$city ,$floor ,$name ,$email ,$phone ,$company_name);
		}
		public function notify_order_status(){
			$order_id = $this->input->post("order_id");
			$order_status = $this->input->post("order_status");
			$duration_time = $this->input->post("duration_time");
			// modify by Jfrost ,must be commented in localhost
			$this->send_order_status_email_to_user($order_id,$order_status );

		}
		function is_open_rest($rest_id,$dp_option){

			$openingTimes = $this->db->where("rest_id",$rest_id)->get("tbl_opening_times")->row();
			date_default_timezone_set('Europe/Luxembourg');
			$now_Y= date("Y");
			$now_m= date("m");
			$now_d= date("d");
			$now_H= date("H");
			$now_i= date("i");
			$now_s= date("s");
			$now_weekday= (date("N") + 6) % 7;

			$delivery_open = false;
			$pickup_open = false;
			if (isset($openingTimes)){
				$pickup_hours = $openingTimes->pickup_hours;
				if (isset($pickup_hours) && $pickup_hours !== ""){
					$pickup_hours = json_decode($pickup_hours);
					foreach ($pickup_hours[$now_weekday] as $pkey => $pvalue) {
						$pickup_start = $pvalue->start;
						$pickup_end = $pvalue->end;
						if (strtotime($now_H.":". $now_i .":00") > strtotime($pickup_start .":00") && strtotime($now_H.":". $now_i .":00") < strtotime($pickup_end .":00")){
							$pickup_open = true;
						}

					}
					
				}
				
				$delivery_hours = $openingTimes->delivery_hours;
				if (isset($delivery_hours) && $delivery_hours !== ""){
					$delivery_hours = json_decode($delivery_hours);
					foreach ($delivery_hours[$now_weekday] as $dkey => $dvalue) {
						$delivery_start = $dvalue->start;
						$delivery_end = $dvalue->end;
						if (strtotime($now_H.":". $now_i .":00") > strtotime($delivery_start .":00") && strtotime($now_H.":". $now_i .":00") < strtotime($delivery_end .":00")){
							$delivery_open = true;
						}

					}
					
				}

				$holidays = $openingTimes->holidays;
				if (isset($holidays) && $holidays !== ""){
					$holidays = json_decode($holidays);
					if (isset($holidays->name)){
						foreach ($holidays->name as $hkey => $hvalue) {
							$holiday_start = $holidays->dateStart[$hkey];
							$holiday_end = $holidays->dateEnd[$hkey];
							$now_time = $now_m . "/" .  $now_d . "/" . $now_Y;
	
							if ( strtotime(date($now_time)) >  strtotime(date($holiday_start)) && ( strtotime(date($now_time)) < strtotime(date($holiday_end)) || $holiday_end == "" )) {
								$delivery_open = false;
								$pickup_open = false;
							}
							if ( strtotime(date($now_time)) <  strtotime(date($holiday_end)) && ( strtotime(date($now_time)) > strtotime(date($holiday_start)) || $holiday_start == "" )) {
								$delivery_open = false;
								$pickup_open = false;
							}
	
						}
					}
				}

				$irregular_openings = $openingTimes->irregular_openings;
				if (isset($irregular_openings) && $irregular_openings !== ""){
					$irregular_openings = json_decode($irregular_openings);
					if (isset($irregular_openings->name )){
						foreach ($irregular_openings->name as $ikey => $ivalue) {
							$irregular_openings_day = $irregular_openings->date[$ikey];
							$irregular_openings_start_time = $irregular_openings->timeStart[$ikey];
							$irregular_openings_end_time = $irregular_openings->timeEnd[$ikey];
							$now_day = $now_m . "/" .  $now_d . "/" . $now_Y;
							$now_time = $now_H . ":" .  $now_i . ":" . $now_s;
					
							if ( strtotime(date($now_day)) ==  strtotime(date($irregular_openings_day)) && ( strtotime(date($irregular_openings_start_time.":00")) < strtotime(date($now_time)) &&  strtotime(date($irregular_openings_end_time.":00")) > strtotime(date($now_time)) )) {
								$delivery_open = true;
								$pickup_open = true;
							}
						}
					}
					
				}

			}
			if ($dp_option == "delivery"){
				return $delivery_open;
			}else if ($dp_option == "pickup"){
				return $pickup_open;
			}
		}
		public function cron_check_delay_order($time = 20,$test_order_time = 30){
			$res = $this->db->query("SELECT * FROM `tbl_orders`  
				WHERE (order_specification <> 'pre' AND order_status = 'pending' AND (NOW()-order_date) >" . $time*100 . ")"
				// . " OR (order_specification = 'virtual' AND (NOW()-order_date) >" . 30*100 . ")"
				. " OR (order_specification = 'pre' AND order_status = 'pending' AND TIMEDIFF(CONCAT(CONCAT(DATE(order_date) ,' '), CONCAT(order_reservation_time,':00')),NOW()) < 0)")->result();
			if (count($res) > 0){
				foreach ($res as $key => $order) {
					$order_id = $order->order_id;
					$payment_method = $order->order_payment_method;

					if ($payment_method ="paypal"){
						$transactionID = $order->order_transaction;
						$RTFields = array(
									'transactionid' => $transactionID, 							// Required.  PayPal transaction ID for the order you're refunding.
									'payerid' => '', 									// Encrypted PayPal customer account ID number.  Note:  Either transaction ID or payer ID must be specified.  127 char max
									'refundtype' => 'Full', 							// Required.  Type of refund.  Must be Full, Partial, or Other.
									'refundsource' => 'any', 							// Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
								);	
									
						$PayPalRequestData = array('RTFields' => $RTFields);
						
						$PayPalResult = $this->paypal_pro->RefundTransaction($PayPalRequestData);
						
						if(!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])){
							$errors = array('Errors'=>$PayPalResult['ERRORS']);
							// $this->load->view('paypal/samples/error',$errors);
						}
					} 

					$this->db->where("order_id",$order_id)->delete("tbl_stripe_order_temp");
					$toUpdatedata = array(
						'order_status' => 'canceled'
					);
					$this->db->where("order_id",$order_id)->update("tbl_orders",$toUpdatedata);
					// modify by Jfrost ,must be commented in localhost
					$this->send_order_status_email_to_user($order_id,'canceled' );

				}
			}
			$this->check_mobile_notification();
			$this->check_addon_plan();
			$res1 = $this->db->query("UPDATE `tbl_customer_loyalty_points` clp
			JOIN `tbl_loyalty_point_settings` lps ON lps.rest_id = clp.rest_id 
			SET clp.loyalty_points = 0 WHERE DATEDIFF(NOW(),clp.last_active_order_date) > lps.expire_after;");

			$res2 = $this->db->query("DELETE FROM tbl_orders WHERE order_specification = 'virtual' AND (NOW()-order_date) > $test_order_time*100; ");
			$res3 = $this->db->query("DELETE FROM tbl_reservations WHERE reservation_specification = 'virtual' AND (NOW()-created_at) > $test_order_time*100;");
		}
		function check_mobile_notification(){
			$res = $this->db->query("SELECT * FROM `tbl_orders`  
				WHERE order_specification = 'pre' AND order_status = 'pending'")->result();
			if (count($res) > 0){
				foreach ($res as $key => $order) {
					$order_id = $order->order_id;
					$is_open = $this->is_open_rest($order->rest_id,$order->type);
					if ($is_open){
						$this->sendNewOrderReservationNotification($dp_option,$order_id);
					}
				}
			}
		}
		function check_addon_plan(){
			$resturants = $this->db->where("addon_ids <> ''")->get("tbl_restaurant_details")->result();
			foreach ($resturants as $rkey => $rvalue) {
				$addon_ids_arr = explode(",",$rvalue->addon_ids);
				foreach ($addon_ids_arr as $akey => $avalue) {
					$card_info = $this->db->where("rest_id",$rvalue->restaurant_id)->where("addon_id",$avalue)->row();
					
					try {
						$exp_date = explode("/", $expiry);
						$exp_month = str_replace(' ', '', $exp_date[0]);
						$exp_year = str_replace(' ', '', $exp_date[1]);
						if (strlen($exp_year) == 2) {
							$exp_year += 2000;
						}
						// create token for customer/buyer credit card
						$token = \Stripe\Token::create(
							array(
								"card" => array(
									'number' => $card_number, 
									'cvc' => $cvc, 
									'exp_month' => $exp_month, 
									'exp_year' => $exp_year, 
									'name' => $first_name . ' ' . $last_name)
								)
							);
					
						$stripe = \Stripe\Charge::create ([
							"amount" => intval($data["total"]),
							"currency" => $currency_code,
							"source" => $token,
							"description" => "Restopage Addon Plan",
						]);
						$this->db->where("id",$addon_invoice_id)->update("tbl_addon_invoices",$update_data);
						$desc = json_decode($addon->addon_title)->value . $addon->addon_id;
						$transactionId = isset($stripe['id']) ? $stripe['id'] : '';
						$update_data = array(
							"status"	=>	"paid",
							"currency"	=>	$currency_code,
							"description"	=>	$desc,
							"transaction_id"	=>	$transactionId,
						);

						$card_info = array(
							"email"	=>	$card_email,
							"card_number"	=>	$card_number,
							"card_expiry"	=>	$expiry,
							"card_cvc"	=>	$cvc,
							"addon_id"	=>	$addon->addon_id,
							"rest_id"	=>	$rest_id,
						);

						$this->db->insert("tbl_restaurant_stripe_info",$card_info);
						$stripe_info_res = $this->db->insert_id();
						// 	$charge = \Stripe\Charge::create(array('amount' => $amount, 'currency' => $this->stripe_storecurrency, 'card' => $token, 'capture' => STRIPE_TRANSACTION_MODE, 'statement_descriptor' => 'Order#' . $wc_order->get_order_number(), 'metadata' => array('Order #' => $wc_order->get_order_number(), 'Total Tax' => $wc_order->get_total_tax(), 'Total Shipping' => $wc_order->get_total_shipping(), 'WP customer #' => $wc_order->user_id, 'Billing Email' => $wc_order->billing_email), 'receipt_email' => $wc_order->billing_email, 'description' => get_bloginfo('blogname') . ' Order #' . $wc_order->get_order_number(), 'shipping' => array('address' => array('line1' => $wc_order->shipping_address_1, 'line2' => $wc_order->shipping_address_2, 'city' => $wc_order->shipping_city, 'state' => $wc_order->shipping_state, 'country' => $wc_order->shipping_country, 'postal_code' => $wc_order->shipping_postcode), 'name' => $wc_order->shipping_first_name . ' ' . $wc_order->shipping_last_name, 'phone' => $wc_order->billing_phone)));
						// }
						die(json_encode(array("status"=>$res,"token"=>$token,"stripe_info_res" =>$stripe_info_res)));
					} catch (Exception $e) {
						die(json_encode(array("status"=>false,"error"=>$e)));
					}
				}
			}
		}
		public function send_order_status_email_to_user($order_id,$order_status){
			if ($order = $this->db->where("order_id",$order_id)->get("tbl_orders")->row()){
				if ($order_status == "accepted"){
					$time_duration_sentence = "It will take for ".($order->order_duration_time > 0 ? $order->order_duration_time."min(s)" : "ASAP for ") . ($order->order_type == "delivery" ? " delivery " : "takeaway" ); 
				}
				if ($customer = $this->db->where("customer_id",$order->order_customer_id)->get("tbl_customers")->row()){
					$email = $customer->customer_email;
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
																								style="maring-top: 30px;font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																								valign="top">
																								Hi Client. <br>
																								We would like to inform that your order <em>"Menu-'.$order_id.'"</em> is <b><u>'.$order_status.'</u></b>.<br>
																								'.$time_duration_sentence.'.
																						</td>
																					</tr>
																			</table>
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
					$this->email->subject("Order is ".$order_status);
					$this->email->message($message);
					return  $this->email->send();
				}
			}
			return false;
		}
		public function send_order_email_to_user($register_user_id,$order_id){
			$order = $this->db->where("order_id",$order_id)->get("tbl_orders")->row();
			$customer = $this->db->where("customer_id",$register_user_id)->get("tbl_customers")->row();
			$email = $customer->customer_email;

			$cart = $this->session->userdata('shopping_cart');
			$stripe = $this->session->userdata('shopping_cart_stripe');

			$tres = ''; 
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
			$rest = $this->db->where("restaurant_id",$cart['shopping_cart']['rest_id'])->get('tbl_restaurant_details')->row();
			$rest_currency_symbol = $order->order_currency;
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
							$item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name . "</span> : ".$rest_currency_symbol." " . $extra_price  . "<br>";
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
						<td> ".$rest_currency_symbol." ". number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ."</td>
					</tr>";
				}else{
				}
			}

			$delivery_tax_str = "
				<tr>
					<td><strong>Delivery Tax ( ".$rest->delivery_tax."% )</strong></td>
					<td> ".$rest_currency_symbol." ".number_format($cart['shopping_cart']['shipping'] * $rest->delivery_tax /100 ,2,".",",")." </td>
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
			}else{
				$shipping_str = $tax_str;
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
			$rest = $this->db->where("restaurant_id",$cart['shopping_cart']['rest_id'])->get('tbl_restaurant_details')->row();
			$rest_currency_symbol = $order->order_currency;
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
							$item_extra_str .= "<span class='wishlist-food-extra' data-extra-id='".$extra_food->extra_id."'>". $extra_name . "</span> : ".$rest_currency_symbol." " . $extra_price  . "<br>";
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
						<td> ".$rest_currency_symbol." ". number_format(floatval($tax->tax_percentage) * floatval($tax_food_value) / 100, 2, '.', ' ') ."</td>
					</tr>";
				}else{

				}
			}

			$delivery_tax_str = "
				<tr>
					<td><strong>Delivery Tax ( ".$rest->delivery_tax."% )</strong></td>
					<td> ".$rest_currency_symbol." ".number_format($cart['shopping_cart']['shipping'] * $rest->delivery_tax /100 ,2,".",",")." </td>
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
			}else{
				$shipping_str = $tax_str;
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
																					<td><strong> Subtotal ( incl Tax )</strong></td>
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
		public function updatedDeliveryAreaDetail(){
			$area_name = "";
			if (null !== $this->input->post('areaname_english') && "" !== trim($this->input->post('areaname_english'))){
				$area_name_english = trim($this->input->post('areaname_english'));
				$area_name = $area_name_english;
			}else{
				$area_name_english="";
			}

			if (null !== $this->input->post('areaname_germany') && "" !== trim($this->input->post('areaname_germany'))){
				$area_name_germany = trim($this->input->post('areaname_germany'));
				$area_name = $area_name_germany;
			}else{
				$area_name_germany="";
			}

			if (null !== $this->input->post('areaname_french') && "" !== trim($this->input->post('areaname_french'))){
				$area_name_french = trim($this->input->post('areaname_french'));
				$area_name = $area_name_french;
			}else{
				$area_name_french="";
			}

			$data=array(
				"area_country"						=>	$this->input->post("country_for_postcode"),
				"area_name"							=>	$area_name,
				"area_name_french"					=>	$area_name_french,
				"area_name_germany"					=>	$area_name_germany,
				"area_name_english"					=>	$area_name_english,
				"post_code"							=>  $this->input->post("postcode"),
				"min_order_amount"					=>  $this->input->post("minimum_order_amount"),
				"delivery_time"						=>  $this->input->post("delivery_time"),
				"delivery_charge"					=>  $this->input->post("delivery_charge"),
				"min_order_amount_free_delivery"	=>  $this->input->post("min_order_amount_free_delivery"),
				"status"							=>  $this->input->post("status"),
			);			
			$condition = array(
				"id" => $this->input->post("area_id")
			);
			die(json_encode(array("status"=>$this->MODEL->update_AreaDetail($condition,$data))));
		}
		public function updatePaymentSetting(){
			$payment_method = "";
			if ($this->input->post("payment_method_stripe") == 'on'){
				$payment_method .= "s";
			}
			if ($this->input->post("payment_method_paypal") == 'on'){
				$payment_method .= "p";
			}
			if ($this->input->post("payment_method_cash") == 'on'){
				$payment_method .= "c";
			}
			if ($this->input->post("payment_method_creditcard_door") == 'on'){
				$payment_method .= "d";
			}
			// $this->input->post("payment_method_stripe");
			$data=array(
				"stripe_public_key"					=>	$this->input->post("stripe_public_key"),
				"stripe_secret_key"					=>	$this->input->post("stripe_secret_key"),
				"paypal_api_username"				=>	$this->input->post("paypal_username"),
				"paypal_api_password"				=>	$this->input->post("paypal_password"),
				"paypal_api_signature"				=>  $this->input->post("paypal_signature"),
				"payment_method"					=>  $payment_method,
				"rest_id" 							=>  $this->input->post("rest_id"),
			);	
			die(json_encode(array("status"=>$this->MODEL->savePaymentSetting($data,$this->input->post("rest_id")))));
		}
		public function saveOpeningTimeSetting(){

			$rest_id = $this->input->post('rest_id');
			$delivery_hours = array();
			$pickup_hours = array();
			$holidays = "";
			$irregular_openings = "";
			$pt_arr = array();
			$dt_arr = array();
			$ot_arr = array();
			for ($i=0; $i < 7; $i++) { 
				if (isset($this->input->post('delivery-opening-hours')[$i])){
					$dt = $this->input->post('delivery-opening-hours')[$i];
					$dt_arr = array();
					foreach ($dt["start"] as $dkey => $dstart) {
						if (($dt["start"][$dkey] == "" && $dt["end"][$dkey] == "") || ($dt["start"][$dkey] == "00:00" && $dt["end"][$dkey] == "00:00")){
						}else{
							$dt_arr[] =array(
								"start"=> $dt["start"][$dkey], 
								"end"=> $dt["end"][$dkey]
								) ;
						}
					}
				}else{
					$dt_arr = array();
				}
				$delivery_hours[] = $dt_arr;

				if (isset($this->input->post('pickup-opening-hours')[$i])){
					$pt = $this->input->post('pickup-opening-hours')[$i];
					$pt_arr = array();
					foreach ($pt["start"] as $pkey => $pstart) {
						if (($pt["start"][$pkey] == "" && $pt["end"][$pkey] == "") || ($pt["start"][$pkey] == "00:00" && $pt["end"][$pkey] == "00:00")){
						}else{	
						$pt_arr[] =array(
							"start"=> $pt["start"][$pkey], 
							"end"=> $pt["end"][$pkey]
							) ;
						}
					}
				}else{
					$pt_arr = array();
				}
				$pickup_hours[] = $pt_arr;

				if (isset($this->input->post('rest-opening-hours')[$i])){
					$ot = $this->input->post('rest-opening-hours')[$i];
					$ot_arr = array();
					foreach ($ot["start"] as $okey => $ostart) {
						if (($ot["start"][$okey] == "" && $ot["end"][$okey] == "") || ($ot["start"][$okey] == "00:00" && $ot["end"][$okey] == "00:00")){
						}else{	
						$ot_arr[] =array(
							"start"=> $ot["start"][$okey], 
							"end"=> $ot["end"][$okey]
							) ;
						}
					}
				}else{
					$ot_arr = array();
				}
				$opening_hours[] = $ot_arr;
			}
			$data=array(
				"rest_id"				=>	$rest_id,
				"delivery_hours"		=>	json_encode($delivery_hours),
				"pickup_hours"			=>	json_encode($pickup_hours),
				"opening_hours"			=>	json_encode($opening_hours),
				"holidays"				=>	json_encode($this->input->post('opening-hours-holidays')),
				"irregular_openings"	=>	json_encode($this->input->post('opening-hours-irregular-openings')),
			);	
			$tmp  =  json_encode($delivery_hours);
			die(json_encode(array("tmp"=>$tmp,"status"=>$this->MODEL->saveOpeningTimeSetting($data,$rest_id))));
		}

		public function updateAllergen(){
			$condition=array("allergen_id"=>$this->input->post('allergen_id'));
			$allergen_name ="";
			if (null !== $this->input->post('allergen_name_english') && trim($this->input->post('allergen_name_english')) !== ""){
				$allergen_name_english = trim($this->input->post('allergen_name_english'));
				$allergen_name = $allergen_name_english;
			}else{
				$allergen_name_english = "";
			}

			if (null !== $this->input->post('allergen_name_germany') && trim($this->input->post('allergen_name_germany')) !== ""){
				$allergen_name_germany = trim($this->input->post('allergen_name_germany'));
				$allergen_name = $allergen_name_germany;
			}else{
				$allergen_name_germany = "";
			}

			if (null !== $this->input->post('allergen_name_french') && trim($this->input->post('allergen_name_french')) !== ""){
				$allergen_name_french = trim($this->input->post('allergen_name_french'));
				$allergen_name = $allergen_name_french;
			}else{
				$allergen_name_french = "";
			}
			$toUpdate=array(
				"allergen_name_germany"		=>		$allergen_name_germany,
				"allergen_name_english"		=>		$allergen_name_english,
				"allergen_name_french"		=>		$allergen_name_french,
				"allergen_name"				=>		$allergen_name,
			);
			die(json_encode(array("status"=>$this->MODEL->update_Allergen($condition,$toUpdate))));
		}
		public function updateExtraCategory(){
			$condition=array("extra_category_id"=>$this->input->post('cat_id'));
			$category_name ="";
			if (null !== $this->input->post('cat_name_english') && trim($this->input->post('cat_name_english')) !== ""){
				$category_name_english = trim($this->input->post('cat_name_english'));
				$category_name = $category_name_english;
			}else{
				$category_name_english = "";
			}

			if (null !== $this->input->post('cat_name_germany') && trim($this->input->post('cat_name_germany')) !== ""){
				$category_name_germany = trim($this->input->post('cat_name_germany'));
				$category_name = $category_name_germany;
			}else{
				$category_name_germany = "";
			}

			if (null !== $this->input->post('cat_name_french') && trim($this->input->post('cat_name_french')) !== ""){
				$category_name_french = trim($this->input->post('cat_name_french'));
				$category_name = $category_name_french;
			}else{
				$category_name_french = "";
			}
			$toUpdate=array(
				"extra_category_name_germany"		=>		$category_name_germany,
				"extra_category_name_english"		=>		$category_name_english,
				"extra_category_name_french"		=>		$category_name_french,
				"extra_category_name"				=>		$category_name,
				"is_multi_select"					=>		$this->input->post('is_multi_select'),
				"extra_category_sort_index"			=>		$this->input->post('category_sort_index'),
			);
			die(json_encode(array("status"=>$this->MODEL->update_ExtraCategory($condition,$toUpdate))));
		}
		public function updateCategory(){
			$condition=array("category_id"=>$this->input->post('cat_id'));
			$category_name ="";
			$category_description ="";
			if (null !== $this->input->post('cat_name_english') && trim($this->input->post('cat_name_english')) !== ""){
				$category_name_english = trim($this->input->post('cat_name_english'));
				$category_name = $category_name_english;
			}else{
				$category_name_english = "";
			}

			if (null !== $this->input->post('cat_name_germany') && trim($this->input->post('cat_name_germany')) !== ""){
				$category_name_germany = trim($this->input->post('cat_name_germany'));
				$category_name = $category_name_germany;
			}else{
				$category_name_germany = "";
			}

			if (null !== $this->input->post('cat_name_french') && trim($this->input->post('cat_name_french')) !== ""){
				$category_name_french = trim($this->input->post('cat_name_french'));
				$category_name = $category_name_french;
			}else{
				$category_name_french = "";
			}

			if (null !== $this->input->post('cat_description_english') && trim($this->input->post('cat_description_english')) !== ""){
				$category_description_english = trim($this->input->post('cat_description_english'));
				$category_description = $category_description_english;
			}else{
				$category_description_english = "";
			}

			if (null !== $this->input->post('cat_description_germany') && trim($this->input->post('cat_description_germany')) !== ""){
				$category_description_germany = trim($this->input->post('cat_description_germany'));
				$category_description = $category_description_germany;
			}else{
				$category_description_germany = "";
			}

			if (null !== $this->input->post('cat_description_french') && trim($this->input->post('cat_description_french')) !== ""){
				$category_description_french = trim($this->input->post('cat_description_french'));
				$category_description = $category_description_french;
			}else{
				$category_description_french = "";
			}
			$toUpdate=array(
				"category_name_germany"		=>		$category_name_germany,
				"category_name_english"		=>		$category_name_english,
				"category_name_french"		=>		$category_name_french,
				"category_name"				=>		$category_name,
				"category_description_germany"		=>		$category_description_germany,
				"category_description_english"		=>		$category_description_english,
				"category_description_french"		=>		$category_description_french,
				"category_description"				=>		$category_description,
				"category_sort_index"		=>		$this->input->post('category_sort_index'),
			);
			$iuF = false;
			if (file_exists($_FILES['category_image']['tmp_name']) || is_uploaded_file($_FILES['category_image']['tmp_name'])){
				$imageArray=pathinfo($_FILES['category_image']['name']);
				$source_img = $_FILES['category_image']['tmp_name'];
				$imageName = 'Top-Resto-Menu-Item-Imag-'.date('dmyhis').'.'.$imageArray['extension'];
				$destination_img='assets/category_images/'.$imageName;
				// $d = compress($source_img, $destination_img, 90);
				// $condition=array("restaurant_id"=>$sessData[0]->rest_id);
				$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
				if (isset($fileUploadingSetting)){
					$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
					$max_width = $fileUploadingSetting->category->max_width;
					$max_height = $fileUploadingSetting->category->max_height;
					$compression = $fileUploadingSetting->category->compression;
				} else{
					$max_width = 0;
					$max_height = 0;
					$compression = 80;
				}
				$this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false);
				$toUpdate['category_image'] = $imageName;
				$iuF = true;
			}else{
				if ($this->input->post('is_category_image')){
					$iuF = true;
					$toUpdate['category_image'] = '';
				}
			}

			if ($iuF){
				if ($old_image = $this->db->where($condition)->get("tbl_category")->row()->category_image){
					if (file_exists(APPPATH."../assets/category_images/".$old_image)){
						unlink(APPPATH."../assets/category_images/".$old_image);
					}
				}
			}
			die(json_encode(array("status"=>$this->MODEL->update_Category($condition,$toUpdate))));
		}
		public function updateSubCategory(){
			$condition	=	array("sub_cat_id"=>$this->input->post('subcat_id'));
			$sub_category_name = "";
			if (null !== $this->input->post('sub_cat_name_english') && "" !== trim($this->input->post('sub_cat_name_english'))){
				$sub_category_name_english = trim($this->input->post('sub_cat_name_english'));
				$sub_category_name = $sub_category_name_english;
			}else{
				$sub_category_name_english="";
			}

			if (null !== $this->input->post('sub_cat_name_germany') && "" !== trim($this->input->post('sub_cat_name_germany'))){
				$sub_category_name_germany = trim($this->input->post('sub_cat_name_germany'));
				$sub_category_name = $sub_category_name_germany;
			}else{
				$sub_category_name_germany="";
			}

			if (null !== $this->input->post('sub_cat_name_french') && "" !== trim($this->input->post('sub_cat_name_french'))){
				$sub_category_name_french = trim($this->input->post('sub_cat_name_french'));
				$sub_category_name = $sub_category_name_french;
			}else{
				$sub_category_name_french="";
			}
			$toUpdate	=	array(
				"sub_category_name_english"		=>	$sub_category_name_english,
				"sub_category_name_french"		=>	$sub_category_name_french,
				"sub_category_name_germany"		=>	$sub_category_name_germany,
				"sub_category_name"				=>	$sub_category_name,
			);
			die(json_encode(array("status"=>$this->MODEL->update_subCategory($condition,$toUpdate))));
		}
		public function updateFoodExtra(){
			$condition	=	array("extra_id"=>$this->input->post('foodExtra_id'));
			$food_extra_name = "";
			if (null !== $this->input->post('food_extra_name_english') && "" !== trim($this->input->post('food_extra_name_english'))){
				$food_extra_name_english = trim($this->input->post('food_extra_name_english'));
				$food_extra_name = $food_extra_name_english;
			}else{
				$food_extra_name_english="";
			}

			if (null !== $this->input->post('food_extra_name_germany') && "" !== trim($this->input->post('food_extra_name_germany'))){
				$food_extra_name_germany = trim($this->input->post('food_extra_name_germany'));
				$food_extra_name = $food_extra_name_germany;
			}else{
				$food_extra_name_germany="";
			}

			if (null !== $this->input->post('food_extra_name_french') && "" !== trim($this->input->post('food_extra_name_french'))){
				$food_extra_name_french = trim($this->input->post('food_extra_name_french'));
				$food_extra_name = $food_extra_name_french;
			}else{
				$food_extra_name_french="";
			}
			$toUpdate	=	array(
				"food_extra_name_english"		=>	$food_extra_name_english,
				"food_extra_name_french"		=>	$food_extra_name_french,
				"food_extra_name_germany"		=>	$food_extra_name_germany,
				"food_extra_name"				=>	$food_extra_name,
			);
			die(json_encode(array("status"=>$this->MODEL->update_foodExtra($condition,$toUpdate))));
		}

		public function getExtraList(){
			die(json_encode(array("data"=>$this->MODEL->get_foodExtraList($this->input->post('item_id'),$this->input->post('price_index')))));
		}
		public function removeRestaurant(){
			die(json_encode(array("status"=>$this->MODEL->remove_Restaurant($this->input->post('rest_id')))));
		}
		public function getAllSubCategory(){
			die(json_encode(array("data"=>$this->MODEL->getAllSubcate($this->input->post('category_id')))));
		}
		public function getCategoryFoodExtra(){
			die(json_encode(array("data"=>$this->MODEL->getCategoryFoodExtra($this->input->post('category_id')))));
		}
		public function getAllCategory(){
			die(json_encode(array("data"=>$this->MODEL->getAllCategory($this->input->post('cat_type_id')))));
		}
		public function getAllMenuItem(){
			$sort_direct = $this->input->post('sort_direction') == "DESC" ? "DESC" : "ASC";
			die(json_encode(array("data"=>$this->MODEL->getAllMenuItem_($this->input->post('rest_id'),$this->input->post('lang'),$sort_direct))));
		}
		public function getAllMenuItem_I(){
			$sort_direct = $this->input->post('sort_direction') == "DESC" ? "DESC" : "ASC";
			die(json_encode(array("data"=>$this->MODEL->getAllMenuItem($this->input->post('rest_id'),$this->input->post('lang'),$sort_direct))));
		}
		public function getAllMenuItem_deactive(){
			$sort_direct = $this->input->post('sort_direction') == "DESC" ? "DESC" : "ASC";
			die(json_encode(array("data"=>$this->MODEL->getAllMenuItem_deactive($this->input->post('rest_id'),$this->input->post('lang'),$sort_direct))));
		}
		public function getAllMenuItemByCatId(){
			die(json_encode(array("data"=>$this->MODEL->getAllMenuItem_ByCatId($this->input->post('rest_id'),$this->input->post('dp_option'),$this->input->post('lang'),$this->input->post('category_id')))));
		}
		public function changeSortIndex(){
			$res1 = true; 
			$res2 = true; 
			$res3 = true;
			
			$src_item_id = $this->input->post("src_item_id");
			$target_item_id = $this->input->post("target_item_id");
			$target_item = $this->db->where("menu_id",$target_item_id)->get("tbl_menu_card")->row();
			$src_item = $this->db->where("menu_id",$src_item_id)->get("tbl_menu_card")->row();
			if ($src_item){
				$rest_id = $src_item->rest_id;
				$category_id = $src_item->category_id;
				if ($target_item && isset($target_item->item_sort_index)){
					$target_item_sort_index = $target_item->item_sort_index;
				}else{
					$target_item_sort_index = 0;
				}
	
				if ($src_item && isset($src_item->item_sort_index)){
					$src_item_sort_index = $src_item->item_sort_index;
				}else{
					$src_item_sort_index = 0;
				}
				if ($target_item_id > 0){
					if ($target_item_sort_index > $src_item_sort_index){
						$this->db->trans_start();
						$res1 = $this->db->query("UPDATE tbl_menu_card SET item_sort_index = item_sort_index-1 WHERE item_sort_index > $src_item_sort_index AND item_sort_index < $target_item_sort_index AND rest_id = $rest_id AND category_id = $category_id ");
						$res2 = $this->db->query("UPDATE tbl_menu_card SET item_sort_index = $target_item_sort_index WHERE menu_id = $src_item_id ");
						$res3 = $this->db->query("UPDATE tbl_menu_card SET item_sort_index = $target_item_id-1 WHERE menu_id = $target_item_id ");
						$this->db->trans_complete(); 
					}else{
						$this->db->trans_start();
						$res1 = $this->db->query("UPDATE tbl_menu_card SET item_sort_index = item_sort_index+1 WHERE item_sort_index < $src_item_sort_index AND item_sort_index > $target_item_sort_index AND rest_id = $rest_id AND category_id = $category_id ");
						$res2 = $this->db->query("UPDATE tbl_menu_card SET item_sort_index = $target_item_sort_index+1 WHERE menu_id = $src_item_id ");
						$this->db->trans_complete();
						$res3 = true; 
					}
				}else{
					$this->db->trans_start();
					$res1 = $this->db->query("UPDATE tbl_menu_card SET item_sort_index = item_sort_index+1 WHERE item_sort_index < $src_item_sort_index AND rest_id = $rest_id AND category_id = $category_id ");
					$res2 = $this->db->query("UPDATE tbl_menu_card SET item_sort_index = 1 WHERE menu_id = $src_item_id ");
					$this->db->trans_complete();
					$res3 = true; 
				}
				$res = $res1 && $res2 && $res3;
				die(json_encode(array("status" => $res  )));
			}else{
				die(json_encode(array("status"=>0)));
			}
		}
		public function resLoginValidate(){
			$data=array(
				"rest_email"=>$this->input->post('rest_email'),
				"rest_pass"=>md5(trim($this->input->post('rest_pass',TRUE))),
				// "rest_pass"=>$this->input->post('rest_pass')
			);
			$res=$this->MODEL->getRestLoginValidate($data);
			if($res!=false){
				// print_r($res);
				$sessData=serialize($res);
				$this->session->set_userdata('rest_user_Data',$sessData);
				// modify by Jfrost
				// $this->session->set_userdata('site_lang',"english");
				// ----------------
			}else{
				$this->session->set_flashdata('msg','<div class="alert alert-danger">'.$this->lang->line("Your Email or Password is invalid").'.</div>');
				redirect(base_url('Home'));
			}
			redirect('Restaurant');
		}

		public function adminLoginValidate(){
			$data=array(
				"admin_email"=>$this->input->post('admin_email'),
				"admin_pass"=>$this->input->post('admin_pass')
			);
			$res=$this->MODEL->getAdminLoginValidate($data);
			if($res!=false){
				$sessData=serialize($res);
				$this->session->set_userdata('admin_user_Data',$sessData);
			}else{
			}
			redirect('Admin/Dashboard/');
		}
		public function removeMenuItem(){
			// print_r($_POST);
			die(json_encode(array("status"=>$this->MODEL->remove_menuItem($this->input->post('menuId')))));
		}
		public function duplicateMenuItem(){
			$menuId = $this->input->post("menuId");
			$columns = $this->db->query("SHOW COLUMNS FROM `tbl_menu_card`")->result();
			$field_names = array();
			foreach ($columns as $ckey => $cvalue) {
				if ($cvalue->Field !== "menu_id"){
					$field_names[] = $cvalue->Field; 
				}
			}
			$field_name_str = implode(",",$field_names);
			
			$res = $this->db->query("INSERT INTO tbl_menu_card ($field_name_str) SELECT $field_name_str FROM tbl_menu_card	WHERE menu_id = $menuId");
			$new_item_id = $this->db->insert_id();
			die(json_encode(array("status"=>$res , "new_item_id"=>$new_item_id)));
		}
		public function saveUserAddress(){
			die(json_encode(array("status"=>1)));
		}
		public function getAllMenuItemByCategory(){
			$category_id=$this->input->post('category_id');
			if($category_id!=0){
			$rest_id=$this->input->post('rest_id');
			// die;
			die(json_encode(array("data"=>$this->MODEL->getAllMenuItemCategory_($category_id,$rest_id))));
			}else{
			    die(json_encode(array("data"=>$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row())));
			}
		}
		public function getAllMenuItemByCategory_(){
			$category_id=$this->input->post('category_id');
			if($category_id!=0){
				$rest_id=$this->input->post('rest_id');
				$lang=$this->input->post('lang');
				$dp_option=$this->input->post('dp_option');
				// die;
				die(json_encode(array("data"=>$this->MODEL->getAllMenuItemCategory__($category_id,$rest_id,$dp_option,$lang))));
			}else{
			    die(json_encode(array("data"=>$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row())));
			}
		}
		
		public function get_saveZipcode(){
			$componentForm = array(
				"street_number" => 'short_name',
				"route" => 'long_name',
				"locality" => 'long_name',
				"neighborhood" => 'long_name',
				"administrative_area_level_1" => 'long_name',
				"administrative_area_level_2" => 'long_name',
				"administrative_area_level_3" => 'long_name',
				"country" => 'long_name',
				"postal_code" => 'short_name',
				"political" => 'short_name'
			);
			$address = $this->input->post("get_address");
			$rest_url_slug = $this->input->post("rest_name_slug");

			$rest = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row();
			$rest_id = isset($rest) ? $rest->rest_id : 0;
			
			$by_zone = false;
			$by_zipcode = false;
			$customer_info = array();
			$detailed_address = array();
			$nF = 0;
			if(!empty($address)){
				$addressComponents = $this->getZipcode($address);
				foreach($addressComponents as $addrComp){
					$addressType = $addrComp->types[0];
					if (in_array($addressType,$componentForm)){
						$vp = $componentForm[$addressType];
						$detailed_address[$addressType]  = $addrComp->$vp;
					}
					if ($addressType == 'street_number' || $addressType == 'route'){
						$nF++;		
					}
					if($addressType == 'postal_code'){
						$res = $addrComp->long_name;
					}
				}
				if ($nF > 1){
					$customer_info['detailed_address'] = $detailed_address;
					// $res = $this->getZipcode($address);
					if(!empty($res) && ($res !== 0)){
						$postcode_list = $this->db->where("rest_id = $rest_id and post_code = '$res' ")->get("tbl_delivery_areas")->row();
						if (isset($postcode_list)){
							$customer_info['address'] = $address;
							$customer_info['post_code'] = $res;
							$customer_info['filtered_by'] = "postcode";
							$customer_info['area'] = $postcode_list;
							$this->session->set_userdata('customer_info', $customer_info);
							$by_zipcode = true;
							die(json_encode(array("status"=>1,"data"=>$postcode_list)));
						}else{
							$by_zipcode = false;
						}
	
					}else{	
						// modify by jfrost ,must be commented in server
						// $customer_info['address'] = $address;
						// $customer_info['post_code'] = "";
						// $this->session->set_userdata('customer_info', $customer_info);
					}
					if (!$by_zipcode){
						$getcode = $this->getLatLng($address);
						if(!empty($getcode) && ($getcode !== 0)){
							$now_lat = $getcode['lat'];
							$now_lng = $getcode['lng'];
							$area_zones = $this->db->where("rest_id = $rest_id")->get("tbl_delivery_area_zones")->result();
							foreach ($area_zones as $akey => $avalue) {
								$zone_geo_data = json_decode($avalue->zone_geo_data);
								if ($avalue->zone_type == "circle"){
									$radius = $zone_geo_data->radius;
									$center_lat = $zone_geo_data->center->lat;
									$center_lng = $zone_geo_data->center->lng;
									if ($this->calculate_distance_on_map($now_lat,$now_lng,$center_lat,$center_lng ) <= $radius ){
										$by_zone = true;
										$customer_info['address'] = $address;
										$customer_info['geo_code'] =$getcode;
										$customer_info['area_zone'] =$avalue;
										$customer_info['filtered_by'] = "areazone";
										
										$this->session->set_userdata('customer_info', $customer_info);
										
										die(json_encode(array("data"=>$customer_info,"status"=>1,"zone_geo_data"=>$avalue->zone_geo_data)));
										break;
									}
								}else{
									foreach ($zone_geo_data as $zkey => $zvalue) {
										$vertices_x[] = $zvalue->lat;
										$vertices_y[] = $zvalue->lng;
									}
									if ($this->delivery_area_location_check($now_lat,$now_lng,$vertices_x,$vertices_y)){
										$by_zone = true;
										$customer_info['address'] = $address;
										$customer_info['geo_code'] =$getcode;
										$customer_info['filtered_by'] = "areazone";
										$customer_info['area_zone'] =$avalue;
										$this->session->set_userdata('customer_info', $customer_info);
	
										die(json_encode(array("data"=>$customer_info,"status"=>1,"zone_geo_data"=>$avalue->zone_geo_data)));
										break;
									}
								}
							}
						}
					}
				}else{
					die(json_encode(array("status"=>-1,"msg"=>"Should contain street and house number","data"=>$customer_info)));
				}
			}
			if (!$by_zipcode && !$by_zone){
				die(json_encode(array("status"=>0,"msg"=>"Not possible in both way","data"=>$customer_info)));
			}
		}
		public function getZipcode($address){
			if(!empty($address)){
				//Formatted address
				$formattedAddr = str_replace(' ','+',$address);
				//Send request and receive json data by address
				$geocodeFromAddr = $this->curl_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc'); 
				if ($geocodeFromAddr){
					$output1 = json_decode($geocodeFromAddr);
					$addressComponents = $output1->results[0]->address_components;
					return $addressComponents;
					// //Get latitude and longitute from json data
					// $latitude  = $output1->results[0]->geometry->location->lat; 
					// $longitude = $output1->results[0]->geometry->location->lng;
					// //Send request and receive json data by latitude longitute
					// $geocodeFromLatlon = $this->curl_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=true_or_false&key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc');
					// $output2 = json_decode($geocodeFromLatlon);
					// if(!empty($output2)){
					// 	$addressComponents = $output2->results[0]->address_components;
					// 	return $addressComponents;
					// 	// foreach($addressComponents as $addrComp){
					// 	// 	$addressType = $addrComp->types[0];
					// 	// 	if ($componentForm[$addressType]) {
					// 	// 		$val = $addrComp[$componentForm[$addressType]];
					// 	// 	}
					// 	// 	if($addressType == 'postal_code'){
					// 	// 		return $addrComp->long_name;
					// 	// 		// die(json_encode(array("data"=>$geocodeFromAddr,"status"=>1)));
					// 	// 	}
					// 	// }
					// 	return 0;
					// }else{
					// 	return 0;
					// }
				}else{
					return $geocodeFromAddr;
				}
			}else{
				return 0;   
			}
		}
		public function getLatLng($address){
			if(!empty($address)){
				//Formatted address
				$formattedAddr = str_replace(' ','+',$address);
				//Send request and receive json data by address
				$geocodeFromAddr = $this->curl_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc'); 
				// $geocodeFromAddr = $this->curl_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=Insingen,+Germany&sensor=true_or_false&key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc'); 
				if ($geocodeFromAddr){
					$output1 = json_decode($geocodeFromAddr);
					//Get latitude and longitute from json data
					$latitude  = $output1->results[0]->geometry->location->lat; 
					$longitude = $output1->results[0]->geometry->location->lng;
					return array(
						"lat"	=>	$latitude,
						"lng"	=>	$longitude
					);
				}else{
					return $geocodeFromAddr;
				}
			}else{
				return 0;   
			}
		}
		function delivery_area_location_check($lat,$lng,$vertices_x,$vertices_y){
			$longitude_x = $lat;  // x-coordinate of the point to test
			$latitude_y = $lng;   // y-coordinate of the point to test
			$points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
			if ($this->is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)){
				return true;  //"Is in polygon!"
			}else{
				return false; //"Is not in polygon";
			}
		}
		function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y){
			$i = $j = $c = 0;
			for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
				if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) && ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
					$c = !$c;
			}
			return $c;
		}
		function calculate_distance_on_map($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo){
			$theta    = $longitudeFrom - $longitudeTo;
			$dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
			$dist    = acos($dist);
			$dist    = rad2deg($dist);
			$miles    = $dist * 60 * 1.1515;
			
			// Convert unit and return distance
			$unit = "M";
			$unit = strtoupper($unit);
			if($unit == "K"){ // km
				return round($miles * 1.609344, 2);
			}elseif($unit == "M"){ // meters
				return round($miles * 1609.344, 2);
			}else{ // miles
				return round($miles, 2);
			}
		}
		function curl_get_contents($url){
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST, 1);                 
			curl_setopt($ch,CURLOPT_POSTFIELDS,'');
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,200);
			curl_setopt($ch,CURLOPT_TIMEOUT, 200);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			  'Content-Type: application/json'
			));
			$response = curl_exec($ch);
			curl_close($ch);

			return $response;
		}
		public function get_latlng_from_country(){
			$address = $this->input->post("country");
			//Formatted address
			$formattedAddr = str_replace(' ','+',$address);
			//Send request and receive json data by address
			$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc'); 
			$output1 = json_decode($geocodeFromAddr);
			//Get latitude and longitute from json data
			$latitude  = $output1->results[0]->geometry->location->lat; 
			$longitude = $output1->results[0]->geometry->location->lng;
			
			die(json_encode(array("status"=>1 , "latitude" => $latitude,"longitude" =>$longitude)));
		}
		public function addLogo(){
		    $sessData=unserialize($this->session->userdata('rest_user_Data'));
			// $sessData[0]->rest_id;
			$is_success_logo = false;
			$is_success_favicon = false;

			if (file_exists($_FILES["rest_logo"]['tmp_name']) || is_uploaded_file($_FILES["rest_logo"]['tmp_name'])){
				$imageArray=pathinfo($_FILES['rest_logo']['name']);
				$source_img = $_FILES['rest_logo']['tmp_name'];
				$imageName = 'Top-Resto-Rest-Logo-'.date('dmyhis').'.'.$imageArray['extension'];
				$destination_img='assets/rest_logo/'.$imageName;
				$data["rest_logo"] = $imageName;
				$is_success_logo = true;
			}
			
			if (file_exists($_FILES["rest_favicon"]['tmp_name']) || is_uploaded_file($_FILES["rest_favicon"]['tmp_name'])){
				$imageArray_=pathinfo($_FILES['rest_favicon']['name']);
				$source_img_ = $_FILES['rest_favicon']['tmp_name'];
				$imageName_ = 'Top-Resto-Rest-favicon-'.date('dmyhis').'.'.$imageArray_['extension'];
				$destination_img_='assets/rest_favicon/'.$imageName_;
				$data["rest_favicon"] = $imageName_;
				$is_success_favicon = true;
			}
				// $d = compress($source_img, $destination_img, 90);
			if ($is_success_favicon || $is_success_logo){
				
				$condition=array("restaurant_id"=>$sessData[0]->rest_id);
				$data["restaurant_id"] = $sessData[0]->rest_id;

				// if($this->compress($source_img, $destination_img, 80)){
				if($sessData[0]->rest_id == $this->input->post("rest_id") && ((!$is_success_logo || move_uploaded_file($source_img, $destination_img)) && (!$is_success_favicon || move_uploaded_file($source_img_, $destination_img_)))){
					if ($rest_detail =  $this->db->where("restaurant_id",$sessData[0]->rest_id)->get("tbl_restaurant_details")->row()){
						if ($is_success_logo && ($old_logo_url = $rest_detail->rest_logo)){
							if (file_exists(APPPATH."../assets/rest_logo/".$old_logo_url)){
								unlink(APPPATH."../assets/rest_logo/".$old_logo_url);
							}
						}
						if ($is_success_favicon && ($old_favicon_url = $rest_detail->rest_favicon)){
							if (file_exists(APPPATH."../assets/rest_favicon/".$old_favicon_url)){
								unlink(APPPATH."../assets/rest_favicon/".$old_favicon_url);
							}
						}
					}
					$response=$this->MODEL->addRestLogo($data,$condition);
					die(json_encode(array("status"=>$response)));
				}else{
					die(json_encode(array("status"=>0)));
				}
			}else{
				die(json_encode(array("status"=>1)));
			}
		}
		public function uploadBanners(){
		    $sessData=unserialize($this->session->userdata('rest_user_Data'));
			// $sessData[0]->rest_id;
			$is_success_delivery = false;
			$is_success_pickup = false;
			$is_success_table = false;

			if (file_exists($_FILES["delivery_banner"]['tmp_name']) || is_uploaded_file($_FILES["delivery_banner"]['tmp_name'])){
				$imageArray=pathinfo($_FILES['delivery_banner']['name']);
				$source_img = $_FILES['delivery_banner']['tmp_name'];
				$imageName = 'Top-Resto-delivery-banner-'.date('dmyhis').'.'.$imageArray['extension'];
				$destination_img='assets/rest_banner/'.$imageName;
				$data["delivery_banner_url"] = $imageName;
				$is_success_delivery = true;
			}
			
			if (file_exists($_FILES["pickup_banner"]['tmp_name']) || is_uploaded_file($_FILES["pickup_banner"]['tmp_name'])){
				$imageArray_=pathinfo($_FILES['pickup_banner']['name']);
				$source_img_ = $_FILES['pickup_banner']['tmp_name'];
				$imageName_ = 'Top-Resto-pickup-banner-'.date('dmyhis').'.'.$imageArray_['extension'];
				$destination_img_='assets/rest_banner/'.$imageName_;
				$data["pickup_banner_url"] = $imageName_;
				$is_success_pickup = true;
			}

			if (file_exists($_FILES["table_banner"]['tmp_name']) || is_uploaded_file($_FILES["table_banner"]['tmp_name'])){
				$imageArray__=pathinfo($_FILES['table_banner']['name']);
				$source_img__ = $_FILES['table_banner']['tmp_name'];
				$imageName__ = 'Top-Resto-table-banner-'.date('dmyhis').'.'.$imageArray__['extension'];
				$destination_img__='assets/rest_banner/'.$imageName__;
				$data["table_banner_url"] = $imageName__;
				$is_success_table = true;
			}
				// $d = compress($source_img, $destination_img, 90);
			if ($is_success_pickup || $is_success_delivery || $is_success_table){
				
				$condition=array("rest_id"=>$sessData[0]->rest_id);
				
				$data["rest_id"] = $sessData[0]->rest_id;
				// if($this->compress($source_img, $destination_img, 80)){
				$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
				if (isset($fileUploadingSetting)){
					$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
					$max_width = $fileUploadingSetting->food_menu_banner->max_width;
					$max_height = $fileUploadingSetting->food_menu_banner->max_height;
					$compression = $fileUploadingSetting->food_menu_banner->compression;
				} else{
					$max_width = 0;
					$max_height = 0;
					$compression = 80;
				}
				if( $sessData[0]->rest_id == $this->input->post("rest_id") && ((!$is_success_delivery || $this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false)) && (!$is_success_pickup || $this->compress($source_img_, $destination_img_, $compression,$max_width,$max_height,false)) && (!$is_success_table || $this->compress($source_img__, $destination_img__, $compression,$max_width,$max_height,false)))){

					if ($rest_banner =  $this->db->where("rest_id",$sessData[0]->rest_id)->get("tbl_banner_settings")->row()){
						if ($is_success_delivery && ($old_delivery_url = $rest_banner->delivery_banner_url)){
							if (file_exists(APPPATH."../assets/rest_banner/".$old_delivery_url)){
								unlink(APPPATH."../assets/rest_banner/".$old_delivery_url);
							}
						}
			
						if ($is_success_pickup && ($old_pickup_url = $rest_banner->pickup_banner_url)){
							if (file_exists(APPPATH."../assets/rest_banner/".$old_pickup_url)){
								unlink(APPPATH."../assets/rest_banner/".$old_pickup_url);
							}
						}
			
						if ($is_success_table && ($old_table_url = $rest_banner->table_banner_url)){
							if (file_exists(APPPATH."../assets/rest_banner/".$old_table_url)){
								unlink(APPPATH."../assets/rest_banner/".$old_table_url);
							}
						}
					}
					$response=$this->MODEL->addRestBanner($data,$condition);
					die(json_encode(array("status"=>$response)));
				}else{
					die(json_encode(array("status"=>0)));
				}
			}else{
				die(json_encode(array("status"=>1)));
			}
		}
		public function compress($source, $destination, $quality,$w = 0,$h = 0,$crop = false) {

		    $info = getimagesize($source);
			list($width, $height) = getimagesize($source);

			if ($w > 0 && $h > 0 && ($w < $width || $h < $height)){
				$nF = true;
				$r = $width / $height;
				if ($crop) {
					if ($width > $height) {
						$width = ceil($width-($width*abs($r-$w/$h)));
					} else {
						$height = ceil($height-($height*abs($r-$w/$h)));
					}
					$newwidth = $w;
					$newheight = $h;
				} else {
					if ($w/$h > $r) {
						$newwidth = $h*$r;
						$newheight = $h;
					} else {
						$newheight = $w/$r;
						$newwidth = $w;
					}
				}
			}else{
				$nF = false;
			}
				
				
			if ($info['mime'] == 'image/png') {
				if ($nF){
					$src= imagecreatefrompng($source);
					$dst = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

					$transparent = imagecolorallocatealpha($dst ,0,0,0,0);
					imagecolortransparent($dst,$transparent);
					imagepng($dst,$destination, $quality*0.09);
				}else{
					$image= imagecreatefrompng($source);
					$transparent = imagecolorallocatealpha($image ,0,0,0,127);
					imagecolortransparent($image,$transparent);
					imagepng($image,$destination, $quality*0.09);
				}
			}else{
				if ($nF){
					$src = imagecreatefromjpeg($source);
					$dst = imagecreatetruecolor($newwidth, $newheight);
					imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					imagejpeg($dst, $destination, $quality );
				}else{
					$image = imagecreatefromjpeg($source);
					imagejpeg($image, $destination, $quality);
				}
			}

		    return $destination;
		}
		public function updateResData(){
		   die(json_encode(array("data"=>$this->MODEL->updateRestDetails_($_POST))));
		}
		public function updateAnnouncement(){
			$rest_id = $this->input->post('rest_id');
			$content_english = $this->input->post('announcement_english');
			$content_french = $this->input->post('announcement_french');
			$content_germany = $this->input->post('announcement_germany');
			$content_bg_color = $this->input->post('announce_bg_color');
			$content_bg_color_alpha = $this->input->post('announce_bg_color_alpha');
			// $content_english = "eng";
			// $content_french = "fre";
			// $content_germany = "ger";
			$content = "";
			if (trim($content_english) !== ""){
				$content = trim($content_english);
			}
			if (trim($content_germany) !== ""){
				$content = trim($content_germany);
			}
			if (trim($content_french) !== ""){
				$content = trim($content_french);
			}
			$data = array(
				'content_english' 	=> $content_english,
				'content_germany' 	=> $content_germany,
				'content_french' 	=> $content_french,
				'content' 			=> $content,
				'rest_id' 			=> $rest_id,
				'content_bg_color'	=> $content_bg_color,
				'content_bg_color_alpha' 	=> $content_bg_color_alpha,
			);	
			if ($rest_id  == 0){
				$announcement_id = $this->input->post('announcement_id');
				if ($old_announc = $this->db->where('id',$announcement_id)->get('tbl_announcement')->row()){
					$res = $this->db->where('id',$announcement_id)->update('tbl_announcement' , $data);
				}else{
					$res = $this->db->insert('tbl_announcement' , $data);
				}
			}else{
				if ($old_announc = $this->db->where('rest_id',$rest_id)->get('tbl_announcement')->row()){
					$res = $this->db->where('rest_id',$rest_id)->update('tbl_announcement' , $data);
				}else{
					$res = $this->db->insert('tbl_announcement' , $data);
				}
			}
			die(json_encode(array("status"=>$res)));
		}
		public function AddAnnouncement(){
			$rest_id = $this->input->post('rest_id');
			$content_english = $this->input->post('announcement_english');
			$content_french = $this->input->post('announcement_french');
			$content_germany = $this->input->post('announcement_germany');
			$content_bg_color = $this->input->post('announce_bg_color');
			$content_bg_color_alpha = $this->input->post('announce_bg_color_alpha');
			// $content_english = "eng";
			// $content_french = "fre";
			// $content_germany = "ger";
			$content = "";
			if (trim($content_english) !== ""){
				$content = trim($content_english);
			}
			if (trim($content_germany) !== ""){
				$content = trim($content_germany);
			}
			if (trim($content_french) !== ""){
				$content = trim($content_french);
			}
			$data = array(
				'content_english' 	=> $content_english,
				'content_germany' 	=> $content_germany,
				'content_french' 	=> $content_french,
				'content' 			=> $content,
				'content_bg_color'	=> $content_bg_color,
				'content_bg_color_alpha' 	=> $content_bg_color_alpha,
				'rest_id' 			=> $rest_id,
			);	
			if ($rest_id == 0){
				$res = $this->db->insert('tbl_announcement' , $data);
			}else{
				$res = 0;
			}
			die(json_encode(array("status"=>$res)));
		}
		public function updateLegalSetting(){
			$rest_id = $this->input->post('rest_id');
			$imprint_page_content_french = $this->input->post('imprint_page_content_french');
			$imprint_page_content_english = $this->input->post('imprint_page_content_english');
			$imprint_page_content_germany = $this->input->post('imprint_page_content_germany');
			$data_protection_page_content_french = $this->input->post('data_protection_page_content_french');
			$data_protection_page_content_english = $this->input->post('data_protection_page_content_english');
			$data_protection_page_content_germany = $this->input->post('data_protection_page_content_germany');
			$tc_page_content_french = $this->input->post('tc_page_content_french');
			$tc_page_content_english = $this->input->post('tc_page_content_english');
			$tc_page_content_germany = $this->input->post('tc_page_content_germany');
			$cookie_note_french = $this->input->post('cookie_note_french');
			$cookie_note_english = $this->input->post('cookie_note_english');
			$cookie_note_germany = $this->input->post('cookie_note_germany');

			$imprint_page_content = "";
			if (trim($imprint_page_content_french) !== ""){
				$imprint_page_content = trim($imprint_page_content_french);
			}elseif (trim($imprint_page_content_germany) !== ""){
				$imprint_page_content = trim($imprint_page_content_germany);
			}else{
				$imprint_page_content = trim($imprint_page_content_english);
			}

			$data_protection_page_content = "";
			if (trim($data_protection_page_content_french) !== ""){
				$data_protection_page_content = trim($data_protection_page_content_french);
			}elseif (trim($data_protection_page_content_germany) !== ""){
				$data_protection_page_content = trim($data_protection_page_content_germany);
			}else{
				$data_protection_page_content = trim($data_protection_page_content_english);
			}

			$tc_page_content = "";
			if (trim($tc_page_content_french) !== ""){
				$tc_page_content = trim($tc_page_content_french);
			}elseif (trim($tc_page_content_germany) !== ""){
				$tc_page_content = trim($tc_page_content_germany);
			}else{
				$tc_page_content = trim($tc_page_content_english);
			}

			$cookie_note = "";
			if (trim($cookie_note_french) !== ""){
				$cookie_note = trim($cookie_note_french);
			}elseif (trim($cookie_note_germany) !== ""){
				$cookie_note = trim($cookie_note_germany);
			}else{
				$cookie_note = trim($cookie_note_english);
			}

			$data = array(
				'rest_id' 			=> $rest_id,
				'imprint_page_content' 					=> $imprint_page_content,
				'imprint_page_content_english' 			=> $imprint_page_content_english,
				'imprint_page_content_french' 			=> $imprint_page_content_french,
				'imprint_page_content_germany' 			=> $imprint_page_content_germany,
				'tc_page_content' 					=> $tc_page_content,
				'tc_page_content_english' 			=> $tc_page_content_english,
				'tc_page_content_french' 			=> $tc_page_content_french,
				'tc_page_content_germany' 			=> $tc_page_content_germany,
				'data_protection_page_content' 					=> $data_protection_page_content,
				'data_protection_page_content_english' 			=> $data_protection_page_content_english,
				'data_protection_page_content_germany' 			=> $data_protection_page_content_germany,
				'data_protection_page_content_french' 			=> $data_protection_page_content_french,
				'cookie_note' 					=> $cookie_note,
				'cookie_note_english' 			=> $cookie_note_english,
				'cookie_note_french' 			=> $cookie_note_french,
				'cookie_note_germany' 			=> $cookie_note_germany,
			);	
			$legal_row = $this->db->where("rest_id",$rest_id)->get("tbl_legal_settings")->row();
			if (!isset($legal_row)){
				$res = $this->db->insert('tbl_legal_settings' , $data);
			}else{
				$res = $this->db->where("rest_id",$rest_id)->update("tbl_legal_settings",$data);
			}
			die(json_encode(array("status"=>$res)));
		}

		public function updateLoyaltyPointSetting(){
			$rest_id = $this->input->post('rest_id');
			$point_status = $this->input->post("point_status");
			if ($point_status == "enable"){
				$earn_points_conversion_rate_points = $this->input->post("earn_points_conversion_rate_points");
				$redemption_conversion_rate_points = $this->input->post("redemption_conversion_rate_points");
				$earn_rounding_mode = $this->input->post("earn_rounding_mode");
				$expire_after = $this->input->post("expire_after");

				$data = array(
					'rest_id' 						=> $rest_id,
					'earn_conversion_rate' 			=> $earn_points_conversion_rate_points,
					'redemption_conversion_rate'    => $redemption_conversion_rate_points,
					'earn_rounding_mode' 			=> $earn_rounding_mode,
					'expire_after' 					=> $expire_after,
					'status'	 					=> "enable",
				);	
			}else{
				$data = array(
					'rest_id' 						=> $rest_id,
					'status'	 					=> "disable",
				);	
			}

			$old_row = $this->db->where("rest_id",$rest_id)->get("tbl_loyalty_point_settings")->row();

			if ($old_row){
				$res = $this->db->where("rest_id",$rest_id)->update("tbl_loyalty_point_settings",$data);
			}else{
				$res = $this->db->insert('tbl_loyalty_point_settings' , $data);
			}
			die(json_encode(array("status"=>$res)));
		}
		public function getItemBySearchKey(){
		   	$keyword = $this->input->post('keyword');
			$rest_id=$this->input->post('rest_id');
			$lang=$this->input->post('lang');
			$dp_option=$this->input->post('dp_option');
			// die(json_encode(array("data"=>$this->MODEL->getAllMenuItemKey_($key,$rest_id,$lang))));
			die(json_encode(array("data"=>$this->MODEL->getAllMenuItemKey($keyword,$rest_id,$dp_option,$lang))));
		}
		public function updateItemImage(){
			if (file_exists($_FILES['item_image']['tmp_name']) || is_uploaded_file($_FILES['item_image']['tmp_name'])){
				$imageArray=pathinfo($_FILES['item_image']['name']);
				$source_img = $_FILES['item_image']['tmp_name'];
				$imageName = 'Top-Resto-Menu-Item-Imag-'.date('dmyhis').'.'.$imageArray['extension'];
				$destination_img='assets/menu_item_images/'.$imageName;
				$toUpdatedata=array(
					"item_image"=>$imageName,
				);
				// $condition=array("restaurant_id"=>$sessData[0]->rest_id);
				if($this->compress($source_img, $destination_img,90)){
				// if(move_uploaded_file($source_img, $destination_img)){
					if ($item_detail =  $this->db->where('menu_id',$this->input->post('menu_id'))->get("tbl_menu_card")->row()){
						if (($old_img_url = $item_detail->item_image)){
							if (file_exists(APPPATH."../assets/menu_item_images/".$old_img_url)){
								unlink(APPPATH."../assets/menu_item_images/".$old_img_url);
							}
						}
					}
					$response=$this->db->where('menu_id',$this->input->post('menu_id'))->update('tbl_menu_card',$toUpdatedata);
					if($response){
					    die(json_encode(array("status"=>1)));
					}else{
					   die(json_encode(array("status"=>0)));
					}
				}else{
					// echo 'Failed to Upload';
					die(json_encode(array("status"=>0)));
				}
			}else{
				$toUpdatedata=array(
					"item_image"=>"",
				);
				$response=$this->db->where('menu_id',$this->input->post('menu_id'))->update('tbl_menu_card',$toUpdatedata);
				if($response){
					die(json_encode(array("status"=>1)));
				}else{
				   die(json_encode(array("status"=>0)));
				}
			}
		    	
		}
		// cart
		public function addCart(){
			$item_id = $this->input->post('item_id');
			$price_index = $this->input->post('price_index');
			$price_qty = $this->input->post('price_qty');
			$dp_option = $this->input->post('dp_option');
			if (strtolower($dp_option) == "delivery"){
				if (null == $this->session->userdata('customer_info')){
					die(json_encode(array("status"=>2)));
				}
			}

			if ($this->input->post('extra_ids')){
				$extra_id_str = $this->input->post('extra_ids') ;
				// $extra_id_str = $this->input->post('extra_id') !== null ? implode("|",$this->input->post('extra_id')) : "" ;
			}else{
				$extra_id_str = "";
			}
			
			$carts_array = array();
			$carts_array_new = array();
			$aF = false;
			if (null !== $this->input->cookie('jfrost_carts')){
				$carts_array = explode(",", $this->input->cookie("jfrost_carts"));

				foreach ($carts_array as $key => $value) {
					$each_item_info = explode(":", $value);
					$each_item_id = $each_item_info[0];
					$each_item_price_index = $each_item_info[1];
					$each_item_price_qty = $each_item_info[2];
					$each_item_extra_index = $each_item_info[3];
					if ($item_id == $each_item_id){
						if ($each_item_price_index == $price_index){
							if ($this->compare_extra_ids_arr($extra_id_str , $each_item_extra_index )){
								$each_item_price_qty = $each_item_price_qty + $price_qty;
								if ($each_item_price_qty > 0){
									// $carts_array_new[] = $each_item_id .":".$each_item_price_index.":".$each_item_price_qty.":".$each_item_extra_index;
									$carts_array_new[] = $each_item_id .":".$each_item_price_index.":".$each_item_price_qty.":".$extra_id_str;
								}
								$aF = true;
							}else{
								$carts_array_new[] =$value;
							}
						}else{
							$carts_array_new[] =$value;
						}
					}else{
						$carts_array_new[] =$value;
					}
				}
				if (!$aF && $price_qty > 0){
					$carts_array_new[] =  $item_id .":".$price_index.":".$price_qty.":".$extra_id_str;
				}
			}else{
				$carts_array_new[] =  $item_id .":".$price_index.":".$price_qty.":".$extra_id_str;
			}
			$carts = implode(",",$carts_array_new);

			$cookie = array(
				'name'   => 'carts',
				'value'  => $carts,
				'expire' => 60*60*2,
				'domain' => "",
				'prefix' => 'jfrost_',
			);
			$this->input->set_cookie($cookie);
			die(json_encode(array("status"=>1,"item_id"=>$item_id,"price_index"=>$price_index,"price_qty"=>$price_qty,"extra_id"=>$extra_id_str,"jfrost_cart"=>$cookie)));
		}
		public function allow_cookie(){
			$allow_cookie = $this->input->post("allow_cookie");
			$cookie = array(
				'name'   => 'allow_cookie',
				'value'  => $allow_cookie,
				'expire' => 60*60*24,
				'domain' => "",
				'prefix' => 'jfrost_',
			);
			$this->input->set_cookie($cookie);
			die(json_encode(array("status"=>1)));
		}
		
		function compare_extra_ids_arr($a_str, $b_str){
			$a_arr = explode("|",$a_str) ;
			$b_arr = explode("|",$b_str) ;
			$result=array_diff($a_arr,$b_arr);
			$result_=array_diff($b_arr,$a_arr);
			if (empty($result) && empty($result_)){
				return true;
			}else{
				return false;
			}
		}
		// wishlist
		public function addWishlist(){
			$item_id = $this->input->post('item_id');
			$price_index = $this->input->post('price_index');
			$price_qty = $this->input->post('price_qty');
			if ($this->input->post('extra_ids')){
				$extra_id_str = $this->input->post('extra_ids') ;
				// $extra_id_str = $this->input->post('extra_id') !== null ? implode("|",$this->input->post('extra_id')) : "" ;
			}else{
				$extra_id_str = "";
			}

			$wishlist_array = array();
			$wishlist_array_new = array();
			$aF = false;
			if (null !== $this->input->cookie('jfrost_wishlist')){
				$wishlist_array = explode(",", $this->input->cookie("jfrost_wishlist"));

				foreach ($wishlist_array as $key => $value) {
					$each_item_info = explode(":", $value);
					$each_item_id = $each_item_info[0];
					$each_item_price_index = $each_item_info[1];
					$each_item_price_qty = $each_item_info[2];
					$each_item_extra_index = $each_item_info[3];

					if ($item_id == $each_item_id){
						if ($each_item_price_index == $price_index){
							if ($this->compare_extra_ids_arr($extra_id_str , $each_item_extra_index )){
								$each_item_price_qty = $each_item_price_qty + $price_qty;
								if ($each_item_price_qty > 0){
									// $wishlist_array_new[] = $each_item_id .":".$each_item_price_index.":".$each_item_price_qty.":".$each_item_extra_index;
									$wishlist_array_new[] = $each_item_id .":".$each_item_price_index.":".$each_item_price_qty.":".$extra_id_str;
								}
								$aF = true;
							}else{
								$wishlist_array_new[] =$value;
							}
						}else{
							$wishlist_array_new[] =$value;
						}
					}else{
						$wishlist_array_new[] =$value;
					}
				}
				if (!$aF && $price_qty > 0){
					$wishlist_array_new[] =  $item_id .":".$price_index.":".$price_qty.":".$extra_id_str;
				}
			}else{
				$wishlist_array_new[] =  $item_id .":".$price_index.":".$price_qty.":".$extra_id_str;
			}
			$wishlist = implode(",",$wishlist_array_new);

			$cookie = array(
				'name'   => 'wishlist',
				'value'  => $wishlist,
				'expire' => 60*60*2,
				'domain' => "",
				'prefix' => 'jfrost_',
			);
			$this->input->set_cookie($cookie);
			die(json_encode(array("status"=>1,"item_id"=>$item_id,"price_index"=>$price_index,"price_qty"=>$price_qty,"extra_id"=>$extra_id_str)));
		}

		public function removeWishlist(){
			$item_id = $this->input->post('item_id');

			$wishlist_array = array();
			if (null !== $this->input->cookie('jfrost_wishlist')){
				$wishlist_array = explode(",", $this->input->cookie("jfrost_wishlist"));
				$key = array_search($item_id, $wishlist_array);
				if ($key !== false) {
					unset($wishlist_array[$key]);
				}
			}else{
			}

			$wishlist = implode(",",$wishlist_array);

			$cookie = array(
				'name'   => 'wishlist',
				'value'  => $wishlist,
				'expire' => 0,
				'domain' => "",
				'prefix' => 'jfrost_',
			);
			$this->input->set_cookie($cookie);
			die(json_encode(array("status"=>1)));
		}

		public function getwishlist(){
			$wishlist_array = array();
			$rest_id = $this->input->post("rest_id");
			if (null !== $this->input->cookie('jfrost_wishlist')){
				$wishlist_array = explode(",", $this->input->cookie("jfrost_wishlist"));
			}
			$wishlist = implode(",",$wishlist_array);
			die(json_encode(array("data"=>$wishlist)));
		}
		public function getwishlistIDs(){
			$wishlist_array = array();			
			if (null !== $this->input->cookie('jfrost_wishlist')){
				$wishlist_array = explode(",", $this->input->cookie("jfrost_wishlist"));
			}

			return $wishlist_array;
		}

		public function getwishlistAllMenuItem(){
			$wlist = $this->getwishlistIDs();
			$rest_id = $this->input->post("rest_id");
			$ail = array();
			$array_item_list = $this->db->query("select menu_id from tbl_menu_card where rest_id = $rest_id")->result();
			foreach ($array_item_list as $key => $value) {
				$ail[] = $value->menu_id;
			}
			$wishlist = array_intersect($ail,$wlist);
			$lang = $this->input->post("lang");
			die(json_encode(array("data"=>$this->MODEL->getWishListItems($wishlist,$lang))));
		}
		public function deleteItemImage(){
			$toUpdatedata=array(
				"item_image"=>"",
			);
			$response=$this->db->where('menu_id',$this->input->post('menu_id'))->update('tbl_menu_card',$toUpdatedata);
			if($response){
			    die(json_encode(array("status"=>1)));
			}else{
			   die(json_encode(array("status"=>0)));
			}
		}
		
		public function updateItemDetails(){

			$section_lang = $this->input->post('section_lang');
			if (null !== $this->input->post('item_price')){
				$pric=implode(',',$this->input->post('item_price'));
			}else{
				die(json_encode(array("status"=>0)));
				return;
			}

			$prices_title_array = array();
			$prices_title_english_array = $this->input->post('price_title_english');
			$prices_title_english = implode(",",$prices_title_english_array);

			$prices_title_french_array = $this->input->post('price_title_french');
			$prices_title_french = implode(",",$prices_title_french_array);

			$prices_title_germany_array = $this->input->post('price_title_germany');
			$prices_title_germany = implode(",",$prices_title_germany_array);

			$food_extra = $this->input->post('extra_id_english');
			$extra_price = $this->input->post('extra_price');
			$extra_cat_ids = $this->input->post('extra_cat_ids');
			$item_food_extra_arr = array();
			$item_food_extra_str = "";
			
			foreach ($prices_title_french_array as $key => $value) {
				if($value == ""){
					if($prices_title_germany_array[$key] == null || $prices_title_germany_array[$key] == ""){
						$val = $prices_title_english_array[$key];
					}else{
						$val = $prices_title_germany_array[$key];
					}
				}else{
					$val = $value;
				}
				$prices_title_array[$key] = $val;

				$join_food_extra_arr = array();
				$join_food_extra_str = "";
				
				if (isset($food_extra[$key])){
					foreach ($food_extra[$key] as $extra_child_key => $extra_children) {
						$join_food_extra_child_arr = array();
						$join_food_extra_child_str = "";

						if (is_array($extra_children)){
							$extra_cat_id = $extra_cat_ids[$key][$extra_child_key];
							foreach ($extra_children as $extra_key => $extra) {
								$each_food_extra = $extra;
								$each_extra_price = $extra_price[$key][$extra_child_key][$extra_key];
								$join_food_extra_child_arr[] = $each_food_extra . ":" . $each_extra_price; 
							}
							$join_food_extra_child_str = implode(",",$join_food_extra_child_arr);
							$join_food_extra_child_str = $extra_cat_id . "->" . $join_food_extra_child_str;
						}
						$join_food_extra_arr[] = $join_food_extra_child_str;						
					}
					$join_food_extra_str = implode(";",$join_food_extra_arr );
					
					$item_food_extra_arr[] = $join_food_extra_str;		
				}else{
					$item_food_extra_arr[] = "";
				}
			}
			$item_food_extra_str = implode("|",$item_food_extra_arr);

			$prices_title = implode("," ,$prices_title_array);

			if (null !== $this->input->post('sub_category_id')){
				$subcat=implode(',',$this->input->post('sub_category_id'));
			}else{
				$subcat="";
			}
			if (null !== $this->input->post('item_allergens')){
				$item_allergens=implode(',',$this->input->post('item_allergens'));
			}else{
				$item_allergens="";
			}
			$item_show_on = 0;
			if ("on" == $this->input->post('item_show_in_delivery')){
				$item_show_on = $item_show_on + 1;
			}
			if ("on" == $this->input->post('item_show_in_pickup')){
				$item_show_on = $item_show_on + 2;
			}
            $toUpdate=array(
				"item_name_".$section_lang			=>$this->input->post('item_name'),
				"category_id"						=>$this->input->post('item_category_id'),
				"item_allergens"					=>$item_allergens,
				"item_desc_".$section_lang			=>$this->input->post('item_desc'),
				"item_type"							=>$this->input->post('item_type'),
				"item_prices"						=>$pric,
				"item_prices_title"					=>$prices_title,
				"item_prices_title_english"			=>$prices_title_english,
				"item_prices_title_french"			=>$prices_title_french,
				"item_prices_title_germany"			=>$prices_title_germany,
				// "sub_cat_ids"						=>$subcat,
				"item_show_blue" 					=> $this->input->post('item_show_blue'),
				"item_sort_index" 					=> $this->input->post('item_sort_index'),
				"item_tax_id" 						=> $this->input->post('item_tax_id'),
				"item_food_extra" 					=> $item_food_extra_str,
				"item_show_on" 						=> $item_show_on,
			);
            if($this->db->where('menu_id',$this->input->post('menu_id'))->update('tbl_menu_card',$toUpdate)){
				die(json_encode(array("status"=>1)));
            }else{
				die(json_encode(array("status"=>0)));
            }

		}
		public function addLogoByAdmin(){
	        $rest_id=$this->input->post('rest_id');
		    	$imageArray=pathinfo($_FILES['rest_logo']['name']);
				$source_img = $_FILES['rest_logo']['tmp_name'];
				$imageName = 'Top-Resto-Rest-Logo-'.date('dmyhis').'.'.$imageArray['extension'];
				$destination_img='assets/rest_logo/'.$imageName;
				// $d = compress($source_img, $destination_img, 90);
				
				$data=array(
							"rest_logo"=>$imageName,
						);
				$condition=array("restaurant_id"=>$rest_id);
				// print_r($condition);
				// echo ' ||Condition|| ';
				// print_r($data);
				if(move_uploaded_file($source_img, $destination_img)){
				// 	echo 'Image Uploade Successfully.';
					$response=$this->MODEL->addRestLogo($data,$condition);
				    die(json_encode(array("status"=>$response)));
				}else{
					// echo 'Failed to Upload';
					die(json_encode(array("status"=>0)));
				}
		}
		public function printThermal(){
			// $imageArray=pathinfo($_FILES['invoice']['name']);
			// $source_img = $_FILES['invoice']['tmp_name'];
			// $imageName = 'invoice.png';
			// $destination_img='assets/additional_assets/temp/'.$imageName;
			
			// if($this->compress($source_img, $destination_img,100)){
			$_lang = "english";
			$invoice = array();
			$printer = "printer";
			$order_id = $this->input->post("order_id");
			$order = $this->db->where("order_id",$order_id)->join('tbl_customers','tbl_customers.customer_id = tbl_orders.order_customer_id')->get('tbl_orders')->row();
			if (isset($order)){
				$rest = $this->db->where("restaurant_id",$order->order_rest_id)->get('tbl_restaurant_details')->row();
				$rest_currency_id = $rest->currency_id;
				$rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
				$rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;
				
				$order_customer_id = $order->order_customer_id;
				$customer = $this->db->query("select * from tbl_customers where customer_id = $order_customer_id")->row();
				$invoice['customer'] = $customer;
			
				
				$esc = chr(hexdec('\x1B')); //ESC byte in hex notation
				$newLine = chr(hexdec('\x0A')); //LF byte in hex notation
				$invoice_str = $esc."@"; //Initializes the printer (ESC @)
				$invoice_str .= $esc.'!'.chr(hexdec('\x38')); //Emphasized.Double-height.Double-width mode selected (ESC ! (8.16.32)) 56 dec => 38 hex
				$invoice_str .= 'Order ID #'.$order_id; //text to print
				$invoice_str .= $newLine.$newLine;
				$invoice_str .= $esc.'!'.chr(hexdec('\x00'));
				$invoice_str .= date_format(date_create(explode(" ",$order->order_date)[0]),"M d Y H:i A").$newLine;
				$invoice_str .= "Payment Mode : ".$order->order_payment_method.$newLine.$newLine;
				$invoice_str .= $esc.'!'.chr(hexdec('\x18')); //Emphasized.Double-height mode selected (ESC ! (16.8)) 24 dec => 18 hex
				$invoice_str .= 'Customer Information'.$newLine;
				$invoice_str .= $esc.'!'.chr(hexdec('\x00')); //Character font A selected (ESC ! 0)
				$invoice_str .= $customer->customer_name.' / '.$customer->customer_company_name .$newLine;
				$invoice_str .= $customer->customer_phone.' / '.$customer->customer_email .$newLine;
				$invoice_str .= $customer->customer_address.' / '.$customer->customer_floor .$newLine;
				$invoice_str .= $customer->customer_city.' '.$customer->customer_country_abv.' / '.$customer->customer_postcode .$newLine;
				$invoice_str .= 'Requested Time : '.($order->order_duration_time > 0 ? $order->order_duration_time . "mins" : "ASAP") .$newLine.$newLine;
				$order_item_ids = explode(",",$order->order_item_ids);
				$order_extra_ids = explode(",", $order->order_extra_ids);
				$order_qty = explode(",", $order->order_qty);
				foreach ($order_item_ids as $okey => $ovalue) { 
					$item_id = explode(":",$ovalue)[0];
					$item_price_index = explode(":",$ovalue)[1];
					$item = $this->db->query("select * from tbl_menu_card where menu_id = $item_id")->row();
					$item_name_field = "item_name";
					$item_price_name_field =  "item_prices_title";
					$pdt_price = 0;
					$extra_div = '';
					
					if ($item_price_index == ""){
						$price_title = "";
						$price = "0";
					}else{
						$price_title = explode(",",$item->$item_price_name_field)[$item_price_index] == "" ? explode(",",$item->$item_price_name_field)[$item_price_index] : explode(",",$item->$item_price_name_field)[$item_price_index];
						$price = explode(",",$item->item_prices)[$item_price_index];
						$pdt_price +=  $price;
						$item_food_extra = $item->item_food_extra;
						if ($item_food_extra !== ""){
							$evalue = explode("|",$item_food_extra)[$item_price_index];
							if($evalue !== ""){
								$extra_div .="";
								$item_extra_p = $evalue;
								if ($item_extra_p !== "" && $item_extra_p !== null ){
									$item_extra_p_arr = explode(";",$evalue);
									$item_extra_arr = array();
									foreach ($item_extra_p_arr as $ipkey => $ipvalue) {
										if (isset(explode("->",$ipvalue)[1])){
											$item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[1]));
										}else{
											$item_extra_arr = array_merge($item_extra_arr,explode(",",explode("->",$ipvalue)[0]));
										}
									}
									foreach ($item_extra_arr as $fkey => $fvalue) {
										$extra_id = explode(":",$fvalue)[0];
										if ($order_extra_ids[$okey] !== ""){
											$order_extra_ids_arr = explode("|",$order_extra_ids[$okey]);
											if (in_array($extra_id,$order_extra_ids_arr)){
												$extra_food = $this->db->query("select * from tbl_food_extra where extra_id = $extra_id")->row();
												$extra_name_field = "food_extra_name_" . $_lang;
												$extra_name = $extra_food->$extra_name_field == "" ? $extra_food ->food_extra_name : $extra_food->$extra_name_field;
												
												$extra_price = explode(":",$fvalue)[1];
												$extra_div .= "        $extra_name : $extra_price $rest_currency_symbol".$newLine;
												$pdt_price += $extra_price;
											}
										}
									} 
								}
							}
						}
					}
					$invoice_str .= $esc.'!'.chr(hexdec('\x18'));
					$invoice_str .=( $item->$item_name_field == "" ? $item->item_name : $item->$item_name_field ) . "   x " .  $order_qty[$okey]."   : ".number_format($pdt_price * $order_qty[$okey],2) . $rest_currency_symbol .$newLine;
					$invoice_str .= $esc.'!'.chr(hexdec('\x00'));
					$invoice_str .= "   ".$price_title." : ".$price." $rest_currency_symbol".$newLine;
					if ($extra_div == ""){

					}else{
						$invoice_str .= "   Extra".$newLine;
						$invoice_str .= $extra_div.$newLine;
					}
				}
				$invoice_str .= $newLine;
				$invoice_str .= "Sub Total     : " .number_format($order->order_amount-$order->order_delivery_cost,2)." $rest_currency_symbol".$newLine;
				$invoice_str .= "Delivery Cost : " .$order->order_delivery_cost." $rest_currency_symbol".$newLine;
				$invoice_str .= "Total         : " .number_format($order->order_amount,2)." $rest_currency_symbol".$newLine;

				$toUpdate = array("order_is_printed" => 1);
				$status = $this->db->where('order_id',$order_id)->update('tbl_orders',$toUpdate);

				die(json_encode(array("status"=>$status,"printer"=>$printer,"invoice"=>$invoice,"invoice_str" =>$invoice_str)));
				// }else{
			}else{
				die(json_encode(array("status"=>0)));
			}
			// }
		}
		public function getRestDetails(){
		    $res=$this->db->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->where('tbl_restaurant.rest_id',$this->input->post('rest_id'))->get('tbl_restaurant')->row();
		    if($res){
		        die(json_encode(array("code"=>1,"data"=>$res)));
		    }else{
		        die(json_encode(array("code"=>0,"data"=>"No Data")));
		    }
		}
		public function slugify($rest_id,$str) {
			
			$str_ = $str;
			$i=0;
			$final_slug = "";
			$search = array('Ș', 'Ț', 'ş', 'ţ', 'Ş', 'Ţ', 'ș', 'ț', 'î', 'â', 'ă', 'Î', 'Ă', 'ë', 'Ë');
			$replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'e', 'E');

			do {
				$str_ = str_ireplace($search, $replace, strtolower(trim($str_)));
				$str_ = preg_replace('/[^\w\d\-\ ]/', '', $str_);
				$str_ = str_replace(' ', '-', $str_);
				$srt_ = preg_replace('/\-{2,}/', '-', $str_);

				$i++;
				$query = "SELECT * FROM `tbl_restaurant` WHERE rest_id <> ".$rest_id." AND rest_url_slug = '" . $str_ ."'";
				$is_possible = $this->db->query($query)->row();
				$final_slug = $str_;
				$str_ = $str_ . $i;
			
			} while ($is_possible);

			return $final_slug;
		}
		public function updateDesignSettings(){
		  //  print_r($_POST);
		  //  die;
			$rest_id=$this->input->post('myRestId');
			if ($rest_id > 0){
				$color_settings = array(
					"standard_color"					=>		$this->input->post('standard_color'),
					"standard_color_alpha"				=>		$this->input->post('standard_color_alpha'),
					"navigation_bg_color"				=>		$this->input->post('navigation_bg_color'),
					"navigation_bg_color_alpha"			=>		$this->input->post('navigation_bg_color_alpha'),
					"menu_bg_color"						=>		$this->input->post('menu_bg_color'),
					"menu_bg_color_alpha"				=>		$this->input->post('menu_bg_color_alpha'),
					"menu_color"						=>		$this->input->post('menu_color'),
					"menu_color_alpha"					=>		$this->input->post('menu_color_alpha'),
					"loginbtn_bg_color"					=>		$this->input->post('loginbtn_bg_color'),
					"loginbtn_bg_color_alpha"			=>		$this->input->post('loginbtn_bg_color_alpha'),
					"loginbtn_color"					=>		$this->input->post('loginbtn_color'),
					"loginbtn_color_alpha"				=>		$this->input->post('loginbtn_color_alpha'),
					"slider_color"						=>		$this->input->post('slider_color'),
					"slider_color_alpha"				=>		$this->input->post('slider_color_alpha'),
					"slider_title_color"				=>		$this->input->post('slider_title_color'),
					"slider_title_color_alpha"			=>		$this->input->post('slider_title_color_alpha'),
					"slider_bg_color"					=>		$this->input->post('slider_bg_color'),
					"slider_bg_color_alpha"				=>		$this->input->post('slider_bg_color_alpha'),
					"home_view_menubtn_color"			=>		$this->input->post('home_view_menubtn_color'),
					"home_view_menubtn_color_alpha"		=>		$this->input->post('home_view_menubtn_color_alpha'),
					"home_view_menubtn_bg_color"		=>		$this->input->post('home_view_menubtn_bg_color'),
					"home_view_menubtn_bg_color_alpha"	=>		$this->input->post('home_view_menubtn_bg_color_alpha'),
					"home_view_menubtn_bg_color"		=>		$this->input->post('home_view_menubtn_bg_color'),
					"home_view_menubtn_bg_color_alpha"	=>		$this->input->post('home_view_menubtn_bg_color_alpha'),
					"home_view_menu_color"				=>		$this->input->post('home_view_menu_color'),
					"home_view_menu_color_alpha"		=>		$this->input->post('home_view_menu_color_alpha'),
					"home_view_menu_bg_color"			=>		$this->input->post('home_view_menu_bg_color'),
					"home_view_menu_bg_color_alpha"		=>		$this->input->post('home_view_menu_bg_color_alpha'),
					"home_view_menu_icon_color"			=>		$this->input->post('home_view_menu_icon_color'),
					"home_view_menu_icon_color_alpha"	=>		$this->input->post('home_view_menu_icon_color_alpha'),
					"body_color"						=>		$this->input->post('body_color'),
					"body_color_alpha"					=>		$this->input->post('body_color_alpha'),
					"service_color"						=>		$this->input->post('service_color'),
					"service_color_alpha"				=>		$this->input->post('service_color_alpha'),
					"servicebtn_bg_color"				=>		$this->input->post('servicebtn_bg_color'),
					"servicebtn_bg_color_alpha"			=>		$this->input->post('servicebtn_bg_color_alpha'),
					"servicebtn_color"					=>		$this->input->post('servicebtn_color'),
					"servicebtn_color_alpha"			=>		$this->input->post('servicebtn_color_alpha'),
					"footer_bg_color"					=>		$this->input->post('footer_bg_color'),
					"footer_bg_color_alpha"				=>		$this->input->post('footer_bg_color_alpha'),
					"footer_heading_color"				=>		$this->input->post('footer_heading_color'),
					"footer_heading_color_alpha"		=>		$this->input->post('footer_heading_color_alpha'),
					
					"price_color"						=>		$this->input->post('price_color'),
					"blueline_color"					=>		$this->input->post('blueline_color'),
					"category_bg_color"					=>		$this->input->post('category_bg_color'),
					"category_color"					=>		$this->input->post('category_color'),
					"tabbtn_bg_color"					=>		$this->input->post('tabbtn_bg_color'),
					"tabbtn_color"						=>		$this->input->post('tabbtn_color'),
					"price_color_alpha"					=>		$this->input->post('price_color_alpha'),
					"blueline_color_alpha"				=>		$this->input->post('blueline_color_alpha'),
					"category_bg_color_alpha"			=>		$this->input->post('category_bg_color_alpha'),
					"category_color_alpha"				=>		$this->input->post('category_color_alpha'),
					"tabbtn_bg_color_alpha"				=>		$this->input->post('tabbtn_bg_color_alpha'),
					"tabbtn_color_alpha"				=>		$this->input->post('tabbtn_color_alpha'),
					"active_tabbtn_bg_color"			=>		$this->input->post('active_tabbtn_bg_color'),
					"active_tabbtn_color"				=>		$this->input->post('active_tabbtn_color'),
					"active_tabbtn_bg_color_alpha"		=>		$this->input->post('active_tabbtn_bg_color_alpha'),
					"active_tabbtn_color_alpha"			=>		$this->input->post('active_tabbtn_color_alpha'),
					"wishlist_tab_color"				=>		$this->input->post('wishlist_tab_color'),
					"wishlist_tab_color_alpha"			=>		$this->input->post('wishlist_tab_color_alpha'),
					"wishlist_tab_bg_color"				=>		$this->input->post('wishlist_tab_bg_color'),
					"wishlist_tab_bg_color_alpha"		=>		$this->input->post('wishlist_tab_bg_color_alpha'),
					"food_menu_big_tabs_bg_color"		=>		$this->input->post('food_menu_big_tabs_bg_color'),
					"food_menu_big_tabs_bg_color_alpha"	=>		$this->input->post('food_menu_big_tabs_bg_color_alpha'),
					"food_menu_big_tabs_color"			=>		$this->input->post('food_menu_big_tabs_color'),
					"food_menu_big_tabs_color_alpha"	=>		$this->input->post('food_menu_big_tabs_color_alpha'),
					"food_menu_heading_color"			=>		$this->input->post('food_menu_heading_color'),
					"food_menu_heading_color_alpha"		=>		$this->input->post('food_menu_heading_color_alpha'),
					"address_time_color"				=>		$this->input->post('address_time_color'),
					"address_time_color_alpha"			=>		$this->input->post('address_time_color_alpha'),
					"address_time_bg_color"				=>		$this->input->post('address_time_bg_color'),
					"address_time_bg_color_alpha"		=>		$this->input->post('address_time_bg_color_alpha'),
					"enter_addressbtn_bg_color"			=>		$this->input->post('enter_addressbtn_bg_color'),
					"enter_addressbtn_bg_color_alpha"	=>		$this->input->post('enter_addressbtn_bg_color_alpha'),
					"enter_addressbtn_color"			=>		$this->input->post('enter_addressbtn_color'),
					"enter_addressbtn_color_alpha"		=>		$this->input->post('enter_addressbtn_color_alpha'),
					"food_color"						=>		$this->input->post('food_color'),
					"food_color_alpha"					=>		$this->input->post('food_color_alpha'),
					"food_description_color"			=>		$this->input->post('food_description_color'),
					"food_description_color_alpha"		=>		$this->input->post('food_description_color_alpha'),
					"food_info_color"					=>		$this->input->post('food_info_color'),
					"food_info_color_alpha"				=>		$this->input->post('food_info_color_alpha'),
					"reservation_page_bg"				=>		$this->input->post('reservation_page_bg'),
					"reservation_page_bg_alpha"		 	=>		$this->input->post('reservation_page_bg_alpha'),
					"menu_card_hover_bg_color"			=>		$this->input->post('menu_card_hover_bg_color'),
					"menu_card_hover_bg_color_alpha" 	=>		$this->input->post('menu_card_hover_bg_color_alpha'),
				);
				$font_settings = array(
					"category_name_font_family"		 	=>		$this->input->post('category_name_font_family'),
				);
				$toUpdate=array(
					"color_settings"		=> json_encode($color_settings),
					"font_settings"		=> json_encode($font_settings)
				);
				if($this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',$toUpdate)){
					die(json_encode(array("code"=>1)));
				}else{
					die(json_encode(array("code"=>0)));
				}
			}
		}
		
		public function removeAddonInvoice(){
			$invoice_id = $this->input->post("invoice_id");
			die(json_encode(array("status"=>$this->MODEL->remove_row("tbl_addon_invoices","id = $invoice_id"))));
		}
		// modify by Jfrost in 2nd stage
		public function updateRestaurantSetting(){
			$rest_id=$this->input->post('myRestId');
			if ($rest_id > 0){
				if (null !== ($this->input->post('admin_lang_option'))){
					$toUpdate=array(
						"admin_language"	=>	$this->input->post('admin_lang_option'),
					);
				}
				if (null !== ($this->input->post('website_lang_option'))){
					$toUpdate=array(
						"website_languages"	=>	$this->input->post('website_lang_option'),
					);
				}
				if (null !== ($this->input->post('dashboard_lang_option'))){
					$toUpdate=array(
						"dashboard_languages"	=>	$this->input->post('dashboard_lang_option'),
					);
				}
				if (null !== ($this->input->post('menu_lang_option'))){
					$toUpdate=array(
						"menu_languages"	=>	$this->input->post('menu_lang_option'),
					);
				}
				if (null !== ($this->input->post('kitchen_ids'))){
					$toUpdate=array(
						"kitchen_ids"	=>	$this->input->post('kitchen_ids'),
					);
				}
				if (null !== ($this->input->post('active_pages'))){
					$toUpdate=array(
						"active_pages"	=>	$this->input->post('active_pages'),
					);
				}
				if (null !== ($this->input->post('plan'))){
					$toUpdate=array(
						"resto_plan"	=>	$this->input->post('plan'),
					);
				}
				$first_pro_date = $this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row()->pro_plan_start_date;
				if ( $first_pro_date == null || $first_pro_date == ""){
					$toUpdate=array(
						"pro_plan_start_date"	=>	date('Y-m-d')
					);
				}
				$is_upgrade_success = 1;

				if(isset($toUpdate) && $this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',$toUpdate)){
					die(json_encode(array("code"=>1)));
				}else{
					die(json_encode(array("code"=>0)));
				}
			}
		}
		public function addonRecurringTransaction($addon_invoice_id){
			// $this->log_header_request();
		}
		public function addonRecurringPaymentPlan($addon_invoice_id){
			//$paymentAmount = $_POST["Payment_Amount"];
			// $paymentAmount = $_SESSION["Payment_Amount"];
			if ($addon_invoice = $this->db->where("id",$addon_invoice_id)->get("tbl_addon_invoices")->row()){
				$addon_id = $addon_invoice->addon_id;
				$addon = $this->MODEL->getAddon_by_addon_id($addon_id);
				if ($addon){
					$paymentAmount = number_format($addon_invoice->total,2);
					$_SESSION["Payment_Amount"] = $paymentAmount;
					
					$currency_country = $this->db->where("id",$addon->addon_price_currency_id)->get("tbl_countries")->row();
					if ($currency_country){
						$currencyCodeType = $currency_country->currency_code; 
						$currencySymbol = $currency_country->currency_symbol;
					}else{
						$currencyCodeType = "EUR";
						$currencySymbol = "€";
					}
					// modify by Jfrost 12/17
					if ($addon_invoice->payment_method == "paypal"){
						$paymentType = "Sale";
			
						#$paymentType = "Authorization";
						#$paymentType = "Order";
						$cancelURL = base_url("Restaurant/Addon/");
						$returnURL = base_url("Restaurant/addonRecurringPaymentReview");
						// $returnURL = base_url("API/addonRecurringTransaction/".$addon_invoice_id);
						$life_cycle = $addon->addon_lifecycle;
						$resArray = $this->recurringpayment->CallShortcutExpressCheckout ($addon_invoice_id,$paymentAmount, $currencyCodeType,$currencySymbol,$life_cycle,$paymentType, $returnURL, $cancelURL);
						$ack = strtoupper($resArray["ACK"]);
						if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING"){
							$this->recurringpayment->RedirectToPayPal ( $resArray["TOKEN"] );
						}else{
							//Display a user friendly Error on the page using any of the following error information returned by PayPal
							$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
							$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
							$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
							$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
			
							$error_msg = "SetExpressCheckout API call failed. ";
							$error_msg .= "Detailed Error Message: " . $ErrorLongMsg;
							$error_msg .= "Short Error Message: " . $ErrorShortMsg;
							$error_msg .= "Error Code: " . $ErrorCode;
							$error_msg .= "Error Severity Code: " . $ErrorSeverityCode;
							var_dump($error_msg);
						}

					}else{ // stripe
						require_once('application/libraries/stripe-php/init.php');
						
						
					}
				}
			}
		}
		function log_header_request($log,$desc){
			$this->db->set('created_at', 'NOW()', FALSE);
			$this->db->insert("tbl_temp",array("log"=> $log,"desc"=>$desc));
		}
		public function addonRecurringPlanConfirm($rest_id,$addon_id){
			$PaymentOption = "PayPal";
			$addonid_arr_str = "";
			$current_addon_ids_arr = array();
			$myRestDetail = $this->db->where('restaurant_id',$rest_id )->get('tbl_restaurant_details')->row();
			if (!empty($myRestDetail->addon_ids)){
				$current_addon_ids_arr = (array)explode(",",$myRestDetail->addon_ids);
			}else{
			}
			if (!in_array($addon_id ,$current_addon_ids_arr)){
				$current_addon_ids_arr[] = $addon_id;
				$addonid_arr_str = implode(",",$current_addon_ids_arr);
			}
			$addon = $this->MODEL->getAddon_by_addon_id($addon_id);
			
			$currency_country = $this->db->where("id",$addon->addon_price_currency_id)->get("tbl_countries")->row();
			if ($currency_country){
				$currencyCodeType = $currency_country->currency_code; 
				$currencySymbol = $currency_country->currency_symbol;
			}else{
				$currencyCodeType = "EUR";
				$currencySymbol = "€";
			}
			$status = 'pending';
			if ($this->db->where("addon_id", $addon_id)->where("rest_id", $rest_id)->get("tbl_restaurant_addons")->row()){
				$res = $this->db->where("addon_id", $addon_id)->where("rest_id", $rest_id)->update("tbl_restaurant_addons",array("status" => $status));
			}else{
				$update_data = array(
					'rest_id' 	=>	$rest_id,
					'addon_id' 	=>	$addon_id,
					'status' 	=>	$status
				);
				$res = $this->db->insert("tbl_restaurant_addons" ,$update_data);
			}
			/*
			die(json_encode(array("code"=>1)));
			$res = $this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',array('addon_ids'=>$addonid_arr_str));
			if ( $PaymentOption == "PayPal" ){
				$finalPaymentAmount =  $_SESSION["Payment_Amount"];
				// $plan_started_date = $this->db->where("restaurant_id = ".$this->input->post('myRestId'))->get('tbl_restaurant_details')->row()->pro_plan_start_date;
				$plan_start_date = date("Y-m-d", strtotime('+'.$addon->addon_trial_period.' days'));
				$resArray = $this->recurringpayment->CreateRecurringPaymentsProfile($plan_start_date,$finalPaymentAmount,$currencyCodeType,$currencySymbol,$addon->addon_lifecycle);
				$ack = strtoupper($resArray["ACK"]);
				if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" ){
					$transactionId		= isset($resArray["TRANSACTIONID"]) ? $resArray["TRANSACTIONID"] : ""; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
					$transactionType 	= isset($resArray["TRANSACTIONTYPE"]) ? $resArray["TRANSACTIONTYPE"] : ""; //' The type of transaction Possible values: l  cart l  express-checkout 
					$paymentType		= isset($resArray["PAYMENTTYPE"]) ? $resArray["PAYMENTTYPE"] : "";  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
					$orderTime 			= isset($resArray["ORDERTIME"]) ? $resArray["ORDERTIME"] : "";  //' Time/date stamp of payment
					$amt				= isset($resArray["AMT"]) ? $resArray["AMT"] : "";  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
					$currencyCode		= isset($resArray["CURRENCYCODE"]) ? $resArray["CURRENCYCODE"] : "";  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
					$feeAmt				= isset($resArray["FEEAMT"]) ? $resArray["FEEAMT"] : "";  //' PayPal fee amount charged for the transaction
					$settleAmt			= isset($resArray["SETTLEAMT"]) ? $resArray["SETTLEAMT"] : "";  //' Amount deposited in your PayPal account after a currency conversion.
					$taxAmt				= isset($resArray["TAXAMT"]) ? $resArray["TAXAMT"] : "";  //' Tax charged on the transaction.
					$exchangeRate		= isset($resArray["EXCHANGERATE"]) ? $resArray["EXCHANGERATE"] : "";  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer’s account.
					$paymentStatus	= isset($resArray["PAYMENTSTATUS"]) ? $resArray["PAYMENTSTATUS"] : ""; 
					$pendingReason	= isset($resArray["PENDINGREASON"]) ? $resArray["PENDINGREASON"] : "";  
					$reasonCode		= isset($resArray["REASONCODE"]) ? $resArray["REASONCODE"] : ""; 
					$payer_id =  urlencode($_SESSION['payer_id']);
					$res = $this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',array('addon_ids'=>$addonid_arr_str));
					$res1 = $this->db->where('addon_id',$addon_id)->where('rest_id',$rest_id)->update('tbl_addon_invoices',array('status'=>'paid','transaction_id'=>$transactionId,'payer_id'=>$payer_id));

					die(json_encode(array("code"=>$res && $res1,"transactionId"=>$transactionId,"rest_id"=>$rest_id,"addon_id"=>$addon_id)));
				}else{
					//Display a user friendly Error on the page using any of the following error information returned by PayPal
					$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
					$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
					$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
					$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
					
					$error_msg = "GetExpressCheckoutDetails API call failed. ";
					$error_msg .= "Detailed Error Message: " . $ErrorLongMsg;
					$error_msg .= "Short Error Message: " . $ErrorShortMsg;
					$error_msg .= "Error Code: " . $ErrorCode;
					$error_msg .= "Error Severity Code: " . $ErrorSeverityCode;
					die(json_encode(array("code"=>0,"error"=>$error_msg,"detail"=>json_encode($resArray))));
				}
				
			}
			*/
		}
		public function addonPayout(){
			$rest_id = $this->input->post("rest_id");
			$addon_id = $this->input->post("addon_id");
			$business_type = $this->input->post("business_type");
			$first_name = $this->input->post("first_name");
			$last_name = $this->input->post("last_name");
			$country = $this->input->post("country");
			$city = $this->input->post("city");
			$postcode = $this->input->post("postcode");
			$address = $this->input->post("address");
			$payment_method = $this->input->post("payment_method");

			$addon = $this->MODEL->getAddon_by_addon_id($addon_id);
			$due_date = "NOW";
			$recurring_interval = 'day';
			if ($addon){
				switch ($addon->addon_lifecycle) {
					case 'daily':
						$due_date = date('Y-m-d', strtotime('+1 day'));
						$recurring_interval = 'day';
						break;
					case 'weekly':
						$due_date = date('Y-m-d', strtotime('+1 week'));
						$recurring_interval = 'week';
						break;
					case 'monthly':
						$due_date = date('Y-m-d', strtotime('+1 month'));
						$recurring_interval = 'month';
						break;
					case 'annually':
						$due_date = date('Y-m-d', strtotime('+1 year'));
						$recurring_interval = 'year';
						break;
					default:
						$due_date = date('Y-m-d');
						break;
				}
			}
			$this->db->set('invoice_date', 'NOW()', FALSE);
			$price = $addon->addon_price;
			$data = array(
				"rest_id"			=>	$rest_id,
				"addon_id"			=>	$addon_id,
				"business_type"		=>	$business_type,
				"first_name"		=>	$first_name,
				"last_name"			=>	$last_name,
				"address"			=>	$address,
				"city"				=>	$city,
				"postcode"			=>	$postcode,
				"country"			=>	$country,
				"payment_method"	=>	$payment_method,
				"due_date"			=>	$due_date,
				"total"				=>	number_format($price,2),
			);
			if ($business_type == "freelancer"){
			}else{
				$company_name = $this->input->post("company_name");
				$vat_number = $this->input->post("vat_number");
				$data["company_name"] = $company_name;
				$data["vat_id"] = $vat_number;
				$vat_number_validation = $this->viesCheckVAT($country, $vat_number);
				if ($country !=="LU" && $vat_number_validation == "true"){
					$data["total"] = number_format($price * 100 / 117,2);
				}
			}
			$currency_code = "EUR";
			$currency_symbol = "€";
			if ($currency_country = $this->db->where("id", $addon->addon_price_currency_id)->get("tbl_countries")->row()){
				if ($currency_country->currency_code !== ""){
					$currency_code = $currency_country->currency_code;
					$currency_symbol = html_entity_decode($currency_country->currency_symbol);					
				}
			}
			$data["currency"] = $currency_symbol;
			$res = $this->db->insert("tbl_addon_invoices",$data);
			$addon_invoice_id = $this->db->insert_id();
			$rest = $this->db->where('tbl_restaurant.rest_id',$rest_id)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			$addon_invoice = $this->db->where("id", $addon_invoice_id)->join('tbl_addons','tbl_addons.addon_id=tbl_addon_invoices.addon_id')->get("tbl_addon_invoices")->row();
			$this->sendAddonPaymentEmail($rest,$addon_invoice);
			$this->sendAddonPaymentEmailtoAdmin($rest,$addon_invoice);
			$this->addonRecurringPlanConfirm($rest_id,$addon_id);
			die(json_encode(array("status"=>$res,"vat_number_validation"=>$vat_number_validation,"addon_id" =>$addon_id,"addon_invoice_id" =>$addon_invoice_id)));
			/*
			if ($payment_method == "paypal"){
				$res = $this->db->insert("tbl_addon_invoices",$data);
				$addon_invoice_id = $this->db->insert_id();
				die(json_encode(array("status"=>$res,"vat_number_validation"=>$vat_number_validation,"addon_id" =>$addon_id,"addon_invoice_id" =>$addon_invoice_id)));
			}else{
				require_once('application/libraries/stripe-php/init.php');
				// get Admin Stripe Key
				$rest = $this->db->where("rest_id", 1)->get("tbl_payment_settings")->row();
				$stripeKey = $rest->stripe_public_key;
				$stripeSecKey = $rest->stripe_secret_key;
				\Stripe\Stripe::setApiKey($stripeKey);
				if (null !== $this->input->post("stripePaymentForm")){
					$res = $this->db->insert("tbl_addon_invoices",$data);
					$addon_invoice_id = $this->db->insert_id();
					$expiry = $this->input->post("stripe_expiry");
					$card_number = $this->input->post("stripe_card");
					$cvc = $this->input->post("stripe_cvc");
					$card_email = $this->input->post("stripe_email");
					$transactionId = "";
					try {
						$exp_date = explode("/", $expiry);
						$exp_month = str_replace(' ', '', $exp_date[0]);
						$exp_year = str_replace(' ', '', $exp_date[1]);
						if (strlen($exp_year) == 2) {
							$exp_year += 2000;
						}
						// create token for customer/buyer credit card
						$token = \Stripe\Token::create(
							array(
								"card" => array(
									'number' => $card_number, 
									'cvc' => $cvc, 
									'exp_month' => $exp_month, 
									'exp_year' => $exp_year, 
									'name' => $first_name . ' ' . $last_name)
								)
							);

						$stripe = new \Stripe\StripeClient(
							$stripeSecKey
							// 'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
						);
						$_customer = $stripe->customers->create([
							'name' => $first_name . ' ' . $last_name,
						]);
						$_name = isset(json_decode($addon->addon_title)->value) ? '#addon-'.$addon->addon_id . '-' . json_decode($addon->addon_title)->value: '#addon-'.$addon->addon_id;

						$_products = $stripe->products->create([
							'name' => $_name ,
						]);
						$_price = $stripe->prices->create([
							'unit_amount' => 25000,
							'currency' => $currency_code,
							'recurring' => ['interval' => $recurring_interval],
							'product' => $_products->id,
						]);
						$_subscriptions_res = $stripe->subscriptions->create([
							'customer' => $_customer->id,
							'items' => [
							  	['price' => $_price->id],
							],
						]);
						// $desc = json_decode($addon->addon_title)->value . $addon->addon_id;
						// $update_data = array(
						// 	"status"	=>	"paid",
						// 	"currency"	=>	$currency_code,
						// 	"description"	=>	$desc,
						// 	"transaction_id"	=>	$_subscriptions_res,
						// );
						// $this->db->where("id",$addon_invoice_id)->update("tbl_addon_invoices",$update_data);

						$card_info = array(
							"email"	=>	$card_email,
							"card_number"	=>	$card_number,
							"card_expiry"	=>	$expiry,
							"card_cvc"	=>	$cvc,
							"addon_id"	=>	$addon->addon_id,
							"rest_id"	=>	$rest_id,
						);

						$this->db->insert("tbl_restaurant_stripe_info",$card_info);
						$stripe_info_res = $this->db->insert_id();
						
						die(json_encode(array("status"=>$res,"token"=>$token,"stripe_info_res" =>$stripe_info_res,"else_data"=>$_price)));
					} catch (Exception $e) {
						die(json_encode(array("status"=>false,"error"=>$e)));
					}
				}else{
					
					$stripe = array("stripe_key"=>$stripeKey ,"amount" =>$data["total"],"currency_code"=>$currency_code,"currency_symbol"=>$currency_symbol);
					die(json_encode(array("status"=>1,"vat_number_validation"=>$vat_number_validation,"addon_id" =>$addon_id,"stripe"=>$stripe)));
				}
			}
			*/
			
		}
		function sendAddonPaymentEmail($rest,$addon_invoice){
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
																	<meta itemprop="name" content="Confirm Email" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
																	<div>
																		<table align="center">
																			<tbody>
																				<tr>
																					<td>Name </td>
																					<td> : '.$addon_invoice->first_name.' '.$addon_invoice->last_name.' </td>
																				</tr>
																				<tr>
																					<td>Restaurant Email </td>
																					<td> : '.$rest->rest_email.' </td>
																				</tr>
																				<tr>
																					<td>Restaurant Name </td>
																					<td> : '.$rest->rest_name.' </td>
																				</tr>
																				<tr>
																					<td>Restaurant Contact Number </td>  
																					<td> : '.$rest->rest_contact_no.'</td>
																				</tr>
																				<tr>
																					<td>Owner Name </td>  
																					<td> : '.$rest->owner_name.'</td>
																				</tr>
																				<tr>
																					<td>Invoice Date </td>  
																					<td> : '.$addon_invoice->invoice_date.'</td>
																				</tr>
																				<tr>
																					<td>Due Date </td>  
																					<td> : '.$addon_invoice->due_date.'</td>
																				</tr>
																				<tr>
																					<td>Business type </td>  
																					<td> : '.$addon_invoice->business_type.'</td>
																				</tr>
																				<tr>
																					<td>Company Name </td>  
																					<td> : '.$addon_invoice->company_name.'</td>
																				</tr>
																				<tr>
																					<td>Payment Method </td>  
																					<td> : '.$addon_invoice->payment_method.'</td>
																				</tr>
																				<tr>
																					<td>Cost </td>  
																					<td> : '.$addon_invoice->total.'</td>
																				</tr>
																			</tbody>
																		</table>
																		<br>
																		<table style="margin: auto;">
																			<tr>
																				<td>
																					<div style="padding-right: 10px;border-right: 3px solid lightgray;">
																						<h3>'.json_decode($addon_invoice->addon_title)->value.'</h3>
																						<div class="d-flex align-items-center justify-content-start flex-wrap">
																							<span>'.$addon_invoice->total.'</span>
																							<span>'.$addon_invoice->currency.'</span>
																							<span>/ '.$addon_invoice->addon_lifecycle.'</span>
																						</div>
																						<em>first <span>'.$addon_invoice->addon_trial_period.'</span> days for free</em>
																					</div>
																				</td>
																				<td style="float:right">
																					'.json_decode($addon_invoice->addon_content_html)->value.'                                                         
																				</td>
																			</tr>
																		</table>
																	</div>
															</td>
													</tr>
											</table>
											
											<H3 align = "center">You will receive a payment request message from Restopage Admin and you will be able to use your add-on as soon as you pay.</H3>
									</div>
							</td>
						</tr>
					</table>
				</body>
			</html>';
	
			$this->email->set_mailtype("html");
			$this->email->from('info@restopage.eu','My Restopage');
			$this->email->to($rest->rest_email);
			$this->email->subject("New Addon Order");
			$this->email->message($message);
		    $this->email->send();
		}
		function sendAddonPaymentEmailtoAdmin($rest,$addon_invoice){
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
																	<meta itemprop="name" content="Confirm Email" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
																	<div>
																		<table align="center">
																			<tbody>
																				<tr>
																					<td>Name </td>
																					<td> : '.$addon_invoice->first_name.' '.$addon_invoice->last_name.' </td>
																				</tr>
																				<tr>
																					<td>Restaurant Email </td>
																					<td> : '.$rest->rest_email.' </td>
																				</tr>
																				<tr>
																					<td>Restaurant Name </td>
																					<td> : '.$rest->rest_name.' </td>
																				</tr>
																				<tr>
																					<td>Restaurant Contact Number </td>  
																					<td> : '.$rest->rest_contact_no.'</td>
																				</tr>
																				<tr>
																					<td>Owner Name </td>  
																					<td> : '.$rest->owner_name.'</td>
																				</tr>
																				<tr>
																					<td>Invoice Date </td>  
																					<td> : '.$addon_invoice->invoice_date.'</td>
																				</tr>
																				<tr>
																					<td>Due Date </td>  
																					<td> : '.$addon_invoice->due_date.'</td>
																				</tr>
																				<tr>
																					<td>Business type </td>  
																					<td> : '.$addon_invoice->business_type.'</td>
																				</tr>
																				<tr>
																					<td>Company Name </td>  
																					<td> : '.$addon_invoice->company_name.'</td>
																				</tr>
																				<tr>
																					<td>Payment Method </td>  
																					<td> : '.$addon_invoice->payment_method.'</td>
																				</tr>
																				<tr>
																					<td>Cost </td>  
																					<td> : '.$addon_invoice->total.'</td>
																				</tr>
																			</tbody>
																		</table>
																		<br>
																		<table style="margin: auto;">
																			<tr>
																				<td>
																					<div style="padding-right: 10px;border-right: 3px solid lightgray;">
																						<h3>'.json_decode($addon_invoice->addon_title)->value.'</h3>
																						<div class="d-flex align-items-center justify-content-start flex-wrap">
																							<span>'.$addon_invoice->total.'</span>
																							<span>'.$addon_invoice->currency.'</span>
																							<span>/ '.$addon_invoice->addon_lifecycle.'</span>
																						</div>
																						<em>first <span>'.$addon_invoice->addon_trial_period.'</span> days for free</em>
																					</div>
																				</td>
																				<td style="float:right">
																					'.json_decode($addon_invoice->addon_content_html)->value.'                                                         
																				</td>
																			</tr>
																		</table>
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
			$this->email->to('billy@made4you.lu');
			$this->email->subject("New Addon Order");
			$this->email->message($message);
		    $this->email->send();
		}
		function viesCheckVAT($countryCode="LU", $vatNumber="123456789", $timeout = 30) {
			$VIES_URL = 'http://ec.europa.eu/taxation_customs/vies/services/checkVatService';
			$response = array ();
			$pattern = '/<(%s).*?>([\s\S]*)<\/\1/';
			$keys = array (
					'countryCode',
					'vatNumber',
					'requestDate',
					'valid',
					'name',
					'address' 
			);
		
			$content = "<s11:Envelope xmlns:s11='http://schemas.xmlsoap.org/soap/envelope/'>
						<s11:Body>
						<tns1:checkVat xmlns:tns1='urn:ec.europa.eu:taxud:vies:services:checkVat:types'>
						<tns1:countryCode>%s</tns1:countryCode>
						<tns1:vatNumber>%s</tns1:vatNumber>
						</tns1:checkVat>
						</s11:Body>
						</s11:Envelope>";
			if (substr($vatNumber,0,2) == $countryCode ){
				$vatNumber = substr($vatNumber,2); 
			}else{
				return "false";
			}
			$opts = array (
					'http' => array (
							'method' => 'POST',
							'header' => "Content-Type: text/xml; charset=utf-8; SOAPAction: checkVatService",
							'content' => sprintf ( $content, $countryCode, $vatNumber ),
							'timeout' => $timeout 
					) 
			);
		
			$ctx = stream_context_create ( $opts );
			$result = file_get_contents ( $VIES_URL, false, $ctx );
		
			if (preg_match ( sprintf ( $pattern, 'checkVatResponse' ), $result, $matches )) {
				foreach ( $keys as $key )
					preg_match ( sprintf ( $pattern, $key ), $matches [2], $value ) && $response [$key] = $value [2];
			}
			if (isset($response["valid"])){
				return $response["valid"];
			}else{
				return "false";
			}
		}
		public function validateCheckVAT(){
			$countryCode = $this->input->post('countryCode');
			$vatNumber = $this->input->post('vatNumber');
			$res = $this->viesCheckVAT($countryCode, $vatNumber);
			die(json_encode(array("status"=>$res)));
		}
		public function updateRestDetailByAdmin(){
		  //  print_r($_POST);
		  //  die;
			$rest_id=$this->input->post('rest_id');
			if ($rest_id > 0){
				$toUpdate=array(
					"owner_name"=>$this->input->post('rest_owner_name'),
					"owner_mobile"=>$this->input->post('rest_owner_contact'),
					"address1"=>$this->input->post('rest_address1'),
					"address2"=>$this->input->post('rest_address2'),
					"establishment_year"=>$this->input->post('rest_est_year'),
					"rest_contact_no"=>$this->input->post('rest_contact'),
					"dp_option"=>$this->input->post('dp_option'),
					"domain_status"=>$this->input->post('domain_status'),
				);
				$rest_url_slug = $this->slugify($rest_id,$this->input->post('rest_name'));
				if ($this->input->post('newpassword') !== "" && $this->input->post('newpassword') !== null){
					$profileUpdate = array(
						"rest_email"=>$this->input->post('rest_email'),
						"rest_name"=>$this->input->post('rest_name'),
						"rest_pass"=>md5(trim($this->input->post('newpassword'))),
						"rest_url_slug"=>$rest_url_slug,
						"rest_domain"=>($this->input->post('rest_domain') !== null) ? $this->input->post('rest_domain') : "",

					);
				}else{
					$profileUpdate = array(
						"rest_email"=>$this->input->post('rest_email'),
						"rest_name"=>$this->input->post('rest_name'),
						"rest_url_slug"=>$rest_url_slug,
						"rest_domain"=>($this->input->post('rest_domain') !== null) ? $this->input->post('rest_domain') : "",
					);
				}
				
				if($this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',$toUpdate)){
					if($this->db->where('rest_id',$rest_id)->update('tbl_restaurant',$profileUpdate)){
						die(json_encode(array("code"=>1)));
					}else{
						die(json_encode(array("code"=>0)));
					}
				}else{
					die(json_encode(array("code"=>0)));
				}
			}else{
				die(json_encode(array("code"=>0)));
			}
		}
		public function updateRestDetailByUser(){
			$rest_id=$this->input->post('rest_id');
			$rest = $this->db->where('tbl_restaurant.rest_id',$rest_id)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			if ($rest_id > 0){
				$what_setting=$this->input->post('what_setting');
				if ($what_setting == "mydomain"){
					$profileUpdate = array(
						"rest_domain"=>($this->input->post('rest_domain') !== null) ? $this->input->post('rest_domain') : "",
					);
					if (($this->input->post('rest_domain') !== null) && trim($this->input->post('rest_domain')) !== ""){
						if($rest_info = $this->db->query("SELECT r.rest_id,rd.resto_plan,rd.activation_status,rd.domain_status FROM tbl_restaurant r JOIN tbl_restaurant_details rd ON r.rest_id = rd.restaurant_id WHERE r.rest_id = '$rest_id' AND rd.resto_plan='pro' AND rd.activation_status='Accepted'")->row()){
							if ($rest_info->domain_status !== "active" ){
								$rest_owner_name = $rest->owner_name;
								$rest_email = $rest->rest_email;
								$rest_name = $rest->rest_name;
								$this->send_change_nameserver($rest_owner_name,$rest_email,$this->input->post('rest_domain'));
								$this->send_change_domain_notification_to_admin($rest_owner_name,$rest_name,$this->input->post('rest_domain'));
							}
						} 
					}
					if($this->db->where('rest_id',$rest_id)->update('tbl_restaurant',$profileUpdate)){
						die(json_encode(array("code"=>1)));
					}else{
						die(json_encode(array("code"=>0)));
					}
				}else{
					$toUpdate=array(
						"owner_name"=>$this->input->post('rest_owner_name'),
						"allow_guest_order"=> $this->input->post('allow_guest_order') == "on" ? 1 : 0,
						"ontable_show"=> $this->input->post('allow_ontable_show') == "on" ? 1 : 0,
						"pre_order"=> $this->input->post('pre_order') == "on" ? 1 : 0,
						"open_pre_order"=> $this->input->post('open_pre_order') == "on" ? 1 : 0,
						"rest_contact_email"=>$this->input->post('rest_contact_email'),
						"owner_mobile"=>$this->input->post('rest_owner_contact'),
						"address1"=>$this->input->post('rest_address1'),
						// "address2"=>$this->input->post('rest_address2'),
						"geocode"=>$this->input->post('rest_geocode'),
						"establishment_year"=>$this->input->post('rest_est_year'),
						"rest_contact_no"=>$this->input->post('rest_contact'),
						"dp_option"=>$this->input->post('dp_option'),
						"currency_id"=>$this->input->post('currency'),
					);
					if ($this->input->post('date_format'))
						$toUpdate['date_format'] = $this->input->post('date_format');
					if ($this->input->post('time_format'))
						$toUpdate['time_format'] = $this->input->post('time_format');

					$rest_url_slug = $this->slugify($rest_id,$this->input->post('rest_name'));
					if ($this->input->post('newpassword') !== "" && $this->input->post('newpassword') !== null){
						$profileUpdate = array(
							"rest_email"=>$this->input->post('rest_email'),
							"rest_name"=>$this->input->post('rest_name'),
							"rest_pass"=>md5(trim($this->input->post('newpassword'))),
							"rest_url_slug"=>$rest_url_slug,
						);
					}else{
						$profileUpdate = array(
							"rest_email"=>$this->input->post('rest_email'),
							"rest_name"=>$this->input->post('rest_name'),
							"rest_url_slug"=>$rest_url_slug,
						);
					}
					if($this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',$toUpdate)){
						if($this->db->where('rest_id',$rest_id)->update('tbl_restaurant',$profileUpdate)){
							die(json_encode(array("code"=>1)));
						}else{
							die(json_encode(array("code"=>0)));
						}
					}else{
						die(json_encode(array("code"=>0)));
					}
				}
				
			}
		}
		public function updateDeliveryAreaZone(){
			$rest_id = $this->input->post("rest_id");
			$area_id = $this->input->post("area_id");
			$area_name = $this->input->post("area_name");
			$delivery_time = $this->input->post("delivery_time");
			$minimum_order_amount = $this->input->post("minimum_order_amount");
			$delivery_charge = $this->input->post("delivery_charge");
			$min_order_amount_free_delivery = $this->input->post("min_order_amount_free_delivery");
			$zone_color = $this->input->post("zone_color");
			$zone_type = $this->input->post("zone_type");
			$zone_geo_data = $this->input->post("geo_data");

			$data = array(
				"rest_id"							=>	$rest_id,
				"area_name"							=>	$area_name,
				"delivery_time"						=>	$delivery_time,
				"minimum_order_amount"				=>	$minimum_order_amount,
				"delivery_charge"					=>	$delivery_charge,
				"min_order_amount_free_delivery"	=>	$min_order_amount_free_delivery,
				"zone_color"						=>	$zone_color,
				"zone_type"							=>	$zone_type,
				"zone_geo_data"						=>	$zone_geo_data,
			);

			if ($area_id > 0){
				$res = $this->db->where("id",$area_id)->where("rest_id",$rest_id)->update("tbl_delivery_area_zones",$data);
			}else{
				$res = $this->db->insert("tbl_delivery_area_zones",$data);
				$area_id = $this->db->insert_id();
			}
			die(json_encode(array("status"=>$res,"area_id"=>$area_id)));
		}
		
		public function getDeliveryAreaZone(){
			if (null !== ($this->input->post("area_id"))){
				$area_zone = $this->db->where("rest_id",$this->input->post("rest_id"))->where("id",$this->input->post("area_id"))->get('tbl_delivery_area_zones')->row();
				die(json_encode(array("rest_id"=>$this->input->post("rest_id"),"area_zone"=>$area_zone)));
			}else{
				$area_zones = $this->db->where("rest_id",$this->input->post("rest_id"))->get('tbl_delivery_area_zones')->result();
				die(json_encode(array("rest_id"=>$this->input->post("rest_id"),"area_zones"=>$area_zones)));
			}
		}
		public function removeDeliveryAreaZone(){
			$rest_id = $this->input->post("rest_id");
			$area_id = $this->input->post("area_id");
			if ($area_id > 0){
				$res = $this->db->where('id',$area_id)->delete('tbl_delivery_area_zones');
			}else{
				$res = 0;
			}
			die(json_encode(array("status"=>$res)));
		}
		// modify by Jfrost
		public function change_lang(){
			$lang = trim($this->input->post('lang',TRUE));
			$this->session->set_userdata('site_lang', $lang);
			// echo "success";
			return true;
		}
		public function change_lang_admin(){
			$lang = trim($this->input->post('lang',TRUE));
			$this->session->set_userdata('site_lang_admin', $lang);
			// echo "success";
			return true;
		}
		public function getCategoryByResId(){
			$rest_id=$this->input->post('rest_id');
			die(json_encode(array("data"=>$this->MODEL->getCategoryByResId($rest_id))));
		}
		// -----------------
		// customer authentication
		public function userLoginValidate(){
			$data=array(
						"customer_email"=>$this->input->post('user_email'),
						"customer_pass"=>md5(trim($this->input->post('user_pass',TRUE))),
					);
			$customer = $this->MODEL->getcustomerLoginValidate($data);
			$rest_url_slug = $this->input->post('rest_url_slug');
			if($customer!=false){
				// print_r($customer);
				$sessData=serialize($customer);
				$this->session->set_userdata('customer_Data',$sessData);
				$this->session->set_userdata('rest_url_slug',$rest_url_slug);

				// modify by Jfrost
				$this->session->set_userdata('site_lang',"french");
				die(json_encode(array("status"=>1,"msg"=>$rest_url_slug)));
				// ----------------
			}else{
				die(json_encode(array("status"=>0)));
			}
		}

		public function recoveryPassword(){
			$nf= true;
			$error_msg =  "";
			$customer_email = $this->input->post('user_email_forgot');
			if ($customer_email== ""){
				$nf = false;
				$error_msg =  "Email is empty.";
			}else{
				$customer = $this->db->where('customer_email',$customer_email)->get("tbl_users")->row();
				if ($customer){

				}else{
					$nf = false;
					$error_msg =  "Your email is not existed or you entered wrong email.";
				}
			}
			if ($nf){
				$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
				$token = substr(str_shuffle($letters), 0, 15);
				$this->db->where('customer_email',$customer_email)->update("tbl_users",array("customer_reset_passwork_token" => $token));
				$recovery=$this->send_recovery_message($customer_email);
				if($recovery!=false){
					die(json_encode(array("status"=>1)));
					// ----------------
				}else{
					die(json_encode(array("status"=>0,"msg"=>"There are some server errors.")));
				}
			}else{
				die(json_encode(array("status"=>0,"msg"=>$error_msg)));
			}
		}
		public function send_recovery_message($customer_email){
			$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$new_password = substr(str_shuffle($letters), 0, 8);
			$customer_pass = md5(trim($new_password));
			if ($this->db->where('customer_email', $customer_email)->update('tbl_users',array('customer_pass' => $customer_pass))){
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
								<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
										valign="top"></td>
								<td class="container" width="100%"
										style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
										valign="top">
										<div class="content"
													style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
												<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
																style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
																>
														
														<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td class="content-wrap"
																		style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																								Hi , Customer <span style="font-size:18px">  We reset your password and you can log in with the following one.</span>
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																						<td class="content-block"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																								valign="top">
																								New Password : '.$new_password.'
																						</td>
																				</tr>
																				<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block" itemprop="handler" 
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																							valign="top">
																							<a href="'.base_url("Customer").'" class="btn-primary" itemprop="url"
																									style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Login with New Password</a>
																					</td>
																				</tr>
																		</table>
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
				$this->email->to($customer_email);
				$this->email->subject("Send New Password");
				$this->email->message($message);
				return  $this->email->send();
			}else{
				return false;
			}
		}
		public function send_change_nameserver($res_owner_name,$customer_email,$domain){
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
							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
									valign="top"></td>
							<td class="container" width="100%"
									style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
									valign="top">
									<div class="content"
												style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
											<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
															style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
															>
													
													<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
															<td class="content-wrap"
																	style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																							Hi '.$res_owner_name.', <span style="font-size:18px">  Thanks for registration of your own domain ('.$domain.') . <br> You should replace your nameserver address with ours bellow to add your domain to our hosting server.</span><br>
																							<b style="font-size:12px;text-decoration:">  After replace nameserver, it will take 1~2 business days to be applied changes.</b>
																					</td>
																			</tr>
																			<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block"
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																							valign="top">
																							Namer Server address 1 : dn1.made4you.lu <br>
																							Namer Server address 2 : dn2.made4you.lu
																					</td>
																			</tr>
																			<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																				<td class="content-block" itemprop="handler" 
																						style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																						valign="top">
																						<a href="'.base_url("/").'" class="btn-primary" itemprop="url"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Goto Dashboard</a>
																				</td>
																			</tr>
																	</table>
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
			$this->email->to($customer_email);
			$this->email->subject("Edit Domain NameServer");
			$this->email->message($message);
			return  $this->email->send();
    	}
		public function send_change_domain_notification_to_admin($res_owner_name,$rest_name,$domain){
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
							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
									valign="top"></td>
							<td class="container" width="100%"
									style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
									valign="top">
									<div class="content"
												style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;text-align: center;">
											<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
															style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
															>
													
													<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
															<td class="content-wrap"
																	style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; display: inline-block; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
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
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
																							Hi SuperAdmin, <span style="font-size:18px">  There is a request for registration of restaurant domain from Owner.
																							<b style="font-size:12px;text-decoration:">  After configuration, review if all is working correctly, then Change the domain_status to "Active".</b>
																					</td>
																			</tr>
																			<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																					<td class="content-block"
																							style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
																							valign="top">
																							Restaurant : '.$res_owner_name.' <br>
																							Owner Name : '.$rest_name.' <br>
																							New Domain : '.$domain.'
																					</td>
																			</tr>
																			<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																				<td class="content-block" itemprop="handler" 
																						style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align:center"
																						valign="top">
																						<a href="'.base_url("/admin").'" class="btn-primary" itemprop="url"
																								style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #10c469; margin: 0; border-color: #10c469; border-style: solid; border-width: 8px 16px;">Login Dashboard</a>
																				</td>
																			</tr>
																	</table>
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
			$this->email->to('info@restopage.eu');
			$this->email->subject("New Domain Registration");
			$this->email->message($message);
			return  $this->email->send();
    	}
		public function userRegister(){
			$nf= true;
			$error_msg =  "";
			if($captcha = $this->input->post('g-recaptcha-response')){
				$secretKey = "6LcQbNsaAAAAAKBy2uDDEFwJFJxQRhGMorDwMRoc";
				$ip = $_SERVER['REMOTE_ADDR'];
				// post request to server
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data_captcha = array('secret' => $secretKey, 'response' => $captcha);
			  
				$options = array(
					'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data_captcha)
					)
				);
				$context  = stream_context_create($options);
				$response_captcha = file_get_contents($url, false, $context);
				$responseKeys_captcha = json_decode($response_captcha,true);
				if($responseKeys_captcha["success"]) {
					if ($this->input->post('user_password_register') == "" || $this->input->post('user_email_register') == ""){
						$nf = false;
						$error_msg =  "Email or Password is empty.";
					}
					if ($this->input->post('user_password_register') == $this->input->post('user_password_confirm_register')){
					}else{
						$error_msg =  "Password is not confirmed";
						$nf = false;
					}
					if ($nf){
						$data=array(
									"customer_email"=>$this->input->post('user_email_register'),
									"customer_pass"=>md5(trim($this->input->post('user_password_register',TRUE))),
									"customer_status"=>"active",
									"customer_name"=>$this->input->post('user_name_register'),
								);
						$customer=$this->MODEL->addNew($data,"tbl_users");
						if($customer!=false){
							die(json_encode(array("status"=>1)));
						}else{
							die(json_encode(array("status"=>0,"msg"=>"There are some server errors.")));
						}
					}else{
						die(json_encode(array("status"=>0,"msg"=>$error_msg)));
					}
				}else{
					die(json_encode(array("status"=>0,"msg"=>"Please check the the captcha form.")));
				}
			}else{
				die(json_encode(array("status"=>0,"msg"=>"Please check the the captcha form.")));
			}
		}
		public function sendNewOrderReservationNotification($dp_option,$order_id){
			$notification = array();
			$arrNotification= array();			
			$arrData = array();											
			if (strtolower($dp_option) == "reservation"){
				$reservation = $this->db->where("id",$order_id)->get("tbl_reservations")->row();
				$arrNotification["body"] = "There is a new reservation at ".$reservation->created_at. " from ".$reservation->first_name . " " .$reservation->last_name; 
				$rest_id = $reservation->rest_id;
				$is_notify = $reservation ->reservation_mobile_notify;
			}else{
				$order = $this->db->where("order_id",$order_id)->join("tbl_customers","tbl_customers.customer_id = tbl_orders.order_customer_id")->get("tbl_orders")->row();
				$rest_id = $order->order_rest_id;
				$arrNotification["body"] = "There is new ".strtolower($dp_option) . " order at ".$order->order_date . " from ". $order->customer_name;
				$is_notify = $order ->order_mobile_notify;
			}
			$arrNotification["title"] = "New ".strtoupper($dp_option);
			$arrNotification["sound"] = "default";
			$arrNotification["type"] = 1;

			if ($is_notify < 1){ // if apk notification is not sent
				$this->sendFCMNotification(	$rest_id,$arrNotification,$dp_option,$order_id,"Android");
			}
		}
		public function sendFCMNotification($rest_id, $notification,$dp_option,$order_id,$device_type ="Android"){
			$SERVER_API_KEY = 'AAAAHYKzACo:APA91bGYbUV9uoItqSwjP2DWdOFIwo4oMlSFSRT7UxLSwgbajxk1wOw5D1WuuxD2H3Lu5sQUJamHGCo0axS0IUVCygsi2mHIlL9bq4eKOzSuRBpm3g0FLmxHOp2-8kTj0N3-Mepoubqe';
	  
			// payload data, it will vary according to requirement
			if ($myRest = $this->db->where("restaurant_id",$rest_id)->get("tbl_restaurant_details")->row()){
				$device_tokens = array();
				if ($myRest->device_tokens !== ""){
					$device_tokens = explode(",",$myRest->device_tokens);
				}
				$nv = $device_type == "Android" ? 1 : 2;
				if ($dp_option == "reservation"){
					$this->db->query("UPDATE tbl_reservations SET reservation_mobile_notify = reservation_mobile_notify+".$nv." WHERE id=$order_id AND rest_id=$rest_id");
				}else{
					$this->db->query("UPDATE tbl_orders SET order_mobile_notify = order_mobile_notify+".$nv." WHERE order_id=$order_id AND order_rest_id=$rest_id");
				}
				foreach ($device_tokens as $value) {
					$registration_id = $value;
					
					if($device_type == "Android"){
						$fields = array(
							'to' => $registration_id,
							'notification' => $notification,
							'priority'=>'high',
							'data' => array(
								"order_id" => $order_id,
								"dp_option" => $dp_option,
							)
						);
					}else{
						$fields = array(
							'to' => $registration_id,
							'notification' => $notification	,
							'data' => array(
								"order_id" => $order_id,
								"dp_option" => $dp_option,
							)
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
		// Homepage Section Handle
		public function rearrangeSortHomeSection(){
			$rest_id = $this->input->post('rest_id');
			$section_id = $this->input->post('section_id');
			$section_type = $this->input->post('section_type');
			$des_section_id = $this->input->post('des_section_id');
			$sort_id = $this->input->post('sort_id');
			$sort_type = $this->input->post('sort_type');
			$table = 'tbl_restaurant_homepage_section_sort';
			if ($sort_type == 'up'){
				$sort_num = $sort_id - 1;
				$pre_data = array(
					'rest_id'=>$rest_id,
					'section_id'=>$des_section_id,
					'section_type'=>$section_type,
					'sort_num'=>$sort_id,
				);
				if ($pre_section = $this->db->where('rest_id',$rest_id)->where('section_id',$des_section_id)->get($table)->row()){
					$this->db->where('rest_id',$rest_id)->where('section_id',$des_section_id)->update($table,$pre_data);
				}else{
					$this->db->insert($table,$pre_data);
				}
			}else if($sort_type == 'down'){
				$sort_num = $sort_id + 1;
				$next_data = array(
					'rest_id'=>$rest_id,
					'section_id'=>$des_section_id,
					'section_type'=>$section_type,
					'sort_num'=>$sort_id,
				);
				if ($next_section = $this->db->where('rest_id',$rest_id)->where('section_id',$des_section_id)->get($table)->row()){
					$this->db->where('rest_id',$rest_id)->where('section_id',$des_section_id)->update($table,$next_data);
				}else{
					$this->db->insert($table,$next_data);
				}
			}
			
			$cur_data = array(
				'rest_id'=>$rest_id,
				'section_id'=>$section_id,
				'sort_num'=>$sort_num,
			);
			
			if ($cur_section = $this->db->where('rest_id',$rest_id)->where('section_id',$section_id)->get($table)->row()){
				$this->db->where('rest_id',$rest_id)->where('section_id',$section_id)->update($table,$cur_data);
			}else{
				$this->db->insert($table,$cur_data);
			}

			die(json_encode(array("status"=>1)));
		}
		public function removeHomePageSection(){
			$rest_id = $this->input->post('rest_id');
			$section_id = $this->input->post('section_id');
			$sId = $this->input->post('sId');
			$section_type = $this->input->post('section_type');
			$sort_table = 'tbl_restaurant_homepage_section_sort';
			$table = 'tbl_restaurant_homepage_text_sections';
			if ($section_type == "homepage-text"){
				$res = $this->db->where('rest_id',$rest_id)->where('section_type',$section_type)->where('section_id',$section_id)->delete($sort_table);
				$res1 = $this->db->where('sRest_id',$rest_id)->where('sSection_id',$section_id)->delete($table);
				die(json_encode(array("status"=>$res && $res1)));
			}else{
				die(json_encode(array("status"=>1)));
			}
		}
	}

?>