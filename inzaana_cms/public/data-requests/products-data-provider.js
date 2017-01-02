
  ElementDataManager.timeout = 0;
  ElementDataManager.context = [ 'products/import/csv' ];

  ElementDataManager.element = 'js-upload-form';
                
  ElementDataManager.submit( { csv: $('#js-upload-files').val(), store: $('#stores').val() }, function(context, data) {

      alert(data.error);
  });