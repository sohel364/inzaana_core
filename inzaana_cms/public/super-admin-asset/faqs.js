/**
 * Created by Sk Asadur Rahman on 9/30/2016.
 */

$('#description').keyup(function () {
    var max = 1000;
    var len = $(this).val().length;
    if (len >= max) {
        $('#charNum').html('<p class="text-red">You have reached the limit</p>');
    } else {
        var char = max - len;
        $('#charNum').html('<p class="text-green">'+char + ' characters left</p>');
    }
});