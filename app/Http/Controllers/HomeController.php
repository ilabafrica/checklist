<?php namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Models\Review;
use App\Models\Lab;
use App\Models\Assessment;
use Auth;
use DB;
use Input;

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
		$all_labs = Lab::lists('name', 'id')->toArray() ;
		$all_assessment_types = Assessment::lists('name', 'id')->toArray();

		//get all reviews for the admin
		if ($role->name ==$user->isAdmin()) {
			$reviews = Review::all();
		}else
		{		
			//get all the reviews the user has created or edited
			$first = DB::table('review_assessors')->where('assessor_id', $user->id)->lists('review_id');
			$user_reviews = Review::where('user_id', Auth::user()->id)->lists('id');				
			$all_reviews = array_merge($first, $user_reviews);



			$reviews = Review::whereIn('id', $first)->get();		
		}

		$message = '';
		return view('home', compact('reviews', 'message', 'all_labs', 'all_assessment_types'));
	}
	public function search()
	{   
		$user = Auth::user();

		$all_labs = Lab::lists('name', 'id') ->toArray();
		$all_assessment_types = Assessment::lists('name', 'id')->toArray();

		$from = Input::get('from');
		$to = Input::get('to');

		$lab = Input::get('lab');
		$assessment_type = Input::get('assessment_type');
		$status = Input::get('status');

		//All reviews
		$reviews = Review::query();

		//one lab's review
		if(Input::has('lab')){
			// echo "trueest";
		    $reviews->where('lab_id',  $lab);
		}

		//assessment status
		if(Input::has('status')){
			// echo "another truth";
		    $reviews->where('status',  $status);
		}

		//one assessment type
		if(Input::has('assessment_type')){
			// echo "another truth";
		    $reviews->where('audit_type_id',  $assessment_type);
		}

		if(Input::has('from') && Input::has('to')){
			// echo "another truth";
		    $reviews->whereBetween('created_at',  [$from, $to]);
		}
		$reviews = $reviews->get();

		
        $message = '';
         return view('home',compact('reviews','message', 'all_labs', 'all_assessment_types'));
		                
	}
}