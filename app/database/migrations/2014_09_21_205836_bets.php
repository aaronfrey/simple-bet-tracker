<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bets', function($table)
		{
		    $table->increments('id');
		});

		Schema::table('bets', function($table)
		{
			$table->string('sport');
			$table->string('game_code');
			$table->string('bet_type');
		    $table->string('team_to_win');
		    $table->string('point_spread');
		    $table->integer('bet_amount');
		    $table->integer('multiplier');
		    $table->integer('win_potential');
		    $table->boolean('won')->default(false);
		    $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bets');
	}

}
