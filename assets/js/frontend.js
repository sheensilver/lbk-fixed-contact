(function($) {
    jQuery(document).ready(function($) { 
        $.fn.hasAttr = function(name) {  
           return this.attr(name) !== undefined;
        };

        $('.fc-toggle-btn').click(function () {
            $('.fc-icon-wrapper').not('.fc-toggle-btn').slideToggle(150);
        });
        if( $('.lbk-fc-wrapper').hasAttr('data-delay') ) {
            var delayTime = Number($('.lbk-fc-wrapper').attr('data-delay'))*1000;
            setTimeout(function(){ $('.lbk-fc-wrapper').show() }, delayTime);
        }else {
            $('.lbk-fc-wrapper').show();
            console.log( "s" );
        }

        
        
    });
})(jQuery);