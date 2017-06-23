<?php namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Review;
use Auth;
use DB;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = Auth::user()->id;
		
		//get all the reviews the user has created or edited
		$first = DB::table('review_assessors')->where('assessor_id', $user_id)->lists('review_id');
		$reviews = Review::whereIn('id', $first)->get();		
		
		$message = '';
		return view('home', compact('reviews', 'message'));
	}
}