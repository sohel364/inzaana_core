
function onUrlPaste(event) {
    // 3. Set the click event or instant to do the validation
    if (!validateURL($(this).val()))
    {
        $('.embed_video_form_group').addClass("hidden");
        console.log($('.embed_video_form_group').is(":hidden"));
        $(this).next().find("strong").html("Please check your url.");
        return;
    }
    
    $('.embed_video_form_group').removeClass("hidden");

    if( $('#has_embed_video').is(":checked"))
    {
        $(this).next().removeClass("hidden");
    }
    else
    {
        $('#has_embed_video').prop("checked", "checked");
        $(this).next().addClass("hidden");
    }
    console.log($('.embed_video_form_group').is(":hidden"));
}

function validateURL(url) {
    console.log(url);

    var urlregex = new RegExp(
          "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
    if(urlregex.test(url)){
      return true;
    } else {
        return false;
    }
}
//https://www.youtube.com/watch?v=LbGyCedMtbY