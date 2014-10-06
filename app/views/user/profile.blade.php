@extends('layouts.master')

@section('content')


{{ Form::open(array('url' => 'user/profile')) }}

	<div class="row">

		<div class="col-md-12 col-md-offset-3">
			<h1>Profile</h1>
			<h3>General Information</h3>
		</div>

		<div class="col-md-6 col-md-offset-3">
			<div class="form-group">
				<label for="username">Username</label>
				<input
					type="text"
					class="form-control"
					name="username"
					id="username"
					value="{{ $user->username }}">
			</div>
		</div>

		<div class="col-md-6 col-md-offset-3">
			<div class="form-group">
				<label for="email">Email Address</label>
				<input
					type="email"
					class="form-control"
					name="email"
					id="email"
					value="{{ $user->email }}">
			</div>
		</div>

		<div class="col-md-2 col-md-offset-3">

			<div class="form-group">
				<label for="current_money">Current Money</label>
				<div class="input-group">
					<div class="input-group-addon">$</div>
					<input
						type="text"
						class="form-control"
						name="current_money"
						id="current_money"
						value="{{ money_format('%i', $user->current_money / 100) }}">
				</div>
			</div>

		</div>

	</div>

	<div class="row">

		<div class="col-md-12 col-md-offset-3">
			<h3>Change Password</h3>
		</div>

		<div class="col-md-3 col-md-offset-3">
			<div class="form-group">
				<label for="password">New Password</label>
				<input
					type="password"
					class="form-control"
					name="password"
					id="password">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="password_again">Confirm Password</label>
				<input
					type="password"
					class="form-control"
					name="password_again"
					id="password_again">
			</div>
		</div>

	</div>

	<div class="row">

		<div class="col-md-2 col-md-offset-3">

			<button type="submit" class="btn btn-default">Update</button>

		</div>

	</div>

{{ Form::close() }}

@stop