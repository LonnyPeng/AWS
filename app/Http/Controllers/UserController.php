<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

class UsserController extends Controller
{
	public function register()
	{
		if(!isAjax()) {
			return false;
		}

		$email = trim(Input::get('email'));
		$pwd = trim(Input::get('pwd'));
	}
}