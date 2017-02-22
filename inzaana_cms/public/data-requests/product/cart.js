jQuery(document).on('click','#add_to_cart',function(){
    var data = {
        cart_item: {
            product_id:    $(this).data('pid'),
            title:      $(this).siblings('div').find('#p-title').text(),
            price:      $(this).siblings('div').find('#p-price').text(),
            image_url:  $(this).siblings('img').attr('src')
        }
    };
    $(this).text("Added");
    $(this).removeAttr('id');
    $.ajax({
        async: true,
        type: 'GET',
        data: data,
        url: window.location.pathname+'/cart/add', // you need change it.
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
    $.ajax({
        async: true,
        type: 'GET',
        url: $(this).attr('formaction'), // you need change it.
        processData: false, // high importance!
        success: function (data) {
            if(data){
                $('#cart_items_count').text($('#cart_items_count').text()-1);
                $(define_this).closest('li').remove();
            }
        },
        error: function(data){
            alert("Oops!!! Something went wrong.");
        },
        timeout: 10000
    });
});
