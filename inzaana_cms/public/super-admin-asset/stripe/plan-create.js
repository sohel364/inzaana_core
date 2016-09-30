/**
 * Created by sk Asadur Rahman on 9/25/2016.
 */
var symbol = {INR:'&#8377;',USD:'&#36;',BDT:'&#x9f3;'}

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
