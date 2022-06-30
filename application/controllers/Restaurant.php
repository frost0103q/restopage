<?php
	/**
	 * 
	 */
	class Restaurant extends CI_Controller
	{
		public $myRestId=0;
		public $myRestName="";
		public $myRestDetail;
		public $addon_features;
		function __construct()
		{
			parent::__construct();
			$this->load->model('AdminModel','MODEL');
			
			if(!$this->session->userdata('rest_user_Data')){
				redirect('Home/login');
			}else{
				$sessData=unserialize($this->session->userdata('rest_user_Data'));
				$this->myRestId=$sessData[0]->rest_id;
				$this->myRestName=$sessData[0]->rest_name;
				$this->myRestDetail = $this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
				$rest_currency_id = $this->myRestDetail->currency_id;
				$rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
				$rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;
				
				if ($this->session->userdata("site_lang_admin") == ""){
					$this->session->set_userdata('site_lang_admin', "french");
				}
				if ( null !== $this->input->get("lang")){
					$this->changeAdminLanguage( $this->input->get("lang"));
				}

				$this->lang->load('content_lang',$this->session->userdata("site_lang_admin"));
	
				$admin_rest_id = 1;
				$admin_rest = $this->db->where("rest_id", $admin_rest_id)->get("tbl_payment_settings")->row();
				$config_recurring = array(
					'SandboxFlag' => $this->config->item('Sandbox'),            // Sandbox / testing mode option.
		
					'API_UserName' => $admin_rest->paypal_api_username ,    // PayPal API username of the API caller
					'API_Password' => $admin_rest->paypal_api_password,    // PayPal API password of the API caller
					'API_Signature' => $admin_rest->paypal_api_signature,    // PayPal API signature of the API caller
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

				$data['currentRestDetail'] = $this->myRestDetail;
				$data['currentRestCurrencySymbol'] = $rest_currency_symbol;
				$addon_features = $this->MODEL->getAddonFeatures_by_rest_id($this->myRestId);
				$data['addon_features'] = $addon_features;
				$this->addon_features = $addon_features;
				$this->load->vars($data);
			}
		}
		private function createURLWithLang($url){
			$lang_surfix = "fr";
			$lang = "french";
			if ($this->session->userdata("site_lang_admin") !== ""){
				$lang = $this->session->userdata("site_lang_admin");
			}
			if ($lang == "english"){
				$lang_surfix = "en";
			}elseif ($lang == "germany"){
				$lang_surfix = "de";
			}elseif ($lang == "french"){
				$lang_surfix = "fr";
			}		
			return $url . "?lang=" . $lang_surfix;
		}
		public function index(){
			if(!$this->session->userdata('rest_user_Data')){
				$this->load->view('website/pages/index');
			}else{
				$this->Setting();
			}
		}
		public function changeAdminLanguage($lang){
			$full_lang = "french";
			if ($lang == "en"){
				$this->session->set_userdata('site_lang_admin', "english");
				$full_lang = "english";
			}elseif ($lang == "de"){
				$this->session->set_userdata('site_lang_admin', "germany");
				$full_lang = "germany";
			}elseif ($lang == "fr"){
				$this->session->set_userdata('site_lang_admin', $full_lang);
				$full_lang = "french";
			}
			$toUpdate=array(
				"admin_language"	=>	$full_lang,
			);
			$this->db->where('restaurant_id',$this->myRestId)->update('tbl_restaurant_details',$toUpdate);
		}
		public function logOut(){
			if($this->session->userdata('rest_user_Data')){
				$this->session->unset_userdata('rest_user_Data');
			}
			redirect('Home');
		}
		public function Menu($lang = "english"){
		    $data['Categories']=$this->db->order_by("category_sort_index","ASC")->where("added_by='$this->myRestId' or added_by=0")->where("category_status","active")->get('tbl_category')->result();
		    $data['allergens']=$this->db->where("added_by='$this->myRestId' or added_by=0")->get('tbl_allergens')->result();
		    $data['taxes']=$this->db->where("rest_id='$this->myRestId'")->get('tbl_tax_settings')->result();
			$data['addRest']=$this->MODEL->getAllActiveRest();
			$data['myRestId']=$this->myRestId;
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			if ($data['restDetails']->menu_languages !== "" && $data['restDetails']->menu_languages !== null && $this->session->userdata('site_lang_admin')){
				if(in_array($this->session->userdata('site_lang_admin'),explode(",", $data['restDetails']->menu_languages))){
					$data['category_lang'] = $this->session->userdata('site_lang_admin');
				}else{
					$data['category_lang'] = explode(",", $data['restDetails']->menu_languages)[0];
				}
			}else{
				$data['category_lang'] = "french";
			}
			$data['myRestName']=$this->myRestName;
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/createMenu');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function pageSetting($parameter = "Homepage"){
			$data['myRestId']=$this->myRestId;
			if ($this->session->userdata('site_lang_admin')){
				$data['_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['_lang'] = "french";
			}
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();

			$data['sliders']=$this->db->where('rest_id',$this->myRestId)->get('tbl_sliders')->result();
			if ($parameter == "Homepage"){
				$data['is_service_section_exist'] = $this->db->where('rest_id',$this->myRestId)->where('section_id','homepage-my-service')->get('tbl_restaurant_homepage_section_sort')->row();
				$data['is_welcome_section_exist'] = $this->db->where('rest_id',$this->myRestId)->where('section_id','homepage-welcome')->get('tbl_restaurant_homepage_section_sort')->row();
				$data['sectionSort']=$this->db->where('rest_id',$this->myRestId)->order_by('sort_num','ASC')->get('tbl_restaurant_homepage_section_sort')->result();

			}

			$data['page_content']=$this->db->where('rest_id',$this->myRestId)->get('tbl_page_contents')->row();
			// modify by Jfrost in 2nd stage
			$data['homepage_services']=$this->db->query('SELECT s.* ,IF (hs.service_status = 1, 1,0) service_status , hs.id hs_id FROM tbl_services s  LEFT JOIN (SELECT * FROM tbl_homepage_services WHERE rest_id = '.$this->myRestId.') hs ON hs.service_id = s.id;')->result();
			$data['myRestName']=$this->myRestName;
			$this->load->view('restaurant_dashboard/layout/header',$data);
			if ($parameter == "Homepage"){
				$this->load->view('restaurant_dashboard/pages/pageSetting');
			}elseif ($parameter == "Slider"){
				$this->load->view('restaurant_dashboard/pages/restaurantSlider');
			}
			$this->load->view('restaurant_dashboard/layout/footer');
		}

		public function rejectedMenu(){
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			if ($this->session->userdata('site_lang_admin')){
				$data['category_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['category_lang'] = "french";
			}
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/rejected_menu');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function videoTutorials(){
			$data['myRestId']	=		$this->myRestId;
			$data['myRestName']	=	$this->myRestName;
			$data["video_tutorials"] = $this->db->get("tbl_video_tutorials")->result();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantVideoTutorial');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function SEOSettings(){
			$data['myRestId']	=		$this->myRestId;
			$data['myRestName']	=	$this->myRestName;
			$data["seo"] = $this->db->where("seo_rest_id" , $this->myRestId)->get("tbl_seo_settings")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantSEO');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function googleAnalytics(){
			$data['myRestId']	=		$this->myRestId;
			$data['myRestName']	=	$this->myRestName;
			$data["seo"] = $this->db->where("seo_rest_id" , $this->myRestId)->get("tbl_seo_settings")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/googleAnalytics');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function FreeSupport(){
			$data['myRestId']	=		$this->myRestId;
			$data['myRestName']	=	$this->myRestName;
			$data["admin"] = $this->db->get("tbl_admin")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantFreeSupport');
			$this->load->view('restaurant_dashboard/layout/footer');
		}

		public function Setting($parameter = "Detail"){
			$data['Categories']=$this->MODEL->getAll("tbl_category");
			$data['addRest']=$this->MODEL->getAllActiveRest();
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			if ($data['restDetails']->admin_language == ""){
				$this->session->set_userdata('site_lang_admin', "french");
			}else{
				$this->session->set_userdata('site_lang_admin', $data['restDetails']->admin_language);
			}
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['announcement'] = $this->db->where('rest_id' , $this->myRestId)->get('tbl_announcement')->row();
			$data["kitchens"] = $this->db->get("tbl_kitchens")->result();
			$data['externalStyle']='<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc&sensor=false&amp;libraries=places" type="text/javascript"></script>
			';
			
			$this->load->view('restaurant_dashboard/layout/header',$data);
			if ($parameter == "Package"){
				$this->load->view('restaurant_dashboard/pages/restaurantPackage');
			}elseif ($parameter == "Kitchen"){
				$this->load->view('restaurant_dashboard/pages/restaurantKitchen');
			}elseif ($parameter == "MyDomain"){
				$this->load->view('restaurant_dashboard/pages/restaurantMyDomain');
			}elseif ($parameter == "Announcements"){
				$this->load->view('restaurant_dashboard/pages/restaurantAnnouncements');
			}elseif ($parameter == "CancelPackage"){
				$this->load->view('restaurant_dashboard/pages/restaurantCancelPackage');
			}elseif ($parameter == "ActivePage"){
				$this->load->view('restaurant_dashboard/pages/restaurantActivePage');
			}elseif ($parameter == "Language"){
				$this->load->view('restaurant_dashboard/pages/restaurantLanguage');
			}elseif ($parameter == "SupportTicket"){
				$this->load->view('restaurant_dashboard/pages/restaurantSupportTicket');
			}else{
				$this->load->view('restaurant_dashboard/pages/restaurantSettings');
			}
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function bannerSetting(){
			$data['addRest']=$this->MODEL->getAllActiveRest();
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['banner_settings']=$this->db->where("rest_id",$this->myRestId)->get("tbl_banner_settings")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantBannerSettings');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function legalPageSetting(){
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['legal_page_settings']=$this->db->where("rest_id",$this->myRestId)->get("tbl_legal_settings")->row();
			$data['standard_legal_page_settings']=$this->db->where("rest_id","0")->get("tbl_legal_settings")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantLegalPagesSetting');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function loaltyPoints(){
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['loaltyPoints']=$this->db->where("rest_id",$this->myRestId)->get("tbl_loyalty_point_settings")->row();
			$data['clients']=$this->db->where("rest_id",$this->myRestId)->where("loyalty_points > 0")->join("tbl_users","tbl_customer_loyalty_points.user_id = tbl_users.id")->get("tbl_customer_loyalty_points")->result();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantLoaltyPoints');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function recurringPaymentReview($addon_invoice_id){
			$data['addRest']=$this->MODEL->getAllActiveRest();
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			$data['addon_invoice'] = $this->db->where("id", $addon_invoice_id)->join('tbl_addons','tbl_addons.addon_id=tbl_addon_invoices.addon_id')->get("tbl_addon_invoices")->row();
			if ($data['restDetails']->admin_language == ""){
				$this->session->set_userdata('site_lang_admin', "french");
			}else{
				$this->session->set_userdata('site_lang_admin', $data['restDetails']->admin_language);
			}

			$token = "";
			if (isset($_REQUEST['token']))
			{
				$token = $_REQUEST['token'];
			}
			$resArray = array();
			// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.	
			if ( $token != "" ){
				$resArray = $this->recurringpayment->GetShippingDetails( $token );
			}
			$data["resArray"] = $resArray;
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/addonRecurringPaymentReview_');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function addonRecurringPaymentReview(){
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			if ($data['restDetails']->admin_language == ""){
				$this->session->set_userdata('site_lang_admin', "french");
			}else{
				$this->session->set_userdata('site_lang_admin', $data['restDetails']->admin_language);
			}

			$token = "";
			$addon_invoice_id = isset($_SESSION["addon_invoice_id"]) ? $_SESSION["addon_invoice_id"] : false;
			if ($addon_invoice = $this->db->where("id",$addon_invoice_id)->get("tbl_addon_invoices")->row()){
				$addon_id = $addon_invoice->addon_id;
				$data["addon_invoice"] = $addon_invoice;
				if ($addon_id){
					$data["addon"] = $this->db->where("addon_id",$addon_id)->get("tbl_addons")->row();
					
					if (isset($_REQUEST['token']))
					{
						$token = $_REQUEST['token'];
					}
					$resArray = array();
					
					// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.	
					if ( $token != "" ){
						$resArray = $this->recurringpayment->GetShippingDetails( $token );
					}
					if (!empty($resArray)){
						$data["resArray"] = $resArray;
						$this->load->view('restaurant_dashboard/layout/header',$data);
						$this->load->view('restaurant_dashboard/pages/addonRecurringPaymentReview');
						$this->load->view('restaurant_dashboard/layout/footer');
					}else{
						redirect($this->createURLWithLang("Restaurant/Addon"));
					}
				}else{
					$this->Addon();
				}
			}else{
				$this->Addon();
			}
		}
		// modify by Jfrost in 2nd stage
		public function colorSetting(){
			$data['Categories']=$this->MODEL->getAll("tbl_category");
			$data['addRest']=$this->MODEL->getAllActiveRest();
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			$data['externalStyle']='<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet">';
			$data['externalStyle'].='<link href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css" rel="stylesheet"> ';
			$data['externalStyle'].='<link href="'.base_url('assets/additional_assets/css/').'selectGfont.min.css" rel="stylesheet"> ';
			$data['externalScript']='<script  src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> ';
			$data['externalScript'].='<script  src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js" defer></script> ';
			$data['externalScript'].='<script  src="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js"></script> ';
			$data['externalScript'].='<script  src="'.base_url('assets/additional_assets/').'js/selectGfont.js"></script> ';
			// $data['google_font']=$google_font;
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/colorSetttings');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function paymentSetting(){
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$rest_details=$this->db->where('restaurant_id',$this->myRestId)->get('tbl_restaurant_details')->row();
			if (in_array("online_payments",$this->addon_features)){
				$data['paymentSetting']=$this->db->where('rest_id',$this->myRestId)->get('tbl_payment_settings')->row();
				$this->load->view('restaurant_dashboard/layout/header',$data);
				$this->load->view('restaurant_dashboard/pages/paymentSetting');
				$this->load->view('restaurant_dashboard/layout/footer');
			}else{
				$this->index();
			}
		}
		public function Addon(){
			$data['myRestId']=$this->myRestId;
			$data['rest_id']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['addons']=$this->db->where('addon_status',"active")->get("tbl_addons")->result();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantAddon');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function AddonPayout($addon_id){
			$data['myRestId']=$this->myRestId;
			$data['addon_id']=$addon_id;
			$data['rest_id']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$rest_details=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			$data['restDetails']=$rest_details;
			$data['externalScript']='<script src="https://checkout.stripe.com/checkout.js"></script> ';
			if ($rest_details->resto_plan == "pro"){
				$this->load->view('restaurant_dashboard/layout/header',$data);
				$this->load->view('restaurant_dashboard/pages/restaurantAddonPayout');
				$this->load->view('restaurant_dashboard/layout/footer');
			}else{
				$this->index();
			}
		}
		public function AddonInvoices(){
			$data['myRestId']=$this->myRestId;
			$data['rest_id']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$rest_details=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			$data['restDetails']=$rest_details;
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['addoninvoices']=$this->db->where('rest_id',$this->myRestId)->get("tbl_addon_invoices")->result();

			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantAddonInvoices');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function AddonInvoiceDetail($invoice_id){
			$data['myRestId']=$this->myRestId;
			$data['rest_id']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$rest_details=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			$data['restDetails']=$rest_details;
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['addonInvoice']=$this->db->where("rest_id",$this->myRestId)->where('id',$invoice_id)->get("tbl_addon_invoices")->row();
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantAddonInvoiceDetail');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function openingTime(){
			$data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['openingTimes']=$this->MODEL->getOpeningTime($this->myRestId);
			$data['externalStyle']='<link href="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">';
			$data['externalStyle'].='<link href="'.base_url('assets/additional_assets/jquery-ui-timepicker').'/jquery.ui.timepicker.css" rel="stylesheet">';
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			
			$openingTimes = $this->db->where("rest_id",$this->myRestId)->get("tbl_opening_times")->row();
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
			$rest_open = false;
			if (isset($openingTimes)){
				$rest_hours = $openingTimes->opening_hours;
				if (isset($rest_hours) && $rest_hours !== ""){
					$rest_hours = json_decode($rest_hours);
					foreach ($rest_hours[$now_weekday] as $rkey => $rvalue) {
						$rest_start = $rvalue->start;
						$rest_end = $rvalue->end;
						if (strtotime($now_H.":". $now_i .":00") > strtotime($rest_start .":00") && strtotime($now_H.":". $now_i .":00") < strtotime($rest_end .":00")){
							$rest_open = true;
						}

					}
					
				}

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
			$data['rest_open']=$rest_open;
			$data['pickup_open']=$pickup_open;
			$data['delivery_open']=$delivery_open;
			
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/openingTime');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function Category($lang = "english"){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['Categories']=$this->db->order_by("category_sort_index")->where("(added_by='$this->myRestId' or added_by=0)")->get('tbl_category')->result();
			// $data['Categories']=$this->db->order_by("category_sort_index")->where("(added_by='$this->myRestId' or added_by=0) and category_status <> 'deactive'")->get('tbl_category')->result();
			// modify by Jfrost
			// $data['category_lang'] = $lang;
			$data['category_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/category');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		// modify by Jfrost in 3rd stage
		public function FoodExtra($lang = "english"){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			// $data['Categories']=$this->db->order_by("extra_category_sort_index")->where("(added_by='$this->myRestId' or added_by=0) and extra_category_status <> 'deactive'")->get('tbl_food_extra_category')->result();
			$data['Categories']=$this->db->order_by("extra_category_sort_index")->where("(added_by='$this->myRestId' or added_by=0)")->get('tbl_food_extra_category')->result();
			// modify by Jfrost
			// $data['category_lang'] = $lang;
			$data['category_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/foodextra');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function Reservation($lang = "english"){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['reservations']=$this->db->where("rest_id",$this->myRestId)->get('tbl_reservations')->result();
		
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/reservation');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function rejectedFoodExtra(){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			
			$data['category_lang'] = $this->session->userdata('site_lang_admin');
			$data['Categories']=$this->db->order_by("extra_category_sort_index")->where("(added_by='$this->myRestId' or added_by=0) and extra_category_status = 'deactive'")->get('tbl_food_extra_category')->result();

			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/rejected_extra_category');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function rejectedCategory(){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			
			$data['category_lang'] = $this->session->userdata('site_lang_admin');
			$data['Categories']=$this->db->order_by("category_sort_index")->where("(added_by='$this->myRestId' or added_by=0 ) and category_status = 'deactive'")->get('tbl_category')->result();

			if ($this->session->userdata('site_lang_admin')){
				$data['category_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['category_lang'] = "french";
				$this->session->set_userdata('site_lang_admin', "french");
			}

			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/rejected_category');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function allergens($lang = "english"){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['allergens']=$this->db->where("added_by='$this->myRestId' or added_by=0")->get('tbl_allergens')->result();
			// modify by Jfrost
			// $data['category_lang'] = $lang;
			$data['allergen_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/allergen');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function categoryDetails($cate_id){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['CategoryDetails']=$this->MODEL->getCategoryDetails($cate_id);
			$data['subCategoryDetails']=$this->MODEL->getCategorySubDetails($cate_id);
			$data['FoodExtraDetails']=$this->MODEL->getFoodExtraDetails($cate_id);
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/categoryDetails');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function ExtraCategoryDetails($cate_id){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['CategoryDetails']=$this->MODEL->getExtraCategoryDetails($cate_id);
			$data['FoodExtraDetails']=$this->MODEL->getFoodExtraDetails($cate_id);
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/extracategoryDetails');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function allergenDetails($allergen_id){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['AllergenDetails']=$this->MODEL->getAllergenDetails($allergen_id);
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/allergenDetails');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function deliveryArea(){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
			$data['delivery_areas']=$this->db->where("rest_id",$this->myRestId)->get('tbl_delivery_areas')->result();
			$data['area_zones']=$this->db->where("rest_id",$this->myRestId)->get('tbl_delivery_area_zones')->result();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$rest_details=$this->db->where('restaurant_id',$this->myRestId)->get('tbl_restaurant_details')->row();
			$geocode = json_decode($rest_details->geocode);
			if (isset($geocode->lat) && isset($geocode->lat)){
				$data['lat'] = $geocode->lat;
				$data['lng'] = $geocode->lng;
			}else{
				$data['lat'] = "49.6773308";
				$data['lng'] = "6.44405039";
			}

			$data['externalStyle']=' <link href="'.base_url('assets/additional_assets/').'template/libs/toastr/toastr.min.css" rel="stylesheet" type="text/css" />';
			$data['externalStyle'].=' <link href="'.base_url('assets/additional_assets/').'template/css/icons.min.css" rel="stylesheet" type="text/css" />';
			$data['externalStyle'].=' <script type="text/javascript" src="'.base_url('assets/additional_assets/').'js/deliveryZone.js"></script>';
			
			$data['externalScript']='<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVqwHQGAyMBx6u8BD_FMn1Qo3wSYvYflc&libraries=drawing,geometry&v=weekly" async></script>';
			$data['externalScript'].='<script type="text/javascript" src="'.base_url('assets/additional_assets/').'template/libs/toastr/toastr.min.js"></script>';

			if (in_array("delivery_zones",$this->addon_features)){
				$this->load->view('restaurant_dashboard/layout/header',$data);
				$this->load->view('restaurant_dashboard/pages/deliveryArea');
				$this->load->view('restaurant_dashboard/layout/footer');
			}else{
				$this->index();
			}
		}
		public function taxSetting(){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
			$data['delivery_tax']=$this->db->where('restaurant_id',$this->myRestId)->get('tbl_restaurant_details')->row()->delivery_tax;
			$data['tax_list']=$this->db->where("rest_id",$this->myRestId)->get('tbl_tax_settings')->result();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$rest_details=$this->db->where('restaurant_id',$this->myRestId)->get('tbl_restaurant_details')->row();
				
			if (in_array("tax_setting",$this->addon_features)){
				$this->load->view('restaurant_dashboard/layout/header',$data);
				$this->load->view('restaurant_dashboard/pages/taxSetting');
				$this->load->view('restaurant_dashboard/layout/footer');
			}else{
				$this->index();
			}
		}
		public function socialSetting(){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
			$data['social_setting']=$this->db->where("rest_id",$this->myRestId)->get('tbl_social_settings')->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/restaurantSocial');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function deliveryAreaDetail($area_id){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['areaDetail']=$this->db->where('id',$area_id)->get('tbl_delivery_areas')->row();

			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/deliveryAreaDetail');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function clients(){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
			$data['clients']=$this->db->query('SELECT tc.* , o.order_id, u.id, u.customer_status,u.customer_email AS account_email FROM `tbl_customers` tc 
				JOIN `tbl_orders` o ON o.order_customer_id = tc.customer_id 
				LEFT JOIN `tbl_users` u ON u.id  = tc.user_id
				WHERE o.order_rest_id = '.$this->myRestId.' AND  tc.customer_id > 0
				GROUP BY tc.customer_email')->result();
		
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/clients');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function clientOrder($customer_id,$filter = "all"){
			if ($customer = $this->db->where("customer_id",$customer_id)->get("tbl_customers")->row()){
				$customer_email = $customer->customer_email;
			}else{
				$customer_email = "none";
			}
			$data["customer_id"] = $customer_id;
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;

			if( $filter == "accepted"){
				$filter_query = " AND o.order_status = 'accepted' AND c.customer_email = '".$customer_email."' ";
			}elseif( $filter == "pending"){
				$filter_query = " AND o.order_status = 'pending' AND c.customer_email = '".$customer_email."' ";
			}elseif( $filter == "finished"){
				$filter_query = " AND o.order_status = 'finished' AND c.customer_email = '".$customer_email."' ";
			}elseif( $filter == "rejected"){
				$filter_query = " AND o.order_status = 'canceled' AND c.customer_email = '".$customer_email."' ";
			}else{
				$filter_query = " AND c.customer_email = '".$customer_email."' ";
			}
			$data['filter_type'] = $filter;
			$data['orders'] = $this->db->query("SELECT o.* , c.* FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId.$filter_query." AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash')
			ORDER BY o.order_date DESC")->result();
			
			$data['pending_order_value'] =$this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId."  AND c.customer_email = '".$customer_email."' AND o.order_status = 'pending' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['finished_order_value'] =$this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId."  AND c.customer_email = '".$customer_email."' AND o.order_status = 'finished' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['canceled_order_value'] = $this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId."  AND c.customer_email = '".$customer_email."' AND o.order_status = 'canceled' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['accepted_order_value'] = $this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId."  AND c.customer_email = '".$customer_email."' AND o.order_status = 'accepted' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['total_order_value'] = floatVal($data['accepted_order_value'])+floatVal($data['pending_order_value'])+floatVal($data['canceled_order_value'])+floatVal($data['finished_order_value']);
			
			// $data['total_order_value'] = number_format($this->db->query("SELECT SUM(order_amount) total_amount FROM tbl_customers t JOIN tbl_orders o ON t.customer_id = o.order_customer_id WHERE order_rest_id = $this->myRestId")->row()->total_amount,2);
			$rest_details=$this->db->where('restaurant_id',$this->myRestId)->get('tbl_restaurant_details')->row();
				
			if (in_array("order_management",$this->addon_features) && in_array("client_management",$this->addon_features)){
				$this->load->view('restaurant_dashboard/layout/header',$data);
				$this->load->view('restaurant_dashboard/pages/clientOrderManagement');
				$this->load->view('restaurant_dashboard/layout/footer');
			}else{
				$this->index();
			}
		}
		public function orderManagement($filter = "all"){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;

			if( $filter == "accepted"){
				$filter_query = " AND o.order_status = 'accepted' ";
			}elseif( $filter == "pending"){
				$filter_query = " AND o.order_status = 'pending' ";
			}elseif( $filter == "finished"){
				$filter_query = " AND o.order_status = 'finished' ";
			}elseif( $filter == "rejected"){
				$filter_query = " AND o.order_status = 'canceled' ";
			}else{
				$filter_query = "";
			}
			$data['filter_type'] = $filter;
			$data['orders'] = $this->db->query("SELECT o.* , c.* FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId.$filter_query." AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash' OR o.order_payment_method = 'creditcard_on_the_door')
			ORDER BY o.order_date DESC")->result();
			
			$data['pending_order_value'] =$this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId." AND o.order_status = 'pending' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash' OR o.order_payment_method = 'creditcard_on_the_door')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['finished_order_value'] =$this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId." AND o.order_status = 'finished' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash' OR o.order_payment_method = 'creditcard_on_the_door')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['canceled_order_value'] = $this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId." AND o.order_status = 'canceled' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash' OR o.order_payment_method = 'creditcard_on_the_door')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['accepted_order_value'] = $this->db->query("SELECT SUM(o.order_amount) total_amount FROM tbl_orders o 
			JOIN tbl_customers c ON o.order_customer_id = c.customer_id
			LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id
			WHERE  o.order_rest_id = ".$this->myRestId." AND o.order_status = 'accepted' AND (o.order_payout_status = 'paid' OR (o.order_payout_status = 'unpaid' AND o.order_payment_method = 'stripe' AND s.temp_id > 0) OR o.order_payment_method = 'cash' OR o.order_payment_method = 'creditcard_on_the_door')
			ORDER BY o.order_date DESC")->row()->total_amount;

			$data['total_order_value'] = floatVal($data['accepted_order_value'])+floatVal($data['pending_order_value'])+floatVal($data['canceled_order_value'])+floatVal($data['finished_order_value']);
			
			// $data['total_order_value'] = number_format($this->db->query("SELECT SUM(order_amount) total_amount FROM tbl_customers t JOIN tbl_orders o ON t.customer_id = o.order_customer_id WHERE order_rest_id = $this->myRestId")->row()->total_amount,2);
			$rest_details=$this->db->where('restaurant_id',$this->myRestId)->get('tbl_restaurant_details')->row();
			if (in_array("order_management",$this->addon_features)){
				$this->load->view('restaurant_dashboard/layout/header',$data);
				$this->load->view('restaurant_dashboard/pages/orderManagement');
				$this->load->view('restaurant_dashboard/layout/footer');
			}else{
				$this->index();
			}
		}

		public function orderDetail($order_id){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
			$data['order'] = $this->db->where("order_id",$order_id)->join('tbl_customers','tbl_customers.customer_id = tbl_orders.order_customer_id')->get('tbl_orders')->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/orderDetail');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function myQrCode(){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['myRestUrlSlug']=$this->db->where('rest_id',$this->myRestId)->get('tbl_restaurant')->row()->rest_url_slug;
		
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/myQr');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function editMenu($item_id,$lang="english"){
		    $data['myRestId']=$this->myRestId;
			$data['myRestName']=$this->myRestName;
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			
			$data['ItemType']=$this->db->query('SELECT ct.* FROM `tbl_category_type` ct JOIN `tbl_category` c ON ct.type_id = c.type_id GROUP BY ct.type_id')->result();
			$data['itemDetails']=$this->db->where('menu_id',$item_id)->get('tbl_menu_card')->row();
			$my_category_id = $data['itemDetails']->category_id;
			$my_type = $this->db->where('category_id',$my_category_id)->get('tbl_category')->row()->type_id;
			// $data['Categories']=$this->db->where("type_id = '$my_type' and (added_by='$this->myRestId' or added_by=0)")->get('tbl_category')->result();
			$data['Categories']=$this->db->order_by("category_sort_index","ASC")->where("added_by='$this->myRestId' or added_by=0")->where("category_status","active")->get('tbl_category')->result();
			$data['section_lang']=$lang;
		    $data['allergens']=$this->db->where("added_by='$this->myRestId' or added_by=0")->get('tbl_allergens')->result();
		    $data['taxes']=$this->db->where("rest_id='$this->myRestId'")->get('tbl_tax_settings')->result();
			$data['subCategories']=$this->MODEL->getCategorySubDetails($data['itemDetails']->category_id);
			$data['foodExtras']=$this->MODEL->getFoodExtraDetails($data['itemDetails']->category_id);
			$data['Extras']=explode('|',$data['itemDetails']->item_food_extra);
			$data['subCat']=explode(',',$data['itemDetails']->sub_cat_ids);
			$data['allergen_arr']=explode(',',$data['itemDetails']->item_allergens);
			$data['Prices']=explode(',',$data['itemDetails']->item_prices);
			if ($data['restDetails']->menu_languages !== "" && $data['restDetails']->menu_languages !== null && $this->session->userdata('site_lang_admin')){
				if(in_array($this->session->userdata('site_lang_admin'),explode(",", $data['restDetails']->menu_languages))){
					$data['category_lang'] = $this->session->userdata('site_lang_admin');
				}else{
					$data['category_lang'] = explode(",", $data['restDetails']->menu_languages)[0];
				}
			}else{
				$data['category_lang'] = "french";
			}
			$this->load->view('restaurant_dashboard/layout/header',$data);
			$this->load->view('restaurant_dashboard/pages/edit_menu');
			$this->load->view('restaurant_dashboard/layout/footer');
		}
		public function addMenuItem(){
			if (null !== $this->input->post('category_id') && $this->input->post('category_id') > 0){
				$category_id = $this->input->post('category_id');

				if (file_exists($_FILES['item_image']['tmp_name']) || is_uploaded_file($_FILES['item_image']['tmp_name'])){
					$imageArray=pathinfo($_FILES['item_image']['name']);
					$source_img = $_FILES['item_image']['tmp_name'];
					$imageName = 'Top-Resto-Menu-Item-Image-'.date('dmyhis').'.'.$imageArray['extension'];}
				else{
					$imageName = "samplefood.png";				
				}

				if (null !== $this->input->post('item_type_title')){
					$item_type_title =  $this->input->post('item_type_title');
				}else{
					$item_type_title = "food";
				}
				// $d = compress($source_img, $destination_img, 90);
				if (null !== $this->input->post('item_type')){
					$item_type = $this->input->post('item_type');
				}else{
					$item_type = 'Non Veg';
				}
				$item_name = "";

				if (null !== $this->input->post('item_name_'.$item_type_title.'_english') && "" !== $this->input->post('item_name_'.$item_type_title.'_english')){
					$item_name_english = $this->input->post('item_name_'.$item_type_title.'_english');
					$item_name = $item_name_english;
				}else{
					$item_name_english = '';
				}
				if (null !== $this->input->post('item_name_'.$item_type_title.'_germany') && "" !== $this->input->post('item_name_'.$item_type_title.'_germany')){
					$item_name_germany = $this->input->post('item_name_'.$item_type_title.'_germany');
					$item_name = $item_name_germany;
				}else{
					$item_name_germany = '';
				}
				if (null !== $this->input->post('item_name_'.$item_type_title.'_french') && "" !== $this->input->post('item_name_'.$item_type_title.'_french')){
					$item_name_french = $this->input->post('item_name_'.$item_type_title.'_french');
					$item_name = $item_name_french;
				}else{
					$item_name_french = '';
				}
				
				$item_desc = "";
				if (null !== $this->input->post('item_desc_germany')){
					$item_desc_germany = $this->input->post('item_desc_germany');
					$item_desc = $item_desc_germany;
				}else{
					$item_desc_germany = '';
				}
				if (null !== $this->input->post('item_desc_english')){
					$item_desc_english = $this->input->post('item_desc_english');
					$item_desc = $item_desc_english;
				}else{
					$item_desc_english = '';
				}
				if (null !== $this->input->post('item_desc_french')){
					$item_desc_french = $this->input->post('item_desc_french');
					$item_desc = $item_desc_french;
				}else{
					$item_desc_french = '';
				}
				$item_show_on = 0;
				if ("on" == $this->input->post('item_show_in_delivery')){
					$item_show_on = $item_show_on + 1;
				}
				if ("on" == $this->input->post('item_show_in_pickup')){
					$item_show_on = $item_show_on + 2;
				}
				
				

				$prices_title_array = array();
				$prices_title_english_array = $this->input->post('item_price_title_'.$item_type_title.'_english');
				$prices_title_english = implode(",",$prices_title_english_array);

				$prices_title_french_array = $this->input->post('item_price_title_'.$item_type_title.'_french');
				$prices_title_french = implode(",",$prices_title_french_array);

				$prices_title_germany_array = $this->input->post('item_price_title_'.$item_type_title.'_germany');
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

				$prices = implode(",",$this->input->post('item_price_'.$item_type_title));
				$prices_title = implode("," ,$prices_title_array);

				if (null !== $this->input->post('sub_category_id')){
					$sub_cat_ids = $this->input->post('sub_category_id');
				}else{
					$sub_cat_ids = [];
				}
				if (null !== $this->input->post('item_allergens')){
					$item_allergens = $this->input->post('item_allergens');
				}else{
					$item_allergens = [];
				}
				// $item_sort_index = $this->input->post('item_sort_index');
				$rest_id = $this->input->post('rest_id');
				$item_sort_max_index_row = $this->db->query("SELECT menu_id ,rest_id, category_id ,item_sort_index ,COALESCE(MAX(item_sort_index),0) +1 AS item_sort_max_index FROM `tbl_menu_card` WHERE rest_id = $rest_id and category_id = $category_id")->row();
				if ($item_sort_max_index_row ){
					$item_sort_index = $item_sort_max_index_row->item_sort_max_index;
				}else{
					$item_sort_index = 0;
				}
				$data=array(
					"rest_id"=>$rest_id,
					"category_id"=>$category_id,
					// "sub_cat_ids"=>implode("," ,$sub_cat_ids),
					"item_image"=>$imageName,
					"item_allergens"=>implode("," ,$item_allergens),
					"item_type"=>$this->input->post('item_type'),
					"item_prices"=>$prices,
					"item_prices_title"=>$prices_title,
					"item_prices_title_english"=>$prices_title_english,
					"item_prices_title_french"=>$prices_title_french,
					"item_prices_title_germany"=>$prices_title_germany,
					"item_desc"=>$item_desc,
					"item_desc_english"=>$item_desc_english,
					"item_desc_french"=>$item_desc_french,
					"item_desc_germany"=>$item_desc_germany,
					"item_name"=>$item_name,
					"item_name_english"=>$item_name_english,
					"item_name_french"=>$item_name_french,
					"item_name_germany"=>$item_name_germany,
					"item_show_blue" => $this->input->post('item_show_blue'),
					"item_sort_index" => $item_sort_index,
					"item_tax_id" => $this->input->post('item_tax_id'),
					"item_food_extra" => $item_food_extra_str,
					"item_show_on" => $item_show_on,
				);
				
				// if($_FILES['item_image']['name'] !== null && $_FILES['item_image']['name'] !== ""){
				if (file_exists($_FILES['item_image']['tmp_name']) || is_uploaded_file($_FILES['item_image']['tmp_name'])) {
					$destination_img='assets/menu_item_images/'.$imageName;
					$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
					if (isset($fileUploadingSetting)){
						$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
						$max_width = $fileUploadingSetting->menu_item->max_width;
						$max_height = $fileUploadingSetting->menu_item->max_height;
						$compression = $fileUploadingSetting->menu_item->compression;
					} else{
						$max_width = 0;
						$max_height = 0;
						$compression = 80;
					}
					$this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false);
				}
				$response=$this->MODEL->addNewItem($data);
			}else{
				$response = 3;
			}
			
			switch ($response) {
				case 0:$this->session->set_flashdata('msg',"Falied to add item."); break;
				case 1:$this->session->set_flashdata('msg',"Item added Successfully."); break;
				case 2:$this->session->set_flashdata('msg',"Item already Exists."); break;
				case 3:$this->session->set_flashdata('msg',"Category ID is empty."); break;
				default:$this->session->set_flashdata('msg',"Something went wrong"); break;
			}
			redirect('Restaurant/Menu');
		}
		public function updateMenuItem(){
			if (null !== $this->input->post('category_id') && $this->input->post('category_id') > 0){
				$category_id = $this->input->post('category_id');

				if (file_exists($_FILES['item_image']['tmp_name']) || is_uploaded_file($_FILES['item_image']['tmp_name'])){
					$imageArray=pathinfo($_FILES['item_image']['name']);
					$source_img = $_FILES['item_image']['tmp_name'];
					$imageName = 'Top-Resto-Menu-Item-Image-'.date('dmyhis').'.'.$imageArray['extension'];}
				else{
					$imageName = "samplefood.png";				
				}

				if (null !== $this->input->post('item_type_title')){
					$item_type_title =  $this->input->post('item_type_title');
				}else{
					$item_type_title = "food";
				}
				// $d = compress($source_img, $destination_img, 90);
				if (null !== $this->input->post('item_type')){
					$item_type = $this->input->post('item_type');
				}else{
					$item_type = 'Non Veg';
				}
				$item_name = "";

				if (null !== $this->input->post('item_name_'.$item_type_title.'_english') && "" !== $this->input->post('item_name_'.$item_type_title.'_english')){
					$item_name_english = $this->input->post('item_name_'.$item_type_title.'_english');
					$item_name = $item_name_english;
				}else{
					$item_name_english = '';
				}
				if (null !== $this->input->post('item_name_'.$item_type_title.'_germany') && "" !== $this->input->post('item_name_'.$item_type_title.'_germany')){
					$item_name_germany = $this->input->post('item_name_'.$item_type_title.'_germany');
					$item_name = $item_name_germany;
				}else{
					$item_name_germany = '';
				}
				if (null !== $this->input->post('item_name_'.$item_type_title.'_french') && "" !== $this->input->post('item_name_'.$item_type_title.'_french')){
					$item_name_french = $this->input->post('item_name_'.$item_type_title.'_french');
					$item_name = $item_name_french;
				}else{
					$item_name_french = '';
				}
				
				$item_desc = "";
				if (null !== $this->input->post('item_desc_germany')){
					$item_desc_germany = $this->input->post('item_desc_germany');
					$item_desc = $item_desc_germany;
				}else{
					$item_desc_germany = '';
				}
				if (null !== $this->input->post('item_desc_english')){
					$item_desc_english = $this->input->post('item_desc_english');
					$item_desc = $item_desc_english;
				}else{
					$item_desc_english = '';
				}
				if (null !== $this->input->post('item_desc_french')){
					$item_desc_french = $this->input->post('item_desc_french');
					$item_desc = $item_desc_french;
				}else{
					$item_desc_french = '';
				}
				$item_show_on = 0;
				if ("on" == $this->input->post('item_show_in_delivery')){
					$item_show_on = $item_show_on + 1;
				}
				if ("on" == $this->input->post('item_show_in_pickup')){
					$item_show_on = $item_show_on + 2;
				}
							
				$prices_title_array = array();
				$prices_title_english_array = $this->input->post('item_price_title_'.$item_type_title.'_english');
				$prices_title_english = implode(",",$prices_title_english_array);

				$prices_title_french_array = $this->input->post('item_price_title_'.$item_type_title.'_french');
				$prices_title_french = implode(",",$prices_title_french_array);

				$prices_title_germany_array = $this->input->post('item_price_title_'.$item_type_title.'_germany');
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

				$prices = implode(",",$this->input->post('item_price_'.$item_type_title));
				$prices_title = implode("," ,$prices_title_array);

				if (null !== $this->input->post('sub_category_id')){
					$sub_cat_ids = $this->input->post('sub_category_id');
				}else{
					$sub_cat_ids = [];
				}
				if (null !== $this->input->post('item_allergens')){
					$item_allergens = $this->input->post('item_allergens');
				}else{
					$item_allergens = [];
				}
				// $item_sort_index = $this->input->post('item_sort_index');
				$rest_id = $this->input->post('rest_id');
				$item_sort_max_index_row = $this->db->query("SELECT menu_id ,rest_id, category_id ,item_sort_index ,COALESCE(MAX(item_sort_index),0) +1 AS item_sort_max_index FROM `tbl_menu_card` WHERE rest_id = $rest_id and category_id = $category_id")->row();
				if ($item_sort_max_index_row ){
					$item_sort_index = $item_sort_max_index_row->item_sort_max_index;
				}else{
					$item_sort_index = 0;
				}

				$data=array(
					"rest_id"=>$rest_id,
					"category_id"=>$category_id,
					// "sub_cat_ids"=>implode("," ,$sub_cat_ids),
					"item_allergens"=>implode("," ,$item_allergens),
					"item_type"=>$this->input->post('item_type'),
					"item_prices"=>$prices,
					"item_prices_title"=>$prices_title,
					"item_prices_title_english"=>$prices_title_english,
					"item_prices_title_french"=>$prices_title_french,
					"item_prices_title_germany"=>$prices_title_germany,
					"item_desc"=>$item_desc,
					"item_desc_english"=>$item_desc_english,
					"item_desc_french"=>$item_desc_french,
					"item_desc_germany"=>$item_desc_germany,
					"item_name"=>$item_name,
					"item_name_english"=>$item_name_english,
					"item_name_french"=>$item_name_french,
					"item_name_germany"=>$item_name_germany,
					"item_show_blue" => $this->input->post('item_show_blue'),
					// "item_sort_index" => $item_sort_index,
					"item_tax_id" => $this->input->post('item_tax_id'),
					"item_food_extra" => $item_food_extra_str,
					"item_show_on" => $item_show_on,
				);
				// if($_FILES['item_image']['name'] !== null && $_FILES['item_image']['name'] !== ""){
				if (file_exists($_FILES['item_image']['tmp_name']) || is_uploaded_file($_FILES['item_image']['tmp_name'])) {
					$destination_img='assets/menu_item_images/'.$imageName;
					$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
					if (isset($fileUploadingSetting)){
						$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
						$max_width = $fileUploadingSetting->menu_item->max_width;
						$max_height = $fileUploadingSetting->menu_item->max_height;
						$compression = $fileUploadingSetting->menu_item->compression;
					} else{
						$max_width = 0;
						$max_height = 0;
						$compression = 80;
					}
					$this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false);
					$data["item_image"] = $imageName;
					$iiF = true;
				}else{
					if ($this->input->post('is_update_item_image')){
						$data["item_image"] = "";
						$iiF = true;
					}else{
						$iiF = false;
					}
				}
				if ($iiF){
					if ($old_item_image = $this->db->where("menu_id",$this->input->post("menu_id"))->get("tbl_menu_card")->row()->item_image){
						if (file_exists(APPPATH."../assets/menu_item_images/".$old_item_image)){
							unlink(APPPATH."../assets/menu_item_images/".$old_item_image);
						}
					}
				}
				$response=$this->MODEL->updateItem($this->input->post("menu_id"),$data);
			}else{
				$response = 3;
			}
			
			switch ($response) {
				case 0:$this->session->set_flashdata('msg',"Failed to add item."); break;
				case 1:$this->session->set_flashdata('msg',"Item updated Successfully."); break;
				case 2:$this->session->set_flashdata('msg',"Item already Exists."); break;
				case 3:$this->session->set_flashdata('msg',"Category ID is empty."); break;
				default:$this->session->set_flashdata('msg',"Something went wrong"); break;
			}
			redirect('Restaurant/editMenu/'.$this->input->post("menu_id"));
		}
		public function editMainPage(){
			// modify by Jfrost in 2nd stage
			$rest_id = $this->input->post('rest_id');
			$data = array();
			
			if ($rest_id == $this->myRestId){
				$what_setting = $this->input->post("what_setting");
				$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
				if ($what_setting == "slider"){
					$slider_paths = array();
					if (isset($fileUploadingSetting)){
						$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
						$max_width = $fileUploadingSetting->slider->max_width;
						$max_height = $fileUploadingSetting->slider->max_height;
						$compression = $fileUploadingSetting->slider->compression;
					} else{
						$max_width = 0;
						$max_height = 0;
						$compression = 80;
					}
					for ($slider_id=0; $slider_id < 4; $slider_id++) { 
						$slider =  "slider" . $slider_id;
						$update_image = $this->input->post("is_update".$slider_id) == "1" ? true : false;
						if (file_exists($_FILES[$slider]['tmp_name']) || is_uploaded_file($_FILES[$slider]['tmp_name'])){
							$imageArray=pathinfo($_FILES[$slider]['name']);
							$update_image = true;
							$source_img = $_FILES[$slider]['tmp_name'];
							$imageName = 'Top-Resto-slider'.$slider_id."-".date('dmyhis').'.'.$imageArray['extension'];

							$destination_img='assets/home_slider_images/'."$imageName";
							$this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false);
							$slider_paths[$slider_id] = $imageName;

						}else{
							$imageName = "";
						}
						
						$caption_title_name = "slider-caption-".($slider_id+1)."-title";
						$caption_content_name = "slider-caption-".($slider_id+1)."-content";

						if ($this->input->post($caption_title_name."_french") !== ""){
							$slider_caption_title = $this->input->post($caption_title_name."_french");
						}elseif($this->input->post($caption_title_name."_germany") !== ""){
							$slider_caption_title = $this->input->post($caption_title_name."_germany");
						}else{
							$slider_caption_title = $this->input->post($caption_title_name."_english");
						}

						if ($this->input->post($caption_content_name."_french") !== ""){
							$slider_caption_content = $this->input->post($caption_content_name."_french");
						}elseif($this->input->post($caption_content_name."_germany") !== ""){
							$slider_caption_content = $this->input->post($caption_content_name."_germany");
						}else{
							$slider_caption_content = $this->input->post($caption_content_name."_english");
						}

						$data[$slider_id] = array(	
							"rest_id"						=> $this->input->post('rest_id'),
							"image_name"					=> $imageName,
							"slider_index"  				=> $slider_id,
							"update_image"  				=> $update_image,
							"slider_caption_title_english"  => $this->input->post($caption_title_name."_english"),
							"slider_caption_title_germany"  => $this->input->post($caption_title_name."_germany"),
							"slider_caption_title_french"   => $this->input->post($caption_title_name."_french"),
							"slider_caption_title"  		=> $slider_caption_title,
							// "slider_caption_title"   => $this->input->post($caption_title_name."_english"),
							"slider_caption_content_english"=> $this->input->post($caption_content_name."_english"),
							"slider_caption_content_germany"=> $this->input->post($caption_content_name."_germany"),
							"slider_caption_content_french"	=> $this->input->post($caption_content_name."_french"),
							"slider_caption_content"		=> $slider_caption_content,
							"slider_overlay_color"  		=> $this->input->post('slider_overlay_color'),
							"slider_overlay_alpha"  		=> $this->input->post('slider_overlay_alpha'),
							"slider_duration"  				=> $this->input->post('slider_duration'),
							"slider_delay"  				=> $this->input->post('slider_delay'),
							"slider_effects"  				=> ($this->input->post('slider_effect') !== null) ? implode(",",$this->input->post('slider_effect')) : "",
							// "slider_caption_content"	=> $this->input->post($caption_content_name."_english"),
						);
						$data_content = array(
							"slider_overlay_color"  		=> $this->input->post('slider_overlay_color'),
							"slider_overlay_alpha"  		=> $this->input->post('slider_overlay_alpha'),
							"slider_duration"  				=> $this->input->post('slider_duration'),
							"slider_delay"  				=> $this->input->post('slider_delay'),
							"slider_effects"  				=> ($this->input->post('slider_effect') !== null ) ? implode(",",$this->input->post('slider_effect')) : "",
						);
					}
					$response = $this->MODEL->updatePageSlider($data,$rest_id);
					$response_content = $this->MODEL->updatePageContent($data_content,$rest_id);
				}else{
					$update_content_image = $this->input->post("is_update_content") == "1" ? true : false;
					if (isset($fileUploadingSetting)){
						$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
						$max_width = $fileUploadingSetting->homepage_service->max_width;
						$max_height = $fileUploadingSetting->homepage_service->max_height;
						$compression = $fileUploadingSetting->homepage_service->compression;
					} else{
						$max_width = 0;
						$max_height = 0;
						$compression = 80;
					}

					if (file_exists($_FILES["content_img"]['tmp_name']) || is_uploaded_file($_FILES["content_img"]['tmp_name'])){
						$imageArray=pathinfo($_FILES["content_img"]['name']);
						$source_img = $_FILES["content_img"]['tmp_name'];
						$content_image = 'Top-Resto-home'."-".date('dmyhis').'.'.$imageArray['extension'];

						$destination_img='assets/home_images/'."$content_image";
						$this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false);
					}else{
						$content_image = "";
					}
					
					$is_update_service_section_background = $this->input->post("is_update_service_section_background") == "1" ? true : false;
					if (file_exists($_FILES["service_section_background"]['tmp_name']) || is_uploaded_file($_FILES["service_section_background"]['tmp_name'])){
						$imageArray=pathinfo($_FILES["service_section_background"]['name']);
						$source_img_ = $_FILES["service_section_background"]['tmp_name'];
						$service_section_background = 'Top-Resto-service-bg'."-".date('dmyhis').'.'.$imageArray['extension'];

						$destination_img_='assets/home_service_background/'."$service_section_background";
						$this->compress($source_img_, $destination_img_, $compression,$max_width,$max_height,false);
					}else{
						$service_section_background = "";
					}
					
					if ($this->input->post('page_content_french') !== ""){
						$content =  $this->input->post('page_content_french');
					}elseif ($this->input->post('page_content_germany') !== ""){
						$content =  $this->input->post('page_content_germany');
					}else{
						$content =  $this->input->post('page_content_english');
					}

					// modify by Jfrost in 2nd stage
					// $homepage_services = $this->db->where('rest_id',$this->myRestId)->get('tbl_homepage_services')->result();
					$h_services = $this->input->post("service_id");
					
					foreach ($h_services as $hs_key => $s_id) {
						$hs_id = $this->input->post("homepage_service_id")[$hs_key];
						$service_status = $this->input->post('homepage_service_status')[$hs_key] == "on" ? 1 : 0;
						$hs_value = array(
							"rest_id"	=> $rest_id,
							"service_status"	=> $service_status,
							"service_id"	=> $s_id,
						);
						if ($hs_id){
							$this->db->where('rest_id',$rest_id)->where("id",$hs_id)->update('tbl_homepage_services',$hs_value);
						}else{
							$this->db->insert('tbl_homepage_services',$hs_value);
						}
					}
					
					if ($this->input->post('service_top_subject_french') !== ""){
						$service_top_subject =  $this->input->post('service_top_subject_french');
					}elseif ($this->input->post('service_top_subject_germany') !== ""){
						$service_top_subject =  $this->input->post('service_top_subject_germany');
					}else{
						$service_top_subject =  $this->input->post('service_top_subject_english');
					}

					if ($this->input->post('service_main_subject_french') !== ""){
						$service_main_subject =  $this->input->post('service_main_subject_french');
					}elseif ($this->input->post('service_main_subject_germany') !== ""){
						$service_main_subject =  $this->input->post('service_main_subject_germany');
					}else{
						$service_main_subject =  $this->input->post('service_main_subject_english');
					}

					if ($this->input->post('service_description_french') !== ""){
						$service_description =  $this->input->post('service_description_french');
					}elseif ($this->input->post('service_description_germany') !== ""){
						$service_description =  $this->input->post('service_description_germany');
					}else{
						$service_description =  $this->input->post('service_description_english');
					}

					$data_content= array(
						"rest_id"						=> $this->input->post('rest_id'),
						"content_english"   			=> $this->input->post('page_content_english'),
						"content_french"   				=> $this->input->post('page_content_french'),
						"content_germany"   			=> $this->input->post('page_content_germany'),
						"content"   					=> $content,
						"service_top_subject_english"  	=> $this->input->post('service_top_subject_english'),
						"service_top_subject_germany"  	=> $this->input->post('service_top_subject_germany'),
						"service_top_subject_french"  	=> $this->input->post('service_top_subject_french'),
						"service_top_subject"  			=> $service_top_subject,
						"service_main_subject_english" 	=> $this->input->post('service_main_subject_english'),
						"service_main_subject_germany" 	=> $this->input->post('service_main_subject_germany'),
						"service_main_subject_french" 	=> $this->input->post('service_main_subject_french'),
						"service_main_subject" 			=> $service_main_subject,
						"service_description_english"  	=> $this->input->post('service_description_english'),
						"service_description_germany"  	=> $this->input->post('service_description_germany'),
						"service_description_french"  	=> $this->input->post('service_description_french'),
						"service_description"  			=> $service_description,
						"is_show_service"				=> $this->input->post('is_show_service') == "on" ? 1 : 0,
						"is_show_welcome"				=> $this->input->post('is_show_welcome') == "on" ? 1 : 0
					);
					if ($update_content_image || (file_exists($_FILES["content_img"]['tmp_name']) || is_uploaded_file($_FILES["content_img"]['tmp_name']))){
						$data_content["content_image"]= $content_image;
						$ciF = true;
					}else{
						if ($update_content_image){
							$ciF = true;
							$data_content["content_image"] = "";
						}else{
							$ciF = false;
						}
					}

					if ($is_update_service_section_background || (file_exists($_FILES["service_section_background"]['tmp_name']) || is_uploaded_file($_FILES["service_section_background"]['tmp_name']))){
						$data_content["service_section_background"] = $service_section_background;
						$ssbF = true;
					}else{
						if ($is_update_service_section_background){
							$ssbF = true;
							$data_content["service_section_background"] = "";
						}else{
							$ssbF = false;
						}
					}

					$homepage_services = $this->db->where('rest_id',$rest_id)->get("tbl_page_contents")->row();
					if ($homepage_services && $ciF){
						if (file_exists(APPPATH."../assets/home_images/".$homepage_services->content_image)){
							unlink(APPPATH."../assets/home_images/".$homepage_services->content_image);
						}
					}
					if ($homepage_services && $ssbF){
						if (file_exists(APPPATH."../assets/home_service_background/".$homepage_services->service_section_background)){
							unlink(APPPATH."../assets/home_service_background/".$homepage_services->service_section_background);
						}
					}
					$response_content = $this->MODEL->updatePageContent($data_content,$rest_id);	
					$response = 1;
				}
			}else{
				$response = 2;
			}
			
			if ($response == 2) {
				$this->session->set_flashdata('msg',"It is not allowed to manage with your permission."); 
				redirect("Restaurant/logOut");
			}else if($response_content == 1 && $response == 1){
				$this->session->set_flashdata('msg',"Content updated Successfully.");
			}else{
				$this->session->set_flashdata('msg',"Something went wrong");
			}
			if ($what_setting == "slider"){
				redirect('Restaurant/pageSetting/Slider');
			}else{
				redirect('Restaurant/pageSetting');
			}
		}
		public function updateHomepageTextSection(){
			// modify by Jfrost in 2nd stage
			$rest_id = $this->myRestId;
			$data = array();
			
			$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
			$update_content_image = $this->input->post("is_update_home_section_img") == "1" ? true : false;
			$text_section_type = $this->input->post("home_text_section_type");
			$sId = $this->input->post("sId");
			$sort_num = $this->input->post("sort_num");
			$section_id = $this->input->post("section_id");
			$is_show_section = $this->input->post('is_show_section') == "on" ? '1' : '0';
			if (isset($fileUploadingSetting)){
				$fileUploadingSetting = json_decode($fileUploadingSetting->option_value);
				$max_width = $fileUploadingSetting->homepage_service->max_width;
				$max_height = $fileUploadingSetting->homepage_service->max_height;
				$compression = $fileUploadingSetting->homepage_service->compression;
			} else{
				$max_width = 0;
				$max_height = 0;
				$compression = 80;
			}

			if (file_exists($_FILES["home_section_img"]['tmp_name']) || is_uploaded_file($_FILES["home_section_img"]['tmp_name'])){
				$imageArray=pathinfo($_FILES["home_section_img"]['name']);
				$source_img = $_FILES["home_section_img"]['tmp_name'];
				$content_image = 'Top-Resto-home'."-".date('dmyhis').'.'.$imageArray['extension'];

				$destination_img='assets/home_images/'."$content_image";
				$this->compress($source_img, $destination_img, $compression,$max_width,$max_height,false);
			}else{
				$content_image = "";
			}

			$content = "";
			if ($this->input->post('page_content_english') !== ""){
				$content =  $this->input->post('page_content_english');
				$sDescriptionJson['english_content'] = $content;
			}
			if ($this->input->post('page_content_germany') !== ""){
				$content =  $this->input->post('page_content_germany');
				$sDescriptionJson['germany_content'] = $content;
			}
			if ($this->input->post('page_content_french') !== ""){
				$content =  $this->input->post('page_content_french');
				$sDescriptionJson['french_content'] = $content;
			}
			$sDescriptionJson['content'] = $content;
			
			$section_heading = "";
			if ($this->input->post('section_heading_english') !== ""){
				$section_heading =  $this->input->post('section_heading_english');
				$sHeadingJson['english_content'] = $section_heading;
			}
			if ($this->input->post('section_heading_germany') !== ""){
				$section_heading =  $this->input->post('section_heading_germany');
				$sHeadingJson['germany_content'] = $section_heading;
			}
			if ($this->input->post('section_heading_french') !== ""){
				$section_heading =  $this->input->post('section_heading_french');
				$sHeadingJson['french_content'] = $section_heading;
			}
			$sHeadingJson['content'] = $section_heading;

			$data_content= array(
				"sRest_id"						=> $rest_id,
				"sDescription"   				=> json_encode($sDescriptionJson),
				"sHeading"   					=> json_encode($sHeadingJson),
				'sSection_id'					=> $section_id,
				"sType"							=> (null !== $this->input->post('home_text_section_type')) ? $this->input->post('home_text_section_type') : 1,
			);
			if ($update_content_image || (file_exists($_FILES["home_section_img"]['tmp_name']) || is_uploaded_file($_FILES["home_section_img"]['tmp_name']))){
				$data_content["sImage"]= $content_image;
				$ciF = true;
			}else{
				if ($update_content_image){
					$ciF = true;
					$data_content["sImage"] = "";
				}else{
					$ciF = false;
				}
			}

			$text_section_row = $this->db->where('sId',$sId)->get("tbl_restaurant_homepage_text_sections")->row();
			if ($text_section_row && $ciF){
				if (file_exists(APPPATH."../assets/home_images/".$homepage_services->content_image)){
					unlink(APPPATH."../assets/home_images/".$homepage_services->content_image);
				}
			}
			$response = $this->MODEL->updateHomeTextSectionContent($data_content,$sId);	
			$sort_content = array(
				'rest_id'		=> $rest_id,
				'section_id'	=> $section_id,
				'sort_num'		=> $sort_num,	
				'is_show_section'	=> $is_show_section,
			);
			$responseSort = $this->MODEL->updateHomeSectionSort($sort_content);	
			die(json_encode(array("status"=>$response && $responseSort,"is_show"=>$this->input->post('is_show_section') )));
		}
		public function hideAnnouncement(){
			$announcement_id = $this->input->post("announcement_id");
			$rest_id = $this->input->post("rest_id");
			$announcement_closed_arr = array();
			if (null !== $this->input->cookie('jfrost_announcement_closed_str')){
				$announcement_closed_arr = explode(",", $this->input->cookie("jfrost_announcement_closed_str"));
			}
			$announcement_closed_arr[] = $announcement_id;
			$announcement_closed_str  = implode(",",$announcement_closed_arr);
			$announcement_cookie = array(
				'name'   => 'announcement_closed_str',
				'value'  => $announcement_closed_str,
				'expire' => 60*60*2,
				'domain' => "",
				'prefix' => 'jfrost_',
			);
			$this->input->set_cookie($announcement_cookie);
			die(json_encode(array("status"=>1,"announcement_cookie"=>$announcement_closed_arr)));
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
	}
?>