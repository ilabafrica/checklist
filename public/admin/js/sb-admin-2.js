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
/* Setting the score */
$("form input:radio").click(function(){
    alert($('input.radio').attr('name'));
});
$("form input:checkbox").click(function(){
    alert('Rihakoro');
});
/* End setting the score */
/* Setting the total */
/* End setting the total */