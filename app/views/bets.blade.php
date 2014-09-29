@extends('layouts.master')

@section('content')

	<div class="row">

		<div class="col-md-12">

			<h1 class="pull-left">Current Bets</h1>

			<div class="pull-right">
				<h5>Real: ${{ money_format('%i', $user->current_money / 100) }}</h5>
				<h5>Potential: ${{ money_format('%i', $potential_money / 100) }}</h5>
			</div>

		</div>

	</div>

	<div class="row">

		@foreach($bet_objects as $bet_object)

		<div class="col-md-4">

			<div class="panel {{ $bet_object->status }}">

 				<div class="panel-heading text-center">{{ $bet_object->game_title }}</div>
  				<div class="panel-body">
    				<div class="row">
    					<div class="col-md-4 text-center">
    						<h5>{{ $bet_object->visiting_team['nickname'] }}</h5>
    						<h1>{{ $bet_object->visiting_team['score'] }}</h1>
    					</div>
    					<div class="col-md-4 text-center">
    						<h3>{{$bet_object->game['display_status2'] }}</h3>
    						<h4>{{$bet_object->game['display_status1'] }}</h4>
    					</div>
       					<div class="col-md-4 text-center">
    						<h5>{{ $bet_object->home_team['nickname'] }}</h5>
    						<h1>{{ $bet_object->home_team['score'] }}</h1>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-md-12 text-center">
    						@if($bet_object->bet['bet_type'] === 'pointspread')
    							<h4>{{ $bet_object->picked_team['nickname'] }} {{ $bet_object->bet->point_spread > 0 ? '+' : '' }}{{ $bet_object->bet->point_spread }}</h4>
    						@endif
    					</div>
    				</div>
  				</div>

			</div>

		</div>

		@endforeach

	</div>

@stop