<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Section;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Lang;
use Excel;
use App;

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
		$data = array();
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
		$chart = '{
        "chart": {
            "type": "column"
        },
        "title": {
            "text": "Monthly Average Rainfall"
        },
        "subtitle": {
            "text": "Source: WorldClimate.com"
        },
        "xAxis": {
            "type": "category",
            "crosshair": true
        },
        "yAxis": {
            "min": "0",
            "title": {
                "text": "Rainfall (mm)"
            }
        },
        "plotOptions": {
            "column": {
                "pointPadding": "0.2",
                "borderWidth": "0"
            }
        },
        "credits": {
	        "enabled": false
	    },
        "series": [{
            "data": [';
            foreach($categories as $section){
            	$chart.= $section->subtotal($review->id).',';
            }
            $chart.= ']
        }]
    });
}';

	$options = '{
	      	type: "column2d",
	      	renderAt: "chartContainer",
	      	width: "100%",
	      	height: "400",
	      	dataFormat: "json",
	      	dataSource: {
	       	"chart": {
	          	"caption": "'.$review->lab->facility->name.'",
	          	"subCaption": "% Score by Section",
	          	"xAxisName": "'.Lang::choice('messages.section', 1).'",
	          	"yAxisName": "Score in %",
	          	"theme": "zune"
	       	},
	       	"data": [';
	       	foreach ($categories as $section) {
	       		$options.='{
	       			"label": "'.$section->name.'",
	       			"value": "'.round($section->subtotal($review->id)*100/$section->total_points, 2).'"
	       		},';
	       	}
	       	$options.='
	        	]
	      	}
	 
	  	}';
	  	$spider = '{
	      	type: "radar",
	      	renderAt: "chartContainer",
	      	width: "100%",
	      	height: "400",
	      	dataFormat: "json",
	      	dataSource: {
	       	"chart": {
	          	"caption": "'.$review->lab->facility->name.'",
	          	"subCaption": "% Score by Section",
	          	"xAxisName": "'.Lang::choice('messages.section', 1).'",
	          	"yAxisName": "Score in %",
	          	"theme": "zune",
	          	"radarFillColor": "#fffffff"
	       	},
	       	"categories":[{
	       		"category": [';
	       		foreach ($categories as $section) {
	       			$spider.='{
	       				"label": "'.$section->name.'"
	       			},';
	       			}
	       		$spider.=']

	       	}],
	       	"dataset": [
	       		{
	       			"seriesName": "% Score per section",
	       			"data": [';
	       				foreach ($categories as $section) {
	       					$spider.='{
	       						"value": "'.round($section->subtotal($review->id)*100/$section->total_points, 2).'"
	       					},';
	       				}
	       			$spider.=']
	       		}
	        	]
	      	}
	 
	  	}';
	  	$high = '{

        "chart": {
            "polar": true,
            "type": "line"
        },

        "title": {
            "text": "'.$review->lab->facility->name.'",
            "x": -80
        },

        "pane": {
            "size": "80%"
        },

        "xAxis": {
            "categories": [';
            	$high.=implode(',', $categories);
            $high.='],
            "tickmarkPlacement": "on",
            "lineWidth": "0"
        },

        "yAxis": {
            "gridLineInterpolation": "polygon",
            "lineWidth": "0",
            "min": "0"
        },

        "tooltip": {
            "shared": "true",
            "pointFormat": "<span style=\"color:{series.color}\">{series.name}: <b>${point.y:,.0f}</b><br/>"
        },

        "legend": {
            "align": "right",
            "verticalAlign": "top",
            "y": 70,
            "layout": "vertical"
        },

        "series": [{
            "name": "Score in %",
            "data": [';
            	foreach ($categories as $section) {
   					$high.=round($section->subtotal($review->id)*100/$section->total_points, 2).',';
   				}
   				$high.='],
            "pointPlacement": "on"
        }]

    }';
		return view('report.index', compact('review', 'options', 'spider'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	/* Export audit data to excel */
	public function export($id){
		$review = Review::find($id);
		$lab_info = array(
			array('Field', 'Value'),
			array(Lang::choice('messages.lab-name', 1), $review->lab->facility->name),
			array(Lang::choice('messages.lab-number', 1), $review->lab->id),
			array(Lang::choice('messages.lab-address', 1), $review->lab->facility->address.'-'.$review->lab->facility->town->postal_code.', '.$review->lab->facility->town->name),
			array(Lang::choice('messages.lab-telephone', 1), $review->lab->facility->telephone),
			array(Lang::choice('messages.lab-fax', 1), $review->lab->facility->fax),
			array(Lang::choice('messages.lab-email', 1), $review->lab->facility->email),
			array(Lang::choice('messages.lab-head', 1), $review->laboratory()->head),
			array(Lang::choice('messages.lab-head-telephone-personal', 1), $review->laboratory()->head_personal_telephone),
			array(Lang::choice('messages.lab-head-telephone-work', 1), $review->laboratory()->head_work_telephone),
			array(Lang::choice('messages.lab-level', 1), $review->lab->labLevel->name),
			array(Lang::choice('messages.lab-affiliation', 1), $review->lab->labAffiliation->name)
			);
		$staffing_summary = array(
			array('Profession', 'Employees', 'Adequate'),
			array(Lang::choice('messages.degree', 1), $review->laboratory()->degree_staff, $review->adequate($review->laboratory()->degree_staff_adequate)),
			array(Lang::choice('messages.diploma', 1), $review->laboratory()->diploma_staff, $review->adequate($review->laboratory()->diploma_staff_adequate)),
			array(Lang::choice('messages.certificate', 1), $review->laboratory()->certificate_staff, $review->adequate($review->laboratory()->certificate_staff_adequate)),
			array(Lang::choice('messages.microscopist', 1), $review->laboratory()->microscopist, $review->adequate($review->laboratory()->microscopist_adequate)),
			array(Lang::choice('messages.data-clerk', 1), $review->laboratory()->data_clerk, $review->adequate($review->laboratory()->data_clerk_adequate)),
			array(Lang::choice('messages.phlebotomist', 1), $review->laboratory()->phlebotomist, $review->adequate($review->laboratory()->phlebotomist_adequate)),
			array(Lang::choice('messages.cleaner', 1), $review->laboratory()->cleaner, $review->adequate($review->laboratory()->cleaner_adequate)),
			array(Lang::choice('messages.cleaner-dedicated', 1), $review->adequate($review->laboratory()->cleaner_dedicated), ''),
			array(Lang::choice('messages.cleaner-trained', 1), $review->adequate($review->laboratory()->cleaner_trained), ''),
			array(Lang::choice('messages.driver', 1), $review->laboratory()->driver, $review->adequate($review->laboratory()->driver_adequate)),
			array(Lang::choice('messages.driver-dedicated', 1), $review->adequate($review->laboratory()->driver_dedicated), ''),
			array(Lang::choice('messages.driver-trained', 1), $review->adequate($review->laboratory()->driver_trained), ''),
			array(Lang::choice('messages.other', 1), $review->laboratory()->other_staff, $review->adequate($review->laboratory()->other_staff_adequate))
		);
		$slmta_info = array(
			array('Field', 'Value'),
			array(Lang::choice('messages.official-slmta', 1), $review->slmta()->official_slmta == Review::OFFICIAL?Lang::choice('messages.yes', 1):Lang::choice('messages.no', 1)),
			array(Lang::choice('messages.audit-start-date', 1), $review->slmta()->audit_start_date),
			array(Lang::choice('messages.audit-end-date', 1), $review->slmta()->audit_end_date),
			array(Lang::choice('messages.names-affiliations-of-auditors', 1), implode(", ", $review->assessors->lists('name'))),
			array(Lang::choice('messages.slmta-audit-type', 1), $review->assessment($review->slmta()->assessment_id)->name),
			array(Lang::choice('messages.tests-before-slmta', 1), $review->slmta()->tests_before_slmta),
			array(Lang::choice('messages.tests-this-year', 1), $review->slmta()->tests_this_year),
			array(Lang::choice('messages.cohort-id', 1), $review->slmta()->cohort_id),
			array(Lang::choice('messages.slmta-lab-type', 1), $review->lab->labType->name),
			array(Lang::choice('messages.baseline-audit-date', 1), $review->slmta()->baseline_audit_date),
			array(Lang::choice('messages.slmta-workshop-date', 1), $review->slmta()->slmta_workshop_date),
			array(Lang::choice('messages.exit-audit-date', 1), $review->slmta()->exit_audit_date),
			array(Lang::choice('messages.baseline-score', 1), $review->slmta()->baseline_score),
			array(Lang::choice('messages.baseline-stars', 1), $review->stars($review->slmta()->baseline_stars_obtained)),
			array(Lang::choice('messages.exit-score', 1), $review->slmta()->exit_score),
			array(Lang::choice('messages.exit-stars', 1), $review->stars($review->slmta()->exit_stars_obtained)),
			array(Lang::choice('messages.last-audit-date', 1), $review->slmta()->last_audit_date),
			array(Lang::choice('messages.last-audit-score', 1), $review->slmta()->last_audit_score),
			array(Lang::choice('messages.prior-audit-status', 1), $review->stars($review->slmta()->prior_audit_status))
		);
		$org_structure = array(
			array('Field', 'Value'),
			array(Lang::choice('messages.sufficient-space', 1), $review->adequate($review->laboratory()->sufficient_space)),
			array(Lang::choice('messages.equipment', 1), $review->adequate($review->laboratory()->equipment)),
			array(Lang::choice('messages.supplies', 1), $review->adequate($review->laboratory()->supplies)),
			array(Lang::choice('messages.personnel', 1), $review->adequate($review->laboratory()->personnel)),
			array(Lang::choice('messages.infrastructure', 1), $review->adequate($review->laboratory()->infrastructure)),
			array(Lang::choice('messages.other-specify', 1).': '.$review->laboratory()->other_description, $review->adequate($review->laboratory()->other))
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
		Excel::create($review->lab->facility->name, function($excel) use ($lab_info, $slmta_info, $staffing_summary, $org_structure, $summary, $action_plan, $review, $categories) {

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
		    $excel->sheet('Organizational Structure', function($sheet) use($org_structure){
		    	foreach ($org_structure as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });
		    /* SLMTA Info */
		    $excel->sheet('SLMTA Information', function($sheet) use($slmta_info){
		    	foreach ($slmta_info as $value) {
		    		$sheet->appendRow($value);
		    	}
		    });
		    /* Audit Details */
		    $excel->sheet('Assessment Details', function($sheet) use($review, $categories){
		    	$sheet->appendRow(array('Question', 'Description', 'Response', 'Notes', 'Compliance'));
		    	foreach ($categories as $section) {
					//$sheet->appendRow(Lang::choice('messages.question', 1), Lang::choice('messages.response', 1), Lang::choice('messages.notes', 1));
					foreach ($section->questions as $question) {
						if(count($question->children)>0){
							$sheet->appendRow(array($question->id, $question->title.''.$question->description));
							foreach($question->children as $kid){
								$sheet->appendRow(array($kid->id, $kid->title?$kid->title:''.$kid->description, $kid->qa($review->id)?Answer::find((int)$kid->qa($review->id)[0])->name:'', $kid->note($review->id)->note, $kid->note($review->id)->non_compliance==Answer::NONCOMPLIANT?Lang::choice('messages.non-compliant', 1):''));
							}
						}
						elseif($question->score != 0){
							$sheet->appendRow(array($question->id, $question->title?$question->title:''.$question->description, $question->qa($review->id)?Answer::find((int)$question->qa($review->id)[0])->name:'', $question->note($review->id)->note, $question->note($review->id)->non_compliance==Answer::NONCOMPLIANT?Lang::choice('messages.non-compliant', 1):''));
						}
					}

				}
		    });
		    /* Question scores */
		    $excel->sheet('Scores', function($sheet) use($review){
		    	$scores = DB::table('review_question_scores')->where('review_id', $review->id)->get();
		    	$sheet->appendRow(array('Question', 'Description', 'Points'));
		    	foreach ($scores as $score) {
		    		$sheet->appendRow(array($score->question_id, (Question::find((int)$score->question_id)->title?substr(Question::find((int)$score->question_id)->title, 0, 4):substr(Question::find((int)$score->question_id)->description, 0, 4)), $score->audited_score));
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
		Excel::create('Non-conformities for '.$review->lab->facility->name.' '.$review->auditType->name.'_'.$review->id, function($excel) use($review){

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
}
$excel = App::make('excel');