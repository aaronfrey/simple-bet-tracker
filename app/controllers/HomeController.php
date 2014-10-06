<?php

class HomeController extends BaseController {

	public function showMain($sport = 'NFL')
	{
		$repo = App::make('GameRepository');

		$this->data['sport'] = $sport;

        $this->data['pending_games'] = $repo->getPendingGames($sport, Config::get('custom.nfl_week'));

		$this->data['current_games'] = [];

		return View::make('main', $this->data);
	}

}