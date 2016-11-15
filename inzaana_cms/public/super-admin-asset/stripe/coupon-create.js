/**
 * Created by sk on 11/12/2016.
 */

var symbol = {INR:'&#8377;',USD:'&#36;',BDT:'&#x9f3;'};

$('#redem_by').datepicker({
    format: 'dd-mm-yyyy'
});

$('[data-toggle="tooltip"]').tooltip();

// numeric validation
$('#max_redemptions').numeric();
$("#amount_off").numeric(); // This is use for decimal validation like only one dot in a number (12.5) not (12.5.5)

$('#amount_off').keypress(function (e) {
    var regex = new RegExp("^[0-9.]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }else{
        alert("It takes only valid number.");
    }
    e.preventDefault();
    return false;
});

$('#max_redemptions').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }else{
        alert("It takes only positive integer.");
    }
    e.preventDefault();
    return false;
});

$('#percent_off').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }else{
        alert("It takes only positive integer.");
    }
    e.preventDefault();
    return false;
});

$('#percent_off').blur(function () {
    var value = $('#percent_off').val();

    if(value > 0 && value <= 100){
        return true;
    }else if(value.length == 0){
        return true;
    }
    else if(value == 0 || value > 100){
        $('#percent_off').val(1);
        alert("It should be take between 1 to 100.");
    }

});


$(document).on('change','#currency',function(e){
    con = $('#currency').val();
    $('#symbol').html(symbol[con]);
});

$('#plan_amount').on('blur',function () {
    if( this.value != ''){
        amount = Number($('#plan_amount').val());
        $('#plan_amount').val(amount.toFixed(2));
    }
    if(this.value == '0.00'){
        $("#required_input").prop('disabled',false);
        $("#required_input").prop('required',true);
        $("#required_field").html('*');
    }else{
        $("#required_input").prop('disabled',true);
        $("#required_field").html('');
    }
});



$(document).on('change','#repeating',function(e){
    var duration = $('#repeating').attr('value');
    if(duration == 'repeating'){
        $("#duration_in_months").val(2);
        $('#view_repeating').css('display','block');
    }
    else{
        $("#duration_in_months").val(2);
        $('#view_repeating').css('display','none');
    }
});


$( "input[type=checkbox]" ).on( "click", function (e) {
    var len = $( "input:checked" ).length;
    if(len){
        $('#percent_off').val(null);
        $('#percent_off_block').css('display','none');
        $('#amount_off_block').css('display','block');
    }else{
        $('#amount_off').val(null);
        $('#amount_off_block').css('display','none');
        $('#percent_off_block').css('display','block');
    }
});

$('#field').keyup(function () {
    var max = 22;
    var len = $(this).val().length;
    if (len >= max) {
        $('#charNum').html('<p class="text-red">You have reached the limit</p>');
    } else {
        var char = max - len;
        $('#charNum').html('<p class="text-green">'+char + ' characters left</p>');
    }
});

