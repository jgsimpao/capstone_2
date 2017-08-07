$(document).ready(function() {

	// Initialize tooltips
	$('[data-toggle="tooltip"]').tooltip();

	// Show or hide basic / advanced search
	$('.basic-link').hide();
	$('.advanced-search').hide();

	$('.advanced-link').click(function() {
		$('.advanced-link').hide();
		$('.basic-search').hide();

		$('.basic-link').show();
		$('.advanced-search').show();
	});

	$('.basic-link').click(function() {
		$('.basic-link').hide();
		$('.advanced-search').hide();

		$('.advanced-link').show();
		$('.basic-search').show();
	});

	// Show or hide torrent / comment update panel
    $('#torrent_on').hide();
	$('#update_msg').hide();
	$('#update_on').hide();

	function resetUpdate() {
		$('select[name="category_id"]').val($('#item_category_id').val()).prop('selected', true);
		$('#update_name').val($('#torrent_name').html());
		$('#update_desc').val($('#torrent_desc').html());
		$('#update_msg').val($('#comment_msg').html());

		$('.upload_file > span').html('');

		if($('#category_name').val() == 'Torrent') {
			$('#upload_cover').wrap('<form>').closest('form').get(0).reset();
			$('#upload_cover').unwrap();

			$('#upload_torrent').wrap('<form>').closest('form').get(0).reset();
			$('#upload_torrent').unwrap();
		}
	}

	$('#update_item').click(function() {
		resetUpdate();

		$('#torrent_off').hide();
		$('#comment_msg').hide();
		$('#update_off').hide();

		$('#torrent_on').show();
		$('#update_msg').show();
		$('#update_on').show();
	});

	$('#update_undo').click(function() {
		resetUpdate();
	});

	$('#update_cancel').click(function() {
		$('#torrent_on').hide();
		$('#update_msg').hide();
		$('#update_on').hide();

		$('#torrent_off').show();
		$('#comment_msg').show();
		$('#update_off').show();
	});

	// Cover image and torrent file control handlers
	$('#upload_cover').inputFileText(
	{
		text: 'Choose Image File',
		buttonClass: 'btn btn-default'
	});

	$('#upload_torrent').inputFileText(
	{
		text: 'Choose Torrent File',
		buttonClass: 'btn btn-default'
	});

	$('#upload_cover').change(function() {
		var filename = $(this).val();
		var lastIndex = filename.lastIndexOf('\\');

		if (lastIndex >= 0) {
			filename = filename.substring(lastIndex + 1);
		}

		$('#update_cover').html(filename);
	});

	$('#upload_torrent').change(function() {
		var filename = $(this).val();
		var lastIndex = filename.lastIndexOf('\\');

		if (lastIndex >= 0) {
			filename = filename.substring(lastIndex + 1);
		}

		$('#update_torrent').html(filename);
	});

	// Go back to admin inbox
	$('#admin_back').click(function() {
		$.post('',
		function(data, status) {
			window.location.href = 'admin.php';
		});
	});

	// Go back to member inbox
	$('#member_back').click(function() {
		$.post('',
		function(data, status) {
			window.location.href = 'member.php';
		});
	});

	// Delete issue message
	$('#delete_issue').click(function() {
		$('.modal-body > p:first-child').html('Permanently delete this message?');
		$('.modal-body > p:last-child').html('');
	});

	// Delete item message
	$('#delete_item').click(function() {
		if($('#item_type').val() == 'Torrent' || $('#item_type').val() == 'Comment') {
			item = $('#item_type').val().toLowerCase();
		}

		$('.modal-body > p:first-child').html('Permanently delete this ' + item + '?');
		$('.modal-body > p:last-child').html('<em>(Warning! Deleting a ' + item + ' will also delete the associated inbox message.)</em>');
	});

	$('[id$="_ok"]').click(function() {
		var group = $(this).val();

		if(group != 'response') {
			$.post('',
			{
				delete_ok: group,
				id: $('#' + group + '_id').val(),
				type: $('#' + group + '_type').val(),
				fkey: $('#' + group + '_fkey').val(),
				source: $('#' + group + '_source').val(),
				image: $('#' + group + '_image').val(),
				group: $('#' + group + '_group').val()
			},
			function(data, status) {
				window.location.href = 'admin.php';
			});
		}
		else {
			$.post('',
			{
				delete_ok: group,
				id: $('#' + group + '_id').val(),
				group: $('#' + group + '_group').val()
			},
			function(data, status) {
				window.location.href = 'member.php';
			});
		}
	});

	function getQueryString() {
		var queryStr = window.location.search;
		var idx = queryStr.indexOf('torrent=');
		return queryStr.substr(idx);
	}

	// Report comment
	$('[name="report_comment"]').click(function() {
		var idx = $(this).val();

		$.post('',
		{
			report_comment: idx,
			subject: $('#subject_' + idx).val(),
			message: $('#message_' + idx).val(),
			comment_id: $('#comment_id_' + idx).val()
		},
		function(data, status) {
			window.location.href = 'torrent.php?' + getQueryString();
		});
	});

	// Modal: Cover Image
	var modal = document.getElementById('cover-modal');

	document.getElementById('cover').onclick = function() {
		modal.style.display = 'block';
		document.getElementById('cover-img').src = this.src;
		document.getElementById('cover-caption').innerHTML = this.alt;
	}

	document.getElementById('cover-close').onclick = function() {
		modal.style.display = 'none';
	}

	modal.onclick = function() {
		this.style.display = 'none';
	}

	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'), sParameterName, i;

		for(i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	};

});
