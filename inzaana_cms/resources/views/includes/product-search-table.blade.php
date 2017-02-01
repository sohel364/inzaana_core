
<div class="boxed-header">
    <h5>Results on Inzaana.com &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<b>1</b> to <b>{{ count($productsBySearch) > 0 ? $productsBySearch->count() : 0 }}</b> of <b>{{ count($productsBySearch) > 0 ? $productsBySearch->total() : 0 }}</b> results.</h5>
</div>
<div class="box-body no-padding">
    <table id="parent" class="table table-hover">
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        @if(isset($productsBySearch))
            @foreach($productsBySearch as $productFromSearch)
                <tr>
                    <td id="photo">
                        <a  data-toggle="modal" 
                            data-product_url="{{ route('user::products.quick.view', [$productFromSearch]) }}"
                            data-target="#_view_detail_{{ $productFromSearch->id }}">
                            <img src="{{ $productFromSearch->thumbnail() }}" height="50px" width="80px"/></a>
                    </td>

                    <td id="product">{{ $productFromSearch->title }}</td>
                    <td id="category">{{ $productFromSearch->marketProduct()->category->name or 'Uncategorized' }}</td>
                    <td id="sellyours">
                        <form method="POST">
                            
                            {!! csrf_field() !!}

                            @if($productFromSearch->isMine())
                                @include('includes.single-product-actions', [ 'product' => $productFromSearch ])
                            @else
                                <input formaction="{{ route('user::products.sell-yours', [$productFromSearch]) }}" class="btn btn-info btn-flat btn-sm" type="submit" value="Sell yours">                                                                                                   
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
    <div class="col-sm-12 noPadMar text-center">

        {{ count($productsBySearch) > 0 ? $productsBySearch->appends([ 'search_box' => $search_terms ])->links() : '' }}

    </div>
</div>