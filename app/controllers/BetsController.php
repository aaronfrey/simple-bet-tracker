<?php

class BetsController extends BaseController {

	function __construct()
	{
       parent::__construct();
   	}

	public function store()
	{
		$input = Input::all();

		$bet = new Bet;
		$bet->user_id = $this->data['user']->id;
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
		$this->data['user']->current_money -= $bet->bet_amount;
		$this->data['user']->save();

		$bet->multiplier = $input['plusminus_multiplier'] === '-' ?
				-$input['multiplier'] : $input['multiplier'];

		$bet->win_potential = $input['win_potential'] * 100;

		$bet->save();
	}

	public function showCurrentBets($size = 'expanded')
	{
		// Set the bet display size in the view
		$this->data['size'] = $size;

		$this->data['bet_objects'] = [];

		// Initialize the potential money that can be won as the current money the user has
		$this->data['potential_money'] = $this->data['user']->current_money;

		// Get all of the users outstanding bets
		$current_bets = Bet::where('user_id', '=', $this->data['user']->id)
			->where('final', false)
			->get();

		if($current_bets)
		{
			$win_bet_objects = [];
			$push_bet_objects = [];
			$lose_bet_objects = [];

			// Get all of the games
			$repo = App::make('GameRepository');
			$pending_games = $repo->getPendingGames('NFL', Config::get('custom.nfl_week'));

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
						$this->data['potential_money'] += $payout;

						// If the game is not over, update winning bets
						if(!$this->isGameFinal($bet_object, true, $payout))
						{
							$bet_object->status = 'panel-success';
							$win_bet_objects[] = $bet_object;
						}
					}
					// If this is a current push bet
					else if(intval($adjusted_team_score) === intval($opposing_team['score']))
					{
						// Payout will be just the initial bet
						$payout = $bet->bet_amount;
						$this->data['potential_money'] += $payout;

						// If the game is not over, update pushed bets
						if(!$this->isGameFinal($bet_object, true, $payout))
						{
							$bet_object->status = 'panel-warning';
							$push_bet_objects[] = $bet_object;
						}
					}
					// If this is a current losing bet
					else
					{
						// If the game is not over, update losing bets
						if(!$this->isGameFinal($bet_object))
						{
							$bet_object->status = 'panel-danger';
							$lose_bet_objects[] = $bet_object;
						}
					}
				}
			}

			$win_bet_objects = $this->sortGamesEndingFirst($win_bet_objects);
			$push_bet_objects = $this->sortGamesEndingFirst($push_bet_objects);
			$lose_bet_objects = $this->sortGamesEndingFirst($lose_bet_objects);			

			$this->data['bet_objects'] = array_merge($win_bet_objects, $push_bet_objects, $lose_bet_objects);
		}

		return View::make('bets', $this->data);
	}

	private function isGameFinal($bet_object, $won = false, $payout = 0)
	{
		// If the game is over, record win and set bet to final
		if($bet_object->game['status'] === 'Final')
		{	
			$bet_object->bet->won = $won;
			$bet_object->bet->final = true;
			$bet_object->bet->save();

			if($won)
			{
				$this->data['user']->current_money += $payout;
				$this->data['user']->save();
			}

			return true;
		}

		return false;
	}

	private function sortGamesEndingFirst(Array $games)
	{
		usort($games, function($a, $b) {
			$result = $a->game['display_status2'] - $b->game['display_status2'];
			if($result === 0)
			{
				return strtotime($a->game['display_status1']) - strtotime($b->game['display_status1']);
			}
			return $result;
		});

		return $games;
	}
}