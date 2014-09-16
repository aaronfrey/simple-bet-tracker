@extends('layouts.master')

@section('content')

	<div class="row">

		<div class="col-md-12">

			<h1>Pending Games</h1>

		</div>

	</div>

	<div class="row">

		@foreach($pending_games as $game)

		@if($game['gamestate']['@attributes']['status'] === 'Pre-Game')

		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title text-center">
						{{ $game['visiting-team']['@attributes']['display_name'] . ' ' .
						   $game['visiting-team']['@attributes']['nickname'] . ' at ' .
						   $game['home-team']['@attributes']['display_name'] . ' ' .
						   $game['home-team']['@attributes']['nickname'] }}
					</h3>
				</div>
				<div class="panel-body text-center">
					{{ $game['gamestate']['@attributes']['gamedate'] . ' at ' . 
					   $game['gamestate']['@attributes']['gametime'] . ' on ' .
					   $game['gamestate']['@attributes']['tv'] }}

					{{ Form::open(array('url' => 'foo/bar')) }}
   						{{ Form::hidden('gamecode', $game['@attributes']['gamecode']) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>

		@endif

		@endforeach

	</div>

	<div class="row">

		<div class="col-md-12">

			<h1>Current Bets</h1>

			@if(count($current_games))

			@foreach($current_games as $game)

			@endforeach

			@else

			<div class="well">
				You Have No Current Bets
			</div>

			@endif

			</div>

		</div>

	</div>

@stop