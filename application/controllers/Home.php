<?php
	/**
	 * 
	 */
	class Home extends CI_Controller
	{
		var $restUrlSlug;
		function __construct(){
			parent::__construct();
			$this->load->model('AdminModel','MODEL');
			// Load session library
			$this->load->library('session');
			$this->load->helper('cookie');
			$this->load->helper('url');
			
			if ( null !== $this->input->get("lang")){
				if ($this->input->get("lang") == "en"){
					$this->session->set_userdata('site_lang', "english");
				}elseif ($this->input->get("lang") == "de"){
					$this->session->set_userdata('site_lang', "germany");
				}elseif ($this->input->get("lang") == "fr"){
					$this->session->set_userdata('site_lang', "french");
				}
			}
			if ($this->session->userdata("site_lang") == ""){
				$this->session->set_userdata('site_lang', "french");
			}
			$this->lang->load('content_lang',$this->session->userdata("site_lang"));
			$rest_domain = str_replace ("www.","",$_SERVER['SERVER_NAME']);
			if ($rest = $this->db->where("tbl_restaurant.rest_domain = '$rest_domain' AND tbl_restaurant_details.activation_status = 'Accepted'  AND tbl_restaurant_details.resto_plan = 'pro'  AND tbl_restaurant_details.domain_status = 'active' ")->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id = tbl_restaurant.rest_id')->get('tbl_restaurant')->row()){
				$this->restUrlSlug = $rest->rest_url_slug;
			}else{
				$this->restUrlSlug = "";
			}
		}
		private function check_Url_Slug($rest_url_slug){
			if ($rest_url_slug == "" && $this->restUrlSlug !== ""){
				$rest_url_slug = $this->restUrlSlug;
			}else{
				if ($rest_url_slug !== "" && $this->restUrlSlug !== "" && $this->restUrlSlug !== $rest_url_slug){
					redirect('/');
				}
			}
			return $rest_url_slug;
		} 
		public function index(){
			if ($this->restUrlSlug !== ""){
				$this->Main_page();
			}else{
				redirect('Restaurant/');
			}
		}
		public function register(){
			// $this->load->view('website/layout/header');
			$this->load->view('website/pages/register');
		}
		public function login(){
			$this->load->view('website/pages/index');
		}
		public function forgot(){
			$this->load->view('website/pages/forgot_password');
		}
		public function Main_page($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest = $this->db->where("tbl_restaurant.rest_url_slug = '$rest_url_slug' AND tbl_restaurant_details.activation_status = 'Accepted' ")->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id = tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			if ($rest){
				$rest_id = $rest->rest_id;
				$data['rest_url_slug']=$rest_url_slug;
				$data['myRestId']=$rest_id;
				$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
				$data['sliders']=$this->db->where('rest_id',$rest_id)->get('tbl_sliders')->result();
				$data['page_contents']=$this->db->where('rest_id',$rest_id)->get('tbl_page_contents')->row();
				$data['site_lang']=$this->session->userdata("site_lang");
				$data['iframe']=$iframe;

				$seo_content = $this->db->where("seo_rest_id",$rest_id)->get('tbl_seo_settings')->row();
				$seo_titles = json_decode(isset($seo_content) ? $seo_content->seo_titles : "");
				$seo_descriptions = json_decode(isset($seo_content->seo_descriptions) ? $seo_content->seo_descriptions : "");
				$seo_title_field = "home_title_" . $data['site_lang'];
				$seo_description_field = "home_desc_" . $data['site_lang'];
				$data['seo_title'] = isset($seo_titles->$seo_title_field) ? $seo_titles->$seo_title_field : "";
				$data['seo_description'] = isset($seo_descriptions->$seo_description_field) ? $seo_descriptions->$seo_description_field : "";
	
				// modify by Jfrost in 2nd stage
				$data['homepage_services']=$this->db->where('rest_id',$rest_id)->join("tbl_services","tbl_services.id = tbl_homepage_services.service_id")->get('tbl_homepage_services')->result();
				if (!in_array("home",explode(",",$data['myRestDetail']->active_pages))){ 
					$this->page_404("Oops",$this->lang->line("It is not allowed to access to this page"));
				}else{
					$this->load->view('website/layout/header',$data);
					$this->load->view('website/pages/home_page');
					$this->load->view('website/layout/footer');
				}
			}else{
				redirect ("/");
			}
		}
		public function legal_page($rest_url_slug="", $page_slug = "imprint", $iframe= ""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest = $this->db->where("tbl_restaurant.rest_url_slug = '$rest_url_slug' AND tbl_restaurant_details.activation_status = 'Accepted' ")->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id = tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			if ($rest){
				$rest_id = $rest->rest_id;
				$data['rest_url_slug']=$rest_url_slug;
				$data['myRestId']=$rest_id;
				$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
				$legal_contents = $this->db->where('rest_id',$rest_id)->get('tbl_legal_settings')->row();
				$data['site_lang']=$this->session->userdata("site_lang");
				$data['legal_contents'] = $legal_contents;
				$standard_legal_page_settings = $this->db->where('rest_id','0')->get('tbl_legal_settings')->row();
				$data['standard_legal_page_settings'] = $standard_legal_page_settings;
				
				$data['page_slug']=$page_slug;
				$data['iframe']=$iframe;

				if ($page_slug == "terms-conditions" && !in_array("tc",explode(",",$data['myRestDetail']->active_pages))){ 
					$this->page_404("Oops",$this->lang->line("It is not allowed to access to this page"));
				}else{
					$this->load->view('website/layout/header',$data);
					$this->load->view('website/pages/legal_page');
					$this->load->view('website/layout/footer');
				}
			}else{
				redirect ("/");
			}
		}
		public function chooseMenu($rest_url_slug="",$iframe=""){
			$this->viewMenu($rest_url_slug,$iframe,true);
		}
		public function viewMenu($rest_url_slug="",$iframe="",$is_dp_choose_page = false){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row();		
			if ($rest){
				$rest_id = $rest->rest_id;
				$data['myRestId']=$rest_id;
				$data['rest_url_slug']=$rest_url_slug;
				$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
				$data['site_lang']=$this->session->userdata("site_lang");
				$data['iframe']=$iframe;

				$data['delivery_open'] = $this->is_open_rest($rest_id,'delivery');
				$data['pickup_open'] = $this->is_open_rest($rest_id,'pickup');
				$data['is_open_time']= $data['delivery_open'] || $data['pickup_open'];
				$data['is_pre_order']= $data['myRestDetail']->pre_order;
				$data["is_dp_choose_page"] = $is_dp_choose_page;
				$data['menu_mode'] = "table";
				$data['common_bottom_bar'] = false;
				if (($data['myRestDetail']->dp_option < 4 && $data['myRestDetail']->dp_option > 0 && $data['myRestDetail']->resto_plan == "pro")){
					if (!in_array("menu",explode(",",$data['myRestDetail']->active_pages))){ 
						$this->page_404("Oops",$this->lang->line("It is not allowed to access to this page"));
					}else{
						$this->load->view('website/layout/header',$data);
						$this->load->view('website/pages/chooseMenu_mode');
						$this->load->view('website/layout/footer');
					}
				}else{
					if ($data['myRestDetail']->ontable_show == 1){
						redirect(base_url("onTable/").$rest_url_slug."/".$iframe."?lang=".$this->input->get("lang"));
					}else{
						$this->page_404("Oops",$this->lang->line("It is not allowed to access to this page"));
					}
				}
			}else{
				redirect ("/");
			}
		}
		public function contact_us($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row();			
			if ($rest){
				$rest_id = $rest->rest_id;
				$data['myRestId']=$rest_id;
				$data['rest_url_slug']=$rest_url_slug;
				$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
				$data['site_lang']=$this->session->userdata("site_lang");
				$data['iframe']=$iframe;
				if (!in_array("contact",explode(",",$data['myRestDetail']->active_pages))){ 
					$this->page_404("Oops",$this->lang->line("It is not allowed to access to this page"));
				}else{
					$this->load->view('website/layout/header',$data);
					$this->load->view('website/pages/contactus_page');
					$this->load->view('website/layout/footer');
				}
			}else{
				redirect ("/");
			}
		}
		public function getAddress($menu_mode,$rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row();			
			if ($rest){
				$rest_id = $rest->rest_id;
				if (!$this->is_open_rest($rest_id,strtolower($menu_mode))){
					redirect ("view/$rest_url_slug");
				}
				$data['myRestId']=$rest_id;
				$data['rest_url_slug']=$rest_url_slug;
				$data['menu_mode']=$menu_mode;
				$cnt_str = "";
				$cnt = explode(",",strtolower($this->db->where('rest_id',$rest_id)->get('tbl_delivery_countries')->row()->countries));
				foreach ($cnt as $key => $value) {
					$cnt_str = $cnt_str . "'" . $value ."',";
				}
				$data['countries']=$cnt_str ;
				$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
				$data['site_lang']=$this->session->userdata("site_lang");
				$data['iframe']=$iframe;
				$this->load->view('website/layout/header',$data);
				$this->load->view('website/pages/getAddress');
			}else{
				$this->load->view('website/pages/index');
			}
		}
		public function onTableMenu($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$this->menu_table($rest_url_slug,$iframe,"table");
		}
		public function Delivery($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$this->menu_table($rest_url_slug,$iframe,"Delivery");
		}
		public function Pickup($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$this->menu_table($rest_url_slug,$iframe,"Pickup");
		}
		function menu_table($rest_url_slug,$iframe,$mode){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest = $this->db->where("tbl_restaurant.rest_url_slug = '$rest_url_slug' AND tbl_restaurant_details.activation_status = 'Accepted' ")->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id = tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			$addon_features = $this->MODEL->getAddonFeatures_by_rest_id($rest->rest_id);
			if ($rest){
				if ($mode !== "table"){
					if (!$this->is_open_rest($rest->rest_id,strtolower($mode)) && !$rest->pre_order){
						redirect ("view/$rest_url_slug");
					}
				}else{
					if (!($rest->resto_plan !== "pro" || ($rest->resto_plan == "pro" && $rest->ontable_show))){
						redirect ("view/$rest_url_slug");
					}
				}
				if ($rest->dp_option == 0 || $rest->dp_option == 4 ){
					if ($mode == "Delivery" || $mode == "Pickup"){
						redirect("view/$rest_url_slug");
					}
				}else if($rest->dp_option == 1){
					if ($mode == "Pickup"){
						redirect("view/$rest_url_slug");
					}
				}else if($rest->dp_option == 2){
					if ($mode == "Delivery"){
						redirect("view/$rest_url_slug");
					}
				}
				$rest_id = $rest->rest_id;
				$data['banner_settings']=$this->db->where("rest_id",$rest_id)->get("tbl_banner_settings")->row();
				$data['iframe']=$iframe;
				$data['myRestId']=$rest_id;
				$this->session->set_userdata('current_rest_id',$rest_id);
				$data['rest_url_slug']=$rest_url_slug;
				$data['mode'] = $mode;
				$data['menu_mode'] = $mode;
				$data['Categories']=$this->db->order_by("category_sort_index","ASC")->where("(added_by='$rest_id' or added_by=0) and  category_status = 'active'")->get('tbl_category')->result();
				$data['myRestDetail']=$this->db->join("tbl_restaurant","tbl_restaurant.rest_id = tbl_restaurant_details.restaurant_id")->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
				$data['categorytype']=$this->db->get('tbl_category_type')->result();
				$data['is_open_delivery']= $this->is_open_rest($rest->rest_id,'delivery');
				$data['is_open_pickup']= $this->is_open_rest($rest->rest_id,'pickup');
				$data['is_open_time']= $mode == "table" ? true : $this->is_open_rest($rest->rest_id,strtolower($mode));
				$data['is_pre_order']= $rest->pre_order;
				$rest_currency_id = $data['myRestDetail']->currency_id;
				$rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
				$rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;
				$data['currentRestCurrencySymbol'] = $rest_currency_symbol;

				$data['site_lang']=$this->session->userdata("site_lang");
				$data['common_bottom_bar'] = false;

				$seo_content = $this->db->where("seo_rest_id",$rest_id)->get('tbl_seo_settings')->row();
				$seo_titles = json_decode(isset($seo_content) ? $seo_content->seo_titles : "");
				$seo_descriptions = json_decode(isset($seo_content->seo_descriptions) ? $seo_content->seo_descriptions : "");
				$seo_title_field = "menu_title_" . $data['site_lang'];
				$seo_description_field = "menu_desc_" . $data['site_lang'];
				$data['seo_title'] = isset($seo_titles->$seo_title_field) ? $seo_titles->$seo_title_field : "";
				$data['seo_description'] = isset($seo_descriptions->$seo_description_field) ? $seo_descriptions->$seo_description_field : "";

				$session_lang = $this->session->userdata("site_lang");
				if ($session_lang == ""){
					$session_lang = "french";
				}
				if ($data['myRestDetail']->resto_plan == "free" && $mode !== "table"){
					$this->page_404("Limited","To access this page, it should be a Resto Pro plan");
				}else{
					$lang_title_field = "item_name_" . $session_lang;
					$nrs = $this->db->where("rest_id = $rest_id AND $lang_title_field <> ''")->get("tbl_menu_card")->num_rows();
					if ($nrs > 1){
						$data['site_lang']=$session_lang;
					}else{
						$langs = ["french","germany","english"];
						foreach ($langs as $key => $value) {
							$lang_title_field = "item_name_" . $value;
							$nr = $this->db->where("rest_id = $rest_id AND $lang_title_field <> ''")->get("tbl_menu_card")->num_rows();
							if ($nr > 0){
								$data['site_lang'] = $value;
								$this->session->set_userdata('site_lang', $value);
								break;
							}
						}
					}
		
					$cbc = array();
					foreach ($data['categorytype'] as $key => $ctype) {
						$cbc[$ctype->type_title][] = $this->db->order_by("category_sort_index","ASC")->where("type_id = ".$ctype->type_id ." and category_status = 'active' and (added_by='$rest_id' or added_by=0)")->get('tbl_category')->result();
					}
					$data['Categories_by_ctypes'] = $cbc;
					if ($mode == "table"){
						// =======================================================================
						$wishlist_array = array();
						$wishlist_item_id_array = array();
						$wishlist_item_price_array = array();
						$wishlist_item_qty_array = array();
						$wishlist_item_extra_array = array();
						if (null !== $this->input->cookie('jfrost_wishlist')){
							$wishlist_array = explode(",", $this->input->cookie("jfrost_wishlist"));
	
							foreach ($wishlist_array as $key => $value) {
								$each_item_info = explode(":", $value);
								$each_item_id = $each_item_info[0];
								$each_item_price_index = $each_item_info[1];
								$each_item_price_qty = $each_item_info[2];
								$each_item_extra_id = $each_item_info[3];
	
								$wishlist_item_id_array[] = $each_item_id;
								$wishlist_item_price_array[] = $each_item_price_index;
								$wishlist_item_qty_array[] = $each_item_price_qty;
								$wishlist_item_extra_array[] = explode("|",$each_item_extra_id);
							}
						}
						$wishlist = $wishlist_array;
						$wishlist_str = implode(",",$wishlist_item_id_array);
						// $data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
						$item_details = array();
						$wish_price = array();
						$wish_qty = array();
						foreach ($wishlist_item_id_array as $key_item => $value_item) {
							if ($item_detail = $this->db->query("select * from tbl_menu_card as mc join tbl_category as c on mc.category_id = c.category_id where rest_id = $rest_id and c.category_status = 'active' and  item_status <> 'Not Available' and menu_id = $value_item")->row()){
								$item_details[] = $item_detail;
								$wish_price[] = $wishlist_item_price_array[$key_item];
								$wish_qty[] = $wishlist_item_qty_array[$key_item];
							}
						}
						$data['wishlist_item_extra_array']	= $wishlist_item_extra_array;
						$data['wishlist']	= $wishlist;
						$data['item_details']	= $item_details;
						$data['wish_price']	= $wish_price;
						$data['wish_qty']	= $wish_qty;
					}else{
						// =======================================================================
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
						// $data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
						$cart_item_details = array();
						$cart_price = array();
						$cart_qty = array();
						foreach ($carts_item_id_array as $c_key_item => $c_value_item) {
							if ($cart_item_detail = $this->db->query("select * from tbl_menu_card as mc join tbl_category as c on mc.category_id = c.category_id left join tbl_tax_settings as tx on tx.id = mc.item_tax_id where mc.rest_id = $rest_id and c.category_status = 'active' and  item_status <> 'Not Available' and menu_id = $c_value_item")->row()){
								$cart_item_details[] = $cart_item_detail;
								$cart_price[] = $carts_item_price_array[$c_key_item];
								$cart_qty[] = $carts_item_qty_array[$c_key_item];
							}
						}
						$data['carts_item_extra_array']	= $carts_item_extra_array;
						$data['carts']	= $carts;
						$data['cart_item_details']	= $cart_item_details;
						$data['cart_price']	= $cart_price;
						$data['cart_qty']	= $cart_qty;
	
						$min_order = 0;
						$delivery_cost = 0;
						$delivery_time = 0;
						$min_order_amount_free_delivery = 0;
						$post_code = 0;
						if ($this->session->userdata('customer_info') !== null){
							$customer_info = $this->session->userdata('customer_info');
							if ($customer_info['filtered_by'] == "postcode"){
								if (strtolower($mode) == "delivery" && $dparea = $customer_info['area']){
									$min_order = $dparea->min_order_amount;
									$delivery_cost = $dparea->delivery_charge;
									$delivery_time = $dparea->delivery_time;
									$min_order_amount_free_delivery = $dparea->min_order_amount_free_delivery;
								}
							}else{
								if (strtolower($mode) == "delivery" && isset($customer_info['area_zone'])){
									$area_zone = $customer_info['area_zone'];
									$min_order = $area_zone->minimum_order_amount;
									$delivery_cost = $area_zone->delivery_charge;
									$delivery_time = $area_zone->delivery_time;
									$min_order_amount_free_delivery = $area_zone->min_order_amount_free_delivery;
								}
							}
						}
						$data['min_order']	= $min_order;
						$data['delivery_time']	= $delivery_time;
						$data['min_order_amount_free_delivery']	= $min_order_amount_free_delivery;
						$data['delivery_cost']	= $delivery_cost;
					}
					
					$cnt_str = "";
					$rest_country = $this->db->where('rest_id',$rest_id)->get('tbl_delivery_countries')->row();
					if ($rest_country){
						$cnt = explode(",",strtolower($rest_country->countries));
					}else{
						$cnt = array();
					}
					foreach ($cnt as $key => $value) {
						$cnt_str = $cnt_str . "'" . $value ."',";
					}
					$data['countries']=$cnt_str ;
					
					$openingTimes = $this->db->where("rest_id",$rest_id)->get("tbl_opening_times")->row();
					$data['openingTimes'] = $openingTimes;
					$this->load->view('website/layout/header',$data);
					$this->load->view('website/pages/rest_menu');
					$this->load->view('website/layout/footer');
				}
			}else{
				$this->load->view('website/pages/index');
			}
		}
		public function wishList($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			// $data['active_tab'] = $active_tab;
			$rest_currency_id = $data['myRestDetail']->currency_id;
			$rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
			$rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;
			$data['currentRestCurrencySymbol'] = $rest_currency_symbol;
			
			$data['site_lang']=$this->session->userdata("site_lang");
			$session_lang = $this->session->userdata("site_lang");

			if ($session_lang == ""){
				$session_lang = "french";
			}
			$lang_title_field = "item_name_" . $session_lang;


			$wishlist_array = array();
			$wishlist_item_id_array = array();
			$wishlist_item_price_array = array();
			$wishlist_item_qty_array = array();
			$wishlist_item_extra_array = array();

			if (null !== $this->input->cookie('jfrost_wishlist')){
				$wishlist_array = explode(",", $this->input->cookie("jfrost_wishlist"));

				foreach ($wishlist_array as $key => $value) {
					$each_item_info = explode(":", $value);
					$each_item_id = $each_item_info[0];
					$each_item_price_index = $each_item_info[1];
					$each_item_price_qty = $each_item_info[2];
					$each_item_extra_id = $each_item_info[3];

					$wishlist_item_id_array[] = $each_item_id;
					$wishlist_item_price_array[] = $each_item_price_index;
					$wishlist_item_qty_array[] = $each_item_price_qty;
					$wishlist_item_extra_array[] = explode("|",$each_item_extra_id);
				}
			}
			$wishlist = $wishlist_array;
			$wishlist_str = implode(",",$wishlist_item_id_array);
			// $data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$item_details = array();
			$wish_price = array();
			$wish_qty = array();
			foreach ($wishlist_item_id_array as $key_item => $value_item) {
					if ($item_detail = $this->db->query("select * from tbl_menu_card as mc join tbl_category as c on  mc.category_id = c.category_id where rest_id = $rest_id and c.category_status = 'active' and  item_status <> 'Not Available' and menu_id = $value_item")->row()){
						$item_details[] = $item_detail;
						$wish_price[] = $wishlist_item_price_array[$key_item];
						$wish_qty[] = $wishlist_item_qty_array[$key_item];
					}
			}
			$data['wishlist_item_extra_array']	= $wishlist_item_extra_array;
			$data['wishlist']	= $wishlist;
			$data['wish_price']	= $wish_price;
			$data['wish_qty']	= $wish_qty;
			$data['item_details']	= $item_details;
			$data['temp'] = $wishlist;
			$data['common_bottom_bar'] = false;
			$this->load->view('website/layout/header',$data);
			$this->load->view('website/pages/wishlist_page');
			$this->load->view('website/layout/footer');
		}
		public function is_open_rest($rest_id,$dp_option){

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
		public function get_min_max_time($rest_id,$dp_option){
			$min_time = "";
			$max_time = "";

			$openingTimes = $this->db->where("rest_id",$rest_id)->get("tbl_opening_times")->row();
			date_default_timezone_set('Europe/Luxembourg');
			$now_Y= date("Y");
			$now_m= date("m");
			$now_d= date("d");
			$now_H= date("H");
			$now_i= date("i");
			$now_s= date("s");
			$now_weekday= (date("N") + 6) % 7;

			$delivery_open_day = "";
			$pickup_open_day = "";

			if (isset($openingTimes)){
				if ($dp_option == "pickup"){
					$pickup_hours = $openingTimes->pickup_hours;
					if (isset($pickup_hours) && $pickup_hours !== ""){
						$pickup_hours = json_decode($pickup_hours);
						$pickup_end = "00:00";
						$pickup_start = "23:59";
						foreach ($pickup_hours[$now_weekday] as $pkey => $pvalue) {
							$pickup_start = strtotime($pvalue->start.":00") < strtotime($pickup_start.":00") ? $pvalue->start : $pickup_start;
							$pickup_end = strtotime($pvalue->end.":00") > strtotime($pickup_end.":00") ? $pvalue->end : $pickup_end;
						}
	
						if (strtotime($now_H.":". $now_i .":00") > strtotime($pickup_start .":00")){
							if (strtotime($now_H.":". $now_i .":00") > strtotime($pickup_end .":00")){
								$pickup_open_day = "tomorrow";
							}else{
								$min_time = $now_H.":". $now_i;
								$max_time = $pickup_end;
								$pickup_open_day = "today";
							}
						}else{
							$min_time = $pickup_start;
							$max_time = $pickup_end;
							$pickup_open_day = "today";
						}
					}
				}else{
					$delivery_hours = $openingTimes->delivery_hours;
					if (isset($delivery_hours) && $delivery_hours !== ""){
						$delivery_hours = json_decode($delivery_hours);
						$delivery_end = "00:00";
						$delivery_start = "23:59";
						foreach ($delivery_hours[$now_weekday] as $pkey => $pvalue) {
							$delivery_start = strtotime($pvalue->start.":00") < strtotime($delivery_start.":00") ? $pvalue->start : $delivery_start;
							$delivery_end = strtotime($pvalue->end.":00") > strtotime($delivery_end.":00") ? $pvalue->end : $delivery_end;
						}
	
						if (strtotime($now_H.":". $now_i .":00") > strtotime($delivery_start .":00")){
							if (strtotime($now_H.":". $now_i .":00") > strtotime($delivery_end .":00")){
								$delivery_open_day = "tomorrow";
							}else{
								$min_time = $now_H.":". $now_i;
								$max_time = $delivery_end;
								$delivery_open_day = "today";
							}
						}else{
							$min_time = $delivery_start;
							$max_time = $delivery_end;
							$delivery_open_day = "today";
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
								if ($dp_option == "delivery"){
									$delivery_open_day = "tomorrow";
								}else{
									$pikcup_open_day = "tomorrow";
								}
							}
							if ( strtotime(date($now_time)) <  strtotime(date($holiday_end)) && ( strtotime(date($now_time)) > strtotime(date($holiday_start)) || $holiday_start == "" )) {
								if ($dp_option == "delivery"){
									$delivery_open_day = "tomorrow";
								}else{
									$pikcup_open_day = "tomorrow";
								}
							}
	
						}
					}
				}

				$irregular_openings = $openingTimes->irregular_openings;
				if (isset($irregular_openings) && $irregular_openings !== ""){
					$irregular_openings = json_decode($irregular_openings);
					if (isset($irregular_openings->name )){
						$irregular_openings_start_time = "23:59";
						$irregular_openings_end_time = "00:00";
						$is_today_irregular_opening = false;
						
						$now_day = $now_m . "/" .  $now_d . "/" . $now_Y;
						$now_time = $now_H . ":" .  $now_i . ":" . $now_s;
						
						foreach ($irregular_openings->name as $ikey => $ivalue) {
							$irregular_openings_day = $irregular_openings->date[$ikey];
							
							$irregular_openings_start_time = $irregular_openings->timeStart[$ikey];
							$irregular_openings_end_time = $irregular_openings->timeEnd[$ikey];
							
							if ( strtotime(date($now_day)) ==  strtotime(date($irregular_openings_day))) {
								$irregular_openings_start_time = strtotime($irregular_openings->timeStart[$ikey]) < strtotime($irregular_openings_start_time.":00") ? $irregular_openings->timeStart[$ikey] : $irregular_openings_start_time;
								$irregular_openings_end_time = strtotime($irregular_openings->timeEnd[$ikey]) > strtotime($irregular_openings_end_time.":00") ? $irregular_openings->timeEnd[$ikey] : $irregular_openings_end_time;
								$is_today_irregular_opening = true;
							}
						}

						if ($is_today_irregular_opening){
							if ($dp_option == "pickup"){
								if ($pickup_open_day !== ""){
									if ($pickup_open_day == "today"){
										if( strtotime($irregular_openings_start_time.":00") <  $min_time) {
											$min_time = strtotime($irregular_openings_start_time.":00");
										}
										if( strtotime($irregular_openings_end_time.":00") >  $max_time) {
											$max_time = strtotime($irregular_openings_end_time.":00");
										}
									}else{ // tomorrow
										if( strtotime($irregular_openings_start_time.":00") < strtotime($now_time) ) {
											$min_time = $now_H . ":" .  $now_i;
											$max_time = $irregular_openings_end_time;
											$pickup_open_day = "today";
										}else{
											$min_time = $irregular_openings_start_time;
											$max_time = $irregular_openings_end_time;
											$pickup_open_day = "today";
										}
									}
								}
							}else{
								if ($delivery_open_day !== ""){
									if ($delivery_open_day == "today"){
										if( strtotime($irregular_openings_start_time.":00") <  $min_time) {
											$min_time = strtotime($irregular_openings_start_time.":00");
										}
										if( strtotime($irregular_openings_end_time.":00") >  $max_time) {
											$max_time = strtotime($irregular_openings_end_time.":00");
										}
									}else{ // tomorrow
										if( strtotime($irregular_openings_start_time.":00") < strtotime($now_time) ) {
											$min_time = $now_H . ":" .  $now_i;
											$max_time = $irregular_openings_end_time;
											$delivery_open_day = "today";
										}else{
											$min_time = $irregular_openings_start_time;
											$max_time = $irregular_openings_end_time;
											$delivery_open_day = "today";
										}
									}
								}
							}
						}
					}
				}
			}
			if ($dp_option == "delivery"){
				return array(
					"_open_day" => $delivery_open_day,
					"min_time"			=> $min_time,
					"max_time"			=> $max_time,
				);
			}else if ($dp_option == "pickup"){
				return array(
					"_open_day" => $pickup_open_day,
					"min_time"			=> $min_time,
					"max_time"			=> $max_time,
				);
			}
		}
		public function cart($rest_url_slug,$menu_mode,$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$rest_currency_id = $data['myRestDetail']->currency_id;
			$rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
			$rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;
			$data['currentRestCurrencySymbol'] = $rest_currency_symbol;

			if ($data['myRestDetail']->pre_order == 0  && !$this->is_open_rest($rest_id,strtolower($menu_mode))){
				redirect ("view/$rest_url_slug");
			}
			$data['is_pre_order']=$data['myRestDetail']->pre_order;
			$data['menu_mode']=$menu_mode;
			$data['is_open_time']= $this->is_open_rest($rest_id,strtolower($menu_mode));
			$session_lang = $this->session->userdata("site_lang");
			if ($session_lang == ""){
				$session_lang = "french";
			}
			$data['site_lang']=$session_lang;
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
			// $data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
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
			$data['carts_item_extra_array']	= $carts_item_extra_array;
			$data['carts']	= $carts;
			$data['cart_item_details']	= $cart_item_details;
			$data['cart_price']	= $cart_price;
			$data['cart_qty']	= $cart_qty;
			
			$min_order = 0;
			$delivery_cost = 0;
			$delivery_time = 0;
			$min_order_amount_free_delivery = 0;
			$post_code = 0;
			if ($this->session->userdata('customer_info') !== null){
				$customer_info = $this->session->userdata('customer_info');
				if ($customer_info['filtered_by'] == "post_code"){
					if (isset($customer_info['post_code'])){
						$post_code = $customer_info['post_code'];
						if (strtolower($mode) == "delivery" && $dparea = $this->db->query("select * from tbl_delivery_areas where post_code = $post_code and min_order_amount <> '' and rest_id = $rest_id AND status = 'active'")->row()){
							$min_order = $dparea->min_order_amount;
							$delivery_cost = $dparea->delivery_charge;
							$delivery_time = $dparea->delivery_time;
							$min_order_amount_free_delivery = $dparea->min_order_amount_free_delivery;
						}
					}
				}else{
					if (isset($customer_info['area_zone'])){
						$area_zone = $customer_info['area_zone'];
						$min_order = $area_zone->minimum_order_amount;
						$delivery_cost = $area_zone->delivery_charge;
						$delivery_time = $area_zone->delivery_time;
						$min_order_amount_free_delivery = $area_zone->min_order_amount_free_delivery;
					}
				}
			}
			$data['min_order']	= $min_order;
			$data['delivery_time']	= $delivery_time;
			$data['min_order']	= $min_order;
			$data['delivery_cost']	= $delivery_cost;

			$data['common_bottom_bar'] = false;
			$this->load->view('website/layout/header',$data);
			$this->load->view('website/pages/cart_page');
			$this->load->view('website/layout/footer');
		}
		public function checkout($rest_url_slug,$menu_mode,$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$myRest =  $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row();
			$rest_id = $myRest->rest_id;
			$data["myRest"] = $myRest;
			$data['customer'] = null;
			if ($this->session->userdata("customer_Data")){
				$sessUserData=unserialize($this->session->userdata('customer_Data'));
				$user_id = $sessUserData[0]->id;
				$data['user_id'] = $user_id;
				$data['customer'] = $this->db->where("user_id",$user_id )->get("tbl_customers")->row();
				$data['loyalty_point_setting'] = $this->db->where("rest_id",$rest_id)->get("tbl_loyalty_point_settings")->row();
			}
			$payment_settings = $this->db->where('rest_id',$rest_id)->get('tbl_payment_settings')->row();

			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;
			$data['payment_settings']=$payment_settings;
			$this->session->set_userdata('rest_id', $rest_id);
			$this->session->set_userdata('menu_mode', $menu_mode);
			$this->session->set_userdata('iframe', $iframe);
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['is_pre_order']=$data['myRestDetail']->pre_order;
			$data['is_open_pre_order']=$data['myRestDetail']->open_pre_order;
			$data['is_open_time']= $this->is_open_rest($rest_id,strtolower($menu_mode));

			$rest_currency_id = $data['myRestDetail']->currency_id;
			$rest_currency_symbol = $this->db->where("id",$rest_currency_id)->get('tbl_countries')->row()->currency_symbol;
			$rest_currency_symbol = $rest_currency_symbol == "" ? "&#8364;" : $rest_currency_symbol;
			$data['currentRestCurrencySymbol'] = $rest_currency_symbol;

			$get_min_max_time = $this->get_min_max_time($rest_id,strtolower($menu_mode));
			if ($get_min_max_time['_open_day'] == ""){
				$data['_open_pre_order_day'] = false;
			}elseif($get_min_max_time['_open_day']  == "today"){
				$data['_open_pre_order_day'] = true;
				$data['begin_time']= $get_min_max_time['min_time'];
				$data['end_time']= $get_min_max_time['max_time'];
			}else{
				$data['_open_pre_order_day'] = false;
			}
			// $data['_open_pre_order_day'] = $get_min_max_time['_open_day'];

			$data['site_lang']=$this->session->userdata("site_lang");
			$data['menu_mode']=$menu_mode;
			$data['common_bottom_bar'] = false;

			if ( $data['myRestDetail']->pre_order == 0 && !$this->is_open_rest($rest_id,strtolower($menu_mode))){
				redirect ("view/$rest_url_slug");
			}
			// for Cart section
			$mode = $menu_mode;
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
			// $data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$cart_item_details = array();
			$cart_price = array();
			$cart_qty = array();
			foreach ($carts_item_id_array as $c_key_item => $c_value_item) {
				if ($cart_item_detail = $this->db->query("select * from tbl_menu_card as mc join tbl_category as c on mc.category_id = c.category_id left join tbl_tax_settings as tx on tx.id = mc.item_tax_id where mc.rest_id = $rest_id and c.category_status = 'active' and  item_status <> 'Not Available' and menu_id = $c_value_item")->row()){
					$cart_item_details[] = $cart_item_detail;
					$cart_price[] = $carts_item_price_array[$c_key_item];
					$cart_qty[] = $carts_item_qty_array[$c_key_item];
				}
			}
			$data['carts_item_extra_array']	= $carts_item_extra_array;
			$data['carts']	= $carts;
			$data['cart_item_details']	= $cart_item_details;
			$data['cart_price']	= $cart_price;
			$data['cart_qty']	= $cart_qty;

			$min_order = 0;
			$delivery_cost = 0;
			$delivery_time = 0;
			$min_order_amount_free_delivery = 0;
			$post_code = 0;
			if ($this->session->userdata('customer_info') !== null){
				$customer_info = $this->session->userdata('customer_info');
				if ($customer_info['filtered_by'] == "postcode"){
					if (strtolower($mode) == "delivery" && $dparea = $customer_info['area']){
						$min_order = $dparea->min_order_amount;
						$delivery_cost = $dparea->delivery_charge;
						$delivery_time = $dparea->delivery_time;
						$min_order_amount_free_delivery = $dparea->min_order_amount_free_delivery;
					}
				}else{
					if (strtolower($mode) == "delivery" && isset($customer_info['area_zone'])){
						$area_zone = $customer_info['area_zone'];
						$min_order = $area_zone->minimum_order_amount;
						$delivery_cost = $area_zone->delivery_charge;
						$delivery_time = $area_zone->delivery_time;
						$min_order_amount_free_delivery = $area_zone->min_order_amount_free_delivery;
					}
				}
			}
			$data['min_order']	= $min_order;
			$data['delivery_time']	= $delivery_time;
			$data['min_order_amount_free_delivery']	= $min_order_amount_free_delivery;
			$data['delivery_cost']	= $delivery_cost;
			$data['mode']	= $mode;
			$data['jquery_1_8_timepicker']	= true;

			$geocode = json_decode($data['myRestDetail']->geocode);
			if (isset($geocode->lat) && isset($geocode->lat)){
				$data['is_geocode'] = true;
				$data['lat'] = $geocode->lat;
				$data['lng'] = $geocode->lng;
			}else{
				$data['is_geocode'] = false;
				$data['lat'] = "49.6773308";
				$data['lng'] = "6.44405039";
			}

			// end cart section
			$this->load->view('website/layout/header',$data);
			$this->load->view('website/pages/checkout');
			$this->load->view('website/layout/footer');
		}
		public function order_complete(){
			// Get cart from session userdata
			$cart = $this->session->userdata('shopping_cart');
			$stripe = $this->session->userdata('shopping_cart_stripe');

			if(empty($cart)) redirect('/');

			// Set cart data into session userdata
			$this->load->vars('cart', $cart);
			$this->load->vars('stripe', $stripe);

			// Successful call.  Load view or whatever you need to do here.
			$this->load->view('website/pages/payment_complete');
		}
		public function help($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
			$data['site_lang']=$this->session->userdata("site_lang");
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			
			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;

			$this->load->view('website/layout/header',$data);
			$this->load->view('website/pages/help');
			$this->load->view('website/layout/footer');
		}
		public function reservation($rest_url_slug="",$iframe=""){
			$rest_url_slug = $this->check_Url_Slug($rest_url_slug);
	
			$data['site_lang']=$this->session->userdata("site_lang");
			$rest_id = $this->db->where('rest_url_slug',$rest_url_slug)->get('tbl_restaurant')->row()->rest_id;
			$seo_content = $this->db->where("seo_rest_id",$rest_id)->get('tbl_seo_settings')->row();
			$seo_titles = json_decode(isset($seo_content) ? $seo_content->seo_titles : "");
			$seo_descriptions = json_decode(isset($seo_content->seo_descriptions) ? $seo_content->seo_descriptions : "");
			$seo_title_field = "reservation_title_" . $data['site_lang'];
			$seo_description_field = "reservation_desc_" . $data['site_lang'];
			$data['seo_title'] = isset($seo_descriptions->$seo_title_field) ? $seo_titles->$seo_title_field : "";
			$data['seo_description'] = isset($seo_descriptions->$seo_description_field) ? $seo_descriptions->$seo_description_field : "";

			$data['rest_url_slug']=$rest_url_slug;
			$data['myRestDetail']=$this->db->where('restaurant_id',$rest_id)->get('tbl_restaurant_details')->row();
			$data['iframe']=$iframe;
			$data['myRestId']=$rest_id;
			// $data['externalScript']= '<script src="'.base_url('assets/additional_assets/').'template/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>';
			if (!in_array("reservation",explode(",",$data['myRestDetail']->active_pages))){ 
				$this->page_404("Oops",$this->lang->line("It is not allowed to access to this page"));
			}else{
				$this->load->view('website/layout/header',$data);
				$this->load->view('website/pages/reservation_page');
				$this->load->view('website/layout/footer');
			}
		}
		public function page_404($title = "Error 404" ,$message = ""){
			$data['error_message'] = $message;
			$data['error_title'] = $title;
			$this->load->view('website/pages/404',$data);
		}
	}
?>