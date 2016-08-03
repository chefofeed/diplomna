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
$("#Selector").change(function(){
    console.log($(this).val());
    var html = '';
    switch ($(this).val()){
        case '1':
            html = '<input type = "text">';
            
            break;
        case '2':
            html = '<div class="row">'+
                 '<div class="col-lg-6">'+
    '<div class="input-group">'+
      '<span class="input-group-addon">'+
        '<input type="checkbox" aria-label="...">'+
      '</span>'+
      '<input type="text" class="form-control" aria-label="...">'+
    '</div></div></div>'
                    +
                '<div class="row">'+
                 '<div class="col-lg-6">'+
    '<div class="input-group">'+
      '<span class="input-group-addon">'+
        '<input type="checkbox" aria-label="...">'+
      '</span>'+
      '<input type="text" class="form-control" id ="shadow" aria-label="...">'+
    '</div></div></div>';
            break;
        case '3':
            html = '<select name="list" form="form">';
            break;
        case '4':
           html = '<div class="row">'+
                 '<div class="col-lg-6">'+
    '<div class="input-group">'+
      '<span class="input-group-addon">'+
        '<input type="radio" aria-label="...">'+
      '</span>'+
      '<input type="text" class="form-control" aria-label="...">'+
    '</div></div></div>'
                    +
                '<div class="row">'+
                 '<div class="col-lg-6">'+
    '<div class="input-group">'+
      '<span class="input-group-addon">'+
        '<input type="radio" aria-label="...">'+
      '</span>'+
      '<input type="text" class="form-control" id ="shadow" aria-label="...">'+
    '</div></div></div>';
            break;
        
    }
    $('#content').html(html);
    
});