<?php
	/**
	 * 
	 */
	class Customer extends CI_Controller
	{
		function __construct(){
			parent::__construct();
			$this->load->model('AdminModel','MODEL');
			$this->load->library('session');
			$this->load->helper('cookie');
			$this->load->library('email');
			$this->lang->load('content_lang',$this->session->userdata("site_lang"));
			// Load session library
			if ($this->session->userdata("site_lang") == ""){
				$this->session->set_userdata('site_lang', "french");
			}
			if ( null !== $this->input->get("lang")){
				if ($this->input->get("lang") == "en"){
					$this->session->set_userdata('site_lang', "english");
				}elseif ($this->input->get("lang") == "de"){
					$this->session->set_userdata('site_lang', "germany");
				}elseif ($this->input->get("lang") == "fr"){
					$this->session->set_userdata('site_lang', "french");
				}
			}
			if(!$this->session->userdata('customer_Data')){
				redirect('Home');
			}
			if(!$this->session->userdata('rest_url_slug')){
				// redirect('Home');
			}
			$sessData= unserialize($this->session->userdata('customer_Data'));
			$this->rest_url_slug = $this->session->userdata('rest_url_slug');

			$this->userID=$sessData[0]->id;
			$this->userEmail=$sessData[0]->customer_email;
		}
		public function index(){
			if(!$this->session->userdata('customer_Data')){
				redirect('Home');
			}else{
				$this->dashboard();
			}
		}
		public function dashboard(){
			
			$rest_url_slug = $this->rest_url_slug;
			$iframe = '';
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;

			$data['site_lang']=$this->session->userdata("site_lang");

			$data['customer'] = $this->db->where("user_id",$this->userID)->get("tbl_customers")->row();
			$user_id = $this->userID;
			$query = "SELECT DISTINCT  r.*,d.* FROM tbl_customers c JOIN tbl_orders o ON o.order_customer_id = c.customer_id JOIN tbl_restaurant r ON o.order_rest_id = r.rest_id JOIN tbl_restaurant_details d ON r.rest_id = d.restaurant_id WHERE c.user_id = $user_id AND d.activation_status = 'Accepted'";
			$data['rests'] = $this->db->query($query)->result();
			$this->load->view('customer/layout/header',$data);
			$this->load->view('customer/layout/top_sidebar');
			$this->load->view('customer/layout/left_sidebar');
			$this->load->view('customer/index_view');
			$this->load->view('customer/layout/footer');
		}
		public function loyaltyPoints(){
			
			$rest_url_slug = $this->rest_url_slug;
			$iframe = '';
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;

			$data['site_lang']=$this->session->userdata("site_lang");

			$data['customer'] = $this->db->where("user_id",$this->userID)->get("tbl_customers")->row();
			$user_id = $this->userID;
		
			$query = "SELECT * FROM `tbl_customer_loyalty_points` clp JOIN `tbl_loyalty_point_settings` lps ON clp.rest_id = lps.rest_id JOIN tbl_restaurant r ON  clp.rest_id = r.rest_id JOIN tbl_restaurant_details d ON r.rest_id = d.restaurant_id WHERE clp.user_id = $user_id AND d.activation_status = 'Accepted'";
			$data['points'] = $this->db->query($query)->result();
			$this->load->view('customer/layout/header',$data);
			$this->load->view('customer/layout/top_sidebar');
			$this->load->view('customer/layout/left_sidebar');
			$this->load->view('customer/loyalty-points_view');
			$this->load->view('customer/layout/footer');
		}
		public function myorders(){
			$rest_url_slug = $this->rest_url_slug;
			$iframe = '';
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;

			$filtered_rest_id = $this->input->get("rest");
			$filtered_status = $this->input->get("status");
			$filtered_date_range = $this->input->get("daterange");

			$data['filtered_rest_id'] = $filtered_rest_id;
			$data['filtered_status'] = $filtered_status;
			$data['filtered_date_range'] = $filtered_date_range;

			$user_id = $this->userID;
			$data['customer'] = $this->db->where("user_id",$this->userID)->get("tbl_customers")->row();
			$data['site_lang']=$this->session->userdata("site_lang");

			$rest_query = "SELECT DISTINCT  r.*,d.* FROM tbl_customers c JOIN tbl_orders o ON o.order_customer_id = c.customer_id JOIN tbl_restaurant r ON o.order_rest_id = r.rest_id JOIN tbl_restaurant_details d ON r.rest_id = d.restaurant_id WHERE c.user_id = $user_id AND d.activation_status = 'Accepted'";
			$data['rests'] = $this->db->query($rest_query)->result();

			if (null !== $filtered_rest_id && "" !== $filtered_rest_id){
				$query_filtering_rest = " AND o.order_rest_id = " . $filtered_rest_id . " ";
			}else{
				$query_filtering_rest = "";
			}
			if (null !== $filtered_status && "" !== $filtered_status){
				$query_filtering_status = " AND o.order_status = '" . $filtered_status . "' ";
			}else{
				$query_filtering_status = "";
			}

			if (null !== $filtered_date_range && "" !== $filtered_date_range){
				$min_date = date_format(date_create( explode("-", trim($filtered_date_range))[0]),"Y-m-d 00:00:00");
				$max_date = date_format(date_create( explode("-", trim($filtered_date_range))[1]),"Y-m-d 23:59:59");
				$query_filtering_data_range = " AND o.order_date > '" . $min_date . "' AND o.order_date < '" . $max_date . "' ";
			}else{
				$query_filtering_data_range = "";
			}
			$order_query = "SELECT o.* ,r.* ,d.* FROM tbl_orders o JOIN tbl_customers c ON o.order_customer_id = c.customer_id JOIN tbl_restaurant r ON o.order_rest_id = r.rest_id JOIN tbl_restaurant_details d ON r.rest_id = d.restaurant_id WHERE c.user_id = $user_id AND d.activation_status = 'Accepted' " . $query_filtering_rest . $query_filtering_status . $query_filtering_data_range;
			
			$data['orders'] = $this->db->query($order_query)->result();

			$extra_style[] = '<link href="'.base_url("assets/additional_assets/template/libs/bootstrap-datepicker/bootstrap-datepicker.css").'" rel="stylesheet">';
			$extra_style[] = '<link href="'.base_url("assets/additional_assets/template/libs/bootstrap-daterangepicker/daterangepicker.css").'" rel="stylesheet">';

			$extra_script[] = '<script src="'.base_url("assets/additional_assets/template/libs/moment/moment.js").'"></script>';
			$extra_script[] = '<script src="'.base_url("assets/additional_assets/template/libs/bootstrap-datepicker/bootstrap-datepicker.min.js").'"></script>';
			$extra_script[] = '<script src="'.base_url("assets/additional_assets/template/libs/bootstrap-daterangepicker/daterangepicker.js").'"></script>';
			$extra_script[] = '<script>jQuery(".input-daterange-datepicker").daterangepicker({buttonClasses:["btn","btn-sm"],applyClass:"btn-secondary",cancelClass:"btn-primary"});
			</script>';
			$data['extra_style'] = $extra_style;
			$data['extra_script'] = $extra_script;
			$this->load->view('customer/layout/header',$data);
			$this->load->view('customer/layout/top_sidebar');
			$this->load->view('customer/layout/left_sidebar');
			$this->load->view('customer/myorders_view');
			$this->load->view('customer/layout/footer');
		}
		public function orderdetail($order_id){
			$rest_url_slug = $this->rest_url_slug;
			$iframe = '';
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;
			
			$data['customer'] = $this->db->where("user_id",$this->userID)->get("tbl_customers")->row();
			$data['site_lang']=$this->session->userdata("site_lang");
			$data['_lang']=$this->session->userdata("site_lang");
			$data['order'] = $this->db->where("order_id",$order_id)->where("order_customer_id",$order_id)->join('tbl_customers','tbl_customers.customer_id = tbl_orders.order_customer_id')->get('tbl_orders')->row();
			$user_id =  $this->userID;
			$order_query = "SELECT o.* ,r.* ,d.* FROM tbl_orders o JOIN tbl_customers c ON o.order_customer_id = c.customer_id JOIN tbl_restaurant r ON o.order_rest_id = r.rest_id JOIN tbl_restaurant_details d ON r.rest_id = d.restaurant_id WHERE c.user_id = $user_id AND d.activation_status = 'Accepted' AND o.order_id = $order_id";
			$order = $this->db->query($order_query)->row();
			if (null !== $order){
				$data['order']  = $order;
			}else{
				redirect(base_url("Customer/myorders"));
			}
			$this->load->view('customer/layout/header',$data);
			$this->load->view('customer/layout/top_sidebar');
			$this->load->view('customer/layout/left_sidebar');
			$this->load->view('customer/orderdetail_view');
			$this->load->view('customer/layout/footer');
		}
		public function account(){
			$rest_url_slug = $this->rest_url_slug;
			$iframe = '';
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;
			
			$data['customer'] = $this->db->where("user_id",$this->userID)->get("tbl_customers")->row();
			$data['site_lang']=$this->session->userdata("site_lang");
			$data['_lang']=$this->session->userdata("site_lang");
			
			$this->load->view('customer/layout/header',$data);
			$this->load->view('customer/layout/top_sidebar');
			$this->load->view('customer/layout/left_sidebar');
			$this->load->view('customer/account_view');
			$this->load->view('customer/layout/footer');
		}
		public function logOut(){
			if($this->session->userdata('customer_Data')){
				$this->session->unset_userdata('customer_Data');
			}
			redirect('Home');
		}

		public function updateAccount(){
			$nf = true;
			$error_msg = "";
			$customer_email = $this->input->post("email"); 
			if ($this->input->post("new_password") !== ""){
				if($this->input->post("new_password") == $this->input->post("confirm_password")){
					$current_pass = $this->input->post("current_password");
					$customer_pass = md5(trim($current_pass));

					$customer_new_pass = md5(trim($this->input->post("new_password")));
					if ( $this->db->where("id = $this->userID AND customer_pass = '$customer_pass' ")->get("tbl_users")->row()){
						if ($this->db->where('customer_email', $customer_email)->update('tbl_users',array('customer_pass' => $customer_new_pass))){
						}else{
							$error_msg = "There are something wrong.";
							$nf= false;
						}
					}else{
						$error_msg = "Enter your current password correctly.";
						$nf = false;
					}
				}else{
					$nf= false;
					$error_msg = "Password should be matched.";
				}
			}
			if (!$nf){
				die(json_encode(array("status"=>0,"msg"=>$error_msg)));
			}else{
				$data = array(
					"customer_name" => $this->input->post("name"),
					"customer_phone" => $this->input->post("phone"),
					"customer_email" => $this->input->post("email"),
					"customer_postcode" => $this->input->post("postcode"),
					"customer_country_abv" => $this->input->post("country"),
					"customer_address" => $this->input->post("address"),
					"customer_city" => $this->input->post("city"),
					"customer_floor" => $this->input->post("floor"),
					"user_id" => $this->userID,
				);
				$re = $this->MODEL->updateUserAccount($this->userID,$data);
				if ($re){
					die(json_encode(array("status"=>1)));
				}else{
					die(json_encode(array("status"=>0,"msg"=>"There are something wrong.")));
				}
			}
		}
	}
?>