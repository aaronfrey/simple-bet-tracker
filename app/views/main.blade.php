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
				<div class="panel-body">

					<div class="text-center">
						{{ $game['gamestate']['@attributes']['gamedate'] . ' at ' . 
						   $game['gamestate']['@attributes']['gametime'] . ' on ' .
						   $game['gamestate']['@attributes']['tv'] }}
					</div>

					<hr>

					<h5>Point Spread</h5>

					<button class="btn btn-primary btn-block bet-option">
						Take the {{ $game['visiting-team']['@attributes']['nickname'] }}
					</button>

					<button class="btn btn-primary btn-block bet-option">
						Take the {{ $game['home-team']['@attributes']['nickname'] }}
					</button>

					<hr>

					<h5>Moneyline</h5>

					<button class="btn btn-primary btn-block bet-option">
						Take the {{ $game['visiting-team']['@attributes']['nickname'] }}
					</button>

					<button class="btn btn-primary btn-block bet-option">
						Take the {{ $game['home-team']['@attributes']['nickname'] }}
					</button>

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
					<h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
				</div>
				<div class="modal-body">
				...
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

@stop