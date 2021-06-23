@extends('admin.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12 col-sm-12">
            <div class="card card-blue">
                <div class="card-header">
                    <h2 class="card-title">{{ $title }}</h2>
                </div>
                <div class="card-body">
                    <table id="ordersDataTable" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:100px;">ORDER NUMBER</th>
                                <th style="font-size: 11px; width:200px;">USERNAME</th>
                                <th style="font-size: 11px; width:150px;">AMOUNT(USD)</th>
                                <th style="font-size: 11px; width:150px;">AMOUNT(BTC)</th>
                                <th style="font-size: 11px; width:150px;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTbody">
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
        function fetchAllOrders()
        {
            $("#ordersDataTable").DataTable({
                ajax:{
                    url: '/admin/order/all',
                    method: 'GET',
                    dataSrc: 'orders'
                },
                columns:[
                    {data: "code"},
                    {data: "username"},
                    {
                        data: "local_amount",
                        render: function(local_amount){
                            return `$${local_amount}`;
                        }
                    },
                    {data: "bitcoin_amount"},
                    {
                        data: "state",
                        render: function(state){
                            var status;
                            if(state === "charge:confirmed"){
                                status = "<span class='badge badge-success badge-pill' style='font-size:14px;'>Confirmed</span>";
                            }
                            if(state === "charge:pending"){
                                status = "<span class='badge badge-info badge-pill' style='font-size:14px;'>Pending</span>";
                            }
                            if(state === "charge:failed"){
                                status = "<span class='badge badge-danger badge-pill' style='font-size:14px;'>Failed</span>";
                            }
                            if(state === "charge:delayed"){
                                status = "<span class='badge badge-info badge-pill' style='font-size:14px;'>Delayed</span>";
                            }
                            if(state === "created"){
                                status = "<span class='badge badge-info badge-pill' style='font-size:14px;'>Pending</span>";
                            }

                            return `${status}`;
                        }
                    }
                ],
                "scrollY": true
            });
        }
        fetchAllOrders()


        function fetchOrderProfit()
        {
            $.ajax({
                url: '/admin/order/profit',
                method: 'GET',
                success: function(res){
                    if(res.profits){
                        $("div#total_profit").text(`$${res.profits ? res.profits.toFixed(2) : '0.00'}`);
                    }
                }
            });
        }
        fetchOrderProfit();
    });
</script>

@endsection
