$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});
/* Custom js */
// Datatables
$(document).ready( function () {
    $('.search-table').DataTable({
        'bStateSave': true,
        'fnStateSave': function (oSettings, oData) {
            localStorage.setItem('.search-table', JSON.stringify(oData));
        },
        'fnStateLoad': function (oSettings) {
            return JSON.parse(localStorage.getItem('.search-table'));
        }
    });
});
//  Toggle password fields
/*Function to toggle password fields*/
function toggle(className, obj){
    var $input = $(obj);
    if($input.prop('checked'))
        $(className).hide();
    else
        $(className).show();
}
/*End toggle function*/
/* Bootstrap 3 datepicker */
$(function () {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});
/* End datepicker */
/*Dynamic loading of select list options*/
$('#section_id').change(function(){
    $.get("/reports/dropdown", 
        { option: $(this).val() }, 
        function(data) {
            var test_type = $('#test_type');
            test_type.empty();
            test_type.append("<option value=''>Select Test Type</option>");
            $.each(data, function(index, element) {
                test_type.append("<option value='"+ element.id +"'>" + element.name + "</option>");
            });
        });
});

/*End dynamic select list options*/
/* Toggle buttons */
$('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    if ($(this).find('.btn-primary').size()>0) {
        $(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
        $(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
        $(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
        $(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');
       
});
/* Dynamic loading of selected audit type */
$('#auditType').change(function(){
    $.get("/audit/select", 
        { option: $(this).val() }, 
        function(data) {
            var audit_type_id = $('#audit_type_id');
            audit_type_id.empty();
            $.each(data, function(index, element) {
                audit_type_id.val(element.id);
            });
        });
});
/* End dynamic selected audit type */
/* Functions to submit action plan without page reload */
function saveActionPlan(rid){
    follow_up_action =  $("#action_"+rid).val();
    responsible_person =  $("#person_"+rid).val();
    timeline =  $("#timeline_"+rid).val();
    var URL_ROOT = 'http://127.0.0.1/e-slipta/public/';
    _token: JSON.stringify($('input[name=_token]').val());
    $.ajax({
        type: 'POST',
        url:  URL_ROOT+'action/plan',
        data: {review_id: rid, follow_up_action: follow_up_action, responsible_person: responsible_person, timeline: timeline, action: "add", '_token': $('input[name=_token]').val()},
        success: function(){
            drawActionPlan(rid);
        }
    });
}
/**
 * Request a json string from the server containing contents of the action plan table for this review
 * and then draws a table based on this data.
 * @param  {int} rid      Review Id
 * @return {void}          No return
 */
function drawActionPlan(rid){
    var URL_ROOT = 'http://127.0.0.1/e-slipta/public/';
    $.getJSON(URL_ROOT+'action/plan', { review_id: rid, action: "draw"}, 
        function(data){
            var tableBody ="";
            $.each(data, function(index, elem){
                tableBody += "<tr>"
                +" <td>"+elem.action+" </td>"
                +" <td>"+elem.responsible_person+"</td>"
                +" <td>"+elem.timeline+"</td>"
                +" <td> </td>"
                +"</tr>";
            });
            tableBody += "<tr>"
                +"<td><textarea id='action_"+rid+"' class='form-control' rows='3'></textarea></td>"
                +"<td><textarea id='person_"+rid+"' class='form-control' rows='3'></textarea></td>"
                +"<td><textarea id='timeline_"+rid+"' class='form-control' rows='3'></textarea></td>"
                +"<td><a class='btn btn-sm btn-danger' href='javascript:void(0)' onclick='saveObservation("+rid+")'><i class='fa fa-save'></i> Save</a></td>"
                +"</tr>";
            $("#action_plan_"+rid).html(tableBody);
        }
    );
}
/* Setting the score */
/*$("form input:radio").click(function(){
    alert($('input.radio').attr('name'));
});
$("form input:checkbox").click(function(){
    alert('Rihakoro');
});*/
/* End setting the score */
/* Setting the total */
/* End setting the total */
/* Functions to watch radio buttons and set scores */
//  Function to return the question ID dynamically
function questionId(str){
    return str.split('_')[1];
}
//  Function to set the score for the main question if elements are selected
function noteChange(name, points){
    var id = questionId(name);
    var count = 0;
    var sum = 0;
    var na = 0;
    var questions = $('.radio_'+id).length;
    var answers = ['YES', 'PARTIAL', 'NO', 'NOT APPLICABLE'];
    $.each($('.radio_'+id), function(key, item){
        var txtId = 0;
        if( $(this).is(':checked')){
            if($(item).val() !== '3')
                sum+=parseInt($(this).val());
            count++;
            txtId = questionId($(this).attr('id'));
            if(parseInt($(item).val()) == 2 || parseInt($(item).val()) == 4){
                $('#text_'+txtId).prop('disabled', false);
                $('#text_'+txtId).addClass('form-control validate[required] text-input');
                $('#text_'+txtId).validationEngine('showPrompt', '* Comment(s) required on this field.', 'red', 'topLeft', true);
            }
            else if(parseInt($(item).val()) == 1){
                $('#text_'+txtId).prop('disabled', false);
                $('#text_'+txtId).validationEngine('hide');
                $('#text_'+txtId).addClass('form-control');
                $('#text_'+txtId).removeClass('validate[required] text-input');
            }
            else if(parseInt($(item).val()) == 3)
            {
                count--;
                na++;
                $('#text_'+txtId).prop('disabled', true);
            }
        }
    });
    if(sum==count && count!=0){
        $('#points_'+id).val(points).trigger('input');
        $('#answer_'+id).val(answers[0]);
        $('#text_'+id).validationEngine('hide');
        $('#text_'+id).removeClass('validate[required] text-input');
    }
    else if(sum==count*2  && count!=0){
        $('#points_'+id).val(0).trigger('input');
        $('#answer_'+id).val(answers[2]);
        $('#text_'+id).addClass('form-control validate[required] text-input');
    }
    else if(count==0)
    {
        $('#points_'+id).val(0).trigger('input');
        $('#answer_'+id).val(answers[3]);
        $('#text_'+id).validationEngine('hide');
        $('#text_'+id).removeClass('validate[required] text-input');
        $('#text_'+id).prop('disabled', true);
    }
    else{
        $('#points_'+id).val(1).trigger('input');
        $('#answer_'+id).val(answers[1]);        
        $('#text_'+id).addClass('form-control validate[required] text-input');
    }
}
//  Set score for main question
function scoreMain(name, points){
    var id = questionId(name);
    var count = 0;
    var answer = 0;
    $.each($('.radio_'+id), function(key, item){
        if( $(this).is(':checked')){
            if(parseInt($(this).val()) != 4)
                answer+=parseInt($(this).val());
            console.log(parseInt($(this).val()));
            if(parseInt($(this).val()) == 2 || parseInt($(this).val()) == 4){
                $('#text_'+id).prop('disabled', false);
                $('#text_'+id).addClass('form-control validate[required] text-input');
                $('#text_'+id).validationEngine('showPrompt', '* Comment(s) required on this field.', 'red', 'topLeft', true);
            }
            else if(parseInt($(this).val()) == 1){
                $('#text_'+id).prop('disabled', false);
                $('#text_'+id).validationEngine('hide');
                $('#text_'+id).removeClass('validate[required] text-input');
            }
            else if(parseInt($(this).val()) == 3)
            {
                $('#text_'+id).prop('disabled', true);
            }
        }    
    });
    if(answer == 1)
        $('#points_'+id).val(points).trigger('input');
    else if(answer == 2)
        $('#points_'+id).val(0).trigger('input');
    else if(answer == 3)
        $('#points_'+id).val(0).trigger('input');
    else
        $('#points_'+id).val(1).trigger('input');
}
//  Function to set the sub-total score for a section
function sub_total(name){
    var id = questionId(name);
    var sum = 0;
    $.each($('.page_'+id), function(){
        val = $(this).val();
        val = parseInt(val);
        val = (isNaN(val)) ? 0: val;
        sum+=val;
    });
    $('#subtotal_'+id).val(sum);
}
/*Toggle country/partner/lab-in-charge administrator*/
function partner(id){
    $('.partner'+id).toggle(this.checked);
}
function country(id){
    $('.nchi'+id).toggle(this.checked);
}

function lab(id){
    $('.laboratory'+id).toggle(this.checked);
}
/*Dynamic loading of select list options for country-partners*/
function load(id){
    cId = $('#country_'+id).val();
    var URL_ROOT = 'http://127.0.0.1/checklist/public/';
    _token: JSON.stringify($('input[name=_token]').val());
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url:  URL_ROOT+'partner/dropdown',
        data: {country_id: cId, '_token': $('input[name=_token]').val()},
        success: function(data){
            console.log(data);
            var partner = $('#partner'+id);
            partner.empty();
            partner.append("<option value=''>Select Partner</option>");
            $.each(data, function(index, element) {
                partner.append("<option value='"+ element.id +"'>" + element.name + "</option>");
            });
        }
    });
}
/*End dynamic select list options for country-partners*/

/** GLOBAL START   
 *  Alert on start
 */
$('.start-data-item-link').click(function(){
    var lab = $(this).data('lab');
    $('#lab').text(lab);
});
$('.start-data-modal').on('show.bs.modal', function(e) {
    $('#lab_id').val($(e.relatedTarget).data('id'));
});
/* 
* Prevent start modal form submit until audit type is selected
*/
$('#audit_type').change(function(){
    if($(this).val() !== '')
        $('.btn-start').prop('disabled', false);
    else
        $('.btn-start').prop('disabled', true);
});

/*Sexy radio buttons*/
$('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});