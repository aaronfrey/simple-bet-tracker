<?php

class BetsController extends BaseController {

	public function store()
	{
		$input = Input::all();
		$user = Confide::user();

		$bet = new Bet;
		$bet->user_id = $user->id;
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

		// Subtract the bet amount from the users current money
		$user->current_money -= $bet->bet_amount;
		$user->save();

		$bet->multiplier = $input['plusminus_multiplier'] === '-' ?
				-$input['multiplier'] : $input['multiplier'];

		$bet->win_potential = $input['win_potential'] * 100;

		$bet->save();
	}

	public function showCurrentBets()
	{
		// Get the current user
		$this->data['user'] = Confide::user();

		// Initialize the potential money that can be won as the current money the user has
		$this->data['potential_money'] = $this->data['user']->current_money;

		// Get all of the users outstanding bets
		$current_bets = Bet::where('user_id', '=', $this->data['user']->id)
			->where('final', false)
			->get();

		if($current_bets)
		{
			$this->data['bet_objects'] = [];

			// Get all of the games
			$repo = App::make('GameRepository');
			$pending_games = $repo->getPendingGames('NFL', '4');

			foreach($current_bets as $bet)
			{
				if(array_key_exists($bet->game_code, $pending_games))
				{
					// Get the game associated with the bet
					$game = $pending_games[$bet->game_code];
					$visiting_team = $game['visiting-team']['@attributes'];
					$home_team = $game['home-team']['@attributes'];

					if($visiting_team['id'] === $bet->team)
					{
						$picked_team = $visiting_team;
						$opposing_team = $home_team;
					}
					else
					{
						$picked_team = $home_team;
						$opposing_team = $visiting_team;
					}

					$bet_object = (object) [];

					$bet_object->bet = $bet;
					$bet_object->game = $game['gamestate']['@attributes'];
					$bet_object->visiting_team = $visiting_team;
					$bet_object->home_team = $home_team;
					$bet_object->picked_team = $picked_team;
					$bet_object->game_title = $visiting_team['display_name'].' '.
												   $visiting_team['nickname'].' at '.
												   $home_team['display_name'].' '.
												   $home_team['nickname'];

					if($bet->bet_type === 'pointspread')
					{
						$adjusted_team_score = $picked_team['score'] + $bet->point_spread;
					}
					else
					{
						$adjusted_team_score = $picked_team['score'];
					}

					// If this is a current winning bet
					if($adjusted_team_score > $opposing_team['score'])
					{
						// Payout will be the initial bet plus winnings
						$payout = $bet->bet_amount + $bet->win_potential;

						// If the game is over, record win and set bet to final
						if($bet_object->game['status'] === 'Final')
						{	
							$bet->won = true;
							$bet->final = true;
							$bet->save();

							$this->data['user']->current_money += $payout;
							$this->data['user']->save();
						}
						else
						{
							$bet_object->status = 'panel-success';
							$this->data['potential_money'] += $payout;
							$this->data['bet_objects'][] = $bet_object;
						}
					}
					// If this is a current push bet
					else if($adjusted_team_score === $opposing_team['score'])
					{
						// Payout will be just the initial bet
						$payout = $bet->bet_amount;

						// If the game is over, record win and set bet to final
						if($bet_object->game['status'] === 'Final')
						{	
							$bet->won = true;
							$bet->final = true;
							$bet->save();

							$this->data['user']->current_money += $payout;
							$this->data['user']->save();
						}
						else
						{
							$bet_object->status = 'panel-warning';

							// Payout will be just the initial bet
							$this->data['potential_money'] += $payout;
							$this->data['bet_objects'][] = $bet_object;
						}
					}
					// If this is a current losing bet
					else
					{
						// If the game is over, set bet to final
						if($bet_object->game['status'] === 'Final')
						{	
							$bet->final = true;
							$bet->save();
						}
						else
						{
							$bet_object->status = 'panel-danger';
							$this->data['bet_objects'][] = $bet_object;
						}
					}
				}
			}
		}

		return View::make('bets', $this->data);
	}

}