<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Response;
use Auth;
use Session;

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
		return view('country.create');
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
        $country->iso_3166_2 = $request->iso_3166_2;
        $country->iso_3166_3 = $request->iso_3166_3;
        $country->capital = $request->capital;
        $country->user_id = Auth::user()->id;
        $country->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Country created successfully.')->with('active_country', $country->id);
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

        return view('country.edit', compact('country'));
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
        $country->iso_3166_2 = $request->iso_3166_2;
        $country->iso_3166_3 = $request->iso_3166_3;
        $country->capital = $request->capital;
        $country->user_id = Auth::user()->id;
        $country->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Country updated successfully.')->with('active_country', $country ->id);
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
		return redirect('country')->with('message', 'Country deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}
}