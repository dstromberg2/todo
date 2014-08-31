var app = {
	
	// Check for empty values in required fields
	checkFields: function(flds, errfld) {
		err = false;
		for (var i = 0; i < flds.length; i++) {
			if(!$.trim(flds[i].val()).length) {
				err = true;
				flds[i].addClass('error');
			} else {
				flds[i].removeClass('error');
			}
		}
		if(err === true) { app.displayErrors(errfld, 'Please fill in the highlighted fields'); }
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
	},

	// Parse error messages and display in the appropriate field
	displayErrors: function(fld, msg) {
		if(typeof msg === 'string') {
			err = msg;
		} else {
			err = '';
			$.each(msg, function() {
				err += $(this)[0]+'<br />';
			});
		}
		fld.html(err).addClass('show');
	},

	// Default actions for form submission
	setupForm: function(frm, flds, err, succ) {
		frm.submit(function(e) {
			// Make sure the form doesn't submit, then check for empty fields
			e.preventDefault();
			chk = app.checkFields(flds, err);
			if(chk === false) {
				// Send the data, then handle the response
				resp = app.sendPost($(this).attr('action'), $(this).serialize());
				resp.done(function(data) {
					if(data.status == 'success') { 
						if(data.redirect == 'true') { window.location.href = data.url; }
						else if(typeof succ !== 'undefined') { succ.addClass('show'); }
					}
					else { app.displayErrors(err, data.message); }
				});
			}
		});
	}
};