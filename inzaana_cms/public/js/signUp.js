  
  function CheckEqual(valu1,valu2){
    var res=true;
      if(valu1!==valu2){
        res= false;
    }
      else
     {   res= true;}

 return res;
}


  function validateForm() {

    var isok=true;
  
    var fname = document.forms["formpost"]["fname"].value;
    var email = document.forms["formpost"]["email"].value;
    var confirmEmail = document.forms["formpost"]["checkemail"].value;
    var password = document.forms["formpost"]["password"].value;
    var checkpassword = document.forms["formpost"]["password_confirmation"].value;

    if (fname==null || fname=="" || email == null || email =="" || confirmEmail==null || confirmEmail=="" || password==null || password=="" 
|| checkpassword==null || checkpassword=="") 
    {

        alert("!Wrong");
        isok=false;
    }

    else{   
            isok = false;
            if(password===checkpassword && email===confirmEmail){
                isok=true;
                showModal();
                }
            else{
                isok = false;
                alert("Unhappy!");
	}
        }


}

function showModal(){
    
    $( "form" ).submit(function( event ) {
        event.preventDefault();
    });

     $('#testPopUp').modal('show');

}


$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>');
            }
        }
        init();
    });
});