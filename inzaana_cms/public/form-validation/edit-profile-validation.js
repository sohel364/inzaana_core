
  function validateNumber(event) {
      var keycode = event.which;
      if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
          event.preventDefault();
      }
  }
  
  function onReadyEditProfileValidation() {

      // validate signup form on keyup and submit
      $('#edit-profile-form').validate({
          rules: {
            name: "required",
            password: {
              minlength: 6
            },
            password_confirmation: {
              minlength: 6,
              equalTo: "#password"
            },
            email: {
              required: true,
              email: true
            },
            phone_number:  {
              required: true,
              minlength: 11,
              maxlength: 11,
              digits: true
            }
          },
          messages: {
            name: "Please enter your full name",
            password: {
              minlength: "Your password must be at least 6 characters long"
            },
            password_confirmation: {
              minlength: "Your password must be at least 6 characters long",
              equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            phone_number: {
              digits: "Please enter digits",
              required: "Please provide a contact number",
              minlength: "Your phone number must be exact 11 digits long",
              maxlength: "Your phone number must be exact 11 digits long"
            }
          }
      });
  }