
  function onReadyEditStoreValidation() {

      // validate signup form on keyup and submit
      $('#edit-store-form').validate({
          rules: {
            store_name: "required",
            phone_number:  {
              required: true,
              minlength: 11,
              maxlength: 11,
              digits: true
            },
            postcode: {
              minlength: 4,
              maxlength: 4,
              digits: true
            }
          },
          messages: {
            store_name: "Please enter your store name",
            phone_number: {
              required: "Please provide a contact number",
              digits: "Please enter digits",
              minlength: "Your phone number must be exact 11 digits long",
              maxlength: "Your phone number must be exact 11 digits long"
            },
            postcode: {
              digits: "Please enter digits",
              minlength: "Your post code must be exact 4 digits long",
              maxlength: "Your post code must be exact 4 digits long"
            }
          }
      });
    }