<?php 

add_action( 'wp_ajax_fixed_contact_admin', 'fixed_contact_admin_init' );
add_action( 'wp_ajax_nopriv_fixed_contact_admin', 'fixed_contact_admin_init' );
function fixed_contact_admin_init() {
 
    //do bên js để dạng json nên giá trị trả về dùng phải encode
    $settingData = isset($_POST['settingData'])) ? $_POST['settingData'] : '';
    

 	$socials_option = unserialize(get_option('lbk_fc_defaulf_socials'));

 	foreach ($socials_option as $social_option_key => $social_option) {
 		foreach ($settingData['list_socials'] as $icon_key => $iconData) {
 			if( $iconData['slug'] == $social_option['slug']) {
 				$socials_option[$social_option_key] = $iconData;
 			}
 		}
 	}

 	$settingData_serialize = serialize($settingData);
 	$socials_option_serialize = serialize($socials_option);

 	update_option('lbk_fc_defaulf_socials', $socials_option_serialize);
 	update_option('lbk_fc_setting_data', $settingData_serialize);
    wp_send_json_success( $settingData );
 
    die();//bắt buộc phải có khi kết thúc
}
