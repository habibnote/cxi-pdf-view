let cx_plugin_modal = ( show = true ) => {
	if(show) {
		jQuery('#cx-plugin-modal').show();
	}
	else {
		jQuery('#cx-plugin-modal').hide();
	}
}

jQuery(function($){
	
	$('#cx-plugin_report-copy').click(function(e) {
		e.preventDefault();
		$('#cx-plugin_tools-report').select();

		try {
			if( document.execCommand('copy') ){
				$(this).html('<span class="dashicons dashicons-saved"></span>');
			}
		} catch (err) {
			console.log('Oops, unable to copy!');
		}
	});
})