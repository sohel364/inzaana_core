
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
            minlength: 6,
            maxlength: 6,
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
            minlength: "Your post code must be exact 6 digits long",
            maxlength: "Your post code must be exact 6 digits long"
          }
        }
    });
  }

  function isEmpty(value) {
      return value == "none" || value == "undefined" || value == "";
  }  

  // callbacks & ajax
  function requestForStoreSuggestions(input, onSuccess, onError)
  {
      var routing_url = '/stores/suggest/input/' + input;
      var request = $.ajax({
          type: "GET",
          url: routing_url,
          dataType: 'json',
          statusCode: {
              404: function() {
                  $('#suggestions').html(isEmpty($.trim(input)) ? '' : 'Something went wrong!');
              }
          }
      });
      request.done(onSuccess).fail(onError);
  }

  function onFocusOutRequestForStoreSuggestion(event) {

      var prefix = 'Try :';
      // event.currentTarget.removeClass('hidden');
      $('#suggestions').html(isEmpty(event.currentTarget.value) ? '' : prefix);
      requestForStoreSuggestions($.trim(event.currentTarget.value), 
      function(data) {
          //JSON.stringify(data.store)
          $('#suggestions').html( isEmpty(data.store) ? '' : ($('#suggestions').html() + data.store));
          // $('#suggestions').html($('#suggestions').html() + 'GOT IT!');
      }, function(xhr, textStatus) {
          // $('#suggestions').html('Suggestion not available!');
          // event.currentTarget.addClass('hidden');
      });
  }
