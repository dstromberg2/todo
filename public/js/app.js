var app = {
	
	// Check for empty values in required fields
	checkFields: function(flds) {
		err = false;
		for (var i = 0; i < flds.length; i++) {
			if(!$.trim(flds[i].val()).length) {
				err = true;
				flds[i].addClass('error');
			} else {
				flds[i].removeClass('error');
			}
		}
		return err;
	},

	// Send post data via ajax
	sendPost: function(url, data) {
		resp = $.ajax({
			url: url,
			data: data,
			dataType: 'json',
			type: 'POST'
		});
		return resp;
	}
};