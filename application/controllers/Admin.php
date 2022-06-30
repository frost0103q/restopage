<?php
	/**
	 * 
	 */
	class Admin extends CI_Controller
	{
		function __construct(){
			parent::__construct();
			$this->load->model('AdminModel','MODEL');
			$this->load->library('email');
			$this->lang->load('content_lang',$this->session->userdata("site_lang_admin"));
			if(!$this->session->userdata('admin_user_Data')){
				redirect('Login');
			}
			if ($this->session->userdata("site_lang_admin") == ""){
				$this->session->set_userdata('site_lang_admin', "french");
			}
			$sessData=unserialize($this->session->userdata('admin_user_Data'));
		}
		public function index(){
            $data['addRest']=$this->MODEL->getAllActiveRest();
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/all_restaurant',$data);
			$this->load->view('admin/layout/footer');
		}
		public function logOut(){
			if($this->session->userdata('admin_user_Data')){
				$this->session->unset_userdata('admin_user_Data');
			}
			redirect('Home');
		}
		public function dashboard(){
            $data['addRest']=$this->MODEL->getAllActiveRest();
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/all_restaurant',$data);
			$this->load->view('admin/layout/footer');
		}
		public function addRestaurant(){
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/new_restaurant');
			$this->load->view('admin/layout/footer');
		}
		public function viewRestaurant($rest_id){
			$data = array(
				"rest_id"=>$rest_id,
			);
			$res=$this->MODEL->getRestLoginValidate($data,false);
			if($res!=false){
				$sessData=serialize($res);
				$this->session->set_userdata('rest_user_Data',$sessData);
				redirect('Restaurant');
			}else{
				redirect('Admin');
			}
		}
		public function freeSupport(){
			$data["admin"] = $this->db->get("tbl_admin")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/freeSupport',$data);
			$this->load->view('admin/layout/footer');
		}
		public function legalPageSetting(){
			$data['legal_page_settings']=$this->db->where("rest_id",'0')->get("tbl_legal_settings")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/adminLegalPagesSetting');
			$this->load->view('admin/layout/footer');
		}
		public function addon(){
			$data['addons']=$this->db->get("tbl_addons")->result();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/adminAddons');
			$this->load->view('admin/layout/footer');
		}
		public function restaurant_addons(){
			$data['restaurant_addons']=$this->db->get("tbl_addons")->result();
			// $data['restaurants']=$this->db->get("tbl_restaurant")->result();
			$data['restaurants']=$this->db->query("SELECT r.rest_id as rid, r.rest_name, ra.* FROM `tbl_restaurant` r
			LEFT JOIN (SELECT * FROM `tbl_restaurant_addons` WHERE `status` = 'pending' GROUP BY `rest_id`) AS ra ON r.`rest_id` = ra.rest_id
			ORDER BY ra.status DESC")->result();
			$data['rest_addon_status']=$this->MODEL->geAllRestaurantAddonStatus();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/restaurantAddonList');
			$this->load->view('admin/layout/footer');
		}
		public function addonDetail($addon_id){
			$data['addon']=$this->db->where("addon_id",$addon_id)->get("tbl_addons")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/adminAddonDetail');
			$this->load->view('admin/layout/footer');
		}
		public function mobilePageSetting(){
			$data['mobile_terms_page']=$this->db->where("option_key","mobile_terms_page")->get("tbl_admin_option")->row();
			$data['mobile_about_page']=$this->db->where("option_key","mobile_about_page")->get("tbl_admin_option")->row();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/adminMobilePagesSetting');
			$this->load->view('admin/layout/footer');
		}
		public function fileUploadingSetting(){
			$fileUploadingSetting=$this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
			if (isset($fileUploadingSetting)){
				$data['fileUploadingSetting'] = json_decode($fileUploadingSetting->option_value);
            }   
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/fileUploadingSetting');
			$this->load->view('admin/layout/footer');
		}
		public function videoTutorials(){
			$data["video_tutorials"] = $this->db->get("tbl_video_tutorials")->result();
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/videoTutorials',$data);
			$this->load->view('admin/layout/footer');
		}
		public function videoTutorialDetail($video_id){
			$data["video_tutorial"] = $this->db->where("video_id",$video_id)->get("tbl_video_tutorials")->row();
			$data["video_id"] = $video_id;
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/videoTutorialDetail',$data);
			$this->load->view('admin/layout/footer');
		}
		public function Announcements(){
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['announcements'] = $this->db->where('rest_id' , 0)->get('tbl_announcement')->result();
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/announcements',$data);
			$this->load->view('admin/layout/footer');
		}
		public function announcementDetails($id){
			$data['_lang'] = $this->session->userdata('site_lang_admin');
			$data['announcement'] = $this->db->where('rest_id' , 0)->where("id",$id)->get('tbl_announcement')->row();
			$data['announcement_id'] = $id;
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/announcementDetail',$data);
			$this->load->view('admin/layout/footer');
		}
		public function allRestaurant(){
			$data['addRest']=$this->MODEL->getAllActiveRest();
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/all_restaurant',$data);
			$this->load->view('admin/layout/footer');
		}
		public function Allergen($rest_id = 0){
			if ($rest_id == 0){
				$data['allergens']=$this->MODEL->getAll("tbl_allergens");
				$data['rest_id'] = "0";
			}else{
				$data['allergens']=$this->db->where("added_by='$rest_id' or added_by=0")->get('tbl_allergens')->result();
				$data['rest_id']=$rest_id;
			}
			// modify by Jfrost
			$data['Rests']=$this->MODEL->getAllActiveRest();
			if ($this->session->userdata('site_lang_admin')){
				$data['allergen_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['allergen_lang'] = "french";
				$this->session->set_userdata('site_lang_admin', "french");
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/allergen',$data);
			$this->load->view('admin/layout/footer');
		}
		public function Kitchens(){
			// modify by Jfrost
			$data['kitchens']=$this->db->get('tbl_kitchens')->result();
			if ($this->session->userdata('site_lang_admin')){
				$data['_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['_lang'] = "french";
				$this->session->set_userdata('site_lang_admin', "french");
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/kitchens',$data);
			$this->load->view('admin/layout/footer');
		}
		public function kitchenDetails($kitchen_id){
			if ($kitchen = $this->MODEL->getKitchenDetails($kitchen_id)){
				$data['kitchen']=$kitchen;
				$data['_lang']=$this->session->userdata("site_lang_admin");
				$this->load->view('admin/layout/header');
				$this->load->view('admin/pages/kitchenDetail',$data);
				$this->load->view('admin/layout/footer');
			}else{
				$this->Kitchens();
			}

		}
		public function Category($rest_id = 0){
			if ($rest_id == 0){
				// $data['Categories']=$this->MODEL->getAll("tbl_category");
				$data['Categories']=$this->db->order_by("category_sort_index")->where("category_status <> 'deactive'")->get('tbl_category')->result();
				$data['rest_id'] = "0";
			}else{
				$data['Categories']=$this->db->order_by("category_sort_index")->where("(added_by='$rest_id' or added_by=0) and category_status <> 'deactive'")->get('tbl_category')->result();
				$data['rest_id']=$rest_id;
			}
			// modify by Jfrost
			$data['Rests']=$this->MODEL->getAllActiveRest();
			if ($this->session->userdata('site_lang_admin')){
				$data['category_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['category_lang'] = "french";
				$this->session->set_userdata('site_lang_admin', "french");
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/category',$data);
			$this->load->view('admin/layout/footer');
		}
		public function rejectedCategory(){
			$data['Categories']=$this->db->order_by("category_sort_index")->where("category_status = 'deactive'")->get('tbl_category')->result();

			if ($this->session->userdata('site_lang_admin')){
				$data['category_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['category_lang'] = "french";
				$this->session->set_userdata('site_lang_admin', "french");
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/rejected_category',$data);
			$this->load->view('admin/layout/footer');
		}
		public function pendingRestaurant(){
			$data['penRest']=$this->MODEL->getAllPendingRest();
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/pending_restaurant',$data);
			$this->load->view('admin/layout/footer');
		}
		public function rejectedRestaurant(){
			$data['rejRest']=$this->MODEL->getAllRejectedRest();
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/rejected_restaurant',$data);
			$this->load->view('admin/layout/footer');
		}
		public function allergenDetails($allergen_id){
			if ($allergens=$this->MODEL->getAllergenDetails($allergen_id)){
				$data['AllergenDetails']=$allergens;
				$this->load->view('admin/layout/header');
				$this->load->view('admin/pages/allergenDetails',$data);
				$this->load->view('admin/layout/footer');
			}else{
				$this->Allergen(0);
			}
		}
		public function categoryDetails($cate_id){
			$data['CategoryDetails']=$this->MODEL->getCategoryDetails($cate_id);
			$data['subCategoryDetails']=$this->MODEL->getCategorySubDetails($cate_id);
			$data['FoodExtraDetails']=$this->MODEL->getFoodExtraDetails($cate_id);
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/categoryDetails',$data);
			$this->load->view('admin/layout/footer');
		}
		public function Menu( $rest_id = 0){
			// $data['Categories']=$this->MODEL->getAll("tbl_category");
			// $data['Categories']=[];
			if ($rest_id > 0){
				$data['Categories']=$this->db->order_by("category_sort_index","ASC")->where("added_by='$rest_id' or added_by=0")->get('tbl_category')->result();
			}else{
				$data['Categories']=[];
			}
			if ($rest_id > 0){
				$data['allergens']=$this->db->where("added_by='$rest_id' or added_by=0")->get('tbl_allergens')->result();
			}else{
				$data['allergens']=[];
			}
			$data['myRestId']= $rest_id;
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$rest_id)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			
			$data['addRest']=$this->MODEL->getAllActiveRest();
			if ($this->session->userdata('site_lang_admin')){
				$data['category_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['category_lang'] = "french";
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/createMenu',$data);
			$this->load->view('admin/layout/footer');
		}
		public function rejectedMenu( $rest_id = 0){
			$data['myRestId']= $rest_id;
			$data['addRest']=$this->MODEL->getAllActiveRest();
			if ($this->session->userdata('site_lang_admin')){
				$data['category_lang'] = $this->session->userdata('site_lang_admin');
			}else{
				$data['category_lang'] = "french";
			}
			$this->load->view('admin/layout/header');
			$this->load->view('admin/pages/rejected_Menu',$data);
			$this->load->view('admin/layout/footer');
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

				if (null !== $this->input->post('item_name_'.$item_type_title.'_germany')){
					$item_name_germany = $this->input->post('item_name_'.$item_type_title.'_germany');
					$item_name = $item_name_germany;
				}else{
					$item_name_germany = '';
				}
				if (null !== $this->input->post('item_name_'.$item_type_title.'_english')){
					$item_name_english = $this->input->post('item_name_'.$item_type_title.'_english');
					$item_name = $item_name_english;
				}else{
					$item_name_english = '';
				}
				if (null !== $this->input->post('item_name_'.$item_type_title.'_french')){
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

					foreach ($food_extra[$key] as $extra_key => $extra) {
						$each_food_extra = $extra;
						$each_extra_price = $extra_price[$key][$extra_key];
						$join_food_extra_arr[$extra_key] = $each_food_extra . ":" . $each_extra_price; 
					}

					$join_food_extra_str = implode(",",$join_food_extra_arr);
					$item_food_extra_arr[] = $join_food_extra_str;
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

				$rest_id = $this->input->post('rest_id');
				$data=array(
					"rest_id"=>$this->input->post('rest_id'),
					"category_id"=>$category_id ,
					"sub_cat_ids"=>implode("," ,$sub_cat_ids),
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
					"item_sort_index" => $this->input->post('item_sort_index'),
					"item_food_extra" => $item_food_extra_str,
					"item_show_on" => $item_show_on,
				);
				
				if (file_exists($_FILES['item_image']['tmp_name']) || is_uploaded_file($_FILES['item_image']['tmp_name'])){
					$destination_img='assets/menu_item_images/'.$imageName;
					if ($this->compress($source_img, $destination_img, 80)){
					}else{
						// $this->session->set_flashdata('msg',"Server Not Found, Failed to add Item");
					}
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
			redirect('Admin/Menu/'.$rest_id);
		}
		public function compress($source, $destination, $quality) {

		    $info = getimagesize($source);

		    if ($info['mime'] == 'image/jpeg') 
		        $image = imagecreatefromjpeg($source);

		    elseif ($info['mime'] == 'image/gif') 
		        $image = imagecreatefromgif($source);

		    elseif ($info['mime'] == 'image/png') 
		        $image = imagecreatefrompng($source);

		    imagejpeg($image, $destination, $quality);

		    return $destination;
		}
		public function Setting($rest_id = 0){
			$data['rest_id'] = $rest_id;
			$data['Categories']=$this->MODEL->getAll("tbl_category");
			$data['addRest']=$this->MODEL->getAllActiveRest();
			
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/restaurantSettings');
			$this->load->view('admin/layout/footer');
			
		}
		public function editMenu($item_id,$lang="english"){
			
			$data['itemDetails']=$this->db->where('menu_id',$item_id)->get('tbl_menu_card')->row();
			$rest_id = $data['itemDetails']->rest_id;
			$data['myRestId']=$rest_id;
			$data['restDetails']=$this->db->where('tbl_restaurant.rest_id',$this->myRestId)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
			
			// $data['myRestName']=$this->myRestName;
			$data['ItemType']=$this->db->get('tbl_category_type')->result();
			$my_category_id = $data['itemDetails']->category_id;
			$my_type = $this->db->where('category_id',$my_category_id)->get('tbl_category')->row()->type_id;
			$data['Categories']=$this->db->where("type_id = '$my_type' and (added_by='$rest_id' or added_by=0)")->get('tbl_category')->result();
			$data['section_lang']=$lang;

			$data['subCategories']=$this->MODEL->getCategorySubDetails($data['itemDetails']->category_id);
			$data['foodExtras']=$this->MODEL->getFoodExtraDetails($data['itemDetails']->category_id);
			
			$data['Extras']=explode('|',$data['itemDetails']->item_food_extra);
			if ($rest_id > 0){
				$data['allergens']=$this->db->where("added_by='$rest_id' or added_by=0")->get('tbl_allergens')->result();
			}else{
				$data['allergens']=[];
			}
			$data['subCat']=explode(',',$data['itemDetails']->sub_cat_ids);
			$data['allergen_arr']=explode(',',$data['itemDetails']->item_allergens);
			$data['Prices']=explode(',',$data['itemDetails']->item_prices);
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/edit_menu');
			$this->load->view('admin/layout/footer');
		}
		public function editMenu_($item_id){
			$data['Categories']=$this->db->get('tbl_category')->result();
			$data['itemDetails']=$this->db->where('menu_id',$item_id)->get('tbl_menu_card')->row();
            $data['subCategories']=$this->MODEL->getCategorySubDetails($data['itemDetails']->category_id);
			$data['subCat']=explode(',',$data['itemDetails']->sub_cat_ids);
			$data['subCatPrice']=explode(',',$data['itemDetails']->item_prices);
			$data['section_lang']=$this->session->userdata("site_lang_admin");
			$this->load->view('admin/layout/header',$data);
			$this->load->view('admin/pages/edit_menu');
			$this->load->view('admin/layout/footer');
		}

		// --------------------------------------------------------Admin CRUD------------------------------------------------------------------
		public function adminVideoTutorials(){
			$video_description_french = $this->input->post("video_description_french");
			$video_description_english = $this->input->post("video_description_english");
			$video_description_germany = $this->input->post("video_description_germany");
			if ($video_description_french == ""){
				$video_description = $video_description_french;
			}elseif ($video_description_germany == ""){
				$video_description = $video_description_germany;
			}else{
				$video_description = $video_description_english;
			}

			if (null !== $this->input->post("is_upload_new_video") && $this->input->post("is_upload_new_video") !== "on"){
				$upload_res = true;
				$update_data = array(
					"video_description"				=>		$video_description,
					"video_description_english"		=>		$video_description_english,
					"video_description_french"		=>		$video_description_french,
					"video_description_germany"		=>		$video_description_germany,
				);
			}else{
				if (file_exists($_FILES['video']['tmp_name']) || is_uploaded_file($_FILES['video']['tmp_name'])){
					$video=pathinfo($_FILES['video']['name']);
					$update_video = true;
					$vi_name = $_FILES['video']['tmp_name'];
					$new_vi_name = 'video-tutorial'."-".date('dmyhis').'.'.$video['extension'];
	
					$destination_path='assets/video_tutorials/'."$new_vi_name";
					$upload_res = move_uploaded_file($vi_name, $destination_path);
	
				}else{
					$destination_path = "";
				}
				
				$update_data = array(
					"video_description"				=>		$video_description,
					"video_description_english"		=>		$video_description_english,
					"video_description_french"		=>		$video_description_french,
					"video_description_germany"		=>		$video_description_germany,
					"video_url"						=>		$new_vi_name,
				);
			}
			if ($upload_res){
				if (null == $this->input->post("video_id")){
					$res = $this->db->insert("tbl_video_tutorials" ,$update_data);
				}else{
					$video_id = $this->input->post("video_id");
					if ($video_t =  $this->db->where("video_id",$video_id)->get("tbl_video_tutorials")->row()){
						if ($old_video_url = $video_t->video_url){
							if (file_exists(APPPATH."../assets/video_tutorials/".$old_video_url)){
								unlink(APPPATH."../assets/video_tutorials/".$old_video_url);
							}
						}
					}
					$res = $this->db->where("video_id",$video_id)->update("tbl_video_tutorials" ,$update_data);
				}
				die(json_encode(array("status"=>$res)));
			}else{
				die(json_encode(array("status"=>0)));
			}
		}
		public function adminFreeSupport(){
			$admin_contact_email = $this->input->post("admin_contact_email");
			$admin_fax = $this->input->post("admin_fax");
			$admin_phone = $this->input->post("admin_phone");
			$admin_other_info_english = $this->input->post("admin_other_info_english");
			$admin_other_info_french = $this->input->post("admin_other_info_french");
			$admin_other_info_germany = $this->input->post("admin_other_info_germany");
			$admin_whatsapp = $this->input->post("admin_whatsapp");
			$admin_is_whatsapp = $this->input->post("is_show_admin_whatsapp") == "on" ? 1 : 0;
			$admin_is_contact_email = $this->input->post("is_show_admin_contact_email") == "on" ? 1 : 0;
			$admin_is_fax = $this->input->post("is_show_admin_fax") == "on" ? 1 : 0;
			$admin_is_phone = $this->input->post("is_show_admin_phone") == "on" ? 1 : 0;
			$admin_is_other_info = $this->input->post("is_show_admin_other_info") == "on" ? 1 : 0;

			$update_data = array(
				"admin_contact_email"	=>		$admin_contact_email,
				"admin_phone"			=>		$admin_phone,
				"admin_other_info_english"		=>		$admin_other_info_english,
				"admin_other_info_french"		=>		$admin_other_info_french,
				"admin_other_info_germany"		=>		$admin_other_info_germany,
				"admin_fax"				=>		$admin_fax,
				"admin_whatsapp"		=>		$admin_whatsapp,
				"admin_is_fax"			=>		$admin_is_fax,
				"admin_is_phone"		=>		$admin_is_phone,
				"admin_is_other_info"	=>		$admin_is_other_info,
				"admin_is_contact_email"=>		$admin_is_contact_email,
				"admin_is_whatsapp"		=>		$admin_is_whatsapp,
			);
			$res = $this->db->update("tbl_admin" ,$update_data);
			die(json_encode(array("status"=>$res)));
		}
		public function updateFileUploadingSetting(){
			$food_menu_banner = array(
				"max_width"	=> $this->input->post("food_menu_banner_max_width"),
				"max_height"	=> $this->input->post("food_menu_banner_max_height"),
				"compression"	=> $this->input->post("food_menu_banner_compression"),
			);
			$slider = array(
				"max_width"	=> $this->input->post("slider_max_width"),
				"max_height"	=> $this->input->post("slider_max_height"),
				"compression"	=> $this->input->post("slider_compression"),
			);
			$category = array(
				"max_width"	=> $this->input->post("category_max_width"),
				"max_height"	=> $this->input->post("category_max_height"),
				"compression"	=> $this->input->post("category_compression"),
			);
			$menu_item = array(
				"max_width"	=> $this->input->post("menu_item_max_width"),
				"max_height"	=> $this->input->post("menu_item_max_height"),
				"compression"	=> $this->input->post("menu_item_compression"),
			);
			$homepage_service = array(
				"max_width"	=> $this->input->post("homepage_service_max_width"),
				"max_height"	=> $this->input->post("homepage_service_max_height"),
				"compression"	=> $this->input->post("homepage_service_compression"),
			);
			$fileUploadingSetting = array(
				"food_menu_banner"	=>	$food_menu_banner,
				"slider"	=>	$slider,
				"category"	=>	$category,
				"menu_item"	=>	$menu_item,
				"homepage_service"	=>	$homepage_service,
				"homepage_service"	=>	$homepage_service,
			);
			$fileUploadingSetting_old = $this->db->where("option_key","fileUploadingSetting")->get("tbl_admin_option")->row();
			if (!isset($fileUploadingSetting_old)){
				$res1 = $this->db->insert('tbl_admin_option' , array("option_key"=>"fileUploadingSetting", "option_value"=>json_encode($fileUploadingSetting)));
			}else{
				$res1 = $this->db->where("option_key","fileUploadingSetting")->update("tbl_admin_option",array("option_key"=>"fileUploadingSetting", "option_value"=>json_encode($fileUploadingSetting)));
			}
			die(json_encode(array("status"=> $res1)));
		}
		public function updateKitchen(){
			$kitchen_name = "";
			$kitchen_id = $this->input->post("kitchen_id");
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

			$update_data=array(
			    "kitchen_name_english"	=>	$kitchen_name_english,
			    "kitchen_name_french"	=>	$kitchen_name_french,
				"kitchen_name_germany"	=>	$kitchen_name_germany,
				"kitchen_name"			=>	$kitchen_name,
			    "kitchen_description_english"	=>	$kitchen_description_english,
			    "kitchen_description_french"	=>	$kitchen_description_french,
				"kitchen_description_germany"	=>	$kitchen_description_germany,
				"kitchen_description"			=>	$kitchen_description,
			);
			$res = $this->db->where("kitchen_id",$kitchen_id)->update("tbl_kitchens" ,$update_data);
			die(json_encode(array("status"=>$res)));
		}
		public function updateMobilePageSetting(){
			$mobile_about_content_french = $this->input->post('mobile_about_content_french');
			$mobile_about_content_english = $this->input->post('mobile_about_content_english');
			$mobile_about_content_germany = $this->input->post('mobile_about_content_germany');

			$mobile_about_content = "";
			if (trim($mobile_about_content_french) !== ""){
				$mobile_about_content = trim($mobile_about_content_french);
			}elseif (trim($mobile_about_content_germany) !== ""){
				$mobile_about_content = trim($mobile_about_content_germany);
			}else{
				$mobile_about_content = trim($mobile_about_content_english);
			}

			$mobile_terms_content_french = $this->input->post('mobile_terms_content_french');
			$mobile_terms_content_english = $this->input->post('mobile_terms_content_english');
			$mobile_terms_content_germany = $this->input->post('mobile_terms_content_germany');

			$mobile_terms_content = "";
			if (trim($mobile_terms_content_french) !== ""){
				$mobile_terms_content = trim($mobile_terms_content_french);
			}elseif (trim($mobile_terms_content_germany) !== ""){
				$mobile_terms_content = trim($mobile_terms_content_germany);
			}else{
				$mobile_terms_content = trim($mobile_terms_content_english);
			}


			$data = array(
				'mobile_about_page_content' 					=> $mobile_about_content,
				'mobile_about_page_content_english' 			=> $mobile_about_content_english,
				'mobile_about_page_content_french' 				=> $mobile_about_content_french,
				'mobile_about_page_content_germany' 			=> $mobile_about_content_germany,
			);	

			$data1 = array(
				'mobile_terms_page_content' 					=> $mobile_terms_content,
				'mobile_terms_page_content_english' 			=> $mobile_terms_content_english,
				'mobile_terms_page_content_french' 				=> $mobile_terms_content_french,
				'mobile_terms_page_content_germany' 			=> $mobile_terms_content_germany,
			);	
			
			$about_page = $this->db->where("option_key","mobile_about_page")->get("tbl_admin_option")->row();
			if (!isset($about_page)){
				$res = $this->db->insert('tbl_admin_option' , array("option_key"=>"mobile_about_page", "option_value"=>json_encode($data)));
			}else{
				$res = $this->db->where("option_key","mobile_about_page")->update("tbl_admin_option",array("option_key"=>"mobile_about_page", "option_value"=>json_encode($data)));
			}

			$terms_page = $this->db->where("option_key","mobile_terms_page")->get("tbl_admin_option")->row();
			if (!isset($terms_page)){
				$res1 = $this->db->insert('tbl_admin_option' , array("option_key"=>"mobile_terms_page", "option_value"=>json_encode($data1)));
			}else{
				$res1 = $this->db->where("option_key","mobile_terms_page")->update("tbl_admin_option",array("option_key"=>"mobile_terms_page", "option_value"=>json_encode($data1)));
			}
			die(json_encode(array("status"=>$res && $res1)));
		}
		public function createAddon(){
			$addon_title_french = $this->input->post('addon_title_french');
			$addon_title_english = $this->input->post('addon_title_english');
			$addon_title_germany = $this->input->post('addon_title_germany');

			$addon_title = "";
			if (trim($addon_title_french) !== ""){
				$addon_title = trim($addon_title_french);
			}elseif (trim($addon_title_germany) !== ""){
				$addon_title = trim($addon_title_germany);
			}else{
				$addon_title = trim($addon_title_english);
			}
			$addon_title = json_encode(array(
				"value" 		=> $addon_title,
				"value_english" => $addon_title_english,
				"value_french" 	=> $addon_title_french,
				"value_germany" => $addon_title_germany,
			));

			$addon_content_html_french = $this->input->post('addon_content_html_french');
			$addon_content_html_english = $this->input->post('addon_content_html_english');
			$addon_content_html_germany = $this->input->post('addon_content_html_germany');


			$addon_content_html = "";
			if (trim($addon_content_html_french) !== ""){
				$addon_content_html = trim($addon_content_html_french);
			}elseif (trim($addon_content_html_germany) !== ""){
				$addon_content_html = trim($addon_content_html_germany);
			}else{
				$addon_content_html = trim($addon_content_html_english);
			}
			$addon_content_html = json_encode(array(
				"value" 		=> $addon_content_html,
				"value_english" => $addon_content_html_english,
				"value_french" 	=> $addon_content_html_french,
				"value_germany" => $addon_content_html_germany,
			));

			$addon_status = $this->input->post('addon_status') == "on" ? "active" : "inactive";
			$addon_price_currency_id = $this->input->post('addon_price_currency_id');
			$addon_price = $this->input->post('addon_price');
			$addon_lifecycle = $this->input->post('addon_lifecycle');
			$addon_trial_period = $this->input->post('addon_trial_period');
			if (null !== $this->input->post('addon_features')){
				$addon_features = $this->input->post('addon_features');
			}else{
				$addon_features = [];
			}
			$data = array(
				'addon_content_html' 			=> $addon_content_html,
				'addon_title' 					=> $addon_title,
				'addon_price' 					=> $addon_price,
				'addon_lifecycle' 				=> $addon_lifecycle,
				'addon_trial_period' 			=> $addon_trial_period,
				'addon_status' 					=> $addon_status,
				'addon_price_currency_id' 		=> $addon_price_currency_id,
				'addon_features' 				=> implode("," ,$addon_features),
			);	
			
			
			$res = $this->db->insert('tbl_addons',$data);
			die(json_encode(array("status"=>$res)));
		}
		public function updateAddon(){
			$addon_id = $this->input->post('addon_id');
			$addon_title_french = $this->input->post('addon_title_french');
			$addon_title_english = $this->input->post('addon_title_english');
			$addon_title_germany = $this->input->post('addon_title_germany');

			$addon_title = "";
			if (trim($addon_title_french) !== ""){
				$addon_title = trim($addon_title_french);
			}elseif (trim($addon_title_germany) !== ""){
				$addon_title = trim($addon_title_germany);
			}else{
				$addon_title = trim($addon_title_english);
			}
			$addon_title = json_encode(array(
				"value" 		=> $addon_title,
				"value_english" => $addon_title_english,
				"value_french" 	=> $addon_title_french,
				"value_germany" => $addon_title_germany,
			));

			$addon_content_html_french = $this->input->post('addon_content_html_french');
			$addon_content_html_english = $this->input->post('addon_content_html_english');
			$addon_content_html_germany = $this->input->post('addon_content_html_germany');


			$addon_content_html = "";
			if (trim($addon_content_html_french) !== ""){
				$addon_content_html = trim($addon_content_html_french);
			}elseif (trim($addon_content_html_germany) !== ""){
				$addon_content_html = trim($addon_content_html_germany);
			}else{
				$addon_content_html = trim($addon_content_html_english);
			}
			$addon_content_html = json_encode(array(
				"value" 		=> $addon_content_html,
				"value_english" => $addon_content_html_english,
				"value_french" 	=> $addon_content_html_french,
				"value_germany" => $addon_content_html_germany,
			));

			$addon_status = $this->input->post('addon_status') == "on" ? "active" : "inactive";
			$addon_price_currency_id = $this->input->post('addon_price_currency_id');
			$addon_price = $this->input->post('addon_price');
			$addon_lifecycle = $this->input->post('addon_lifecycle');
			$addon_trial_period = $this->input->post('addon_trial_period');
			if (null !== $this->input->post('addon_features')){
				$addon_features = $this->input->post('addon_features');
			}else{
				$addon_features = [];
			}
			$data = array(
				'addon_content_html' 			=> $addon_content_html,
				'addon_title' 					=> $addon_title,
				'addon_price' 					=> $addon_price,
				'addon_lifecycle' 				=> $addon_lifecycle,
				'addon_trial_period' 			=> $addon_trial_period,
				'addon_status' 					=> $addon_status,
				'addon_price_currency_id' 		=> $addon_price_currency_id,
				'addon_features' 				=> implode("," ,$addon_features),
			);	
			
			
			$res = $this->db->where("addon_id",$addon_id)->update('tbl_addons',$data);
			die(json_encode(array("status"=>$res)));
		}
		public function removeAddon(){
			$addon_id = $this->input->post("addon_id");
			die(json_encode(array("status"=>$this->MODEL->remove_row("tbl_addons","addon_id = $addon_id"))));
		}
		public function changeAddonStatus(){
			$addon_id = $this->input->post("addon_id");
			$addon_status = $this->input->post("addon_status");
			die(json_encode(array("status"=>$this->db->where("addon_id", $addon_id)->update("tbl_addons",array("addon_status" => $addon_status)))));
		}
		public function changeRestAddonStatus(){
			$addon_id = $this->input->post("addon_id");
			$status = $this->input->post("status");
			$rest_id = $this->input->post("rest_id");
			$addon_ids = $this->input->post("active_arr");
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
			$_res = $this->db->where("restaurant_id", $rest_id)->update("tbl_restaurant_details",array("addon_ids" => $addon_ids));
			if ($status == 'active'){
				$rest = $this->db->where('tbl_restaurant.rest_id',$rest_id)->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->get('tbl_restaurant')->row();
				$addon = $this->db->where("addon_id", $addon_id)->get('tbl_addons')->row();
				$currency_code = "EUR";
				$currency_symbol = "€";
				if ($currency_country = $this->db->where("id", $addon->addon_price_currency_id)->get("tbl_countries")->row()){
					if ($currency_country->currency_code !== ""){
						$currency_code = $currency_country->currency_code;
						$currency_symbol = html_entity_decode($currency_country->currency_symbol);					
					}
				}
				$this->sendActiveStatustMail($rest,$addon,$currency_symbol);
			}
			die(json_encode(array("status"=>$res && $_res)));
		}
		public function sendActiveStatustMail($rest,$addon,$currency){
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
											<h3>Your request for Addon - ('.json_decode($addon->addon_title)->value.') is now activated.</h3>
											<table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" 
														style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;"
														>
													
													<tr style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
															<td class="content-wrap"
																	style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 30px;border: 3px solid #71B6F9;border-radius: 7px; background-color: #fff;"
																	valign="top">
																	<meta itemprop="name" content="Confirm Email" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"/>
																	<div>
																		<table style="margin: auto;">
																			<tr>
																				<td>
																					<div style="padding-right: 10px; border-right: 3px solid #d3d3d3 !important;">
																						<h3>'.json_decode($addon->addon_title)->value.'</h3>
																						<div class="d-flex align-items-center justify-content-start flex-wrap">
																							<span>'.$addon->addon_price.'</span>
																							<span>'.$currency.'</span>
																							<span>/ '.$addon->addon_lifecycle.'</span>
																						</div>
																						<em>first <span>'.$addon->addon_trial_period.'</span> days for free</em>
																					</div>
																				</td>
																				<td style="float:right">
																					'.json_decode($addon->addon_content_html)->value.'                                                         
																				</td>
																			</tr>
																		</table>
																		<p>Just click <a href="'.base_url("Restaurant/Addon").'">here</a> to log in to the restaurant dashboard and check it.</p>
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
			$this->email->to($rest->rest_email);
			$this->email->subject("Addon request is activated");
			$this->email->message($message);
		    $this->email->send();
		}
	}
?>