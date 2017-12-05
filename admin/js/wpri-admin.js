function wpri_get_report() {
	jQuery.post(
		wpri.ajaxurl,
		{
			'action': 'get_report',
			'data':   {'report_form' : report_form}
		},
		function(response){
		   // location.reload();
		   alert('The server responded: ');
		}
	);


}
