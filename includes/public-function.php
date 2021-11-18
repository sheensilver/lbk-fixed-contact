<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'lbkFc_Function' ) ) {
    /**
     * Class lbkFc_Function
     */
    final class lbkFc_Function {

        public static function form_text_input($name,$label,$value = '', $additional = '')
        {
            $value = esc_html($value);
            return "<td><label class=\"input_spacing\" for=\"$name\">$label</label></td> <td><input type=\"text\" name=\"$name\" id=\"$name\" value=\"$value\"> $additional</td>";
        }

        // Get link image

    }
    new lbkFc_Function();
}

if ( ! function_exists( 'lbk_form_checkbox' ) ) {
    function lbk_form_checkbox($name,$label,$checked = 1) {
		$checked = ((bool)$checked) ? 'checked' : '';
		return "<td style='text-align:center'><input type=\"hidden\" name=\"$name\" value=\"0\"><input type=\"checkbox\" name=\"$name\" id=\"$name\" value=\"1\" $checked><td>";
	}
}

if ( ! function_exists( 'lbk_get_link_img' ) ) {
    function lbk_get_link_img( $image='' ) {
        $link = LBK_FC_URL . 'assets/images/' . $image;
        return $link;
    }
}