var app = {

	lastview: $('#mainview'),
	itemurl: '',
	rowurl: '',
	
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
	setupForm: function(frm, flds, err, succ, finish) {
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

						if(typeof finish === 'function') { finish(); }
					}
					else { app.displayErrors(err, data.message); }
				});
			}

			if(typeof succ !== 'undefined') {
				setTimeout(function() {
					succ.removeClass('show');
					err.removeClass('show');
				}, 3000);
			}
		});
	},

	loadPage: function(cont) {
		par = cont.closest('.views');
		$('.views').each(function() {
			if(!$(this).hasClass('vhide') && $(this).attr('id') !== par.attr('id')) { 
				$(this).addClass('lastview').addClass('vhide');
				app.lastview = $(this);
			}
		});
		par.removeClass('vhide');
	},

	clearEdit: function() {
		$('#topview').data('new', 'true');
		$('#item-edit-id').val('0');
		$('#item-edit-title').val('');
		$('#item-edit-body').val('');
		$('#item-edit-due').val('');
		$('#item-edit-status-false').prop('checked', true);
		$('#item-edit-status-true').prop('checked', false);
		$('#item-edit-title').removeClass('error');
		$('#item-edit-due').removeClass('error');
		$('#tag-edit-container').empty();
	},

	loadRows: function() {
		data = {'order': $('.sortrow.active').data('sort'), 'dir': $('.sortrow.active').data('dir')};
		$.ajax({
			url: app.rowurl,
			data: data,
			dataType: 'html',
			type: 'GET'
		}).done(function(data) {
			$('#rowwrap').empty();
			$('#rowwrap').html(data);
		});
	},

	sortRows: function(fld) {
		if(fld.hasClass('active')) {
			if(fld.data('dir') == 'ASC') fld.data('dir', 'DESC');
			else fld.data('dir', 'ASC');
		}
		$('.sortrow.active').removeClass('active');
		fld.addClass('active');
		app.loadRows();
	},

	loadEdit: function(id, finish) {
		app.clearEdit();
		$.ajax({
			url: app.itemurl,
			data: {'id': id},
			dataType: 'json',
			type: 'GET'
		}).done(function(data) {
			if(data.status == 'success') {
				$('#topview').data('new', 'false');
				$('#item-edit-id').val(data.item.id);
				$('#item-edit-title').val(data.item.title);
				$('#item-edit-body').val(data.item.body);
				$('#item-edit-due').val(data.item.due);
				if(data.item.status == '0') { $('#item-edit-status-false').prop('checked', true); }
				else { $('#item-edit-status-true').prop('checked', true); }
				$('#tag-edit-container').empty();
				$.each(data.item.taglinks, function() {
					app.addTag($('#tag-edit-container'), this, true);
				});

				if(typeof finish === 'function') { finish(); }
			} else {
				app.displayErrors($('#error-box'), data.message);
				setTimeout(function() {
					$('#error-box').removeClass('show');
				}, 3000);
			}
		});
	},

	loadView: function(id, finish) {
		$.ajax({
			url: app.itemurl,
			data: {'id': id},
			dataType: 'json',
			type: 'GET'
		}).done(function(data) {
			if(data.status == 'success') {
				$('#item-edit-btn').data('id', data.item.id);
				$('#item-show-title').html(data.item.title);
				$('#item-show-body').html(data.item.body);
				$('#item-show-due').html(data.item.due);
				if(data.item.status == '0') { 
					$('#item-show-status-false + label').show();
					$('#item-show-status-true + label').hide();
				} else {
					$('#item-show-status-false + label').hide();
					$('#item-show-status-true + label').show();
				}
				$('#item-show-author').html(data.item.user.name);
				$('#tag-view-container').empty();
				$.each(data.item.taglinks, function() {
					app.addTag($('#tag-view-container'), this, false);
				});

				if(typeof finish === 'function') { finish(); }
			} else {
				app.displayErrors($('#error-box'), data.message);
				setTimeout(function() {
					$('#error-box').removeClass('show');
				}, 3000);
			}
		});
	},

	loadNew: function(url) {
		app.clearEdit();
		resp = app.sendPost(url, {});
		resp.done(function(data) {
			$('#item-edit-id').val(data.item.id);
			$('#topview').data('new', 'true');
			app.loadPage($('#topview'));
		});
	},

	addTag: function(cont, taglink, edit) {
		tag = $('<div class="tag" data-id="'+taglink.id+'">'+taglink.tag.name+'</div>');
		if(edit === true) {
			tag.append('<span class="tagdel">X</span>');
		}
		cont.append(tag);
	}

};