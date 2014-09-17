$(function() {

	$('#bet-modal').modal({
		'show': false
	});

	$(document).on('click', 'button.bet-option', function() {
		$('#bet-modal').modal('show');
	});

});