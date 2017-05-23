<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Http\Models\MemberModel as MemberModels;
use DB;

class DefaultController extends Controller
{
    public function index()
    {
    	// $models = new MemberModels();

    	$email =trim(Input::get('email'));

    	// $result = $models->getTable('t_member_perm', '*', array());

    	print_r('lonny');die;
    	return view('default.index');
    }
}