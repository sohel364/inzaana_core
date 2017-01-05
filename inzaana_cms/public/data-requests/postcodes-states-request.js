
  // definition: element-data-manager-1.0.js

  ElementDataManager.isCompleted = function() { return $('select#state option').length > 0 && $('select#postcode option').length > 0; };
  ElementDataManager.load('INDIA', function(context, data) {
      var options = '';
      var id = '';
      var addressKey = '';
      if(data.context == context[1])
      {
          addressKey = '$address[\'STATE\']';
          id = '#state';
      }
      else if(data.context == context[0])
      {
          addressKey = '$address[\'POSTCODE\']';
          id = '#postcode';
      }
      $.each(data.value, function( index, value ) {
          options += "<option value='" + index + "' {{ " + addressKey + " == '" + index + "' ? ' selected' : ''}} >" + value + "</option>";
      });

      $(id).html(options);
  });