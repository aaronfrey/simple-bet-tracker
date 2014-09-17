<?php

class HomeController extends BaseController {

	public function showMain($sport = 'NFL')
	{
		$repo = App::make('GameRepository');

		$this->data['sport'] = $sport;

        $this->data['pending_games'] = $repo->getPendingGames($sport, '3');

		$this->data['current_games'] = [];

		return View::make('main', $this->data);
	}

}