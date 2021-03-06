<?php 
function lbk_fc_check_position($position) {
	switch ($position) {
    	case 'right-bottom':
    		return true;
    		break;
    	
    	case 'left-bottom':
    		return true;
    		break;
    	
    	case 'right-center':
    		return true;
    		break;
    	
    	case 'left-center':
    		return true;
    		break;
    	
    	default:
    		return false;
    		break;
    }
}
function lbk_fc_check_fc_trigger_delay_status($delay_status) {
	switch ($delay_status) {
    	case 'true':
    		return true;
    		break;
    	
    	case 'false':
    		return true;
    		break;
    
    	default:
    		return false;
    		break;
    }
} 
function lbk_fc_check_fc_trigger_delay_time($delay_time) {
	if( filter_var( $delay_time, FILTER_VALIDATE_INT ) ) {
		return true;
	}
	return false;
} 
function lbk_fc_check_fc_trigger_state($state) {
	switch ($state) {
    	case 'click':
    		return true;
    		break;
    	
    	case 'default':
    		return true;
    		break;
    	
    	case false :
    		return false;
    		break;
    	default:
    		return false;
    		break;
    }
}
function lbk_fc_check_fc_social_url($social_url){
	
	if( filter_var( $social_url, FILTER_VALIDATE_URL ) !== false ) {
		return true;
	}
	return false;
}
function lbk_fc_check_fc_social_placeholer($social){
	if( strlen($social_placeholer) < 30 ) {
		return true;
	}
	return false;
}
add_action( 'wp_ajax_fixed_contact_admin', 'fixed_contact_admin_init' );
add_action( 'wp_ajax_nopriv_fixed_contact_admin', 'fixed_contact_admin_init' );
function fixed_contact_admin_init() {
	$settingDataError = array();
	
	if( $_POST ) {

		$socials_status = array();

		$fc_position = filter_var($_POST["settingData"]["fc_position"], FILTER_SANITIZE_STRING);
		$social_icon_size = filter_var($_POST["settingData"]["social_icon_size"], FILTER_SANITIZE_NUMBER_INT);
		$toggle_icon_effect = filter_var($_POST["settingData"]["toggle_icon_effect"], FILTER_SANITIZE_STRING);

		$fc_trigger = $settingData["fc_trigger"];


		$fc_trigger_delay_status = filter_var($_POST["settingData"]["fc_trigger"]["delay"]["status"], FILTER_SANITIZE_STRING);
		$fc_trigger_delay_time = filter_var($_POST["settingData"]["fc_trigger"]["delay"]["time"], FILTER_SANITIZE_NUMBER_INT);

		$fc_trigger_state = filter_var($_POST["settingData"]["fc_trigger"]["state"], FILTER_SANITIZE_STRING);


		$fc_list_socials = $_POST["settingData"]["list_socials"];

		foreach($fc_list_socials as $social) {
			$social["url"] = filter_var('https://www.w3schools.com', FILTER_SANITIZE_URL);
			$social["placeholder"] = filter_var($social["placeholder"], FILTER_SANITIZE_STRING);
		}

	    if( !lbk_fc_check_position($fc_position) ){ 
	    	wp_send_json_error( $data = "Xin kh??ng thay ?????i c??c gi?? tr??? m???c ?????nh c???a v??? tr?? fixed contact");
	        die();
	    }
	    if( !lbk_fc_check_fc_trigger_delay_status($fc_trigger_delay_status) ){ 
	    	wp_send_json_error( $data = "Xin kh??ng thay ?????i c??c gi?? tr??? m???c ?????nh c??ng t???c b???t - t???t delay");
	        die();
	    }
	    if( !lbk_fc_check_fc_trigger_delay_time($fc_trigger_delay_time) ){ 
	    	wp_send_json_error( $data = "Th???i gian delay ch??? c?? th??? l?? d???ng s???, Xin Xin ?????ng thay ?????i sang gi?? tr??? kh??c ");
	        die();
	    }
	    if( !lbk_fc_check_fc_trigger_state($fc_trigger_state) ){ 
	    	wp_send_json_error( $data = "Hi???n t???i state ch??? c?? ???n khi b???t ho???c hi???n khi b???t, Xin kh??ng thay ?????i c??c gi?? tr??? n??o kh??c");
	        die();
	    }
	    foreach($fc_list_socials as  $index => $social) {

	    	$social_status = array( 'url' => true, 'placeholder' => true ); 
	    	array_push($socials_status, $social_status);

		   	if( !lbk_fc_check_fc_social_url($social['url']) ){
		   		
		   		$socials_status[$index]['url'] = false;
		    }else {
		    	$_POST["settingData"]["list_socials"][$index]['url'] = $social['url'];
		    }

		    if( !lbk_fc_check_fc_social_placeholer($social['placeholer']) ){ 
		        $socials_status[$index]['placeholer'] = false;
		    }else {
		    	$_POST["settingData"]["list_socials"][$index]['placeholer'] = $social['placeholer'];
		    }
	    }
	}    

 	$socials_option = get_option('lbk_fc_defaulf_socials');

 	foreach ($socials_option as $social_option_key => $social_option) {
 		foreach ($_POST["settingData"]['list_socials'] as $icon_key => $iconData) {
 			if( $iconData['slug'] == $social_option['slug']) {
 				$_POST["settingData"][$social_option_key] = $iconData;
 			}
 		}
 	}

 	update_option('lbk_fc_defaulf_socials', $socials_option);
 	update_option('lbk_fc_setting_data', $_POST["settingData"]);

 	foreach($socials_status as $social_status) {
 		if($social_status['url'] == false) {
 			wp_send_json_error( $data = $socials_status );
	        die();
 		}elseif($social_status['placeholder'] == false) {
 			wp_send_json_error( $data = $socials_status );
	        die();
 		}
 	}
    wp_send_json_success( $fc_list_socials ); 
    die();
}
