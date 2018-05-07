<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Section;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\ReviewSlmtaInfo;
use App\Models\ReviewLabProfile;
use App\Models\ReviewQuestion;
use App\Models\ReviewQAnswer;
use App\Models\ReviewQScore;
use App\Models\ReviewNote;
use App\Models\ReviewActPlan;
use App\Models\AuditType;
use Lang;
use Excel;
use App;
use PDF;
use PDFS;

use Illuminate\Http\Request;

class ReportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$review = Review::find($id);
		$categories = array();
		$labels = array();
		$overall = $review->auditType->sections->sum('total_points');
		$points = 0;
		$score = 0;
		$sections = $review->auditType->sections;
		foreach($sections as $section){
			if($section->total_points!=0)
				array_push($categories, $section);
			else
				continue;
		}
		$counter = count($categories);
		foreach($categories as $section){
			// dd($section->id);
			array_push($labels, $section->name);
			$points+=(int)$section->subtotal($review->id);
			$score+=(int)$section->subtotal($review->id, 1);
		}
		$average = $score*100/$overall;
		return view('report.index', compact('review', 'categories', 'overall', 'score', 'average'));
	}
	/**
	 * Show the bar chart
	 *
	 * @return Response
	 */
	public function bar($id)
	{	
		$review = Review::find($id);
		$categories = array();
		$labels = array();
		$full_labels=array();
		$sections = $review->auditType->sections;
		foreach($sections as $section){
			if($section->total_points!=0)
				array_push($categories, $section);
			else
				continue;
		}
		foreach($categories as $section){
			array_push($labels, $section->name);
			array_push($full_labels, $section->name);
		}
		//	Column chart
		$column = '{
            chart: {
                type: "column"
            },
            "title": {
	            "text": "'.$review->lab->name.'"
	        },
	        "subtitle": {
	            "text": "% Score per section"
	        },
	        "xAxis": {
	            categories: [';
		        	foreach ($labels as $label) {
		       			$column.="'".$label."',";
	       			}
	       		$column.='],
	        },
            "yAxis": {
	            "min": "0",
	            "title": {
	                "text":"% Score"
	            },
	            crosshair: true
	        },
            "credits": {
		        "enabled": false
		    },
            plotOptions: {
                series: {
                    colorByPoint: true
                }
            },
            "series": [{
            	"showInLegend": false,
            	"name": "% Score",
	            "data": [';
	            foreach($categories as $section){
	            	$column.= $section->subtotal($review->id).',';
	            }
	            $column.= ']
	        }]          
        }';
		return view('report.bar', compact('review', 'column'));//
	}

	/**
	 * Store the spider chart
	 *
	 * @return Response
	 */
	public function spider($id)
	{
		$review = Review::find($id);
		$categories = array();
		$labels = array();
		$sections = $review->auditType->sections;
		foreach($sections as $section){
			if($section->total_points!=0)
				array_push($categories, $section);
			else
				continue;
		}
		foreach($categories as $section){
			array_push($labels, $section->name);
		}
        //	Spider chart
	  	$spider = '{
	        "chart": {
	            "polar": true,
	            "type": "line"
	        },
	        "title": {
	            "text": "'.$review->lab->name.'",
	            "x": -80
	        },
	        "pane": {
	            "size": "80%"
	        },
	        "xAxis": {
	            "categories": [';
	        	foreach ($labels as $label) {
		       			$spider.="'".$label."',";
	       			}
	       		$spider.='],
	            "tickmarkPlacement": "on",
	            "lineWidth": "0"
	        },
	        "yAxis": {
	            "gridLineInterpolation": "polygon",
	            "lineWidth": "0",
	            "min": "0"
	        },
	        "credits": {
		        "enabled": false
		    },
	        "legend": {
	            "align": "right",
	            "verticalAlign": "top",
	            "y": 70,
	            "layout": "vertical"
	        },
	        "series": [{
	            "name": "% score",
	            "data": [';
	            	foreach ($categories as $section) {
	   					$spider.= $section->subtotal($review->id).',';
	   				}
	   				$spider.='],
	            "pointPlacement": "on"
	        }]
	    }';
		return view('report.spider', compact('review', 'spider'));
	}
	/* Export audit data to excel */
	public function export($id){
		$review = Review::find($id);
		$lab_info = array(
			array('Field', 'Value'),
			array(Lang::choice('messages.lab-name', 1), $review->lab->name),
			array(Lang::choice('messages.lab-number', 1), $review->lab->lab_number),
			array(Lang::choice('messages.lab-address', 1), $review->lab->address.'-'.$review->lab->postal_code.', '.$review->lab->city),
			array(Lang::choice('messages.lab-telephone', 1), $review->lab->telephone),
			array(Lang::choice('messages.lab-fax', 1), $review->lab->fax),
			array(Lang::choice('messages.lab-email', 1), $review->lab->email),
			array(Lang::choice('messages.lab-head', 1), $review->laboratory?$review->laboratory->head:''),
			array(Lang::choice('messages.lab-head-telephone-personal', 1), $review->laboratory?$review->laboratory->head_personal_telephone:''),
			array(Lang::choice('messages.lab-head-telephone-work', 1), $review->laboratory?$review->laboratory->head_work_telephone:''),
			array(Lang::choice('messages.lab-level', 1), $review->lab->labLevel->name),
			array(Lang::choice('messages.lab-affiliation', 1), $review->lab->labAffiliation->name)
			);
		$staffing_summary = array(
			array('Profession', 'Employees', 'Adequate'),
			array(Lang::choice('messages.degree', 1), $review->laboratory?$review->laboratory->degree_staff:'', $review->laboratory?$review->adequate($review->laboratory->degree_staff_adequate):''),
			array(Lang::choice('messages.diploma', 1), $review->laboratory?$review->laboratory->diploma_staff:'', $review->laboratory?$review->adequate($review->laboratory->diploma_staff_adequate):''),
			array(Lang::choice('messages.certificate', 1), $review->laboratory?$review->laboratory->certificate_staff:'', $review->laboratory?$review->adequate($review->laboratory->certificate_staff_adequate):''),
			array(Lang::choice('messages.microscopist', 1), $review->laboratory?$review->laboratory->microscopist:'', $review->laboratory?$review->adequate($review->laboratory->microscopist_adequate):''),
			array(Lang::choice('messages.data-clerk', 1), $review->laboratory?$review->laboratory->data_clerk:'', $review->laboratory?$review->adequate($review->laboratory->data_clerk_adequate):''),
			array(Lang::choice('messages.phlebotomist', 1), $review->laboratory?$review->laboratory->phlebotomist:'', $review->laboratory?$review->adequate($review->laboratory->phlebotomist_adequate):''),
			array(Lang::choice('messages.cleaner', 1), $review->laboratory?$review->laboratory->cleaner:'', $review->laboratory?$review->adequate($review->laboratory->cleaner_adequate):''),
			array(Lang::choice('messages.cleaner-dedicated', 1), $review->laboratory?$review->adequate($review->laboratory->cleaner_dedicated):'', ''),
			array(Lang::choice('messages.cleaner-trained', 1), $review->laboratory?$review->adequate($review->laboratory->cleaner_trained):'', ''),
			array(Lang::choice('messages.driver', 1), $review->laboratory?$review->laboratory->driver:'', $review->laboratory?$review->adequate($review->laboratory->driver_adequate):''),
			array(Lang::choice('messages.driver-dedicated', 1), $review->laboratory?$review->adequate($review->laboratory->driver_dedicated):'', ''),
			array(Lang::choice('messages.driver-trained', 1), $review->laboratory?$review->adequate($review->laboratory->driver_trained):'', ''),
			array(Lang::choice('messages.other', 1), $review->laboratory?$review->laboratory->other_staff:'', $review->laboratory?$review->adequate($review->laboratory->other_staff_adequate):'')
		);
		$slmta_info = array(
			array('Field', 'Value'),
			array(Lang::choice('messages.official-slmta', 1), $review->slmta?($review->slmta->official_slmta == Review::OFFICIAL?Lang::choice('messages.yes', 1):Lang::choice('messages.no', 1)):''),
			array(Lang::choice('messages.audit-start-date', 1), $review->slmta?$review->slmta->audit_start_date:''),
			array(Lang::choice('messages.audit-end-date', 1), $review->slmta?$review->slmta->audit_end_date:''),
			array(Lang::choice('messages.names-affiliations-of-auditors', 1), $review->slmta?implode(", ", $review->assessors->lists('name')->all()):''),
			array(Lang::choice('messages.slmta-audit-type', 1), $review->slmta?$review->assessment($review->slmta->assessment_id)->name:''),
			array(Lang::choice('messages.tests-before-slmta', 1), $review->slmta?$review->slmta->tests_before_slmta:''),
			array(Lang::choice('messages.tests-this-year', 1), $review->slmta?$review->slmta->tests_this_year:''),
			array(Lang::choice('messages.cohort-id', 1), $review->slmta?$review->slmta->cohort_id:''),
			array(Lang::choice('messages.slmta-lab-type', 1), $review->lab->labType->name),
			array(Lang::choice('messages.baseline-audit-date', 1), $review->slmta?$review->slmta->baseline_audit_date:''),
			array(Lang::choice('messages.slmta-workshop-date', 1), $review->slmta?$review->slmta->slmta_workshop_date:''),
			array(Lang::choice('messages.exit-audit-date', 1), $review->slmta?$review->slmta->exit_audit_date:''),
			array(Lang::choice('messages.baseline-score', 1), $review->slmta?$review->slmta->baseline_score:''),
			array(Lang::choice('messages.baseline-stars', 1), $review->slmta?$review->stars($review->slmta->baseline_stars_obtained):''),
			array(Lang::choice('messages.exit-score', 1), $review->slmta?$review->slmta->exit_score:''),
			array(Lang::choice('messages.exit-stars', 1), $review->slmta?$review->stars($review->slmta->exit_stars_obtained):''),
			array(Lang::choice('messages.last-audit-date', 1), $review->slmta?$review->slmta->last_audit_date:''),
			array(Lang::choice('messages.last-audit-score', 1), $review->slmta?$review->slmta->last_audit_score:''),
			array(Lang::choice('messages.prior-audit-status', 1), $review->slmta?$review->stars($review->slmta->prior_audit_status):'')
		);
		$org_structure = array(
			array('Field', 'Value'),
			array(Lang::choice('messages.sufficient-space', 1), $review->laboratory?$review->adequate($review->laboratory->sufficient_space):''),
			array(Lang::choice('messages.equipment', 1), $review->laboratory?$review->adequate($review->laboratory->equipment):''),
			array(Lang::choice('messages.supplies', 1), $review->laboratory?$review->adequate($review->laboratory->supplies):''),
			array(Lang::choice('messages.personnel', 1), $review->laboratory?$review->adequate($review->laboratory->personnel):''),
			array(Lang::choice('messages.infrastructure', 1), $review->laboratory?$review->adequate($review->laboratory->infrastructure):''),
			array(Lang::choice('messages.other-specify', 1).': '.($review->laboratory?$review->laboratory->other_description:''), $review->laboratory?$review->adequate($review->laboratory->other):'')
		);
		$summary = array(
			array('Field', 'Value'),
			array(Lang::choice('messages.commendations', 1), $review->summary_commendations?$review->summary_commendations:''),
			array(Lang::choice('messages.challenges', 1), $review->summary_challenges?$review->summary_challenges:''),
			array(Lang::choice('messages.recommendations', 1), $review->recommendations?$review->recommendations:''),
		);
		$action_plan = array(
			array('Action', 'Incharge', 'Timeline'),
			$review->plans()
		);
		$categories = array();
		$assessment = array();
		foreach ($review->auditType->sections as $section) {
			if($section->total_points!=0)
				array_push($categories, $section);
			else
				continue;
		}
		Excel::create($review->lab->name, function($excel) use ($lab_info, $slmta_info, $staffing_summary, $org_structure, $summary, $action_plan, $review, $categories) {

		    // Set the title
		    $excel->setTitle('Complete audit data');

		    // Chain the setters
		    $excel->setCreator('eChecklist')
		          ->setCompany('slipta');

		    // Call them separately
		    $excel->setDescription('Audit information as provided');

		    //	Create sheets
		    /* Lab Info */
		    $excel->sheet('Laboratory Information', function($sheet) use($lab_info){
		    	foreach ($lab_info as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });
		    /* Staffing Summary */
		    $excel->sheet('Staffing Summary', function($sheet) use($staffing_summary){
		    	foreach ($staffing_summary as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });
		    /* Organizational Structure */
		    /*$excel->sheet('Organizational Structure', function($sheet) use($org_structure){
		    	foreach ($org_structure as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });*/
		    /* SLMTA Info */
		    $excel->sheet('SLMTA Information', function($sheet) use($slmta_info){
		    	foreach ($slmta_info as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });
		    /* Audit Details */
		    $excel->sheet('Assessment Details', function($sheet) use($review, $categories){
		    	$sheet->appendRow(array('Question', 'Description', 'Response', 'Notes'));
		    	foreach ($categories as $section) {
					//$sheet->appendRow(Lang::choice('messages.question', 1), Lang::choice('messages.response', 1), Lang::choice('messages.notes', 1));
					foreach ($section->questions as $question) {
						if(count($question->children)>0){
							$sheet->appendRow(array($question->id, $question->title.''.$question->description));
							foreach($question->children as $kid){
								$sheet->appendRow(array($kid->id, $kid->title?$kid->title:''.$kid->description, $kid->qa($review->id)?Answer::find((int)$kid->qa($review->id))->name:'', $kid->note($review->id)?$kid->note($review->id)->note:''));
							}
						}
						elseif($question->score != 0){
							$sheet->appendRow(array($question->id, $question->title?$question->title:''.$question->description, $question->qa($review->id)?Answer::find((int)$question->qa($review->id))->name:'', $question->note($review->id)?$question->note($review->id)->note:''));
						}
					}

				}
		    });
		    /* Question scores */
		    $excel->sheet('Scores', function($sheet) use($review){
		    	$rqs = $review->rq->lists('id');
		    	$scores = ReviewQScore::whereIn('review_question_id', $rqs)->get();
		    	$sheet->appendRow(array('Question', 'Description', 'Points'));
		    	$counter = 0;
		    	foreach ($scores as $score) {
		    		$counter++;
		    		$rq = ReviewQuestion::find($score->review_question_id);
		    		$question = Question::find((int)$rq->question_id);
		    		$sheet->appendRow(array($counter, ($question->title?substr($question->title, 0, 4):substr($question->description, 0, 4)), $score->audited_score));
		    	}
		    });
		    /* Audit Summary */
		    $excel->sheet('Summary of Assessment Findings', function($sheet) use($summary){
		    	foreach ($summary as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });
		    /* Action plan - If any */
		    $excel->sheet('Action Plan', function($sheet) use($action_plan){
		    	foreach ($action_plan as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });

		})->download('xlsx');
	}
	public function noncompliance($id){
		$review = Review::find($id);
		Excel::create('Non-conformities for '.$review->lab->name.' '.$review->auditType->name.'_'.$review->id, function($excel) use($review){

		    $excel->sheet('Non Conformity Table', function($sheet) use($review){
		    	$sheet->appendRow(array(Lang::choice('messages.non-conformities', 1), Lang::choice('messages.recommendations', 1).'/'.Lang::choice('messages.comment', 2), Lang::choice('messages.checklist-question', 1), Lang::choice('messages.iso', 1), Lang::choice('messages.major-minor', 1)));
		    	foreach ($review->noncompliance() as $noncompliance) {
		    		$question = Question::find($noncompliance->question_id);
		    		$sheet->appendRow(array($noncompliance->note, '', $question->title?$question->title:''.$question->description, $question->info?$question->info:'', ''));
		    	}
		    });

		})->export('xlsx');
	}
	public function download($id){
		$review = Review::find($id);
		Excel::create('Audits Summary Sheet - '.date('d-m-Y H:i:s'), function($excel) use($review){

		    $excel->sheet('Audits per user', function($sheet) use($review){
		    	$sheet->appendRow(array(Lang::choice('messages.user', 1), Lang::choice('messages.total-audits', 1)));
		    	foreach (User::all() as $user) {
		    		$sheet->appendRow(array($user->name, $user->reviews->count()));
		    	}
		    });

		})->export('csv');
	}
	public function  pdfexport($id){
		$review = Review::find($id);        
		//	Get notes for main questions, sanitize and post to view
		$notes = $review->notes($id);

		$questions = [];
		foreach ($notes as $note) {
			array_push($questions, ReviewQuestion::find($note->review_question_id)->question_id);
		}
		//	Get audit type
		$audit = AuditType::find($review->audit_type_id);
		//Convert form to pdf		
        $pdf = PDFS::loadView('pdfdownload.pdf',compact('review', 'audit', 'notes', 'questions'));        
        return $pdf->download('pdf');
	}
}
$excel = App::make('excel');
