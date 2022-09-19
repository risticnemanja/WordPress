/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {
    "use strict";
    // Update the site title in real time...
    wp.customize( 'APBDWCM_settings_cs_position', function( value ) {
        value.bind( function( newval ) {
            var position="";
            switch (newval){
                case 'LT':
                    position='apbd-mini-cart-top';
                    break;
                case 'LM':
                    position='';
                    break;
                case 'LB':
                    position='apbd-mini-cart-bottom';
                    break;
                case 'RT':
                    position='apbd-mini-cart-right apbd-mini-cart-top';

                    break;
                case 'RM':
                    position='apbd-mini-cart-right ';
                    break;
                case 'RB':
                    position='apbd-mini-cart-right apbd-mini-cart-bottom';
                    break;
            };
            $( '#apbd-mini-cart-container' )
                .removeClass("apbd-mini-cart-right")
                .removeClass("apbd-mini-cart-bottom")
                .removeClass("apbd-mini-cart-top").addClass(position);

            getStyle();

        } );
    } );

    wp.customize( 'APBDWCM_settings_cs_color', function( value ) {
        value.bind( function( newval ) {
            $('link[id^=apbd-woo-mini-cart-skin]').attr("href",apbd_customizer_mca_vars.skin[newval]);
        } );
    } );
    wp.customize( 'APBDWCM_settings_cs_drawer_type', function( value ) {
        value.bind( function( newval ) {
            $('link[id^=apbd-woo-mini-cart-frontend-css]').attr("href",apbd_customizer_mca_vars.type[newval]);
            if(newval=='F') {
                $("#apbd-mini-cart-container").addClass('apbd-floating-type');
            }else{
                $("#apbd-mini-cart-container").removeClass('apbd-floating-type');
            }
        } );
    });
    wp.customize( 'APBDWCM_settings_cs_control_size', function( value ) {
        value.bind( function( newval ) {
            getStyle();
        });
    });
    wp.customize( 'APBDWCM_settings_cs_border_radius', function( value ) {
        value.bind( function( newval ) {
            getStyle();
        });
    });
    wp.customize( 'APBDWCM_settings_cs_top_margin', function( value ) {
        value.bind( function( newval ) {
            getStyle();
        } );
    });
    wp.customize( 'APBDWCM_settings_cs_left_margin', function( value ) {
        value.bind( function( newval ) {
            getStyle();
        } );
    });



    wp.customize( 'APBDWCM_settings_cs_icon', function( value ) {
        value.bind( function( newval ) {
            $('#apbd-mini-cart-container .apbd-mca-icon > i').attr("class"," apmc "+newval);
            $('#apbd-mini-cart-container .apbd-mca-cart-title > i').attr("class"," apmc "+newval);
        } );
    } );
    wp.customize( 'APBDWCM_settings_cs_df_type', function( value ) {
        value.bind( function( newval ) {
           try{
               $('#apbd-mini-cart-container .apbd-mca-item-counter').html(apbd_customizer_mca_vars.dr_footer[newval]);
           }catch (e) {}

        } );
    } );
    wp.customize( 'APBDWCM_settings_cs_dr_anim', function( value ) {
        value.bind( function( newval ) {
            $('#apbd-mini-cart-container .apbd-mca-drawer-control').attr("class","apbd-mca-drawer-control  animated "+newval);
        } );
    } );
    wp.customize( 'APBDWCM_settings_cs_title_text', function( value ) {
        value.bind( function( newval ) {
            $("#apbd-mini-cart-container").addClass("apbd-mca-show");
            $('#apbd-mini-cart-container .apbd-mca-cart-title > span').text(newval);
        } );
    } );
    wp.customize( 'APBDWCM_settings_cs_hide_corner_circle', function( value ) {
        value.bind( function( newval ) {
           if(!newval){
               if($("#apbd-mini-cart-container .apbd-mca-icon > .apbd-qty-c").length==0) {
                   var newEntry = '<span class="apbd-qty-c">'+apbd_customizer_mca_vars.wc_qty+'</span>';
                   $("#apbd-mini-cart-container .apbd-mca-icon").append(newEntry);
               }else{
                   $("#apbd-mini-cart-container .apbd-mca-icon > .apbd-qty-c").show();
               }
           }else{
               $("#apbd-mini-cart-container .apbd-mca-icon > .apbd-qty-c").hide();
           }
        } );
    } );

    function getStyle(){
        if(wp.customize( 'APBDWCM_settings_cs_drawer_type').get()!="F"){
            return;
        }
        var position=wp.customize( 'APBDWCM_settings_cs_position').get();
        var size=parseInt(wp.customize( 'APBDWCM_settings_cs_control_size').get());
        var leftRightProperty="left";
        var left_or_right=parseInt(wp.customize( 'APBDWCM_settings_cs_left_margin').get());
        var left_ro_right_extra_rule='right: unset !important;'
        if(['RM','RB','RT'].indexOf(position)>-1){
            leftRightProperty="right";
            left_ro_right_extra_rule='left: unset !important;'
        }
        var border_radius=parseInt(wp.customize( 'APBDWCM_settings_cs_border_radius').get());
        var topMargin=parseInt(wp.customize( 'APBDWCM_settings_cs_top_margin').get());
        var marginTopProperty='margin-top';
        var marginTopFinal=0;
        var bottomRule="";

        var newstryle='#apbd-mini-cart-container.apbd-floating-type:not(.apbd-mca-show) .apbd-mini-cart-ajax .apbd-mca-drawer-control {'+
            'position: fixed !important;'+
            'width:'+size+'px !important;'+
            'height:'+size+'px !important;'+
            leftRightProperty+': '+left_or_right+'px !important;'+
            left_ro_right_extra_rule+
            '-webkit-border-radius: '+border_radius+'%;'+
            ' -moz-border-radius: '+border_radius+'%;'+
            'border-radius: '+border_radius+'%;'+
            'bottom: '+topMargin+'px  !important; '+
            '}';
        $("#apbd-woo-mini-cart-frontend-inline-css").html(newstryle);

    }
} )( jQuery );

