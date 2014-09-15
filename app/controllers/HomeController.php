<?php

class HomeController extends BaseController {

	public function showMain()
	{
		$games = []; 

		$url = 'http://scores.nbcsports.com/ticker/data/gamesNEW.js.asp?jsonp=true&sport=NFL&period=2';

		$jsonp = file_get_contents($url);

		$json_str = str_replace(');', '', str_replace('shsMSNBCTicker.loadGamesData(', '', $jsonp));

		$json_parsed = json_decode($json_str);

		foreach($json_parsed->games as $game)
		{
			$game_xml = simplexml_load_string($game);
			$games[] = Formatter::make($game_xml, 'xml')->to_array();
		}

		$this->data['games'] = $games;

		return View::make('main', $this->data);
	}

}