<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use App\Models\Partner;
use Response;
use Auth;
use Session;
use Lang;
use Input;

class CountryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all countries
		$countries = Country::all();
		return view('country.index', compact('countries'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		/* Get all partners */
		$partners = Partner::all();
		return view('country.create', compact('partners'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CountryRequest $request)
	{
		$country = new Country;
        $country->name = $request->name;
        $country->code = $request->code;
        $country->capital = $request->capital;
        $country->user_id = Auth::user()->id;
        $country->save();
        //	Save partners
	    if($request->partners){
			$country->setPartners($request->partners);
		}
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_country', $country->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a Country
		$country = Country::find($id);
		//show the view and pass the $Country to it
		return view('country.show', compact('country'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$country = Country::find($id);
		//	Get all partners
		$partners = Partner::all();
        return view('country.edit', compact('country', 'partners'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CountryRequest $request, $id)
	{
		$country = Country::findOrFail($id);;
        $country->name = $request->name;
        $country->code = $request->code;
        $country->capital = $request->capital;
        $country->user_id = Auth::user()->id;
        $country->save();
        //	Save partners
	    if($request->partners){
			$country->setPartners($request->partners);
		}
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-updated', 1))->with('active_country', $country ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$country= Country::find($id);
		$country->delete();
		return redirect('country')->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
	/**
	 * Show the form for creating a new country-partner.
	 *
	 * @return Response
	 */
	public function partner()
	{
		//	Get all countries
		$countries = Country::all();
		//	Get all partners
		$partners = Partner::all();
		
		return view('country.partner', compact('countries', 'partners'));
	}
	/**
	*	Function to return partners of a particular country to fill partners dropdown
	*/
	public function dropdown(){
        $input = Input::get('country_id');
        $country = Country::find($input);
        $partners = Partner::whereIn('id', $country->partners->lists('partner_id'))->get();
        return json_encode($partners);
    }
}