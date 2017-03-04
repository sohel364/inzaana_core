jQuery(document).on('click','#add_to_cart',function(){
    var data = {
        cart_item: {
            product_id: $(this).data('pid'),
            title:      $(this).siblings('div').find('#p-title').text(),
            price:      $(this).siblings('div').find('#p-price').text(),
            image_url:  $(this).siblings('img').attr('src')
        }
    };
    $(this).text("Added");
    //$(this).removeAttr('id');
    $(this).attr('id','add_to_cart-inactive');
    var fingerprint = $(this).data('fingerprint');
    $.ajax({
        async: true,
        type: 'GET',
        data: data,
        url: '/showcase/cart/' + fingerprint + '/add', // you need change it.
        processData: true, // high importance!
        success: function (data) {
            $('#add-item').html(data);
        },
        error: function(data){
            alert("Oops!!! Something went wrong.");
        },
        timeout: 10000
    });


});

jQuery(document).on('click','#cart-item-remove-btn',function(e){
    e.preventDefault();
    var define_this = this;
    var pid = $(this).data('pid');
    $.ajax({
        async: true,
        type: 'GET',
        url: $(this).attr('formaction'), // you need change it.
        processData: false, // high importance!
        success: function (data) {
            if(data){
                // $('#cart_items_count').text($('#cart_items_count').text()-1);
                // $(define_this).closest('li').remove();
                $('a[data-pid="'+pid+'"]').attr('id','add_to_cart').text("Add to Cart");
            }

            $('#add-item').html(data);
        },
        error: function(data){
            alert("Oops!!! Something went wrong.");
        },
        timeout: 10000
    });
});
