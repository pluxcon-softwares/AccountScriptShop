@extends('user.layouts.master')

@section('title')
    @if (isset($title))
        {{$title}}
    @endif
@endsection

@section('content')

<div class="row mt-5">
    <div class="col-md-12 mr-auto ml-auto">
      <div class="card card-blue">
        <div class="card-header">
          <h2 class="card-title">Shopping Cart</h2>
        </div>
        <div class="card-body">
             <!-- title row -->
             <div class="row">
                <div class="  invoice-header">
                  <h3>
                      <i class="fa fa-shopping-cart"></i> Order Item(s).
                  </h3>
                </div>
                <!-- /.col -->
              </div>

              <!-- Table row -->
              <div class="row">
                  <table class="table" style="padding: 10px;">
                      <thead>
                        <tr>
                          <th>Product Type</th>
                          <th style="width: 59%">Product</th>
                          <th>Subtotal</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody id="orderItemsTbody">
                        @if ($cartItems->count() > 0)
                            @foreach ($cartItems as $item)
                                <tr>
                                <td>{{ $item->product_type }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="subtotal">${{ $item->price }}</td>
                                <td><a class="delete_item btn btn-sm btn-danger" data-delete_item="{{$item->id}}"><i class="fas fa-trash"></i></a></td>
                              </tr>
                            @endforeach
                        @endif

                      </tbody>
                    </table>
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-md-7">
                  <p class="lead">Payment Methods:</p>
                  <img src="{{asset('images/bitcoin.png')}}" width="20" height="20" alt="Bitcon(BTC)"> Bitcoin(BTC)
                  <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                      <strong>NOTE:</strong>Your product(s) can be processed when you have enough funds in your wallet
                      to cover full payment of products in cart.
                      Make sure you have funded your wallet -OR- topup before payment. Thank You!
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-md-5">
                  <p class="lead">Amount Due: {{ date('Y-m-d') }}</p>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th style="width:50%">Total:</th>
                          <td id="total_price">${{ $totalPrice ? $totalPrice : '0.00' }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <p>
                      <button class="btn btn-success fa-pull-right" id="makePayment"><i class="fa fa-credit-card"></i> Make Payment</button>
                  </p>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extra_script')
    <script>
        $(function(){

            // Disable MakePayment button if Cart is empty
            function disablePaymentButton()
            {
                $.ajax({
                    url: `/cart/check-cart`,
                    method: 'GET',
                    success: function(res){
                        if(res.empty_cart === true){
                            $('#makePayment').attr('disabled', true);
                        }else{
                            $('#makePayment').attr('disabled', false);
                        }
                    }
                });
            }
            disablePaymentButton();

            function removeItemInCart()
            {
                $("#orderItemsTbody").on('click', '.delete_item', function(e){
                    e.preventDefault();
                    var orderItemID = e.currentTarget.dataset.delete_item;
                    $.ajax({
                        url: '/cart/delete-cart-item/'+orderItemID,
                        method: 'GET',
                        success: function(res){
                            if(res.status == true)
                            {
                                $('#makePayment').attr('disabled', true);
                            }

                            if(res.status === 200){
                                window.location.reload();
                                $('#makePayment').attr('disabled', false);
                            }
                        }
                    });
                });
            }
            removeItemInCart();

            function makePayment()
            {
                $("#makePayment").on('click', function(){
                    $.ajax({
                        url: '/cart/process-order',
                        method: 'GET',
                        success: function(res){
                            if(res.empty_cart){
                                swal.fire({
                                    title: "Shopping Cart",
                                    text: res.empty_cart,
                                    icon: "error"
                                }).then((result)=>{
                                  window.location.replace('/home');
                                })

                            }

                            if(res.error){
                                swal.fire({
                                title: "Shopping Cart",
                                text: res.error,
                                icon: "error"
                                })
                            }

                            if(res.success){
                                swal.fire({
                                title: "Purchase Order",
                                text: res.success,
                                icon: "success"
                                }).then((result)=>{
                                  window.location.replace("/cart/thank-you");
                                });
                            }
                        }
                    });
                });
            }
            makePayment();
        });
    </script>
@endsection
