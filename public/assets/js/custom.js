$(function() {

	var betModal = $('#bet-modal');

	betModal.modal({
		'show': false
	});

	betModal.on('hide.bs.modal', function (e) {
  	$(this).find('form').trigger('reset');
	});

	$(document).on('click', 'button.bet-option', function() {

		var teamBtn = $(this);
		var panel = teamBtn.parents('.panel');
		var panelBody = panel.find('.panel-body');
		var betType = teamBtn.parents('.bet-type').data('bet-type');

		if(betType === 'pointspread') {
			$('#pointspread').show();
		} else {
			$('#pointspread').hide();
		}

		// Set display text
		betModal.find('.modal-title').text(panel.find('.panel-title').text());
		$('#bet-type').text(betType.toUpperCase());
		$('#bet-team').text(teamBtn.data('team-display').toUpperCase());

		// Set form inputs
		betModal.find("input[name='sport']").val(panelBody.data('sport'));
		betModal.find("input[name='game_code']").val(panelBody.data('game-code'));
		betModal.find("input[name='bet_type']").val(teamBtn.parents('.bet-type').data('bet-type'));
		betModal.find("input[name='team']").val(teamBtn.data('team-id'));

		// Show the Bet Modal
		betModal.modal('show');
	});

	$('form').on('submit', function(event) {
  	event.preventDefault();

  	var form = $(this);

  	$.post($(this).attr('action'), $(this).serialize(), function(response) {
  		console.log(response);
  		betModal.modal('hide');
  		form.trigger("reset");
  	});

	});

	var calculate = function() {
		var bet = $("input[name='bet_amount']").val();
		var multiplier = $("input[name='multiplier']").val();
		var plusminus = $("input[name='plusminus_multiplier']:checked").val();

		if(bet && multiplier) {
			var total = 0;
			var betDecimal = Math.abs(multiplier / 100);

			if(plusminus === '+') {
				total = parseFloat(bet) * betDecimal;
			} else {
				total = parseFloat(bet) / betDecimal;
			}
			$("input[name='win_potential']").val(total.toFixed(2));
		}		
	};

	$('.calculate').on('keyup', function(event) {
		calculate();
	});

	$('.plusminus').on('change', function(event) {
		calculate();
	});

});