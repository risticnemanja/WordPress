function wmcAPBDCustomizerInitControl() {
    var v = wp.customize('APBDWCM_settings_cs_drawer_type').get();

    if (v == 'F') {
        var position = wp.customize('APBDWCM_settings_cs_position').get();
        if(['LB','LT'].indexOf(position)>-1){
            wp.customize('APBDWCM_settings_cs_position').set('LB');
        }
        if(['RB','RT'].indexOf(position)>-1){
            wp.customize('APBDWCM_settings_cs_position').set('RB');
        }

        wp.customize.control('APBDWCM_settings_cs_control_size').activate();
        wp.customize.control('APBDWCM_settings_cs_border_radius').activate();
        wp.customize.control('APBDWCM_settings_cs_top_margin').activate();
        wp.customize.control('APBDWCM_settings_cs_left_margin').activate();
        wp.customize.control('APBDWCM_settings_cs_df_type').deactivate();
        jQuery(".dr-footer-anim.apmc.ap-drawer:not(.apd-no-change)").removeClass("ap-drawer").addClass("ap-circle");
        jQuery("#_customize-input-APBDWCM_settings_cs_position-radio-LT,#_customize-input-APBDWCM_settings_cs_position-radio-LM,#_customize-input-APBDWCM_settings_cs_position-radio-RT,#_customize-input-APBDWCM_settings_cs_position-radio-RM").closest('.apbd-app-box-option').hide();

    } else {
        wp.customize.control('APBDWCM_settings_cs_control_size').deactivate();
        wp.customize.control('APBDWCM_settings_cs_border_radius').deactivate();
        wp.customize.control('APBDWCM_settings_cs_top_margin').deactivate();
        wp.customize.control('APBDWCM_settings_cs_left_margin').deactivate();
        wp.customize.control('APBDWCM_settings_cs_df_type').activate();
        jQuery(".dr-footer-anim.apmc.ap-circle:not(.apd-no-change)").removeClass("ap-circle").addClass("ap-drawer");
        jQuery("#_customize-input-APBDWCM_settings_cs_position-radio-LT,#_customize-input-APBDWCM_settings_cs_position-radio-LM,#_customize-input-APBDWCM_settings_cs_position-radio-RT,#_customize-input-APBDWCM_settings_cs_position-radio-RM").closest('.apbd-app-box-option').show();
    }
}
( function( api ) {
    'use strict';
    wp.customize.bind('ready', function() {

        wmcAPBDCustomizerInitControl();
        api('APBDWCM_settings_cs_drawer_type', function (setting) {
            setting.bind("change", function (v) {
                wmcAPBDCustomizerInitControl();
            });

        });
        jQuery("#accordion-section-apbd_mca_drawer").on("click",function(){
            wmcAPBDCustomizerInitControl();
        });
    });
}( wp.customize ) );

( function( $ ) {
    'use strict';
    try {
        jQuery( document ).ready(function( $ ) {
            $(".app-slider-input:not(.added-slider)").each(function(){
                var thisObj=$(this);
                $(this).addClass('added-slider');
                var slider = thisObj.find('>input[type=range]');
                var postFix=slider.data('unit')?slider.data('unit'):'';
                var valueFilter;
                try{
                    valueFilter=slider.data('format')?eval(slider.data('format')):function(value,postfix,type){
                        return value+postfix;
                    };
                }catch (e) {
                    valueFilter=function(value,postfix,type){
                        return value+postfix;
                    };
                }


                thisObj.append('<span class="app-slider-min-container">'+valueFilter(slider.attr('min'),postFix,'M')+'</span> ');
                thisObj.append('<span class="app-slider-max-container">'+valueFilter(slider.attr('max'),postFix,'X')+'</span> ');

                var currentValue=$('<span class="app-slider-current-container" ></span>');
                currentValue.html(valueFilter(slider.val(),postFix,'C'));
                thisObj.append(currentValue);
                slider.on("input",function(){
                    currentValue.html(valueFilter(slider.val(),postFix,'C'));
                });

            });

        });


    } catch (e) {
        console.log(e);
    }

}( jQuery ) );
