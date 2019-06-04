( function( $ ) {
    var WidgetElementsPopupHandler = function( $scope, $ ) {


        var get_dce_ElementSettings = function( $element ) {
            var elementSettings = {},
                modelCID = $element.data( 'model-cid' );

            if ( elementorFrontend.isEditMode() && modelCID ) {
                var settings = elementorFrontend.config.elements.data[ modelCID ],
                    settingsKeys = elementorFrontend.config.elements.keys[ settings.attributes.widgetType || settings.attributes.elType ];

                jQuery.each( settings.getActiveControls(), function( controlKey ) {
                    if ( -1 !== settingsKeys.indexOf( controlKey ) ) {
                        elementSettings[ controlKey ] = settings.attributes[ controlKey ];
                    }
                } );
            } else {
                elementSettings = $element.data('settings') || {};
            }
            return elementSettings;
        }
        //

        function dce_getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        function dce_setCookie(cname, cvalue, exdays) {
            var d = new Date();
            //d.setTime(d.getTime() + (exdays*24*60*60*1000)); // in days
            d.setTime(d.getTime() + (exdays*1000)); // in seconds
            var expires = "expires="+ d.toUTCString()+";";
            if (!exdays) {
                expires = '';
            }
            document.cookie = cname + "=" + cvalue + ";" + expires + "path=/";
        }


        function dce_show_modal(id_modal) {
            var dce_popup_settings = get_dce_ElementSettings( $scope ); //jQuery('#'+id_modal).closest('.elementor-element').data('settings');

            //console.log('show modal: '+id_modal);
            var open_delay = 0;
            if (dce_popup_settings.open_delay) {
                open_delay = dce_popup_settings.open_delay;
            }
            setTimeout(function(){

                push_actions();

                //aggiungo al body la classe aperto
                if (!elementorFrontend.isEditMode()) {
                    jQuery('body').addClass('modal-open-'+id_modal).addClass('dce-modal-open');
                    jQuery('html').addClass('dce-modal-open');
                }
                if( dce_popup_settings.wrapper_maincontent ){

                    jQuery(dce_popup_settings.wrapper_maincontent).addClass('dce-push').addClass('animated').parent().addClass('perspective');
                }
                jQuery('#'+id_modal).show();
                //jQuery('#'+id_modal+' .modal-dialog').addClass(dce_popup_settings.open_animation); //modal();
                jQuery('#'+id_modal+'-background').show().removeClass('fadeOut').addClass('fadeIn');
            }, open_delay);
        }

        function dce_hide_modal(id_modal) {
            var dce_popup_settings = get_dce_ElementSettings( $scope ); //jQuery('#'+id_modal).closest('.elementor-element').data('settings');
            // set cookie
            console.log('set cookie for: '+id_modal);
            if (!dce_popup_settings.always_visible) {
                dce_setCookie(id_modal,1,dce_popup_settings.cookie_lifetime);
            }
            var settings_close_delay = 0;
            if (dce_popup_settings.close_delay) {
                settings_close_delay = dce_popup_settings.close_delay;
            }

            //levo dal body la classe aperto
            jQuery('body').removeClass('modal-open-'+id_modal);
            jQuery('body').addClass('modal-close-'+id_modal);

            //
            jQuery('#'+id_modal+' .modal-dialog').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(el){
                               jQuery('#'+id_modal).hide();
                               jQuery('#'+id_modal+'-background').hide()
                               //jQuery(el.currentTarget).removeClass(dce_popup_settings.close_animation);
                               jQuery(el.currentTarget).off('webkitAnimationEnd oanimationend msAnimationEnd animationend');

                               setTimeout(function(){
                                    if (!elementorFrontend.isEditMode()) {
                                        jQuery('body').removeClass('modal-close-'+id_modal).removeClass('dce-modal-open');
                                        jQuery('html').removeClass('dce-modal-open');
                                    }
                                    if( dce_popup_settings.wrapper_maincontent ) jQuery( dce_popup_settings.wrapper_maincontent ).removeClass('dce-push').removeClass('animated').parent().removeClass('perspective');

                                },300);

                            });

            setTimeout(function(){
                //alert(dce_popup_settings.close_animation);
                //jQuery('#'+id_modal+' .modal-dialog').removeClass(dce_popup_settings.open_animation).addClass(dce_popup_settings.close_animation); //modal();
                jQuery('#'+id_modal+'-background').removeClass('fadeIn').addClass('fadeOut');
            }, settings_close_delay);
        }



        /*document.addEventListener('DOMContentLoaded', function() {



        }, false);*/



        var elementSettings = get_dce_ElementSettings( $scope );


        //var dce_popup_settings = jQuery(this).closest('.elementor-element').data('settings');
        var modal = $scope.find('.dce-popup-container');

        //alert('... '+elementSettings);
        function push_actions() {
            /*if( typeof elementSettings.enabled_push !== 'undefined' &&  elementSettings.enabled_push){
                //alert(elementSettings.enabled_push);
                if(!jQuery('#dce-wrap').length){

                    // avvolgo il contenuto del body per poterlo spostare
                    jQuery('body').wrapInner('<div id="dce-outer-wrap"><div id="dce-wrap" class="dce-wrap-animated animated"></div></div>');
                    //sposto il modale fuori

                }
                // ....

            }*/
            if (!elementorFrontend.isEditMode()) {
                jQuery(modal).prependTo("body");
            }

        }




        // - * - * - * - * - * - * - * - * - * - * -


        // ON LOAD
        jQuery('.dce-popup-onload').each(function(){
            var dce_popup_settings = get_dce_ElementSettings( $scope ); //jQuery(this).closest('.elementor-element').data('settings');
            var id_modal = jQuery(this).find('.modal').attr('id');
            console.log('trigger onload for: '+id_modal);
            // read cookie
            var cookie_popup = dce_getCookie(id_modal);
            if (dce_popup_settings.always_visible) {
                cookie_popup = false;
            }
            if (!cookie_popup) {
                    dce_show_modal(id_modal);
            } else {
                console.log('cookie already setted for: '+id_modal);
            }
        });

        // BUTTON
        jQuery(document).on('click', '.dce-button-open-modal, .dce-button-next-modal', function() {
            var id_modal = jQuery(this).data('target')
            console.log('trigger click btn for: '+id_modal);
            //alert(id_modal);
            dce_show_modal(id_modal);
        });


        // WIDGET
        jQuery('.dce-popup-widget').each(function(){
            var id_modal = jQuery(this).find('.modal').attr('id');
            var dce_popup_settings = get_dce_ElementSettings( $scope ); //jQuery(this).closest('.elementor-element').data('settings');
            var cookie_popup = dce_getCookie(id_modal);

            if (dce_popup_settings.always_visible) {
                cookie_popup = false;
            }
            if (!cookie_popup) {
                jQuery(this).removeClass('dce-popup-widget');
                console.log('cookie setted for: '+id_modal);
            }
        });
        if (jQuery('.dce-popup-widget').length) {
            jQuery(window).on('load scroll resize', function(){
                jQuery('.dce-popup-widget').each(function(){
                    if (jQuery(this).visible()) {
                        jQuery(this).removeClass('dce-popup-widget');
                        var id_modal = jQuery(this).find('.modal').attr('id');
                        console.log('trigger widget for: '+id_modal);
                        dce_show_modal(id_modal);
                        //console.log('visible widget: '+id_modal);
                    }
                });
            });
        }

        // SCROLL
        if (jQuery('.dce-popup-scroll').length) {
            jQuery(window).on('scroll', function(){
                jQuery('.dce-popup-scroll').each(function(){
                    var dce_popup_settings = get_dce_ElementSettings( $scope ); //jQuery(this).closest('.elementor-element').data('settings');
                    if (jQuery(window).scrollTop() > dce_popup_settings.scroll_display_displacement) {
                        jQuery(this).removeClass('dce-popup-scroll');
                        var id_modal = jQuery(this).find('.modal').attr('id');
                        console.log('trigger scroll for: '+id_modal);
                        dce_show_modal(id_modal);
                        //console.log('visible scroll: '+id_modal);
                    }
                });
            });
        }

        jQuery(window).on('scroll', function(){
            jQuery('.modal-hide-on-scroll:visible').each(function(){
                jQuery(this).removeClass('modal-hide-on-scroll');
                dce_hide_modal(jQuery(this).attr('id'));
            });
        });

        jQuery(document).on('keyup',function(evt) {
            if (evt.keyCode == 27) {
                jQuery('.modal-hide-esc:visible').each(function(){
                    jQuery(this).removeClass('modal-hide-esc');
                    dce_hide_modal(jQuery(this).attr('id'));
                });
            }
        });

        jQuery(document).on('click', '.dce-modal .dce-modal-close, .dce-button-close-modal, .dce-modal .dce-button-next-modal', function() {
           dce_hide_modal(jQuery(this).closest('.dce-modal').attr('id'));
           //alert(jQuery(this).closest('.dce-modal').attr('id'));
        });

        jQuery(document).on('click', '.dce-modal-background-layer-close', function() {
           dce_hide_modal(jQuery(this).attr('data-target'));
        });

        // VIDEO
        /*(function($) {
                $('#popup-<?php echo $selectedPopup->post->ID; ?>').on('hide.bs.modal', function(e) {
                        var $if = $(e.delegateTarget).find('iframe');
                        var src = $if.attr("src");
                        $if.attr("src", '/empty.html');
                        $if.attr("src", src);
                });
        })(jQuery);*/

    }

    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/dyncontel-popup.default', WidgetElementsPopupHandler );
    } );
} )( jQuery );
