<?php namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
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
		$user = Auth::user();
		$role = $user->roles()->first();

		//get all reviews for the admin
		if ($role->name ==$user->isAdmin()) {
			$reviews = Review::all();
		}else
		{		
			//get all the reviews the user has created or edited
			$first = DB::table('review_assessors')->where('assessor_id', $user->id)->lists('review_id');
			$user_reviews = Review::where('user_id', Auth::user()->id)->lists('id');				
			$all_reviews = array_merge($first, $user_reviews);

			// dd($all_reviews);


			$reviews = Review::whereIn('id', $first)->get();		
		}

		$message = '';
		return view('home', compact('reviews', 'message'));
	}
}