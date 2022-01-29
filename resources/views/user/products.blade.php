@extends('user.layouts.master')

@section('title')
    {{ $data['title'] }}
@endsection

@section('content')

    <div class="row mt-3">

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card card-blue">
                <div class="card-header">
                    <h3 class="card-title">Product Category</h3>
                </div>
                <div class="card-body" style="text-align: center; color:#fff;">
                    @if(count($data['subcategories']) <= 0)
                            No Product Categories
                        @else

                            @foreach ($data['subcategories'] as $subcat)
                            <li style="
                            display: inline-block;
                            /*border: 1px solid #bbb;*/
                            padding: 5px 10px;
                            margin: 0 5px 5px 0;
                            border-radius: 5px;
                            color: #000;
                            ">
                                <a href="#" class="category_btn" data-category_id='{{ $subcat->id }}' style="color: #fff;">
                                    <img src="{{ $subcat->image == 'no_image.png' ? asset('/images/category/no_image.png') : asset('/storage/category_images/'.$subcat->image) }}" alt="" style=" width: 50px; border-radius:50%; "><br />
                                    {{ $subcat->sub_category_name }}
                                </a>
                            </li>
                            @endforeach

                        @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card card-blue">
                <div class="card-header">
                    <h2 class="card-title">Products</h2>
                </div>
                <div class="card-body" id="card-body">
                    <table id="productTbl" style="font-size: 14px; width:100%;" class="table">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:50px;">TYPE</th>
                                <th style="font-size: 11px; width:300px;">INFORMATION</th>
                                <th style="font-size: 11px; width:30px;">COUNTRY</th>
                                <th style="font-size: 11px; width:15px;">PRICE</th>
                                <th style="font-size: 11px; width:15px; text-align:center;">BUY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['products'] as $product)
                                <tr>
                                    <td>{{ $product->subCategory->sub_category_name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->country }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_script')
    <script>
        $(function(){

            //Count Items in cart
            function countCart()
            {
                var countCartEl = $('#count_cart span');
                        countCartEl.empty();
                        $.ajax({
                        url: '/cart/count/items',
                        method: 'GET',
                        success:(res)=>{
                        `${(res.countCartItems) ? countCartEl.text(res.countCartItems) : countCartEl.text(0) }`;
                    }
                });
            }

            var productsTbl = $('#productTbl').DataTable({

                columns:[
                    {data: 'sub_category.sub_category_name'},
                    {data: 'name'},
                    {data: 'country'},
                    {data: 'price'},
                    {
                        data: 'id',
                        render: function(id){
                            return `
                            <a href="#" style="font-size:10px; margin:0!important;" class="btn btn-xs btn-primary buy_btn" data-product_id="${id}">
                                <i class="fa fa-shopping-cart"></i>
                                <div class="spinner-border spinner-border-sm text-danger" style="display:none;"></div>
                                Buy Now
                            </a>
                            `;
                        }
                    }
                ]
            });

            //Fetch all products by subcategory id
            $('a.category_btn').on('click', function(e){
                e.preventDefault();
                //$('#card-body tbody').empty();
                var subcategory_id = e.currentTarget.dataset['category_id'];
                $.ajax({
                    url: `/products/subcategory/${subcategory_id}`,
                    method: 'GET',
                    success:(res)=>{
                        productsTbl.clear();
                        productsTbl.rows.add(res.data);
                        productsTbl.draw();
                    }
                });
            });


            //Add To Cart
            $(document).on('click', '.buy_btn', function(e){
                e.preventDefault();
                var product_id = e.currentTarget.dataset['product_id'];
                var elementParent = e.currentTarget;
                $.ajax({
                    url: `/cart/add-to-cart`,
                    method: 'POST',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id' : `${product_id}`
                    },
                    success:(res)=>{
                        //console.log(res);

                        if(res.errors)
                        {
                            swal.fire({
                                title: 'Error!',
                                text: `${res.errors}`,
                                icon: 'error'
                            });
                        }

                        if(res.wallet)
                        {
                            swal.fire({
                                title: 'Error!',
                                text: `${res.wallet}`,
                                icon: 'error'
                            });
                        }

                        if(res.success)
                        {
                            countCart();
                            elementParent.parentNode.parentNode.remove();
                        }
                    }
                });
            });

        });
    </script>
@endsection
