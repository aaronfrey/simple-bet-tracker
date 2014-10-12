<?php

class HomeController extends BaseController {

	public function showMain($sport = 'NFL')
	{
		$repo = App::make('GameRepository');

		$this->data['sport'] = $sport;

        $games = $repo->getPendingGames($sport, Config::get('custom.nfl_week'));

        $this->data['pending_games'] = $this->sortGamesStartingFirst($games);

		$this->data['current_games'] = [];

		return View::make('main', $this->data);
	}

	private function sortGamesStartingFirst(Array $games)
	{
		usort($games, function($a, $b) {
			$a_date = strtotime($a['gamestate']['@attributes']['gamedate']);
			$b_date = strtotime($b['gamestate']['@attributes']['gamedate']);

			$result = $a_date - $b_date;

			if($result === 0)
			{
				$a_time = strtotime($a['gamestate']['@attributes']['gametime']);
				$b_time = strtotime($b['gamestate']['@attributes']['gametime']);
				return $a_time - $b_time;
			}

			return $result;
		});

		return $games;
	}

}