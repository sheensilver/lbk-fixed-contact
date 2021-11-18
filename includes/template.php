<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function lbk_fc_template() {
    // Get the general settings options
    $socials_option = unserialize(get_option('lbk_fc_setting_data'));
    $socials_icon = $socials_option['list_socials'];
    $icon_size = $socials_option['social_icon_size'];
    $fc_position = $socials_option['fc_position'];
    $toggle__effect = $socials_option['toggle_icon_effect'];
    $fc_trigger = $socials_option['fc_trigger'];


    ?>

    <div class="lbk-fc-wrapper <?php echo $fc_position;?>" <?php if($fc_trigger = $socials_option['fc_trigger']['delay']['status'] == "true") {echo 'data-delay='.$socials_option['fc_trigger']['delay']['time']; } ?>>
        <div class="lbk-fc-list">
        <?php
            foreach($socials_icon as $key => $social) {
            ?>
                <div class = "fc-social fc-icon-wrapper" style="width: <?php echo esc_attr($icon_size); ?>; height: <?php echo esc_attr($icon_size)?>; display: <?php echo $fc_trigger['state'] !== 'click' ? 'none' : 'block'; ?>">
                    <a class="fc-icon" href ="<?php echo $social['url']; ?> ">
                        <img src="<?php echo LBK_FC_URL . 'assets/images/' . $social['image'];  ?>">
                    </a>
                    <span class="fc-social-tooltip"><?php echo $social['title'];?></span>
                </div>

            <?php
            }
        ?>
            <div class = "fc-icon-wrapper fc-toggle-btn <?php echo $toggle__effect !== 'none' ? ('fc-animation '.$toggle__effect) : ''; ?>" style="width: <?php echo esc_attr($icon_size); ?>; height: <?php echo esc_attr($icon_size)?>"  >
                <div class="fc-icon ">
                    <img src="<?php echo LBK_FC_URL . 'assets/images/message.svg'; ?>">
                </div> 
                <span class="fc-social-tooltip">Contact Us!</span>
            </div>
        </div>
    </div>
    
<?php }
add_action( 'wp_footer', 'lbk_fc_template', 188 );
