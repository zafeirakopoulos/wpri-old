function wpri_get_report(report_form) {
	jQuery.post(
		wpri.ajaxurl,
		{
			'action': 'get_report',
			'data':  JSON.stringify({'report_form' : report_form})
		},
		function(response){
		   // location.reload();
		   alert('The server responded: '+ response);
		}
	);


}
