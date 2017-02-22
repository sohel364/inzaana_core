/**
 * Created by sk on 2/4/2017.
 */

/* Sk Asadur Rahman Script*/

var myProduct = {
    baseURI:window.location.pathname,
    URI: null,
    sendGetAjax: function(flushData){
        $.ajax({
            async: true,
            type: 'GET',
            url: myProduct.URI, // you need change it.
            processData: false, // high importance!
            success: function (data) {
                flushData.getResult(data);
            },
            error: function(data){
                alert("Oops!!! Something went wrong.");
            },
            timeout: 10000
        });
    },
    sendPostAjax: function(formData, flushData){
        $.ajax({
            async: true,
            type: 'POST',
            data: formData,
            url: myProduct.URI, // you need change it.
            processData: false, // high importance!
            success: function (data) {
                flushData.getResult(data);
            },
            error: function (data) {
                alert("Oops!!! Something went wrong.");
            },
            timeout: 10000
        });
    }
};

$(document).on('click','.view_detail', function (e) {
    e.preventDefault();
    myProduct.URI = $(this).data('product_url');
    var dataArea = {
        getResult:function(data){
            $('#modal_container').html(data);
            $('#modal_open').modal('show');
        }
    };
    myProduct.sendGetAjax(dataArea);
});

$(document).on('click','#product_del_btn',function(e){
    e.preventDefault();
    var c = confirm("Are you sure want to delete this product?");
    if(c) {
        var id = $(this).data('product_id')
        var product_id = "#product_" + id;
        myProduct.URI = $(this).data('url');
        var formData = $(this).serialize();
        var dataArea = {
            getResult: function (data) {
                if(data['status'] == 1){
                    $(product_id).closest('tr').remove();
                    alert(data['msg']);
                }
            }
        }
       myProduct.sendPostAjax(formData,dataArea);
    }

});

$(document).on('click','#sort_by_click', function (e) {
    e.preventDefault();
    var sort = $(this).attr('data-sort');
    var order = $(this).attr('data-order');
    var url = window.location.pathname;
    /* alert(url);
     $.ajax({
     async: true,
     type: 'GET',
     url: url+'?sort='+sort+'&order='+order, // you need change it.
     processData: false, // high importance!
     success: function (data) {
     //$('#coupon-area').html(data);
     alert(data);
     },
     error: function(data){

     },
     timeout: 10000
     });*/

});

function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah-'+id).attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

for(i=1;i<5;i++){
    $("#imgInp-"+i).change(function(){
        var preview_id = $(this).data('image_id');
        readURL(this, preview_id);
    });
}


function removeLocalImage(e){
    var imageSource = '#'+$(e).data('image_src');
    var fileInput = '#'+$(e).data('file_input');
    $(imageSource).attr('src','/images/products/default_product.jpg');
    $(fileInput).val("");

}

function removeServerImage(e){
    var imageSource = '#'+$(e).data('image_src');
    var fileInput = '#'+$(e).data('file_input');
    var imageTitle = $(e).data('image_title');
    var imagePATH = $(e).data('image_url');
    var product_id = $(e).data('product_id');
    if(imageTitle != null){
        myProduct.URI = myProduct.baseURI+'/'+imageTitle+'/image-delete?imagePath='+imagePATH;
        var dataArea = {
            getResult: function (data) {
                if(data['status']){
                    $(imageSource).attr('src','/images/products/default_product.jpg');
                    $(fileInput).val("");
                    $(e).attr("onclick", "removeLocalImage(this)");
                }
            }
        };
        myProduct.sendGetAjax(dataArea);
    }
}

$(document).on('click','#select_all',function(e){
    var table= $(e.target).closest('table');
    $('td input:checkbox',table).prop('checked',this.checked);
    if($("#select_all").is(':checked'))
        $('#delete_all').html('<button class="btn btn-danger" id="product_delete_all">Delete All</button>');
    else
        $('#delete_all').html('');
});

$(document).on('click','#product_delete_all',function(){
    var productID = $(".product_table tbody>tr input:checkbox:checked").map(function(e){
        if($(this).val() != 'on')
            return $(this).val();
    }).get();
    myProduct.URI = myProduct.baseURI+'/'+productID+'/product-bulk-delete';
    var dataArea = {
        getResult: function (data) {
            if(data){
                window.location.reload();
            }
        }
    }
    myProduct.sendPostAjax(productID,dataArea);
});

$( "#search_box" ).autocomplete( "instance" );

$( "#search_box" ).autocomplete({
    source: function( request, response ) {
        var search_item = request.term;
        myProduct.URI = myProduct.baseURI+'/'+search_item+'/search-product';
        var dataArea = {
            getResult: function (data) {
                if(isEmpty(data)){
                    response(["No results found"]);
                }else{
                    response(data);
                }
            }
        };
        myProduct.sendGetAjax(dataArea);
    },
    minLength: 2,
    select: function( event, ui ) {
        var single_product = ui.item.value;
        myProduct.URI = myProduct.baseURI+'/'+single_product+'/search-single-product';
        var dataArea = {
            getResult: function (data) {
                $('#load_table_dom').html(data);
            }
        };
        myProduct.sendGetAjax(dataArea);
    }
});

$(document).on('click','#search_by_button_click',function(e){
    searchAllProduct();
});

$('#search_box').keyup(function(e){
    if(e.keyCode == 13)
    {
        searchAllProduct();
    }
});

$('#search_box').keyup(function(e){
    var serach_val = $('#search_box').val();
    if(serach_val !== ''){
        return true;
    }else{
        myProduct.URI = myProduct.baseURI;
        var dataArea = {
            getResult: function (data) {
                $('#load_table_dom').html(data);
            }
        };
        myProduct.sendGetAjax(dataArea);
    }
});

function searchAllProduct(){
    var search_item = $('#search_box').val();
    myProduct.URI = myProduct.baseURI+'/'+search_item+'/search-all-product';
    if(search_item !== ''){
        var dataArea = {
            getResult: function (data) {
                $('#load_table_dom').html(data);
            }
        };
        myProduct.sendGetAjax(dataArea);
    }else{
        alert("Please input search string.");
    }
}
$(document).on('click','.parentPagDiv > .pagination > li > a', function(e){
    e.preventDefault();
    myProduct.URI = $(this).attr('href');
    var dataArea = {
        getResult: function (data) {
            $('#load_table_dom').html(data);
        }
    };
    myProduct.sendGetAjax(dataArea);
});