@extends('admin.layouts.master')

@section('title')
    {{ $data['title'] }}
@endsection

@section('content')

<div class="row">

    <div class="col-12">
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">

            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              
                <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab">Transaction Completed</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab">Transaction Pending</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab">Transaction Failed</a>
              </li>
              
            </ul>

          </div>
          <div class="card-body">
              
            <div class="tab-content" id="custom-tabs-one-tabContent">
              
              <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                 <table class="table" id="transaction_completed_tbl">
                     <thead>
                        <tr>
                            <td>OrderID</td>
                            <td>BuyerName</td>
                            <td>BuyerEmail</td>
                            <td>Amount($)</td>
                            <td>Status</td>
                        </tr>
                     </thead>
                     <tbody>
                         @foreach ($data['transaction_completed'] as $tc)
                             <tr>
                                 <td>{{ $tc->order_id }}</td>
                                 <td>{{ $tc->buyer_name }}</td>
                                 <td>{{ $tc->buyer_email }}</td>
                                 <td>{{ $tc->amount_total_fiat }}</td>
                                 <td>{{ $tc->status_text }}</td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
              </div>
              
              <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                 
                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <table class="table" id="transaction_pending_tbl" style="width: 100%">
                        <thead>
                           <tr>
                               <td>OrderID</td>
                               <td>BuyerName</td>
                               <td>BuyerEmail</td>
                               <td>Amount($)</td>
                               <td>Status</td>
                           </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['transaction_pending'] as $tc)
                                <tr>
                                    <td>{{ $tc->order_id }}</td>
                                    <td>{{ $tc->buyer_name }}</td>
                                    <td>{{ $tc->buyer_email }}</td>
                                    <td>{{ $tc->amount_total_fiat }}</td>
                                    <td>{{ $tc->status_text }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                 </div>

              </div>
              
              <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                 
                <table class="table" id="transaction_failed_tbl" style="width: 100%">
                    <thead>
                       <tr>
                           <td>OrderID</td>
                           <td>BuyerName</td>
                           <td>BuyerEmail</td>
                           <td>Amount($)</td>
                           <td>Status</td>
                       </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['transaction_failed'] as $tc)
                            <tr>
                                <td>{{ $tc->order_id }}</td>
                                <td>{{ $tc->buyer_name }}</td>
                                <td>{{ $tc->buyer_email }}</td>
                                <td>{{ $tc->amount_total_fiat }}</td>
                                <td>{{ $tc->status_text }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

              </div>
              
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>

</div>

@endsection



@section('extra_script')

<script>
    $(function(){
        var transaction_completed_tbl = $('#transaction_completed_tbl').DataTable();

        var transaction_pending_tbl = $('#transaction_pending_tbl').DataTable();

        var transaction_failed_tbl = $('#transaction_failed_tbl').DataTable();
    });
</script>

@endsection
