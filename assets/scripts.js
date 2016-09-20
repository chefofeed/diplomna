$( document ).ready(function() {
    console.log( "ready!" );
    $('#tokecode').select();
});

$(function () {
    // Side Bar Toggle
    $('.hide-sidebar').click(function () {
        $('#sidebar').hide('fast', function () {
            $('#content').removeClass('span9');
            $('#content').addClass('span12');
            $('.hide-sidebar').hide();
            $('.show-sidebar').show();
        });
    });

    $('.show-sidebar').click(function () {
        $('#content').removeClass('span12');
        $('#content').addClass('span9');
        $('.show-sidebar').hide();
        $('.hide-sidebar').show();
        $('#sidebar').show('fast');
    });
//});S
//$(document).ready(function() {
// // executes when HTML-Document is loaded and DOM is ready
// $('#pol').click(function () {
//    console.log("success");
//    $.get("html/poll.php", function (data) {
//        $(".poll_body").html(data);
//        alert("Load was performed.");
//    });
//    
//});
// alert("document is ready");
});

//function myFunction() {
//    var x = document.getElementById("mySelect").value;
//    document.getElementById("demo").innerHTML = "You selected: " + x;
//}


$('body').on('change', '#Selector', function () {
    var html = '';
    switch ($(this).val()) {
        case '2':
            html = '<div class="row"><div class="col-lg-6">' +
                    '<input type="text" class="form-control answer" aria-label="..." value=" your text here!" disabled="disabled">' +
                    '</div></div></div>';

            break;
        case '3':
            if ($('#content input[type="radio"], #content input.list').length > 0) {
                $('#content input[type="radio"], #content input[type="hidden"]').each(function (ind, el) {
                    $(el).attr('type', 'checkbox');
                });
                return;
            }
            html = '<div class="row"><div class="col-lg-6"><div class="input-group"><span class="input-group-addon">' +
                    '<input type="checkbox" aria-label="..." class="type" disabled="disabled"></span><input type="text" class="form-control  " aria-label="..." value="Option 1">' +
                    '</div></div></div>'
                    +
                    '<div class="row"><div class="col-lg-6"><div class="input-group">' +
                    '<span class="input-group-addon "><input type="checkbox" aria-label="..." class="type" disabled="disabled"></span>' +
                    '<input type="text" class="form-control shadow answer"  value="click to add option"  aria-label="...">' +
                    '</div></div></div>';
            break;
        case '4':
            if ($('#content input[type="checkbox"], #content input[type="radio"]').length > 0) {
                $('#content input[type="checkbox"], #content input[type="radio"]').each(function (ind, el) {
                    $(el).attr('type', 'hidden');
                });
                return;
            }
            html =
                    '<div class="row"><div class="col-lg-6">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">' +
                    '<input  type="hidden" aria-label="..."  class="type" name="optionsRadios" id="optionsRadios2" disabled="disabled"></span>' +
                    '<input type="text" class="form-control list answer" aria-label="..." value="Option 1">' +
                    '</div></div></div>' +
                    '<div class="row"><div class="col-lg-6">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">' +
                    '<input  type="hidden" aria-label="..."  class="type" name="optionsRadios" id="optionsRadios2" disabled="disabled"></span>' +
                    '<input type="text" class="form-control shadow list answer" aria-label="..." value="click to add option">' +
                    '</div></div></div>';
            break;
        case '5':
            if ($('#content input[type="checkbox"], #content input[type="hidden"]').length > 0) {
                $('#content input[type="checkbox"], #content input[type="hidden"]').each(function (ind, el) {
                    $(el).attr('type', 'radio');
                });
                return;
            }
            html = '<div class="row"><div class="col-lg-6">' +
                    '<div class="input-group"><span class="input-group-addon ">' +
                    '<input type="radio" aria-label="..." class="type" name="optionsRadios" id="optionsRadios1" disabled="disabled"></span>' +
                    '<input type="text" class="form-control answer" aria-label="..." value="Option 1" >' +
                    '</div></div></div>'
                    +
                    '<div class="row" ><div class="col-lg-6" ><div class="input-group" >' +
                    '<span class="input-group-addon">' +
                    '<input  type="radio" aria-label="..."  class="type" name="optionsRadios" id="optionsRadios2" disabled="disabled"></span>' +
                    '<input type="text" class="form-control shadow answer" value="click to add option"   aria-label="..." ' +
                    '</div></div></div>';
            break;
        case '6':
            html = '<div class="row"><div class="col-lg-6"><div class="textarea answer">your text</div></div></div>';
            break;
    }
    $('#content').html(html);

});
//add new element
$('body').on('click', '.shadow ', function () {
    var button = '<span class="input-group-btn"><button class="btn btn-default remove_option" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></span>';
    var element = $(this).closest('.row').clone();
    var index = $('#content .row').index($(this).closest('.row')) + 1;
    if (index == 2) {
        $('#content .row:eq(0) .input-group').append(button);
    }
    $(this).closest('.input-group').append(button);

    $(this).removeClass('shadow').val('Option ' + index);
    $('#content').append(element);

});

$('body').on('click', '.remove_option', function () {
    $(this).closest('.row').remove();
    if ($('#content .row').length <= 2) {
        $('#content .row:eq(0) span:has(".remove_option")').remove();
    }
});

$('body').on('mouseenter', '.question', function () {
    $(this).css("border", "3px");
    $(this).css("border", "double");
    $(this).css("border-color", "red");
    $(this).css("border-radius", "10px");
    $('.row-buttons button', this).removeClass('hidden');
});

$('body').on('mouseleave', '.question', function () {
    $(this).css("border", "0px");
    $(this).css("border", "none");
    $('.row-buttons button', this).addClass('hidden');
});

$('body').on('click', '.question .option', function () {
    var container = $(this).closest('.question');
    var quest = container.clone();
    container.empty();
    var html = '<div class="edit-question">' +
            '<div class="form-group">' +
            '<input type="text" name="question-title" value="Question title" class="form-control">' +
            '</div>' +
            '<div class="form-group">' +
            '<input type="text" name="htext" value="Help text" class="form-control">' +
            '</div>' +
            '<label>Question Type:</label>' +
            '<select id="Selector">' +
            '<option value="1">Select </option>' +
            '<option value="2">Text </option>' +
            '<option value="3">Multiple choice </option>' +
            '<option value="4">Choose from a list </option>' +
            '<option value="5">Radio button </option>' +
            '<option value="6">Paragraph text</option>' +
            '</select>' +
            '<div id="content" class="container-fluid">' +
            ' </div>' +
            '<div class="form-group">' +
            '<button type="button" class="btn btn-primary  ready">Done</button>' +
            ' </div> </div>';

    container.append(html);
    var title = quest.find('h2').html();
    container.find('[name="question-title"]').val(title);

    var helptext = quest.find('[name="htext"]').val();
    container.find('[name="htext"]').val(helptext);
    var type = undefined;
    quest.find('.option').each(function (ind, el) {
        type = $(el).find('input').attr('type');
        if (type != undefined) {
            switch (type) {
                case 'radio':
                {
                    $('#Selector').val(5);
                    $('#content').append('<div class="row"><div class="col-lg-6">' +
                            '<div class="input-group"><span class="input-group-addon">' +
                            '<input type="radio" aria-label="..."  class="type" name="optionsRadios" id="optionsRadios1" disabled="disabled"></span>' +
                            '<input type="text" class="form-control answer" aria-label="..." value="" >' +
                            '</div></div></div>');
                    $('#content input[type="text"]').last().val($(el).find('input[type="text"]').val());
                    break;
                }
                case 'list':
                {
                    $('#Selector').val(4);
                    $('#content').append('<div class="row"><div class="col-lg-6">' +
                            '<div class="input-group"><span class="input-group-addon">' +
                            '<input type="hidden" aria-label="..." class="type" name="optionsRadios" id="optionsRadios1" disabled="disabled"></span>' +
                            '<input type="text" class="form-control answer" aria-label="..." value="" >' +
                            '</div></div></div>');
                    $('#content input[type="text"]').last().val($(el).find('input[type="text"]').val());
                    break;
                }
                case 'text':
                {
                    $('#Selector').val(2);
                    $('#content').append('<div class="row"><div class="col-lg-6"><div class="form-group">' +
                            '<input type="text" class="form-control answer" aria-label="..." value="Add your text here!" disabled="disabled">' +
                            '</div></div></div></div>');
                    break;
                }
                case 'Paragraph':
                {
                    $('#Selector').val(6);
                    $('#content').append('<div class="row"><div class="col-lg-6"><div class="form-group">' +
                            '<input type="textarea" class="form-control answer" aria-label="..." value=" text here!" disabled="disabled">' +
                            '</div></div></div></div>');
                    break;
                }
                case 'checkbox':
                {
                    $('#Selector').val(3);
                    $('#content').append('<div class="row"><div class="col-lg-6">' +
                            '<div class="input-group"><span class="input-group-addon">' +
                            '<input type="checkbox" aria-label="..." class="type" name="optionsRadios" id="optionsRadios1" disabled="disabled"></span>' +
                            '<input type="text" class="form-control answer" aria-label="..." value="" >' +
                            '</div></div></div>');
                    $('#content input[type="text"]').last().val($(el).find('input[type="text"]').val());
                    break;

                }
            }

        }
    });

    if (type != undefined && type != 'text') {
        $('#content').append('<div class="row"><div class="col-lg-6">' +
                '<div class="input-group">' +
                '<span class="input-group-addon">' +
                '<input  type="' + type + '" aria-label="..." class="type" name="optionsRadios" id="optionsRadios2" disabled="disabled"></span>' +
                '<input type="text" class="form-control shadow list" aria-label="..." value="click to add option">' +
                '</div></div></div>');
    }
});
$('body').on('click', '.ready', function () {
    //get values
    var title = $('[name="question-title"]').val();
    var helptext = $('[name="htext"]').val();
    var type = $('#Selector').val();
    var values = new Array();
    var container = $(this).closest('.question');
    switch (type) {
        case'3':
        case'4':
        case'5':
            $('#content input[type="text"]:not(".shadow")').each(function (ind, el) {
                values.push($(el).val());
            });
            break;
    }

    $(this).closest('.question').empty();
    if (title == undefined || title == '') {
        title = "Untitled Question";
    }
    var html = '<h2>' + title + '</h2>';
    html += '<input type="hidden" name="htext" value="' + helptext + '">';
    switch (type) {
        case'2':
            html += '<div class="form-group option"><input  class="type" type="text" disabled="disabled"></div>';
            break;
        case '3':
            for (var i = 0; i < values.length; i++) {
                html += '<div class="row"><div class="col-lg-6">' +
                        '<div class="input-group option">' +
                        '<span class="input-group-addon">' +
                        '<input type="checkbox" aria-label="..."  class="type"name="optionsRadios" id="optionsRadios1" disabled="disabled"></span>' +
                        '<input type="text" class="form-control answer" aria-label="..." value="' + values[i] + '" >' +
                        '</div></div></div>';
            }
            break;
        case '4':
            for (var i = 0; i < values.length; i++) {
                html += '<div class="row"><div class="col-lg-6">' +
                        '<div class="input-group">' +
                        '<span class="input-group-addon">' +
                        '<input  type="hidden" aria-label="..." class="type" name="optionsRadios" id="optionsRadios2" disabled="disabled"></span>' +
                        '<input type="text" class="form-control list" aria-label="..." value="' + values[i] + '">' +
                        '</div></div></div>';

            }
            break;
        case '5':
            for (var i = 0; i < values.length; i++) {
                html += '<div class="row"><div class="col-lg-6">' +
                        '<div class="input-group option"><span class="input-group-addon ">' +
                        '<input type="radio"  class="type" aria-label="..." name="optionsRadios" id="optionsRadios1" disabled="disabled"></span>' +
                        '<input type="text" class="form-control answer" aria-label="..." value="' + values[i] + '" >' +
                        '</div></div></div>';
            }
            break;
        case'6':
            html += '<div class="row"><div class="col-lg-6"><div class="textarea option  type">your text</div></div></div>';
            break;
    }
    container.append(html);
//    console.log(html);
});
//submit button on click
$('body').on('click','#submit-question', function () {
    var data = {};
    data['formtitle'] = $('[name="formtitle"]').val();
    data['description'] = $('[name="formdescription"]').val();
    data['single_response']=$('#single_response').is(':checked') ? true: false;
    data['edit_response']=$('#edit_response').is(':checked') ? true: false;
    data['shuffle_question']=$('#shuffle_question').is(':checked') ? true: false;
    console.log(data); 
     
    data['questions'] = new Array;
    $('.question').each(function (i, el) {
        data['questions'][i] = {};
        data['questions'][i]['question'] = $('h2', this).html();
        data['questions'][i]['type'] = $('.type', this).is('div.textarea') ? 'textarea' : $('.type', this).attr('type');
        data['questions'][i]['answers'] = new Array;
        if (data['questions'][i]['type'] == 'text') {
            return true;
        }
        $('.answer').each(function (j, el) {
            data['questions'][i]['answers'][j] = $(el).val();

        });
    });
    $.post('savesurvey.php', data, function (resp) {
//        console.log(resp);
        return;
    });
});

$('body').on('click','#add_question', function () {
    var html = '<div class="question">' +
            '<div class="row">' +
            '<div class="col-lg-6">' +
            '<div class="form-group">' +
            '<h2>Untitled Question</h2>' +
            '</div>' +
            '<input type="hidden" name="htext" >' +
            '<div class="input-group option">' +
            '<span class="input-group-addon">' +
            '<input type="radio" aria-label="..." class="type"></span>' +
            '<input type="text" class="form-control" aria-label="..."class="form-control answer" value="Option 1">' +
            '</div>' +
            '</div><div></div>';
    $(this).before(html);
});
$('body').on('click', '#blank', function () {
    var data = {};
    
    $.post('blank.php', data, function (resp) {
        $('#page_content').html(resp);
//        console.log(resp);
    });
});

$('body').on('click', '.survey', function () {
    var data = {};
    data['id'] = $(this).attr('id');
    $.post('get_survey.php', data, function (resp) {
        $('#page_content').html(resp);
//        console.log(resp);
    });
});


$('body').on('shown.bs.modal', '#modal',function () {
    console.log($('#tokencode'));
    $('#tokencode').focus();
    $('#tokencode').select();
});  
$('body').on('click', '#submit-vote', function () {
    var data = {};
    data['questions'] = new Array;
    console.log($('#ftitle'));
    console.log($('#ftitle').attr('survey-id'));
    data['survey-id']= $('#ftitle').attr('survey-id');
    $('.question_vote').each (function(ind, el){
    var question = {};
        question['qid']=$(this).attr('id');
        question['type'] = $(this).attr('type');
        switch ($(this).attr('type')) {
             case'text':
                question['text'] = $('input[type="text"]', this).val();
            break;
        case 'checkbox':
            var ids = new Array;
            $('input[type="checkbox"]:checked', this).each(function(){
                ids.push($(this).attr('id'));
            });
            question['id'] = ids;
            break;
        case 'textarea':
            question['text'] = $('textarea', this).val();
            break;
        case 'radio': 
            question['id'] = $('input[type="radio"]:checked', this).attr('id');
            break;
        case 'hidden':
            question['id'] = $('select', this).val();  
            break;
//    //$("#yourdropdownid").change(function() {
//    console.log($("option:selected", this).text()); //text
//    console.log($(this).val()); //value
//})
        }
        data['questions'][ind] = question;
    });
    console.log(data);
    $.post('save_vote.php', data, function (resp) {
      //$('#page_content').html(resp);
      console.log(resp);

    });
});
   
$('body').on('click', '.cmd-edit', function () {
    $('.question .option').click();
});

$('body').on('click', '.cmd-duplicate', function () {
    var copy = $(this).parents('.question').clone();
     $(this).parents('.question').after(copy);
});
$('body').on('click', '.cmd-delete', function () {
    var data = {}; 
    data['question-id']= $(this).parents('.question').attr('id');
    data['survey-id']= $('#survey').attr('survey_id');
    console.log(data);
    var question = this;
    $.post('delete-question.php', data, function (resp) {
        console.log(resp);
        console.log(resp['success']);
        if(resp['success'] == true){
            console.log('del');
            $(question).parents('.question').remove();
        }
    }, 'json');  
});

$('body').on('click', '.show-chart', function () {
    $(this).parents('.switchable').find('.question-chart').removeClass('hidden');
    $(this).parents('.question-table').addClass('hidden');
});

$('body').on('click', '.show-table', function () {
    $(this).parents('.switchable').find('.question-chart').addClass('hidden');
    $(this).parents('.switchable').find('.question-table').removeClass('hidden');
});