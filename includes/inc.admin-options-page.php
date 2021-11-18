<div id="lbkfc" class="wrap">
    <h1><?php _e( 'LBK Fixed Contact', 'lbk-fc' ); ?></h1>
    <div class="fixed-contact-container">
        <div class ="left-group">
            <h2>Choise Socials</h2>
            <div class="social-icons flex">
                <?php 

                    $socials_info = unserialize(get_option('lbk_fc_defaulf_socials'));
                    $socials_data = unserialize(get_option('lbk_fc_setting_data'));

                    foreach ($socials_info as $index => $social_info) {
                        foreach ($socials_data['list_socials'] as $key => $social_data) {
                            if( $social_info['slug'] == $social_data['slug'] ) {
                                $activeClass = true;
                                break;
                            }
                        }
                        ?>
                            <div class ="social-icon <?php echo $activeClass ? 'active' : '' ?>" active-attr= <?php echo $activeClass ? 'true' : 'false' ?> social-key=<?php echo esc_html()($social_info['slug']) ?>  social-index=<?php echo esc_attr($index); ?>>
                                <img src="<?php echo esc_url(LBK_FC_URL . 'assets/images/' . $social_info['image']); ?>" style="width: 40px; height: 40px; margin: auto;">
                                <span class="tooltip"><?php echo esc_html($social_info['title']); ?></span>
                            </div>
                        <?php
                        $activeClass = false;
                    }
                ?>
            </div>
            <div class= "fc-setting-data">

                <div class ="icons-setting"></div>
                <div class="fc-setting" style="padding-top: 30px; border-top: 2px solid">
                    <h2>Fixed contact setting</h2>
                    <div class="fc-input-group fc-position"> 
                        <span class="fc-field-label"> Position </span>
                        <div class="select">
                            <select class="input-element" data-field="fcPosition">
                                <option value = "right-bottom" >Right Bottom</option>
                                <option value = "right-center" >Right Center</option>
                                <option value = "left-bottom" >Left Bottom</option>
                                <option value = "left-center" >Left Center</option>
                            </select>
                        </div>
                    </div>
                    <div class="fc-input-group fc-icon-size">
                        <span class="fc-field-label"> Icons Size </span>
                        <div class="select">
                            <select class="input-element" data-field="fcIconSize">
                                <option value = "35px" >Small</option>
                                <option value = "45px" >Normal</option>
                                <option value = "55px" >Large</option>
                                <option value = "55px" >XLarge</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="fc-input-group">
                        <span class="fc-field-label"> Toggle Icon Effects </span>
                        <div class="select">
                            <select class="input-element" data-field="iconListEffect">
                                <option value = "none" >None</option>
                                <option value = "fc-flash" >Flash</option>
                                <option value = "fc-zoomInOut" >Zoom In Out</option>
                                <option value = "fc-fade" >Fade</option>
                                <option value = "fc-shake" >Shake</option>
                                <option value = "fc-spin" >Spin</option>
                                <option value = "fc-bounce" >Bounce</option>
                            </select>
                        </div>   
                    </div>                
                    <div class="fc-trigger">
                        <div class="fc-input-group">
                            <span class="fc-field-label"> State </span>
                            <div class="switch-field">
                                <input class="input-element" type="radio" id="fcTriggerState-1" data-field="fcTriggerState" name="fcTriggerState" value="default" checked/>
                                <label for="fcTriggerState-1">Default</label>
                                <input class="input-element" type="radio" id="fcTriggerState-2" data-field="fcTriggerState" name="fcTriggerState"  value="click" />
                                <label for="fcTriggerState-2">Click</label>
                            </div>
                        </div>
                        <div class="fc-input-group">
                            <span class="fc-field-label"> Delay</span>
                            <div class="switch-field">
                                <input class="input-element" type="radio" id="fcTriggerDelayStatus-1" data-field="fcTriggerDelayStatus" name="fcTriggerDelayStatus" value="true" checked/>
                                <label for="fcTriggerDelayStatus-1">On</label>
                                <input class="input-element" type="radio" id="fcTriggerDelayStatus-2" data-field="fcTriggerDelayStatus" name="fcTriggerDelayStatus" value="false" />
                                <label for="fcTriggerDelayStatus-2">Off</label>
                            </div>
                        </div>
                        <div class="fc-input-group">
                            <span class="fc-field-label"> Delay Times </span>
                            <input class="input-element" type="number" class="input-element" data-field="fcTriggerDelayTime" value="<?php echo esc_attr($socials_data['fc_trigger']['delay']['time']); ?>" style="max-width: 45px; text-align: center"/> seconds
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="button save-all fc-save-setting">Save all</a>
        </div>
        <div class ="right-group">
            <div class="fc-preview-screen">
                <div class="fc-preview-inner">   
                    <div class="device-button-group">
                        <span class="device-button desktop active">
                            Desktop
                        </span>
                        <span class="device-button mobile">
                            Mobile
                        </span>
                    </div>
                    <div class="list-icons"></div>
                </div>
            </div>
        </div>
        <div class="fc-overlay-wrapper">
            <div class="fc-overlay-inner">
                <div class="fc-overlay">
                    <div class="fc-spin-icon fc-spin"></div>
                    <div class="fc-finished" style="display: none"><img width="100" height="100" src="<?php echo esc_url(LBK_FC_URL . 'assets/images/checked.svg'); ?>" /></div>
                    <div class="message">Đang lưu ... </div>
                </div>
            </div>
        </div>
   </div>

    <script type="text/javascript">
        (function($){
            $(document).ready(function(){

                var socialsData = <?php echo json_encode($socials_info,JSON_FORCE_OBJECT);?>;
                var fcOptions = <?php echo json_encode($socials_data);?>;

                console.log(fcOptions.list_socials);

                buildingSettingIcons(fcOptions.list_socials);
                
                $('.social-icon').click(function(){

                    iconSlug = $(this).attr('social-key');
                    toggleIconBySlug( iconSlug, fcOptions.list_socials, socialsData );
                });

                $('.icons-setting ').on('click', '.close-button',  function() {

                    iconSlug = $(this).attr('social-slug-data');
                    toggleIconBySlug( iconSlug, fcOptions.list_socials, socialsData);
                });

                $('.icons-setting ').on('click', '.up-button',  function() {

                    iconIndex = $(this).attr('social-index-data');
                    moveUpIcon( Number(iconIndex), fcOptions.list_socials );
                });

                $('.icons-setting ').on('click', '.down-button',  function() {
                    
                    iconIndex = $(this).attr('social-index-data');
                    moveDownIcon( Number(iconIndex), fcOptions.list_socials );
                });

                $('.icons-setting').on('keyup', 'input',  function() {

                    field = $(this).attr('input-field-data');
                    socialIcon = $(this).parent().attr('social-slug-data');
                    socialIndex = $(this).parent().attr('social-index-data');
                    // console.log($(this).val());

                    bindingInputData( field, Number(socialIndex), fcOptions , $(this) );
                });
                $('.fc-setting').on('change', '.input-element', function() {
                    field = $(this).attr('data-field');
                    bindingInputData( field, null , fcOptions, $(this));
                    console.log(fcOptions.fc_position);
                })

                $('.device-button').click(function() {
                    $('.device-button').removeClass('active');
                    $(this).addClass('active'); 

                    if( $(this).hasClass('mobile')) {
                         $('.fc-preview-screen').css("height", "622.2px");
                    }else {
                        $('.fc-preview-screen').css("height", "197px");
                    }
                   
                });
                $('.list-icons').addClass(fcOptions.fc_position);
                $('.save-all').click(function(){

                    $.ajax({
                        type : "post", //Phương thức truyền post hoặc get
                        dataType : "json", 
                        url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                        data : {
                            action: "fixed_contact_admin", //Tên action
                            settingData : fcOptions ,//Biến truyền vào xử lý. $_POST['website']
                        },
                        context: this,
                        beforeSend: function(){
                            $('.fc-overlay-wrapper').show();
                        },
                        success: function(response) {
                            
                            if(response.success) {

                                console.log(response.data);
                            }
                            else {
                                alert('Đã có lỗi xảy ra');
                            }
                            var successIcon = '<img width="100" height="100" src= "'+ "" +'"/>';

                            $('.fc-overlay-wrapper .fc-spin-icon').hide();
                            $('.fc-overlay-wrapper .fc-finished').show();
                            $('.fc-overlay-wrapper .message').html('Đã lưu');

                            setTimeout(function(){
                                $('.fc-overlay-wrapper').hide(); 
                                $('.fc-overlay-wrapper .fc-spin-icon').show();
                                $('.fc-overlay-wrapper .fc-finished').hide();
                            }, 1000);
                            

                            
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            //Làm gì đó khi có lỗi xảy ra
                            console.log( 'The following error occured: ' + textStatus, errorThrown );
                        }
                    })
                    return false;
                });

            })

            // Function 
            function buildingSettingIcons(listIcons) {      

                var socialsItem = '';

                listIcons.forEach( ({title, slug, url, placeholder}, index) => {
                    socialsItem += '<div class = "social-setting" social-slug-data ="' + slug + '" social-index-data ="' + index + '"><span class="social-title">' + title + '</span><input type="text" value="' + url + '" placeholder="' + placeholder + '" input-field-data ="url" /><span class ="close-button" social-slug-data ="' + slug + '"><img src="<?php echo esc_url(LBK_FC_URL. 'assets/images/close.svg'); ?>" /></span><span class ="up-button" social-index-data ="' + index + '"><img src="<?php echo esc_url(LBK_FC_URL . 'assets/images/arrow-up.svg'); ?>" /></span><span class ="down-button" social-index-data ="' + index + '"><img style="transform: rotate(180deg)" src="<?php echo esc_url(LBK_FC_URL . 'assets/images/arrow-up.svg'); ?>" /></span></div><div></div>';
                    $('.icons-setting').html(socialsItem);
                }); 

                listIcons.length == 0 ? $('.icons-setting').html('') : '';
                previewFc(listIcons);

            }


            function toggleIconBySlug( iconKey, listIcons, defaultListIcons ) { 

                var socialIcons = $('.social-icons .social-icon');

                socialIcons.each( function( index )  {

                    if( $( this ).attr('social-key') === iconKey ) {

                        if( $( this ).hasClass( 'active' ) ) {

                            $( this ).removeClass('active');
                            $( this ).attr("active-attr", 'false');

                            var existSocial = listIcons.findIndex( ({ slug }) => slug == iconKey);
                
                            if( existSocial !== -1 ) {
                                listIcons.splice( existSocial, 1 );
                            }

                        }else {
                            
                            if( listIcons.length >= 6) {
                                addMore = confirm("Số lượng nền tảng quá nhiều. OK nếu bạn muốn tiếp tục");
                                if( addMore == false ) {
                                    return false;
                                }
                                console.log(addMore);
                            }
                             
                            $( this ).addClass('active');
                            $( this ).attr("active-attr", 'true');

                           listIcons.push(defaultListIcons[index]);
                                               
                        } 
                    }
                });

                buildingSettingIcons( listIcons );
            }

            function moveUpIcon( index, listIcons ) {
                if ( listIcons.length >= 2 && index > 0) {

                    var socialIcon = listIcons.splice( index, 1 );
                    
                    listIcons.splice( index - 1, 0, socialIcon[0] );

                    buildingSettingIcons( listIcons );
                }
            }
            function moveDownIcon( index, listIcons ) {
                if ( listIcons.length >= 2 && index < listIcons.length - 1) {

                    var socialIcon = listIcons.splice( index, 1 );
                    
                    listIcons.splice( index + 1, 0, socialIcon[0] );

                    buildingSettingIcons( listIcons );
                }
            }
            function bindingInputData(field , index , fcData,  input) {                

                if(field == 'url') {
                    fcData.list_socials[index].url = input.val();
                }
                if(field == 'placeholder') {
                    fcData.list_socials[index].placeholder = input.val();
                }
                if(field == 'fcPosition'){
                    fcData.fc_position = input.val();
                    var listIcon = $('.list-icons');
                    listIcon.removeAttr('class');
                    listIcon.addClass('list-icons ');
                    listIcon.addClass(fcData.fc_position);
                }
                if(field == 'fcIconSize') {
                    fcData.social_icon_size = input.val();
                }
                if(field == 'iconListEffect') {
                    fcData.toggle_icon_effect = input.val();
                }
                if(field == 'fcTriggerState') {
                    fcData.fc_trigger['state'] = input.val();
                }
                if(field == 'fcTriggerDelayStatus') {
                    fcData.fc_trigger['delay'].status = input.val();
                }
                if(field == 'fcTriggerDelayTime') {
                    fcData.fc_trigger['delay'].time = input.val();
                }
            }
            function previewFc (socialIcons) {
                console.log(socialIcons);
                socialsItem = '';
                socialIcons.forEach( ({slug,image}, index) => {
                    socialsItem += '<div class = "icon" social-slug-data ="' + slug + '" ><img src="' + "<?php echo esc_url(LBK_FC_URL) . 'assets/images/'; ?>" + image + '"/></div>';   
                });
                socialsItem += '<div class = "icon toggle-icon"><img src="' + "<?php echo esc_url(LBK_FC_URL . 'assets/images/message.svg'); ?>" + '"/></div>';

                $('.fc-preview-inner .list-icons').html(socialsItem);

                var togglebtn = $('.fc-preview-inner .toggle-icon');

                togglebtn.click( function() {
                    $('.fc-preview-inner .icon').each(function() {
                        $(this).not(".toggle-icon").slideToggle(150);
                    });
                } );
            }

        })(jQuery)
    </script>

   
</div>