<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\LabLevelRequest;
use App\Models\LabLevel;
use Response;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Session;

class LabLevelController extends Controller {
    use SoftDeletes;
    protected $dates = ['deleted_at'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all lab Levels
		$labLevels = LabLevel::all();
		return view('lab.level.index', compact('labLevels'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('lab.level.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LabLevelRequest $request)
	{
		$labLevel = new LabLevel;
        $labLevel->name = $request->name;
        $labLevel->description = $request->description;
        $labLevel->user_id = Auth::user()->id;;
        $labLevel->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Lab level created successfully.')->with('active_labLevel', $labLevel ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a lab level
		$labLevel = LabLevel::find($id);
		//show the view and pass the $labLevel to it
		return view('lab.level.show', compact('labLevel'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$labLevel = LabLevel::find($id);

        return view('lab.level.edit', compact('labLevel'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(LabLevelRequest $request, $id)
	{
		$labLevel = LabLevel::findOrFail($id);;
        $labLevel->name = $request->name;
        $labLevel->description = $request->description;
        $labLevel->user_id = Auth::user()->id;;
        $labLevel->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Lab level updated successfully.')->with('active_labLevel', $labLevel ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$labLevel= LabLevel::find($id);
		$labLevel->delete();
		return redirect('labLevel')->with('message', 'labLevel deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}

}