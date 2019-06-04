/* 
 * DCE EDITOR
 * dynamic.ooo
 */

var dce_model_cid = null;

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
function getUrlParam(parameter, defaultvalue){
    var urlparameter = defaultvalue;
    if(window.location.href.indexOf(parameter) > -1){
        urlparameter = getUrlVars()[parameter];
    }
    return urlparameter;
}

function dce_disable_save_button() {
    // enable save buttons
    jQuery('#elementor-panel-saver-button-publish, #elementor-panel-saver-button-save-options, #elementor-panel-saver-menu-save-draft').addClass('elementor-saver-disabled').prop('disabled', true);
    return true;
}

function dce_enable_save_button() {
    // enable save buttons
    console.log('enable save button');
    jQuery('#elementor-panel-saver-button-publish, #elementor-panel-saver-button-save-options, #elementor-panel-saver-menu-save-draft').removeClass('elementor-saver-disabled').removeClass('elementor-disabled').prop('disabled', false).removeProp('disabled');
    return true;
}

function dce_get_element_id_from_cid(cid) {
    var iFrameDOM = jQuery("iframe#elementor-preview-iframe").contents();
    var eid = iFrameDOM.find('.elementor-element[data-model-cid='+cid+']').data('id');
    return eid;
}

jQuery(window).on( 'load', function() {
        
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
            //console.log( $scope );
        } );
        
        elementor.hooks.addAction( 'panel/open_editor/section', function( panel, model, view ) {
            //console.log(model);
            var cid = model.cid;
            dce_model_cid = cid;
        } );
        elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {
            //console.log(model);
            var cid = model.cid;
            dce_model_cid = cid;
            //var $element = view.$el.find( '.elementor-selector' );
            //console.log($element);
        } );
});

/*
function dce_popup_toggle(cid, navigator) {
    var settings = elementorFrontend.config.elements.data[cid].attributes;
    if (change_data) {
        if (settings['show_popup_editor']) {
            elementorFrontend.config.elements.data[cid].attributes['show_popup_editor'] = '';
        } else {
            elementorFrontend.config.elements.data[cid].attributes['show_popup_editor'] ='yes';
        }
    }
    //dce_menu_list_item_toggle(cid);
    if (navigator) {
        elementor_navigator_element_toggle(cid);
    }
    var eid = dce_get_element_id_from_cid(cid);
    return true;
}
function elementor_navigator_element_toggle(cid) {
    //alert('toggleVisibility');
    jQuery('.elementor-navigator__element[data-model-cid='+cid+']').trigger('request:toggleVisibility');
}
*/

/******************************************************************************/

// RAW PHP
jQuery(window).load(function() {
    var iFrameDOM = jQuery("iframe#elementor-preview-iframe").contents();
    //console.log(elementor);
    if (jQuery('#elementor-preview-iframe').length) {
        setInterval(function(){
            if (iFrameDOM.find("div.elementor-widget-dce-rawphp").length) { 
                if (iFrameDOM.find("div.elementor-widget-dce-rawphp.elementor-loading").length) { 
                    //&& iFrameDOM.find("div[data-id=<?php echo $this->get_id(); ?>]").hasClass('elementor-loading')) {
                    dce_disable_save_button();
                    jQuery('#elementor-panel-saver-button-publish').addClass('elementor-saver-disabled-dce');
                    jQuery('.dce-notice-phpraw').slideDown();
                    //console.log('errore');
                } else {
                    if (jQuery('#elementor-panel-saver-button-publish').hasClass('elementor-saver-disabled-dce')) {
                        dce_enable_save_button();
                        jQuery('#elementor-panel-saver-button-publish').removeClass('elementor-saver-disabled-dce');
                    }
                    jQuery('.dce-notice-phpraw').slideUp();
                }
            }
            //console.log('controllato php_raw');
        }, 1000);
    }
});

/******************************************************************************/
    
// VISIBILITY HELPERS
function dce_visibility_is_hidden(cid) {   
    var settings = elementorFrontend.config.elements.data[cid].attributes;
    //console.log(cid);console.log(settings);
    if (settings['enabled_visibility']) { // && settings['dce_visibility_hidden']) {
        //if (Extensions\DCE_Extension_Visibility::is_hidden($settings)) {
            return true;
        //}
    }
    return false;
}
function dce_visibility_toggle(cid, change_data) {
    var settings = elementorFrontend.config.elements.data[cid].attributes;
    if (change_data) {
        if (settings['enabled_visibility']) {
            elementorFrontend.config.elements.data[cid].attributes['enabled_visibility'] = '';
        } else {
            elementorFrontend.config.elements.data[cid].attributes['enabled_visibility'] = 'yes';
            elementorFrontend.config.elements.data[cid].attributes['dce_visibility_hidden'] = 'yes';
        }
    }
    
    dce_menu_list_item_toggle(cid);
    dce_navigator_element_toggle(cid);
    
    // color element hidden
    var eid = dce_get_element_id_from_cid(cid);
    var iFrameDOM = jQuery("iframe#elementor-preview-iframe").contents();
    if (settings['enabled_visibility']) {
        iFrameDOM.find('.elementor-element[data-id='+eid+']').addClass('dce-visibility-hidden');
    } else {
        iFrameDOM.find('.elementor-element[data-id='+eid+']').removeClass('dce-visibility-hidden');
    }
    
    dce_enable_save_button();
    return true;
}
function dce_menu_list_item_toggle(cid) {
    var menu_item = jQuery('.elementor-context-menu[data-cid='+cid+'] .elementor-context-menu-list__item-visibility');
    // update icon
    menu_item.find('.elementor-context-menu-list__item__icon').children('.dce-icon-visibility').toggleClass('dce-icon-visibility-hidden').toggleClass('fa-eye').toggleClass('fa-eye-slash');

    // update text
    var text = (menu_item.find('.elementor-context-menu-list__item__icon').children('.dce-icon-visibility').hasClass('dce-icon-visibility-hidden')) ? 'Show' : 'Hide';
    menu_item.find('.elementor-context-menu-list__item__title').text(text + ' in frontend');
    
    return true;
}
function dce_navigator_element_toggle(cid) {
    //jQuery('.dce-elementor-navigator__element__toggle[data-cid='+cid+']').children('.dce-icon-visibility').toggleClass('dce-icon-visibility-hidden').toggleClass('fa-eye').toggleClass('fa-eye-slash');
    jQuery('.elementor-navigator__element[data-model-cid='+cid+'] > .elementor-navigator__item > .dce-elementor-navigator__element__toggle > .dce-icon-visibility').toggleClass('dce-icon-visibility-hidden').toggleClass('fa-eye').toggleClass('fa-eye-slash');
    jQuery('.elementor-navigator__element[data-model-cid='+cid+']').toggleClass('dce-visibility-hidden');
}
    
// VISIBILITY ADDONS    
jQuery(window).load(function() {
    var iFrameDOM = jQuery("iframe#elementor-preview-iframe").contents();
    setInterval(function(){
        // add navigator element toggle
        jQuery('.elementor-navigator__item').each(function(){
            if (!jQuery(this).hasClass('dce-visibility__item' )) {
                var element = jQuery(this).closest('.elementor-navigator__element');
                var cid = element.data('model-cid');    
                var eid = dce_get_element_id_from_cid(cid);
                //console.log('add quick visibility toggle for: '+ cid + ' - ' + eid);
                if (eid) {
                    // add button to force visibility
                    jQuery(this).children('.elementor-navigator__element__toggle').after(
                            '<div class="dce-elementor-navigator__element__toggle" data-cid="'+cid+' data-eid="'+eid+'"><i class="dce-icon-visibility fa fa-eye" aria-hidden="true"></i></div>'
                        );
                    jQuery(this).addClass('dce-visibility__item');

                    // check if element is just hidden
                    if (dce_visibility_is_hidden(cid)) {
                        console.log('check hidden for: '+ cid);
                        dce_navigator_element_toggle(cid);
                        iFrameDOM.find('.elementor-element[data-id='+eid+']').addClass('dce-visibility-hidden');//.addClass('dce-visibility-hidden');
                    }
                }
            }
        });

        // add context menu item
        jQuery('.elementor-context-menu').each(function(){
            if (!jQuery(this).find('.elementor-context-menu-list__item-visibility').length && dce_model_cid) {
                console.log('append visibility to context menu');
                
                var cid = dce_model_cid;
                //console.log('add cid to context menu: '+cid);
                jQuery(this).attr('data-cid', cid);
                jQuery(this).find('.elementor-context-menu-list__group-delete').append(
                    '<div class="elementor-context-menu-list__item elementor-context-menu-list__item-visibility" data-cid="'+cid+'"><div class="elementor-context-menu-list__item__icon"><i class="dce-icon-visibility fa fa-eye" aria-hidden="true"></i></div><div class="elementor-context-menu-list__item__title">Hide in frontend</div></div>'
                );

                if (dce_visibility_is_hidden(cid)) {
                    dce_menu_list_item_toggle(cid);
                }
                
                /*var menu_item = jQuery(this).find('.elementor-context-menu-list__item-visibility');
                menu_item.hide().slideDown();*/

            }
        });

    }, 1000);
    
    // get model CID on mouse dx click
    iFrameDOM.on('mousedown', '.elementor-element', function(event) {
        if (event.which == 3) {
            //iFrameDOM.find('body').on('contextmenu', function() {
            var eid = jQuery(this).data('id');
            var cid = jQuery(this).data('model-cid');
            var type = jQuery(this).data('element_type');
            dce_model_cid = cid;
            console.log(type + ' - ' + eid + ' - ' + cid);
            if (dce_model_cid) {
                return false;
            }
        }
        
    });

});

// VISIBILITY
jQuery(document).ready(function() {
    
    jQuery(document).on('click', '.dce-elementor-navigator__element__toggle', function() {
        var element = jQuery(this).closest('.elementor-navigator__element');
        var cid = element.data('model-cid');   
        var eid = jQuery(this).data('eid');
        //console.log('dce visibility navigator '+cid);
        dce_visibility_toggle(cid, true);
        return false;
    });

    jQuery(document).on('click', '.elementor-context-menu-list__item-visibility', function() {
        var cid = dce_model_cid;
        var menu_item = jQuery(this);
        //console.log('dce visibility context menu '+cid);
        dce_visibility_toggle(cid, true);
        return false;
    });
    
    jQuery(document).on('change', '.elementor-switch-input[data-setting=enabled_visibility]', function() {
        //var cid = jQuery(this).attr('id').split('-').pop();
        var cid = dce_model_cid;
        //console.log('dce visibility settings '+cid);
        dce_visibility_toggle(cid, false);
    });
    
    $(document).on('mousedown','.elementor-control-repeater_shape_path .elementor-repeater-fields, .elementor-control-repeater_shape_polyline .elementor-repeater-fields',function(){
            var repeater_index = $(this).index();

            // ------------
            var eid = dce_get_element_id_from_cid(dce_model_cid);
            var iFrameDOM = jQuery("iframe#elementor-preview-iframe").contents();
            var morphed = iFrameDOM.find('.elementor-element[data-id='+eid+'] svg.dce-svg-morph');
            // ------------
            morphed.attr('data-morphid',repeater_index).trigger('changeDataMorph');

        
            //morphed.data("morphid", repeater_index).trigger('changeDataMorph');

            //alert(morphed.attr('class')+repeater_index);
            //alert(eid);
            //alert( $(this).index() );
        });

    $(document).on('change','.elementor-control-playpause_control',function(){
            var runAnimation = elementorFrontend.config.elements.data[dce_model_cid].attributes['playpause_control'];

            // ------------
            var eid = dce_get_element_id_from_cid(dce_model_cid);
            var iFrameDOM = jQuery("iframe#elementor-preview-iframe").contents();
            var morphed = iFrameDOM.find('.elementor-element[data-id='+eid+'] #dce-svg-'+eid);
            // ------------
            morphed.attr('data-run',runAnimation).trigger('changeDataMorphRun');

            //morphed.data("run", runAnimation).trigger('changeData'); 
            //alert(morphed.attr('class')+repeater_index);
            //alert(eid);
            //alert( runAnimation );
        });
});

/******************************************************************************/

/*
// POPUP
jQuery(document).ready(function() {
    
    jQuery(document).on('click', '.elementor-navigator__element__toggle', function() {
        var element = jQuery(this).closest('.elementor-navigator__element');
        var cid = element.data('model-cid');   
        var eid = jQuery(this).data('eid');
        //console.log('dce visibility navigator '+cid);
        dce_popup_toggle(cid, true);
    });
    
    jQuery(document).on('change', '.elementor-switch-input[data-setting=show_popup_editor]', function() {
        //var cid = jQuery(this).attr('id').split('-').pop();
        var cid = dce_model_cid;
        //console.log('dce visibility settings '+cid);
        dce_popup_toggle(cid, false);
    });
    
});
*/

