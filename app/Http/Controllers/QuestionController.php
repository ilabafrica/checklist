<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Section;
use App\Models\Answer;
use App\Models\Note;
use Response;
use Auth;

class QuestionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all questions
		$questions = Question::all();
		return view('audit.question.index', compact('questions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get parent questions
		$parents = Question::lists('name', 'id');
		//	Get all audit questions
		$sections = Section::lists('name', 'id');
		//	Get all answers
		$answers = Answer::orderBy('name')->get();
		//	Get all notes
		$notes = Note::orderBy('name')->get();
		//	question types
		$questionTypes = array(Question::CHOICE=>'Choice', Question::DATE=>'Date', Question::FIELD=>'Field');
		return view('audit.question.create', compact('parents', 'sections', 'questionTypes', 'answers', 'notes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(QuestionRequest $request)
	{
		//	Get the values
		$question = new Question;
		$question->section_id = $request->section_id;
		$question->name = $request->name;
		$question->title = $request->title;
		$question->description = $request->description;
		$question->comment = $request->comment;
		$question->question_type = $request->question_type;
		$question->required = $request->required;
		$question->info = $request->info;
		$question->score = $request->score;
		$question->one_star = $request->one_star;
		$question->user_id = Auth::user()->id;
		try{
			$question->save();
			if($request->parent_id){
				$question->setParent(array($request->parent_id));
			}
			if($request->answers){
				$question->setAnswers($request->answers);
			}
			if($request->notes){
				$question->setNotes($request->notes);
			}
			//$url = Session::get('SOURCE_URL');
        
        	return redirect('question')->with('message', 'Question created successfully.');
		}
		catch(QueryException $e){
			Log::error($e);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show an Audit question
		$question = Question::find($id);
		//show the view and pass the $Section to it
		return view('audit.question.show', compact('question'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get audit question
		$question = Question::find($id);
		//	Get parent questions
		$parents = Question::lists('name', 'id');
		//	Get initially selected parent
		$parent = $question->parent_id;
		//	Get all audit question groups
		$sections = Section::lists('name', 'id');
		//	Get audit question group
		$section = $question->section_id;
		//	question types
		$questionTypes = array(Question::CHOICE=>'Choice', Question::DATE=>'Date', Question::FIELD=>'Field');
		//	Get question type
		$questionType = $question->question_type;
		//	Get all answers
		$answers = Answer::orderBy('name')->get();
		//	Get all notes
		$notes = Note::orderBy('name')->get();
		return view('audit.question.edit', compact('question', 'parents', 'sections', 'questionTypes', 'parent', 'section', 'questionType', 'answers', 'notes'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(QuestionRequest $request, $id)
	{
		$question = Question::find($id);
		$question->section_id = $request->section_id;
		$question->name = $request->name;
		$question->title = $request->title;
		$question->description = $request->description;
		$question->comment = $request->comment;
		$question->question_type = $request->question_type;
		$question->required = $request->required;
		$question->info = $request->info;
		$question->score = $request->score;
		$question->one_star = $request->one_star;
		$question->user_id = Auth::user()->id;

		try{
			$question->save();
			if($request->parent_id){
				$question->setParent(array($request->parent_id));
			}
			if($request->answers){
				$question->setAnswers($request->answers);
			}
			if($request->notes){
				$question->setNotes($request->notes);
			}
			//$url = Session::get('SOURCE_URL');
        
        	return redirect('question')->with('message', 'Question updated successfully.');
		}
		catch(QueryException $e){
			Log::error($e);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$question= Question::find($id);
		$question->delete();
		return redirect('question')->with('message', 'Question deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}

}
