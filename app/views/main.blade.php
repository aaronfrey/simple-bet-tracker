@extends('layouts.master')

@section('content')

	<div class="row">

		<div class="col-md-12">

			<h1>Pending {{ $sport }} Games</h1>

		</div>

	</div>

	<div class="row">

		@foreach($pending_games as $game)

		@if($game['gamestate']['@attributes']['status'] === 'Pre-Game')

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title text-center">
						{{ $game['visiting-team']['@attributes']['display_name'] . ' ' .
						   $game['visiting-team']['@attributes']['nickname'] . ' at ' .
						   $game['home-team']['@attributes']['display_name'] . ' ' .
						   $game['home-team']['@attributes']['nickname'] }}
					</h3>
				</div>

				<div
					class="panel-body"
					data-game-code="{{ $game['@attributes']['gamecode'] }}"
					data-sport="{{ $sport }}">

					<div class="text-center">
						{{ $game['gamestate']['@attributes']['gamedate'] . ' at ' . 
						   $game['gamestate']['@attributes']['gametime'] . ' on ' .
						   $game['gamestate']['@attributes']['tv'] }}
					</div>

					<hr>

					<div class="bet-type" data-bet-type="pointspread">

						<h5>Point Spread</h5>

						<button
							class="btn btn-primary btn-block bet-option"
							data-team-id="{{ $sport }}-{{ $game['visiting-team']['@attributes']['id'] }}"
							data-team-display="{{ $game['visiting-team']['@attributes']['nickname'] }}">
							Take the {{ $game['visiting-team']['@attributes']['nickname'] }}
						</button>

						<button
							class="btn btn-primary btn-block bet-option"
							data-team-id="{{ $sport }}-{{ $game['home-team']['@attributes']['id'] }}"
							data-team-display="{{ $game['home-team']['@attributes']['nickname'] }}">
							Take the {{ $game['home-team']['@attributes']['nickname'] }}
						</button>

					</div>

					<hr>

					<div class="bet-type" data-bet-type="moneyline">

						<h5>Moneyline</h5>

						<button
							class="btn btn-primary btn-block bet-option"
							data-team-id="{{ $sport }}-{{ $game['visiting-team']['@attributes']['id'] }}"
							data-team-display="{{ $game['visiting-team']['@attributes']['nickname'] }}">
							Take the {{ $game['visiting-team']['@attributes']['nickname'] }}
						</button>

						<button
							class="btn btn-primary btn-block bet-option"
							data-team-id="{{ $sport }}-{{ $game['home-team']['@attributes']['id'] }}"
							data-team-display="{{ $game['home-team']['@attributes']['nickname'] }}">
							Take the {{ $game['home-team']['@attributes']['nickname'] }}
						</button>

					</div>

					<hr>

				</div>
			</div>
		</div>

		<?php //echo '<pre>' . print_r($game, true) . '</pre>'; ?>

		@endif

		@endforeach

	</div>

	<div
		id="bet-modal"
		class="modal fade"
		tabindex="-1"
		role="dialog"
		aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button
						type="button"
						class="close"
						data-dismiss="modal">
							<span aria-hidden="true">×</span>
							<span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
				
					{{ Form::open(array('action' => 'BetsController@store')) }}

						<div class="row">

							<div class="col-md-3 text-center">
								<h4>Bet Type</h4>
								<p id="bet-type"></p>

								<h4>Team</h4>
								<p id="bet-team"></p>
							</div>

							<div class="col-md-3">
								<div id="pointspread">
									<h4>Point Spread</h4>
									<div class="btn-group pull-left plusminus" data-toggle="buttons">
										<label class="btn btn-primary active">
											<input type="radio" name="plusminus_pointspread" value="+" checked> +
										</label>
										<label class="btn btn-primary">
											<input type="radio" name="plusminus_pointspread" value="-"> -
										</label>
									</div>
									{{ Form::text('point_spread', '', array('class' => 'form-control pull-left small')) }}
								</div>
								<h4>Multiplier</h4>
								<div class="btn-group pull-left plusminus" data-toggle="buttons">
									<label class="btn btn-primary active">
										<input type="radio" name="plusminus_multiplier" value="+" checked> +
									</label>
									<label class="btn btn-primary">
										<input type="radio" name="plusminus_multiplier" value="-"> -
									</label>
								</div>
								{{ Form::text('multiplier', '',
									array('class' => 'form-control pull-left small calculate')) }}
							</div>
							<div class="col-md-3">
								<h4>Bet Amount</h4>
								<div class="input-group">
							      <div class="input-group-addon">$</div>
							      {{ Form::text('bet', '', array('class' => 'form-control calculate')) }}
							    </div>

								<h4>Win Potential</h4>
								<div class="input-group">
							      <div class="input-group-addon">$</div>
							      {{ Form::text('win_potential', '', array('class' => 'form-control')) }}
							    </div>
							</div>
							<div class="col-md-3 text-center">
								{{ Form::submit('Place Bet', array('class' => 'btn btn-primary')) }}
							</div>
						</div>

						{{ Form::hidden('sport') }}
						{{ Form::hidden('game_code') }}
						{{ Form::hidden('bet_type') }}
						{{ Form::hidden('team_to_win') }}

					{{ Form::close() }}					

				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

@stop