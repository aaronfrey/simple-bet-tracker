<?php

class GameRepository
{
    public function getPendingGames($sport = 'NFL', $period = '')
    {
        $games = []; 

        $url = "http://scores.nbcsports.com/ticker/data/gamesNEW.js.asp?jsonp=true&sport=$sport&period=$period";

        $jsonp = file_get_contents($url);

        $json_str = str_replace(');', '', str_replace('shsMSNBCTicker.loadGamesData(', '', $jsonp));

        $json_parsed = json_decode($json_str);

        foreach($json_parsed->games as $game)
        {
            $game_xml = simplexml_load_string($game);
            $game_array = Formatter::make($game_xml, 'xml')->to_array();
            $games[$game_array['@attributes']['gamecode']] = $game_array;
        }

        return $games;
    }
}