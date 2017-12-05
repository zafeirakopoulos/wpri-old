function wpri_get_report(report_form) {
	jQuery.post(
		wpri.ajaxurl,
		{
			'action': 'get_report',
			'data':  JSON.stringify({'report_form' : report_form})
		},
		// function(response){
		//    // location.reload();
		//    alert('The server responded: '+ response);
		// }
		function(response) {
			alert('The server responded: '+ response);
            var form = $jQuery('<form method="POST" action="' + url + '">');
            // jQuery.each(params, function(k, v) {
            //     form.append(jQuery('<input type="hidden" name="' + k +
            //             '" value="' + v + '">'));
            // });
			form.append(jQuery('<input type="hidden" name="excelfile" value="' + data['report_form'] + '">'));
	        jQuery('body').append(form);
            form.submit();

    	}
	);


}
