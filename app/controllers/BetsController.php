<?php

class BetsController extends BaseController {

	public function store()
	{
		echo('<pre>');
		print_r(Input::all());
		echo('</pre>');
		dd();
	}

}