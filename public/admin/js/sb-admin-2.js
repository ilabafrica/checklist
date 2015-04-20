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

$('.radiocc').change(function(){
    var count = 0;
    $.each($('.radiocc'), function(){
        if( $(this).is(':checked')){
            console.log($(this).val());
        }    
    });
    //console.log(count);
})
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
function noteChange() {
  changed = true;
}
function getRadioClicked(name) {
  $("input:radio[name="+name+"]").click(function() {
    var value = $this.val();
  });
}
function click_sub_sec(name) {
    var ssid = name.substr(0, 5);
    $('#'+ssid+'_score').click();
}
function watch_yna(name, score) {
    var selector = "input[name='"+ name +"']";
    $(selector).change(function() {
        var out = 0;
        // alert($(this).val());
        switch($(this).val()) {
        case 'YES':
        case 'N/A':
            out = score;
            break;

        case 'NO':
            out = 0;
            break;
        default:
            out = 0;
        };
        $('#'+name+'_score').val(out.toString());
        $('#'+name+'_icon').remove();
        changed = true;
        set_total(name.substr(0,3));
    });
}

function watch_ynp(name, score) {
    var selector = "input[name='"+ name +"']";
    $(selector).change(function() {
        var out = 0;
        // alert($(this).val());
        switch($(this).val()) {
        case 'YES':
            out = score;
            break;
        case 'PARTIAL':
            out = 1;
            break;
        case 'NO':
            out = 0;
            break;
        default:
            out = 0;
        };
        $('#'+name+'_score').val(out.toString());
        $('#'+name+'_icon').remove();
        changed = true;
        if (name.length == 5) {// this is a sub section
            $('input[name="'+ name+'"]:checked').each( function() {
                $('#'+name+'_inc').val(0);
            });
        }
        set_total(name.substr(0,3));
    });
}
function set_score(id, score) {
    var ct = $('#'+id).attr('rel');
    var p = id.split('_')[0];
    var yesct = 0,
    noct = 0, 
    nact= 0,
    unset = 0;
    var val, thisid;
    $('input[name^="'+p+'"]:checked').each(function(i) {
        var thisname = $(this).attr('name');
        var x = p;
        if (thisname.substr(0, 5) == p && (thisname.substr(-2) == 'yn'
            || thisname.substr(-3) == 'yna'|| thisname.substr(-3) == 'ynp')) {
            switch($(this).val()) {
            case 'YES':
            case 'N/A':
                yesct++; 
                break;
            case 'NO': noct++;break;
            // what happens for PARTIAL
            default: unset++; 
            }
            
            var rel = $('#'+id).attr('rel');
            var calcval = 0;
            var ynp = 'NO';
            rel = parseInt(rel);
            if (yesct == rel) {
                calcval = score;
                ynp = 'YES';
            } else if (yesct <rel && yesct > 0) {
                calcval = 1;
                ynp = 'PARTIAL';
            } 
            var incct = rel - (yesct + noct);
            $('#'+p+'_inc').val(incct.toString());
            $('#'+id).val(calcval.toString());
            $('#'+p+'_ynp').val(ynp);
            set_total(id.substr(0,3));
        }
    });
}

function set_total(id) {
    var myid = id+ '_total';
    var incid = id + '_secinc';
    var total = 0;
    var val, abc;
   $('input[name$="_score"]').each( function(i) {
       val = $(this).val();
       val = parseInt(val);
       val = (isNaN(val)) ? 0: val;
       total = total + val;
       $('#'+myid).val(total);
       abc = 0;
   });
   total = 0;
   $('input[name$="_inc"]').each( function(i) {
       val = $(this).val();
       val = parseInt(val);
       val = (isNaN(val)) ? 0: val;
       total = total + val;
       $('#'+incid).val(total);
       abc = 0;
   });
    var xx= 0;
}
function count_ynaa_add(name) {
    var yesct = 0,
        noct = 0, 
        nact= 0;
    var i, val;
    $('input[name$="_ynaa"]:checked').each( function(i) {
        switch($(this).val()) {
        case 'YES': yesct++; break;
        case 'NO':  noct++; break;
        case 'N/A': nact++; break;
        default: 
        }
        $('#'+name+'_y_ct').val(yesct);
        $('#'+name+'_n_ct').val(noct);
        $('#'+name+'_na_ct').val(nact);
    });
    var na;
}

function count_ynp_add(name) {
    var yesct = 0,
        noct = 0, 
        pct= 0;
    var i, val;
    $('input[name$="_ynp"]:checked').each( function(i) {
        switch($(this).val()) {
        case 'YES': yesct++; break;
        case 'NO':  noct++; break;
        case 'PARTIAL': pct++; break;
        default: 
        }
        $('#'+name+'_y_ct').val(yesct);
        $('#'+name+'_n_ct').val(noct);
        $('#'+name+'_p_ct').val(pct);
    });
    var na;
}