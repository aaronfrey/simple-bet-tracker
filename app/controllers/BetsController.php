<?php

class BetsController extends BaseController {

	public function store()
	{
		$input = Input::all();

		// echo('<pre>');
		// print_r($input);
		// echo('</pre>');
		// dd();

		$bet = new Bet;
		$bet->sport = $input['sport'];
		$bet->game_code = $input['game_code'];
		$bet->bet_type = $input['bet_type'];
		$bet->team = $input['team'];

		if($bet->bet_type === 'pointspread')
		{
			$bet->point_spread = $input['plusminus_pointspread'] == '-' ?
				-$input['point_spread'] : $input['point_spread'];
		}

		$bet->bet_amount = $input['bet_amount'] * 100;

		$bet->multiplier = $input['plusminus_multiplier'] === '-' ?
				-$input['multiplier'] : $input['multiplier'];

		$bet->win_potential = $input['win_potential'] * 100;

		$bet->save();
	}

}