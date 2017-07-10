$(document).ready(function() {
	// $('[data-toggle="popover"]').popover({html:true});

    $('#torrent_on').hide();
	$('#update_msg').hide();
	$('#update_on').hide();

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
});

$('#update_item').click(function() {
	$('#torrent_off').hide();
	$('#comment_msg').hide();
	$('#update_off').hide();

	$('#torrent_on').show();
	$('#update_msg').show();
	$('#update_on').show();
});

$('#update_undo').click(function() {
	$('#update_name').val($('#torrent_name').html());
	$('#update_desc').val($('#torrent_desc').html());
	$('#update_msg').val($('#comment_msg').html());
});

$('#update_cancel').click(function() {
	$('#torrent_on').hide();
	$('#update_msg').hide();
	$('#update_on').hide();

	$('#torrent_off').show();
	$('#comment_msg').show();
	$('#update_off').show();
});

$('#issue_back').click(function() {
	$.post('', {},
	function(data, status) {
		window.location.href = 'admin.php';
	});
});

$('#update_save').click(function() {
	$.post('',
	{
		update_save: $(this).val(),
		category: $(this).val(),
		category_id: $('[name="category_id"]').val(),
		name: $('#update_name').val(),
		description: $('#update_desc').val(),
		message: $('#update_msg').val(),
		fkey: $('#item_id').val()
	},
	function(data, status) {
		window.location.href = 'admin.php';
	});
});

$('#post_comment').click(function() {
	$.post('',
	{
		post_comment: $(this).val(),
		message: $('#comment_msg').val(),
		torrent_id: $('#torrent_id').val()
	},
	function(data, status) {
		window.location.href = 'torrent.php';
	});
});

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
		window.location.href = 'torrent.php';
	});
});

$('#send_response').click(function() {
	$.post('',
	{
		send_response: $(this).val(),
		subject: $('#subject').val(),
		message: $('#message').val(),
		message_id: $('#message_id').val()
	},
	function(data, status) {
		window.location.href = 'admin.php';
	});
});


// Modal: Cover

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
