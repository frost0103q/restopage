<?php
	/**
	 * 
	 */
	class AdminModel extends CI_Model
	{
		
		public function getAllActiveRest(){
			return $this->db->where("tbl_restaurant_details.activation_status='Accepted'")->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->order_by('tbl_restaurant.rest_id','desc')->get('tbl_restaurant')->result();
		}
		public function getAllPendingRest(){
			return $this->db->where("tbl_restaurant_details.activation_status='Pending'")->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->order_by('tbl_restaurant.rest_id','desc')->get('tbl_restaurant')->result();
		}
		public function getAllRejectedRest(){
			return $this->db->where("tbl_restaurant_details.activation_status='Rejected'")->join('tbl_restaurant_details','tbl_restaurant_details.restaurant_id=tbl_restaurant.rest_id')->order_by('tbl_restaurant.rest_id','desc')->get('tbl_restaurant')->result();
		}
		public function getTypeId($item_id){
			return $this->db->where("tbl_menu_card.menu_id = $item_id AND category_status = 'active' AND tbl_menu_card.item_status = 'Available'")->join('tbl_category','tbl_category ON tbl_menu_card.category_id = tbl_category.category_id ')->join('tbl_category_type','tbl_category.type_id = tbl_category_type.type_id')->get('tbl_menu_card')->row();
		}
		public function get_foodExtraList($item_id,$price_index){
			$rest_detail = $this->db->where("menu_id = $item_id AND item_status = 'Available'")->get('tbl_menu_card')->row();
			if ($rest_detail){
				$rest_food_extra = $rest_detail->item_food_extra;
				$food_extra_list = array();
				if ($rest_food_extra !== null && $rest_food_extra !== ""){
					$food_extra = explode("|",$rest_food_extra);
					if ($food_extra[$price_index] !== null && $food_extra[$price_index] !== "" ){
						$fcatlist = explode(";",$food_extra[$price_index]);
						foreach ($fcatlist as $fcatkey => $fcatvalue) {
							$fcat_id = explode("->",$fcatvalue)[0];
							$food_extra_list["extra_cat"][ $fcatkey ] = $this->db->where("extra_category_id = $fcat_id AND extra_category_status = 'active'")->get('tbl_food_extra_category')->row();

							if (explode("->",$fcatvalue)[1] !== null && explode("->",$fcatvalue)[1] !== ""){
								$fcat_child = explode("->",$fcatvalue)[1];
								$flist = explode(",",$fcat_child);
								foreach ($flist as $fkey => $fvalue) {
									if ($fvalue !== ""){
										$extra_id = explode(":",$fvalue)[0];
										$extra_price = explode(":",$fvalue)[1];
										$food_extra_list["extra"][ $fcatkey ][] = $this->db->where("tbl_food_extra.extra_id = $extra_id AND tbl_food_extra_category.extra_category_status = 'active'")->join('tbl_food_extra_category','tbl_food_extra ON tbl_food_extra.category_id = tbl_food_extra_category.extra_category_id')->get('tbl_food_extra')->row();
										$food_extra_list["price"][ $fcatkey ][] = $extra_price;
									}else{
										$food_extra_list["extra"][ $fcatkey ][] = "";
										$food_extra_list["price"][ $fcatkey ][] = "";
									}
								}
							}
						}
					}
					return $food_extra_list;
				}
			}
			return true;
		}
		public function activateThisRest($rest_id){
			if($this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',array('activation_status'=>1))){
				return true;
			}else{
				return false;
			}
		}
		public function deactivateThisRest($rest_id){
			if($this->db->where('restaurant_id',$rest_id)->update('tbl_restaurant_details',array('activation_status'=>2))){
				return true;
			}else{
				return false;
			}
		}
		public function changeStatusReservation($reservation_id,$status){
			if($this->db->where('id',$reservation_id)->update('tbl_reservations',array('status'=>$status))){
				return 1;
			}else{
				return 0;
			}
		}
		public function getOrdersAndReservations($rest_id,$status="",$offset = 0 , $limit = 10){
			$condition1 = "";
			$condition2 = "";
			if ($status==""){

			}else if (strtolower($status) == "canceled"){
				$condition1 = ' AND o.order_status="canceled"';
				$condition2 = ' AND r.status="rejected"';
			}else{
				
				$condition1 = ' AND o.order_status="'.strtolower($status).'"';
				$condition2 = ' AND r.status="'.strtolower($status).'"';
			}
			$result = $this->db->query('
			(SELECT o.order_id AS id , o.order_rest_id AS rest_id,
				o.order_type AS TYPE , 
				order_status AS STATUS  , 
				o.order_date AS DATE, 
				o.order_mobile_notify as mobile_notify,
				IF (o.order_payment_method = "stripe", 
					"creditcard" , 
					IF (o.order_payment_method = "creditcard_on_the_door", 
						IF ( o.order_type = "delivery" ,
							"creditcard on the door",
							"creditcard at pickup") ,
						o.order_payment_method)) AS subtitle , 
				IF (o.order_status = "pending" ,
					IF (o.order_specification = "pre" ,
						IF (DATE(order_date) = CURRENT_DATE , 
							TIME_TO_SEC(TIMEDIFF(CONCAT(order_reservation_time,":00"),CURRENT_TIME)) 
							,0),
						TIME_TO_SEC(TIMEDIFF(DATE_ADD(order_date, INTERVAL 20 MINUTE),NOW()))), 
					0 ) AS remaining_time,
				IF (o.order_status = "accepted" ,
					IF ( o.order_type = "pickup" ,
						IF (o.order_specification = "pre" ,
							IF (DATE(order_date) = CURRENT_DATE , 
								TIME_TO_SEC(TIMEDIFF(CONCAT(order_reservation_time,":00"),CURRENT_TIME)) 
								,0),
							TIME_TO_SEC(TIMEDIFF(DATE_ADD(order_date, INTERVAL 20 MINUTE),NOW()))), 
						IF (o.order_specification = "pre" ,
							IF (DATE(order_date) = CURRENT_DATE , 
								TIME_TO_SEC(TIMEDIFF(CONCAT(order_reservation_time,":00"),CURRENT_TIME)) 
								,0),
							TIME_TO_SEC(TIMEDIFF(DATE_ADD(order_date, INTERVAL o.order_duration_time MINUTE),NOW())))),
					0 ) AS remaining_time_after_accept,
				o.order_specification AS specification,
				IF (o.order_type = "pickup" , c.customer_name, CONCAT(c.customer_address," ", c.customer_city)) AS title
			FROM `tbl_orders` o LEFT JOIN `tbl_customers` c ON c.customer_id = o.order_customer_id  LEFT JOIN tbl_stripe_order_temp s ON s.order_id = o.order_id LEFT JOIN `tbl_reservations` r ON r.rest_id = o.order_rest_id
			WHERE  ((o.order_specification = "virtual") OR (o.order_payout_status = "paid" OR (o.order_payout_status = "unpaid" AND o.order_payment_method = "stripe" AND s.temp_id > 0) OR o.order_payment_method = "cash" OR o.order_payment_method = "creditcard_on_the_door"))
			AND r.rest_id = '.$rest_id.$condition1.')
			UNION 
			(SELECT r.id AS id, r.rest_id AS rest_id,
				"reservation" AS TYPE , 
				r.status AS STATUS , 
				r.created_at AS DATE , 
				r.reservation_mobile_notify as mobile_notify,
				CONCAT(r.date ," ", r.time ) AS subtitle , 
				"" AS remaining_time ,
				"" AS remaining_time_after_accept,
				r.reservation_specification AS specification,
				r.number_of_people AS title
			FROM `tbl_orders` o RIGHT JOIN `tbl_reservations` r ON r.rest_id = o.order_rest_id
			WHERE r.rest_id = '.$rest_id.$condition2.')
			ORDER BY DATE DESC
			LIMIT '.$offset.','.$limit.'
			')->result();
			$_result = array();
			foreach ($result as $key => $value) {
				if ($value->specification == 'pre' && $value->STATUS == 'pending' && $value->mobile_notify == 0){
				}else{
					$_result[] = $value;
				}
			}
			return $result;
		}
		//Common function to addSomeThing
		public function addNew($data,$table_name){
			$check=$this->db->where($data)->get($table_name)->result();
			 if(count($check)==0){
			 	// echo 'Can be added';
			 	if($this->db->insert($table_name,$data)){
			 		return 1;
			 	}else{
			 		return 0;
			 	}
			}else{
			 	// echo 'Already Added';
			 	return 2;
			}
		}
		public function addNewTable($data,$table_name){
			$check=$this->db->where($data)->get($table_name)->result();
			if(count($check)==0){
			 	// echo 'Can be added';
			 	if($this->db->insert($table_name,$data)){
					$insert_id = $this->db->insert_id();
			 		return $insert_id;
			 	}else{
			 		return 0;
			 	}
			}else{
				if ($table_name == "tbl_customers"){
					return $check[0]->customer_id;
				}else{
					return -1;
				}
			}
		}
		public function register_order($data){
			$check=$this->db->where($data)->get("tbl_orders")->result();
			if(count($check) == 0){
				// echo 'Can be added';
				$this->db->set('order_date', 'NOW()', FALSE);
				if($this->db->insert("tbl_orders",$data)){
					$insert_id = $this->db->insert_id();
					return $insert_id;
				}else{
					return 0;
				}
			}else{
				return -1;
			}
		}
		public function addNewReservation($data){
			$this->db->set('created_at', 'NOW()', FALSE);
			if($this->db->insert("tbl_reservations",$data)){
				$insert_id = $this->db->insert_id();
				return $insert_id;
			}else{
				return 0;
			}
		}

		public function addNewRestaurant($data){
			 // `tbl_restaurant`(`rest_id`, `rest_name`, `rest_email`, `rest_pass`) 
			 			 
			 $rest_url_slug = $this->slugify(-1,$data['rest_name']);

			 $data_tbl_rest=array(
				"rest_name"=>$data['rest_name'],
				"rest_email"=>$data['rest_email'],
				"rest_pass"=>md5(trim($data['rest_pass'])),
				"rest_url_slug"=>$rest_url_slug
				);
			 // 
			 // print_r($data_tbl_rest);
			 $check=$this->db->where($data_tbl_rest)->get('tbl_restaurant')->result();
			 if(count($check)==0){
			 	// echo 'Can be added';
			 	if($this->db->insert('tbl_restaurant',$data_tbl_rest)){
			 		// return 1;
			 		$data_rest_detal=array(
			 							"restaurant_id"=>$this->db->insert_id(),
			 							"activation_status"=>1
			 						);
			 		// print_r($data_rest_detal);
			 		if($this->db->insert('tbl_restaurant_details',$data_rest_detal)){
			 			 return 1;
			 		}else{
			 			return 0;
			 		}
			 		// die;
			 		// tbl_restaurant_details

			 	}else{
			 		return 0;
			 	}
			 }else{
			 	// echo 'Already Added';
			 	return 2;
			 }
			//Then in tbl_rest_details
		}
		public function getAll($table_name){
			return $this->db->get($table_name)->result();
		}
		public function remove_Category($cat_id){
			$img_url = $this->db->where('category_id',$cat_id)->get("tbl_category")->row()->category_image;
			if (file_exists(APPPATH."../assets/category_images/".$img_url)){
				unlink(APPPATH."../assets/category_images/".$img_url);
			}
			$res=$this->db->where('category_id',$cat_id)->delete('tbl_category');
			if($res){
				if($this->db->where('category_id',$cat_id)->delete('tbl_menu_card')){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		public function remove_ExtraCategory($cat_id){
			$res=$this->db->where('extra_category_id',$cat_id)->delete('tbl_food_extra_category');
			if($res){
				if($this->db->where('category_id',$cat_id)->delete('tbl_food_extra')){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		public function activate_Category($cat_id){
			if($this->db->where('category_id',$cat_id)->update('tbl_category',array('category_status'=>"active"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function activate_ExtraCategory($cat_id){
			if($this->db->where('extra_category_id',$cat_id)->update('tbl_food_extra_category',array('extra_category_status'=>"active"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function deactivate_Category($cat_id){
			if($this->db->where('category_id',$cat_id)->update('tbl_category',array('category_status'=>"deactive"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function deactivate_ExtraCategory($cat_id){
			if($this->db->where('extra_category_id',$cat_id)->update('tbl_food_extra_category',array('extra_category_status'=>"deactive"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function activate_Area($area_id){
			if($this->db->where('id',$area_id)->update('tbl_delivery_areas',array('status'=>"active"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function deactivate_Area($area_id){
			if($this->db->where('id',$area_id)->update('tbl_delivery_areas',array('status'=>"deactive"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function activate_MenuItem($menuId){
			if($this->db->where('menu_id',$menuId)->update('tbl_menu_card',array('item_status'=>"Available"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function deactivate_MenuItem($menuId){
			if($this->db->where('menu_id',$menuId)->update('tbl_menu_card',array('item_status'=>"Not Available"))){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_row($table_name,$row_condition){
			$res=$this->db->where($row_condition)->delete($table_name);
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_Allergen($allergen_id){
			$res=$this->db->where('allergen_id',$allergen_id)->delete('tbl_allergens');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_Kitchen($kitchen_id){
			$res=$this->db->where('kitchen_id',$kitchen_id)->delete('tbl_kitchens');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_Announcement($announcement_id){
			$res=$this->db->where('id',$announcement_id)->delete('tbl_announcement');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_Video_Tutorial($video_id){
			if ($video_t =  $this->db->where("video_id",$video_id)->get("tbl_video_tutorials")->row()){
				if ($old_video_url = $video_t->video_url){
					if (file_exists(APPPATH."../assets/video_tutorials/".$old_video_url)){
						unlink(APPPATH."../assets/video_tutorials/".$old_video_url);
					}
				}
			}
			$res=$this->db->where('video_id',$video_id)->delete('tbl_video_tutorials');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_Area($area_id){
			$res=$this->db->where('id',$area_id)->delete('tbl_delivery_areas');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_Order($order_id){
			$res=$this->db->where('order_id',$order_id)->delete('tbl_orders');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function getCategoryDetails($cate_id){
			return $this->db->where('category_id',$cate_id)->where('category_status','active')->get('tbl_category')->result();
		}
		// modify by Jfrost in 3rd stage
		public function getExtraCategoryDetails($cate_id){
			return $this->db->where('extra_category_id',$cate_id)->get('tbl_food_extra_category')->result();
			// return $this->db->where('extra_category_id',$cate_id)->where('extra_category_status','active')->get('tbl_food_extra_category')->result();
		}
		public function getAllergenDetails($allergen_id){
			return $this->db->where('allergen_id',$allergen_id)->get('tbl_allergens')->result();
		}
		public function getKitchenDetails($kitchen_id){
			return $this->db->where('kitchen_id',$kitchen_id)->get('tbl_kitchens')->row();
		}
		public function getOpeningTime($rest_id){
			return $this->db->where('rest_id',$rest_id)->get('tbl_opening_times')->row();
		}
		public function getCategorySubDetails($cate_id){
			return $this->db->join('tbl_sub_category','tbl_sub_category.category_id=tbl_category.category_id')->where('category_status','active')->where('tbl_category.category_id',$cate_id)->get('tbl_category')->result();
		}
		// modify by Jfrost in 3rd stage
		public function getFoodExtraDetails($cate_id){
			return $this->db->join('tbl_food_extra','tbl_food_extra.category_id=tbl_food_extra_category.extra_category_id')->where('tbl_food_extra_category.extra_category_id',$cate_id)->get('tbl_food_extra_category')->result();
			// return $this->db->join('tbl_food_extra','tbl_food_extra.category_id=tbl_food_extra_category.extra_category_id')->where('extra_category_status','active')->where('tbl_food_extra_category.extra_category_id',$cate_id)->get('tbl_food_extra_category')->result();
		}
		public function update_Category($condition,$toUpdate){
			if($this->db->where($condition)->update('tbl_category',$toUpdate)){
				return 1;
			}else{
				return 0;
			}
		}
		public function update_ExtraCategory($condition,$toUpdate){
			if($this->db->where($condition)->update('tbl_food_extra_category',$toUpdate)){
				return 1;
			}else{
				return 0;
			}
		}
		public function update_Allergen($condition,$toUpdate){
			if($this->db->where($condition)->update('tbl_allergens',$toUpdate)){
				return 1;
			}else{
				return 0;
			}
		}
		public function update_AreaDetail($condition,$toUpdate){
			if($this->db->where($condition)->update('tbl_delivery_areas',$toUpdate)){
				return 1;
			}else{
				return 0;
			}
		}
		public function saveOpeningTimeSetting($data,$rest_id){
			if($this->db->where("rest_id",$rest_id)->get("tbl_opening_times")->row()){
				if($this->db->where("rest_id",$rest_id)->update('tbl_opening_times',$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert('tbl_opening_times',$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}
		public function updatePageSlider($data,$rest_id){
			foreach ($data as $key => $slider) {
				$slider_index = $slider['slider_index'];
				$image_name = $slider['image_name'];
				$rest_id = $slider['rest_id'];
				$update_image = $slider['update_image'];
				$row = array(
					"rest_id"				=> $this->input->post('rest_id'),
					"image_name"			=> $image_name,
					"slider_index"  		=> $slider_index,
				);

				$slider_caption_title = $slider['slider_caption_title'];
				$slider_caption_content = $slider['slider_caption_content'];
				$row_slider_label = array(
					"slider_caption_title"  		=> $slider_caption_title,
					"slider_caption_title_english"  => $slider['slider_caption_title_english'],
					"slider_caption_title_french"  	=> $slider['slider_caption_title_french'],
					"slider_caption_title_germany"  => $slider['slider_caption_title_germany'],
					"slider_caption_content"  		=> $slider_caption_content,
					"slider_caption_content_english"  	=> $slider['slider_caption_content_english'],
					"slider_caption_content_french"  	=> $slider['slider_caption_content_french'],
					"slider_caption_content_germany"  	=> $slider['slider_caption_content_germany'],
				);
				if($old_row = $this->db->where("rest_id = $rest_id AND slider_index = $slider_index")->get("tbl_sliders")->row()){
					if($this->db->where("rest_id = $rest_id AND slider_index = $slider_index")->update('tbl_sliders',$row_slider_label)){
						if ($update_image){
							$old_image = $old_row->image_name;
							if (file_exists(APPPATH."../assets/home_slider_images/".$old_image)){
								unlink(APPPATH."../assets/home_slider_images/".$old_image);
							}
							if($this->db->where("rest_id = $rest_id AND slider_index = $slider_index")->update('tbl_sliders',$row)){
							}else{
								return 0;
							}
						}
					}else{
						return 0;
					}
					
				}else{
					if($this->db->insert('tbl_sliders',$row)){
					}else{
						return 0;
					}
				}
			}
			return 1;
		}
		public function updatePageContent($data,$rest_id){
			if($old_row = $this->db->where("rest_id",$rest_id)->get("tbl_page_contents")->row()){
				if (isset($old_row->content_image) && isset($data["content_image"])){
					$old_image = $old_row->content_image;
					if (file_exists (base_url("assets/home_images/".$old_image)))
					unlink (base_url("assets/home_images/".$old_image));
				}
				if($this->db->where("rest_id",$rest_id)->update('tbl_page_contents',$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert('tbl_page_contents',$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}
		public function updateHomeTextSectionContent($data,$sId){
			$table = "tbl_restaurant_homepage_text_sections";
			if($old_row = $this->db->where("sId",$sId)->get($table)->row()){
				if ($data['sType'] == 3){
	
				}else{
					if (isset($old_row->sImage) && isset($data["sImage"])){
						$old_image = $old_row->sImage;
						if (file_exists (base_url("assets/home_images/".$old_image)))
						unlink (base_url("assets/home_images/".$old_image));
					}
					if($this->db->where("rest_id",$rest_id)->update($table,$data)){
						return 1;
					}else{
						return 0;
					}
				}
			}else{
				if($this->db->insert($table,$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}
		public function updateHomeSectionSort($data){
			$table = "tbl_restaurant_homepage_section_sort";
			if($this->db->where("rest_id",$data["rest_id"])->where("section_id",$data["section_id"])->get($table)->row()){
				if($this->db->where("rest_id",$data["rest_id"])->where("section_id",$data["section_id"])->update($table,$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert($table,$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}
		public function savePaymentSetting($data,$rest_id){
			if($this->db->where("rest_id",$rest_id)->get("tbl_payment_settings")->row()){
				if($this->db->where("rest_id",$rest_id)->update('tbl_payment_settings',$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert('tbl_payment_settings',$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}

		public function saveDeliverycountry($data,$rest_id){
			if($this->db->where("rest_id",$rest_id)->get("tbl_delivery_countries")->row()){
				if($this->db->where("rest_id",$rest_id)->update('tbl_delivery_countries',$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert('tbl_delivery_countries',$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}

		public function update_subCategory($condition,$toUpdate){
			if($this->db->where($condition)->update('tbl_sub_category',$toUpdate)){
				return 1;
			}else{
				return 0;
			}
		}
		public function update_foodExtra($condition,$toUpdate){
			if($this->db->where($condition)->update('tbl_food_extra',$toUpdate)){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_subCategory($subcat_id){
			$res=$this->db->where('sub_cat_id',$subcat_id)->delete('tbl_sub_category');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_foodExtra($extra_id){
			$res=$this->db->where('extra_id',$extra_id)->delete('tbl_food_extra');
			if($res){
				return 1;
			}else{
				return 0;
			}
		}
		public function remove_Restaurant($rest_id){
			$res=$this->db->where('rest_id',$rest_id)->delete('tbl_restaurant');
			if($res){
				if($this->db->where('restaurant_id',$rest_id)->delete('tbl_restaurant_details')){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		public function getAllSubcate($cate_id){
			return $this->db->where('category_id',$cate_id)->get('tbl_sub_category')->result();
		}
		public function getCategoryFoodExtra($cate_id){
			return $this->db->where('category_id', $cate_id )->get('tbl_food_extra')->result();
		}
		public function getAllAllergens($rest_id){
			return $this->db->get('tbl_allergens')->result();
		}
		public function getCategoryByResId($rest_id){
			return $this->db->where('(added_by = '.$rest_id.' or added_by = 0) and category_status = "active"')->get('tbl_category')->result();
		}
		public function getAllCategory($cat_type_id){
			return $this->db->where('type_id = '.$cat_type_id.' and category_status = "active"')->get('tbl_category')->result();
		}
		public function updateItem($menu_id,$data){
			return $this->db->where("menu_id",$menu_id)->update('tbl_menu_card',$data);
		}
		public function addNewItem($data){
			$check=$this->db->where($data)->where("item_status = 'Available' ")->get('tbl_menu_card')->result();
			if(count($check)==0){
			 	// echo 'Can be added';
			 	if($this->db->insert('tbl_menu_card',$data)){
			 		return 1;
			 	}else{
			 		return 0;
			 	}
			}else{
			 	// echo 'Already Added';
			 	return 2;
			}
		}
		public function get_category_list_by_added_by_type_id($added_by_id,$type_id){
			$category_array = $this->db->where("added_by = $added_by_id or added_by = 0")->where('type_id',$type_id)->get('tbl_category')->result();
			return $category_array ;
		}
		public function getAllMenuItem_ByCatId($rest_id,$dp_option,$lang,$cat_id){
			// return
			$mainArray=array();
			$category_array=array();
			$subCategories=array();

			if (strtolower($dp_option) == "delivery"){
				$item_show_on_condition = " and (item_show_on = 1 or item_show_on = 3) ";
			}elseif (strtolower($dp_option )== "pickup"){
				$item_show_on_condition = " and ( item_show_on > 1 )";
			}else{
				$item_show_on_condition = " and ( item_show_on < 4 ) ";
			}

			// $category_ids=$this->db->group_by('category_id')->where('rest_id',$rest_id)->get('tbl_menu_card')->result();
			$category_ids=$this->db->query("SELECT * FROM tbl_menu_card m JOIN tbl_category  c ON c.category_id  = m.category_id WHERE m.rest_id = ".$rest_id." and item_status = 'Available' and category_status = 'active' $item_show_on_condition GROUP BY m.category_id ORDER BY c.category_sort_index")->result(); 
			$category_name_field = 'category_name_' . $lang;
			$category_description_field = 'category_description_' . $lang;
			$allergens=(array)$this->getAllAllergens($rest_id);
			foreach ($category_ids as $key => $value) {
				$allitemsofcategory=$this->getItemOfCategory($value->category_id,$rest_id,$dp_option,$lang);
				$cat = $this->getCategoryDetails($value->category_id)[0];

				$cattype=$cat->type_id;
				$category=$cat->$category_name_field == "" ? $cat->category_name : $cat->$category_name_field;
				$categoryDesc=$cat->$category_description_field == "" ? $cat->category_description : $cat->$category_description_field;
				$category_img=$cat->category_image;
				$subCategories=(array)$this->getAllSubcate($value->category_id);
				$mainArray[]=array("category"=>$category,"categoryDesc"=>$categoryDesc,"category_img"=>$category_img,"cattype"=>$cattype,"sub_categories"=>$subCategories,"items"=>$allitemsofcategory,"card"=>$value,"allergens" => $allergens);
			}
			return $mainArray; 
		}
		public function getAllMenuItem_($rest_id,$lang="french",$sort_direct = "ASC"){
			// return
			$mainArray=array();
			$category_array=array();
			$subCategories=array();
			$category_name_field = 'category_name_' . $lang;
			if ($sort_direct !== "DESC"){
				$sort_direct = "ASC";
			}
			// $category_ids=$this->db->group_by('category_id')->where('rest_id',$rest_id)->get('tbl_menu_card')->result(); 
			$category_ids=$this->db->query("SELECT * FROM tbl_menu_card m JOIN tbl_category  c ON c.category_id  = m.category_id WHERE m.rest_id = ".$rest_id."  and item_status = 'Available' and category_status = 'active' GROUP BY m.category_id ORDER BY c.category_sort_index")->result(); 
			foreach ($category_ids as $key => $value) {
				$category_array=$this->getItemOfCategory($value->category_id,$rest_id,"table",$lang,$sort_direct);
				$category_name = $this->getCategoryDetails($value->category_id)[0]->$category_name_field;
				$cattype = $this->getCategoryDetails($value->category_id)[0]->type_id;
				$subCategories=(array)$this->getAllSubcate($value->category_id);
				$mainArray[]=array("cate_name"=>$category_name,"sub_categories"=>$subCategories,"items"=>$category_array,"card"=>$value,"cattype"=>$cattype);
			}
			return $mainArray; 
		} 
		public function getAllMenuItem($rest_id,$lang="french",$sort_direct = "ASC"){
			// return
			$mainArray=array();
			$category_array=array();
			$subCategories=array();
			$category_name_field = 'category_name_' . $lang;
			if ($sort_direct !== "DESC"){
				$sort_direct = "ASC";
			}
			// $category_ids=$this->db->group_by('category_id')->where('rest_id',$rest_id)->get('tbl_menu_card')->result(); 
			$category_ids=$this->db->query("SELECT * FROM tbl_menu_card m JOIN tbl_category  c ON c.category_id  = m.category_id WHERE m.rest_id = ".$rest_id." and category_status = 'active' GROUP BY m.category_id ORDER BY c.category_sort_index")->result(); 
			foreach ($category_ids as $key => $value) {
				$category_array=$this->getItemOfCategoryAll($value->category_id,$rest_id,"table",$lang,$sort_direct);
				$category_name = $this->getCategoryDetails($value->category_id)[0]->$category_name_field;
				$cattype = $this->getCategoryDetails($value->category_id)[0]->type_id;
				$subCategories=(array)$this->getAllSubcate($value->category_id);
				$mainArray[]=array("cate_name"=>$category_name,"sub_categories"=>$subCategories,"items"=>$category_array,"card"=>$value,"cattype"=>$cattype,"cat_id"=>$value->category_id);
			}
			return $mainArray; 
		} 
		public function getAllMenuItem_deactive($rest_id,$lang="french",$sort_direct = "ASC"){
			// return
			$mainArray=array();
			$category_array=array();
			$subCategories=array();
			$category_name_field = 'category_name_' . $lang;
			if ($sort_direct !== "DESC"){
				$sort_direct = "ASC";
			}
			if ($rest_id == 0){
				$category_ids=$this->db->query("SELECT * FROM tbl_menu_card m JOIN tbl_category  c ON c.category_id  = m.category_id WHERE item_status = 'Not Available' and category_status = 'active' GROUP BY m.category_id ORDER BY c.category_sort_index")->result(); 
				foreach ($category_ids as $key => $value) {
					$category_array=$this->getItemOfCategory_deactive($value->category_id,$rest_id,$lang,$sort_direct);
					$category_name = $this->getCategoryDetails($value->category_id)[0]->$category_name_field;
					$cattype = $this->getCategoryDetails($value->category_id)[0]->type_id;
					$subCategories=(array)$this->getAllSubcate($value->category_id);
					$mainArray[]=array("cate_name"=>$category_name,"sub_categories"=>$subCategories,"items"=>$category_array,"card"=>$value,"cattype"=>$cattype);
				}
			}else{
				$category_ids=$this->db->query("SELECT * FROM tbl_menu_card m JOIN tbl_category  c ON c.category_id  = m.category_id WHERE m.rest_id = ".$rest_id."  and item_status = 'Not Available' and category_status = 'active' GROUP BY m.category_id ORDER BY c.category_sort_index")->result(); 
				foreach ($category_ids as $key => $value) {
					$category_array=$this->getItemOfCategory_deactive($value->category_id,$rest_id,$lang,$sort_direct);
					$category_name = $this->getCategoryDetails($value->category_id)[0]->$category_name_field;
					$cattype = $this->getCategoryDetails($value->category_id)[0]->type_id;
					$subCategories=(array)$this->getAllSubcate($value->category_id);
					$mainArray[]=array("cate_name"=>$category_name,"sub_categories"=>$subCategories,"items"=>$category_array,"card"=>$value,"cattype"=>$cattype);
				}
			}
			return $mainArray; 
		} 
		public function getItemOfCategoryAll($cate_id,$rest_id,$dp_option="table",$lang="french",$sort_direct="ASC"){
			$subcat=array();
			$menuDetail=array();
			$condition=array(
				"rest_id"=>$rest_id,
				"category_id"=>$cate_id,
			);
			if (strtolower($dp_option) == "delivery"){
				$item_show_on_condition = "(item_show_on = 1 or item_show_on = 3)";
			}elseif (strtolower($dp_option)== "pickup"){
				$item_show_on_condition = "(item_show_on > 1)";
			}else{
				$item_show_on_condition = "(item_show_on < 4)";
			}
			$item_name_field = 'item_name_' . $lang;
			$result= $this->db->order_by("item_sort_index",$sort_direct)->where($condition)->where($item_show_on_condition)->get('tbl_menu_card')->result();
			$item_prices_title_field = "item_prices_title_". $lang;
			$sub_category_name_field = "sub_category_name_" .$lang; 
			foreach ($result as $key => $value) {
				$itemPrice=explode(',', $value->item_prices);
				$itemPriceTitle=explode(',', $value->$item_prices_title_field);
				$subCatArray=explode(',', $value->sub_cat_ids);
					if (sizeof($subCatArray)>1){
					$subcat = [];
					foreach ($subCatArray as $subcat_) {
						$resSub=$this->getSubCateDetails($subcat_);
						$subcat[]=$resSub->$sub_category_name_field;
					}
				}else{
					$subcat = [];
				}

			$menuDetail[]=array("item_detail"=>$value,"sub_Cat"=>$subcat,"item_price"=>$itemPrice,"itemPriceTitle" =>$itemPriceTitle);
			}
			return $menuDetail;
		}
		public function getItemOfCategory($cate_id,$rest_id,$dp_option="table",$lang="french",$sort_direct="ASC"){
			$subcat=array();
			$menuDetail=array();
			$condition=array(
				"rest_id"=>$rest_id,
				"category_id"=>$cate_id,
				"item_status" => 'Available' ,
			);
			if (strtolower($dp_option) == "delivery"){
				$item_show_on_condition = "(item_show_on = 1 or item_show_on = 3)";
			}elseif (strtolower($dp_option)== "pickup"){
				$item_show_on_condition = "(item_show_on > 1)";
			}else{
				$item_show_on_condition = "(item_show_on < 4)";
			}
			$item_name_field = 'item_name_' . $lang;
			$result= $this->db->order_by("item_sort_index",$sort_direct)->where($condition)->where($item_show_on_condition)->get('tbl_menu_card')->result();
			$item_prices_title_field = "item_prices_title_". $lang;
			$sub_category_name_field = "sub_category_name_" .$lang; 
			foreach ($result as $key => $value) {
				$itemPrice=explode(',', $value->item_prices);
				$itemPriceTitle=explode(',', $value->$item_prices_title_field);
				$subCatArray=explode(',', $value->sub_cat_ids);
					if (sizeof($subCatArray)>1){
					$subcat = [];
					foreach ($subCatArray as $subcat_) {
						$resSub=$this->getSubCateDetails($subcat_);
						$subcat[]=$resSub->$sub_category_name_field;
					}
				}else{
					$subcat = [];
				}

			$menuDetail[]=array("item_detail"=>$value,"sub_Cat"=>$subcat,"item_price"=>$itemPrice,"itemPriceTitle" =>$itemPriceTitle);
			}
			return $menuDetail;
		}
		public function getItemOfCategory_deactive($cate_id,$rest_id,$lang="french",$sort_direct="ASC"){
			$subcat=array();
			$menuDetail=array();
			if ($rest_id == 0){
				$condition=array(
					"category_id"=>$cate_id,
					"item_status" => 'Not Available' 
				);
			}else{
				$condition=array(
					"rest_id"=>$rest_id,
					"category_id"=>$cate_id,
					"item_status" => 'Not Available' 
				);
			}
			$item_name_field = 'item_name_' . $lang;
			// $result= $this->db->order_by($item_name_field,$sort_direct)->where($condition)->get('tbl_menu_card')->result();
			$result= $this->db->order_by("item_sort_index",$sort_direct)->where($condition)->get('tbl_menu_card')->result();
			// $result= $this->db->where($condition)->get('tbl_menu_card')->result();
			$item_prices_title_field = "item_prices_title_". $lang;
			$sub_category_name_field = "sub_category_name_" .$lang; 
			foreach ($result as $key => $value) {
				$itemPrice=explode(',', $value->item_prices);
				$itemPriceTitle=explode(',', $value->$item_prices_title_field);
				$subCatArray=explode(',', $value->sub_cat_ids);
					if (sizeof($subCatArray)>1){
					$subcat = [];
					foreach ($subCatArray as $subcat_) {
						$resSub=$this->getSubCateDetails($subcat_);
						$subcat[]=$resSub->$sub_category_name_field;
					}
				}else{
					$subcat = [];
				}

			$menuDetail[]=array("item_detail"=>$value,"sub_Cat"=>$subcat,"item_price"=>$itemPrice,"itemPriceTitle" =>$itemPriceTitle);
			}
			return $menuDetail;
		}
		public function getWishListItems($wishlists,$lang){
			$wishlist_str = implode(",",$wishlists);
			$query_wish = ("SELECT * FROM `tbl_menu_card` WHERE item_status = 'Available'  and `menu_id` IN  ('" . $wishlist_str . "' ) GROUP BY category_id;");
			$wish_arr = $this->db->query($query_wish)->result();

			$mainArray=array();
			$category_array=array();
			$subCategories=array();
			$category_ids=$wish_arr;
			$category_name_field = 'category_name_' . $lang;
			foreach ($category_ids as $key => $value) {
				$rest_id = $value->rest_id;
				$allitemsofcategory=$this->getItemOfCategory_wish($value->category_id,$rest_id,$wishlists,$lang);
				$category=$this->getCategoryDetails($value->category_id)[0]->$category_name_field;
				$category_img=$this->getCategoryDetails($value->category_id)[0]->category_image;
				$cattype=$this->getCategoryDetails($value->category_id)[0]->type_id;
				$subCategories=(array)$this->getAllSubcate($value->category_id);
				$allergens = $this->getAllAllergens($rest_id);
				$mainArray[]=array("category"=>$category,"category_img"=>$category_img,"cattype"=>$cattype,"sub_categories"=>$subCategories,"items"=>$allitemsofcategory,"card"=>$value,"allergens"=>$allergens);
			}
			return $mainArray; 
		}
		public function getItemOfCategory_wish($cate_id,$rest_id,$wishlists,$lang="english"){
			$subcat=array();
			$menuDetail=array();
			$condition=array(
				"rest_id"=>$rest_id,
				"category_id"=>$cate_id
			);

			$wishlist_str = implode(",",$wishlists);
			$query_wish =  $this->db->query("SELECT * FROM tbl_menu_card WHERE rest_id = ".$rest_id ."  and item_status = 'Available' AND category_id = ".$cate_id ." AND `menu_id` IN  (" . $wishlist_str . " ) ");

			// $query_res = $this->db->query("SELECT * FROM tbl_menu_card WHERE rest_id = ".$rest_id ." AND category_id = ".$cate_id ." AND (( item_name_english like '%".$key."%' ) OR ( item_name_germany like '%".$key."%' ) OR ( item_name_french like '%".$key."%' ) OR ( item_name like '%".$key."%'));");
			$result = $query_wish->result();
			// $result= $this->db->where($condition)->like('item_name',$key,'both')->get('tbl_menu_card')->result();
			$item_prices_title_field = "item_prices_title_". $lang;
			$sub_category_name_field = "sub_category_name_" .$lang; 
			foreach ($result as $key => $value) {
				$itemPrice=explode(',', $value->item_prices);
				$itemPriceTitle=explode(',', $value->$item_prices_title_field);
				$subCatArray=explode(',', $value->sub_cat_ids);
				if (sizeof($subCatArray) > 1){
					foreach ($subCatArray as $subcat_) {
						$resSub=$this->getSubCateDetails($subcat_);
						$subcat[]=$resSub->$sub_category_name_field;
					}
				}else{
					$subcat[] = [];
				}

			$menuDetail[]=array("item_detail"=>$value,"sub_Cat"=>$subcat,"item_price"=>$itemPrice,"itemPriceTitle" =>$itemPriceTitle);
			}
			return $menuDetail;
		}
		public function getItemOfCategoryByKey($cate_id,$rest_id,$dp_option,$key,$lang){
			$subcat=array();
			$menuDetail=array();
			if (strtolower($dp_option) == "delivery"){
				$item_show_on_condition = " and (item_show_on = 1 or item_show_on = 3) ";
			}elseif (strtolower($dp_option )== "pickup"){
				$item_show_on_condition = " and ( item_show_on > 1 )";
			}else{
				$item_show_on_condition = " and ( item_show_on < 4 ) ";
			}
			
			$condition=array(
				"rest_id"=>$rest_id,
				"category_id"=>$cate_id
			);
			
			$query_res = $this->db->query("SELECT * FROM tbl_menu_card WHERE rest_id = ".$rest_id ."  and item_status = 'Available' $item_show_on_condition AND category_id = ".$cate_id ." AND (( item_name_english like '%".$key."%' ) OR ( item_name_germany like '%".$key."%' ) OR ( item_name_french like '%".$key."%' ) OR ( item_name like '%".$key."%'));");
			$result = $query_res->result();
			// $result= $this->db->where($condition)->like('item_name',$key,'both')->get('tbl_menu_card')->result();
			$item_prices_title_field = "item_prices_title_". $lang;
			$sub_category_name_field = "sub_category_name_" .$lang; 
			foreach ($result as $key => $value) {
				$itemPrice=explode(',', $value->item_prices);
				$itemPriceTitle=explode(',', $value->$item_prices_title_field);
				$subCatArray=explode(',', $value->sub_cat_ids);
				if (sizeof($subCatArray)>1){
					foreach ($subCatArray as $subcat_) {
						$resSub=$this->getSubCateDetails($subcat_);
						$subcat[]=$resSub->$sub_category_name_field;
					}
				}else{
					$subcat[] = [];
				}

			$menuDetail[]=array("item_detail"=>$value,"sub_Cat"=>$subcat,"item_price"=>$itemPrice,"itemPriceTitle" =>$itemPriceTitle);
			}
			return $menuDetail;
		}
		public function getSubCateDetails($subcat_id){
			return $this->db->where('sub_cat_id',$subcat_id)->get('tbl_sub_category')->row();
		}
		// ---------------------------customer side-------------------------------
		public function getcustomerLoginValidate($data){
			$result=$this->db->where($data)->get('tbl_users')->result();
			if(count($result)>0){
				return $result;
			}else{
				return false;
			}
		}
		public function updateUserAccount($user_id,$data){
			if($this->db->where("user_id",$user_id)->get("tbl_customers")->row()){
				if($this->db->where("user_id",$user_id)->update('tbl_customers',$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert('tbl_customers',$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}
		// ------------------------------------------------------------------------
		public function getRestLoginValidate($data,$is_active_only = true){
			if ($is_active_only){
				$res=$this->db->where($data)->where("activation_status","Accepted")->join("tbl_restaurant_details","tbl_restaurant_details.restaurant_id = tbl_restaurant.rest_id")->get('tbl_restaurant')->result();
			}else{
				$res=$this->db->where($data)->get('tbl_restaurant')->result();
			}
			if($res){
				return $res;
			}else{
				return false;
			}
		}
		public function getAdminLoginValidate($data){
			$result=$this->db->where($data)->get('tbl_admin')->result();
			if(count($result)>0){
				return $result;
			}else{
				return false;
			}
		}
		public function remove_menuItem($itemId){
			if($this->db->where('menu_id',$itemId)->delete('tbl_menu_card')){
				return 1;
			}else{
				return 0;
			}
		}
		public function getAllMenuItemCategory_($category_id,$rest_id,$lang = "french"){
			$category_array=array();
			$subCategories=array();
			$menuDetail=$category_array=(array)$this->getItemOfCategory($category_id,$rest_id,"table",$lang);
			$subCategories=(array)$this->getAllSubcate($category_id);
			$mainArray=array("sub_categories"=>$subCategories,"items"=>$menuDetail);
			return $mainArray; 
		}
		public function getAllMenuItemCategory__($category_id,$rest_id,$dp_option,$lang="english"){
			$subCategories=array();
			$menuDetail=(array)$this->getItemOfCategory($category_id,$rest_id,$dp_option,$lang);
			$allergens = (array)$this->getAllAllergens($rest_id);

			$query_cat = $this->db->query("SELECT * FROM tbl_category WHERE category_id = '". $category_id ."' and category_status = 'active'");
			$category_row = $query_cat->row();
			$category_name_field = "category_name_".$lang;
			$category_description_field = "category_description_".$lang;
			$category = $category_row->$category_name_field == "" ? $category_row->category_name : $category_row->$category_name_field;
			$categoryDesc = $category_row->$category_description_field == "" ? $category_row->category_description : $category_row->$category_description_field;
			$category_img = $category_row->category_image;
			$subCategories=(array)$this->getAllSubcate($category_id);
			$mainArray=array("sub_categories"=>$subCategories,"items"=>$menuDetail,"category"=>$category,"categoryDesc"=>$categoryDesc,"category_img"=>$category_img,"allergens" => $allergens);
			return $mainArray; 
		}
		public function addRestLogo($data,$condition){
				if($this->db->get('tbl_restaurant_details')->row()){
				if($this->db->where($condition)->update('tbl_restaurant_details',$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert('tbl_restaurant_details',$data)){
					return 1;
				}else{
					return 0;
				}
			}
		}
		public function addRestBanner($data,$condition){
			
				if($this->db->where($condition)->get('tbl_banner_settings')->row() ){
				if($this->db->where($condition)->update('tbl_banner_settings',$data)){
					return 1;
				}else{
					return 0;
				}
			}else{
				if($this->db->insert('tbl_banner_settings',$data)){
					return 1;
				}else{
					return 0;
				}
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
		public function updateRestDetails_($data){
			//  print_r($data);
				$sessData=unserialize($this->session->userdata('rest_user_Data'));
				// 			$sessData[0]->rest_id;

			$rest_url_slug = $this->slugify($sessData[0]->rest_id,$data['rest_name']);
			if ($data['confirmpassword'] == $data['newpassword'] && $data['newpassword'] !== ""){
				$pwd_encrypt = md5(trim($data['newpassword']));
				$res = $this->db->where('rest_id',$sessData[0]->rest_id)->update('tbl_restaurant',array("rest_name"=>$data['rest_name'],"rest_url_slug" =>$rest_url_slug,"rest_pass" =>$pwd_encrypt));
			}else{
				$res = $this->db->where('rest_id',$sessData[0]->rest_id)->update('tbl_restaurant',array("rest_name"=>$data['rest_name'],"rest_url_slug" =>$rest_url_slug));
			}
				if($res){
					//  return 1;
					//``(`tbl_res_id`, `restaurant_id`, `rest_logo`, `gst_no`, ``, ``, ``, ``, ``, `menu_card_id`, `added_on`, `activation_status`)
					$toUpdate=array(
				"owner_name"=>$this->input->post('rest_owner_name'),
				"owner_mobile"=>$this->input->post('rest_owner_contact'),
				"address"=>$this->input->post('rest_address'),
				"establishment_year"=>$this->input->post('rest_est_year'),
				"rest_contact_no"=>$this->input->post('rest_contact'),
				
				);
						if($this->db->where('restaurant_id',$sessData[0]->rest_id)->update('tbl_restaurant_details',$toUpdate)){
								return 1;
						}else{
								return 0;
						}
				}else{
						return 0;
				}
		}
		public function getAllMenuItemKey_($key,$rest_id,$lang="english"){
			
			$category_array=array();
			$subCategories=array();
			$items=$this->db->like('item_name',$key,'both')->where("item_status = 'Available' ")->get('tbl_menu_card')->result();
			$category_name_field = "category_name_".$lang;
			foreach ($items as $key => $value) {
				$category_name=$this->getCategoryDetails($value->category_id)[0]->$category_name_field=="" ? $this->getCategoryDetails($value->category_id)[0]->category_name: $this->getCategoryDetails($value->category_id)[0]->$category_name_field;
				$category_img=$this->getCategoryDetails($value->category_id)[0]->category_image;
				$subCategories=(array)$this->getAllSubcate($value->category_id);
				$price=explode(',',$value->item_prices);
				$mainArray[]=array("cate_name"=>$category_name,"category_img"=>$category_img, "sub_categories"=>$subCategories,"items"=>$value,"price"=>$price);
			}
			return $mainArray; 
		}
		public function getAllMenuItemKey($keyword,$rest_id,$dp_option,$lang="english"){
			
			$mainArray=array();
			$category_array=array();
			$subCategories=array();

			if (strtolower($dp_option) == "delivery"){
				$item_show_on_condition = " and (item_show_on = 1 or item_show_on = 3) ";
			}elseif (strtolower($dp_option )== "pickup"){
				$item_show_on_condition = " and ( item_show_on > 1 )";
			}else{
				$item_show_on_condition = " and ( item_show_on < 4 ) ";
			}
			// $category_ids=$this->db->group_by('category_id')->where('rest_id',$rest_id)->get('tbl_menu_card')->result(); 
			$category_ids=$this->db->query("SELECT * FROM tbl_menu_card m JOIN tbl_category  c ON c.category_id  = m.category_id WHERE m.rest_id = ".$rest_id."  and item_status = 'Available' and category_status = 'active' $item_show_on_condition AND (( item_name_english like '%".$keyword."%' ) OR ( item_name_germany like '%".$keyword."%' ) OR ( item_name_french like '%".$keyword."%' ) OR ( item_name like '%".$keyword."%')) GROUP BY m.category_id ORDER BY c.category_sort_index")->result();
			$category_name_field = 'category_name_' . $lang;
			$category_description_field = 'category_description_' . $lang;
			$allergens = $this->getAllAllergens($rest_id);
			foreach ($category_ids as $key => $value) {
				$allitemsofcategory=$this->getItemOfCategoryByKey($value->category_id,$rest_id,"table",$keyword,$lang);
				$cat = $this->getCategoryDetails($value->category_id)[0];
				
				$cattype=$cat->type_id;
				$category=$cat->$category_name_field == "" ? $cat->category_name : $cat->$category_name_field;
				$categoryDesc=$cat->$category_description_field == "" ? $cat->category_description : $cat->$category_description_field;
				$category_img=$cat->category_image;

				$subCategories=(array)$this->getAllSubcate($value->category_id);
				$mainArray[]=array("category"=>$category,"categoryDesc"=>$categoryDesc,"cattype"=>$cattype,"category_img"=>$category_img,"sub_categories"=>$subCategories,"items"=>$allitemsofcategory,"card"=>$value,"allergens" => $allergens);
			}
			return $mainArray; 
		}
		public function getAddon_by_addon_id($addon_id){
			$addon = $this->db->where("addon_id",$addon_id)->get("tbl_addons")->row();
			return $addon; 
		}
		public function getAddonFeatures_by_rest_id($rest_id){
			$addon_features = array();
			if ($rest = $this->db->where("restaurant_id",$rest_id)->get("tbl_restaurant_details")->row()){
				if ($rest->addon_ids !== ""){
					$addon_ids = $rest->addon_ids;
					if ($addons = $this->db->query('SELECT * FROM tbl_addons WHERE addon_id IN ('.$addon_ids.')')->result()){
						foreach ($addons as $akey => $avalue) {
							$each_addon_features = explode(",",$avalue->addon_features);
							foreach ($each_addon_features as $ekey => $evalue) {
								$addon_features[] = $evalue;
							}
						}
					}
				}
			}
			
			return $addon_features;
		}
		public function geAllRestaurantAddonStatus(){
			$rest_addon_status_arr = array();
			$restaurants = $this->db->query("SELECT r.rest_id as rid, ra.* FROM `tbl_restaurant` r
			LEFT JOIN (SELECT * FROM `tbl_restaurant_addons` WHERE `status` = 'pending' GROUP BY `rest_id`) AS ra ON r.`rest_id` = ra.rest_id
			ORDER BY ra.status DESC")->result();
			$addons = $this->db->get("tbl_addons")->result();
			foreach ($restaurants as $rkey => $rvalue) {
				foreach ($addons as $akey => $avalue) {
					$rest_addon_status_arr[$rvalue->rid][$avalue->addon_id] = "inactive";
				}
			}
			$rest_addon = $this->db->get("tbl_restaurant_addons")->result();
			foreach ($rest_addon as $rakey => $ravalue) {
				$rest_addon_status_arr[$ravalue->rest_id][$ravalue->addon_id] = $ravalue->status;
			}
			return $rest_addon_status_arr;
		}
	}

?>