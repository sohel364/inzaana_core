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
});
