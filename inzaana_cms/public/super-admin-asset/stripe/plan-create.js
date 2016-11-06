/**
 * Created by sk Asadur Rahman on 9/25/2016.
 */
var symbol = {INR:'&#8377;',USD:'&#36;',BDT:'&#x9f3;'};

// numeric validation
$("#plan_amount").numeric();

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


$(document).on('change','#plan_interval',function(e){
    var interval = $('#plan_interval').val();
    if(interval == 'custom'){
        $("#interval_count").val(0);
        $('.custom').css('display','block');
    }
    else{
        $("#interval_count").val(0);
        $('.custom').css('display','none');
    }
});

$('#plan_amount').keypress(function (e) {
    var regex = new RegExp("^[0-9.]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }else{
        alert("Please input a valid amount.");
    }
    e.preventDefault();
    return false;
});


$('#interval_count').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }else{
        alert("Only number is allowed.");
    }
    e.preventDefault();
    return false;
});


$('#interval_count').on('blur',function () {
    if(this.value > 12 && this.value <= 52){
        $('#week').css('display','block');
        $('#week')
            .removeAttr('selected')
            .attr('selected', true);
        $('#mnth').css('display','none');
    }else if(this.value > 52 && this.value <= 365){
        $('#day')
            .removeAttr('selected')
            .attr('selected', true);
        $('#week').css('display','none');
    }else if(this.value <=12){

        $('#mnth').css('display','block');
        $('#week').css('display','block');

        $('#mnth')
            .removeAttr('selected')
            .attr('selected', true);
    }else{
        $('#interval_count').val(0);
        alert("Please input valid days.");
    }
});




