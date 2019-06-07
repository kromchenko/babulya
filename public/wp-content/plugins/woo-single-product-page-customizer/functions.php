<?php
if( !defined( 'ABSPATH' ) ) exit;

function wsppc_get_hook()
{
	return get_option('wsppc_hook');
}
function  wsppc_error_message($msg)
{
	echo '<div class="notice notice-success wsppc-error-msg is-dismissible"><p> ' . $msg . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';	
	
}
function  wsppc_success_message($msg)
{
	echo '<div class="notice notice-success wsppc-success-msg is-dismissible"><p> ' . $msg . '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text"> Dismiss this notice.</span></button></div>';		
	
	
}

function wsppc_get_hook_value($hook)
{
	$all_hook=wsppc_get_hook();
	return $all_hook[$hook];
}

function wsppc_output($meta){
	
	if ( empty( $meta ) ) {
		return;
	}
	if ( trim( $meta ) == '' ) {
		return;
	}
 
	// Output
	return html_entity_decode(wp_unslash( $meta ));
	
}
?>