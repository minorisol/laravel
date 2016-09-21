<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth', ['only' => 'index']);
	}
	
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}
	
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function bookmark($token)
	{
		if (strlen($token) > 0) {
			$user = User::whereRememberToken($token)->first();
			Auth::login($user);
		}
		return view('home');
	}
}