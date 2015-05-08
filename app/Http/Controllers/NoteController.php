<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use App\Models\Note;
use App\Models\AuditType;
use Response;
use Auth;
use Session;

class NoteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all notes
		$notes = Note::all();
		return view('audit.note.index', compact('notes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all audit types
		$auditTypes = AuditType::lists('name', 'id');
		return view('audit.note.create', compact('auditTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(NoteRequest $request)
	{
		$note = new Note;
        $note->name = $request->name;
        $note->description = $request->description;
        $note->audit_type_id = $request->audit_type_id;
        $note->user_id = Auth::user()->id;
        $note->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Note created successfully.')->with('active_note', $note ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a note
		$note = Note::find($id);
		//show the view and pass the $note to it
		return view('audit.note.show', compact('note'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$note = Note::find($id);
		//	Get all audit types
		$auditTypes = AuditType::lists('name', 'id');
		//	Get initial audit type
		$auditType = $note->audit_type_id;

        return view('audit.note.edit', compact('note', 'auditTypes', 'auditType'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(NoteRequest $request, $id)
	{
		$note = Note::findOrFail($id);;
        $note->name = $request->name;
        $note->description = $request->description;
        $note->audit_type_id = $request->audit_type_id;
        $note->user_id = Auth::user()->id;
        $note->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Note updated successfully.')->with('active_note', $note ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$note= Note::find($id);
		$note->delete();
		return redirect('note')->with('message', 'Note deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}
}