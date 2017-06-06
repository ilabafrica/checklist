<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use App\Models\Lab;
use Response;
use Auth;
use Session;
use Lang;

class PartnerController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all partners
		$partners = Partner::all();
		return view('partner.index', compact('partners'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all labs
		$labs = Lab::all();
		return view('partner.create', compact('labs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PartnerRequest $request)
	{
		$partner = new Partner;
        $partner->name = $request->name;
        $partner->head = $request->head;
        $partner->contact = $request->contact;
        $partner->user_id = Auth::user()->id;
        $partner->save();
        //	Save labs
	    if($request->labs){
			$partner->setLabs($request->labs);
		}
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_partner', $partner->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a Partner
		$partner = Partner::find($id);
		//show the view and pass the $partner to it
		return view('partner.show', compact('partner'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$partner = Partner::find($id);
		//	Get all labs
		$labs = Lab::all();
        return view('partner.edit', compact('partner', 'labs'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(PartnerRequest $request, $id)
	{
		$partner = Partner::findOrFail($id);;
        $partner->name = $request->name;
        $partner->head = $request->head;
        $partner->contact = $request->contact;
        $partner->user_id = Auth::user()->id;
        $partner->save();
        //	Save labs
	    if($request->labs){
			$partner->setLabs($request->labs);
		}
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-updated', 1))->with('active_partner', $partner ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$partner= Partner::find($id);
		$partner->delete();
		return redirect('partner')->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
	public function destroy($id)
	{
		//
	}
}