@extends('user.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row mt-5">
        <div class="col-md-3 col-sm-12">
            <div class="card card-blue sg-shadow">
                <div class="card-header">
                    <h2 class="card-title">Bitcoin (BTC) Payment</h2>
                </div>
                <div class="card-body" style="text-align: center;">
                    <!-- <h4>We Accept BTC <i class="badge badge-success badge-pill">Online</i></h4> -->
                    <img src="{{asset('images/btc.png')}}" class="sg-shadow img-circle img-thumbnail mb-3" width="75px" height="75px" alt="">

                    <form method="POST" action="{{ route('deposit') }}">
                        @csrf
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #f5bc36; color:#fff;">$</div>
                        </div>
                        <input type="text" name="deposit" class="form-control" placeholder="Deposit Amount">
                            <div class="input-group-append">
                                <input type="submit" value="Deposit" style="background-color: #f5bc36;  color:#fff; border:none;">
                            </div>
                    </div>
                     @if($errors->has('deposit'))
                            <span style="font-size: 14px; font-weight:bold; color:#F5365C;">{{ $errors->first('deposit') }}</span>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-sm-12">

            <div class="card card-blue sg-shadow">
                <div class="card-header">
                    <h2 class="card-title">History of Payments</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-condensed" id="paymentHistoryDataTable">
                        <thead>
                            <tr>
                                <th>TxnID</th>
                                <th style='width:100px;'>USD</th>
                                <th>BTC</th>
                                <th style="width: 200px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment_history as $payment)
                            <tr>
                                <td>{{ $payment->txn_id }}</td>
                                <td>${{ $payment->amount_total_fiat }}</td>
                                <td>{{ $payment->amountf }}</td>
                                <td>
                                    @if($payment->status == 0)
                                    <span class="badge badge-info badge-pill" style="font-size: 12px;">Waiting for funds</span> | 
                                    <a class="btn btn-xs btn-danger" href="{{ $payment->checkout_url }}">
                                    Pay Now!
                                    </a>
                                    @elseif($payment->status >= 100)
                                    <span class="badge badge-success badge-pill" style="font-size: 12px;">Completed</span>
                                    @elseif($payment->status <= -1)
                                    <span class="badge badge-danger badge-pill" style="font-size: 12px;">Canceled</span>
                                    @elseif($payment->status == 1)
                                    <span class="badge badge-danger badge-pill" style="font-size: 12px;">Wait for confirmation</span>
                                    @endif
                                    
                                </td>
                                
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
            $('#paymentHistoryDataTable').DataTable({});
        });
    </script>
@endsection
