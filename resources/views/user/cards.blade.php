@extends('user.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 sg-shadow" style="margin: 3% auto; text-align:center; padding:20px 10px 0 10px;">
            <p>
               credit card filter forms
            </p>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <table id="cardsDataTable" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered table-responsive table-striped">
                <thead>
                    <tr>
                        <th style="font-size: 11px;">CARD TYPE</th>
                        <th style="font-size: 11px;">BIN</th>
                        <th style="font-size: 11px;">EXP</th>
                        <th style="font-size: 11px;">HOLDER</th>
                        <th style="font-size: 11px;">COUNTRY</th>
                        <th style="font-size: 11px;">ADDRESS</th>
                        <th style="font-size: 11px;">STATE</th>
                        <th style="font-size: 11px;">CITY</th>
                        <th style="font-size: 11px;">DOB</th>
                        <th style="font-size: 11px;">SSN</th>
                        <th style="font-size: 11px;">ZIP</th>
                        <th style="font-size: 11px;">BASE</th>
                        <th style="font-size: 11px;">PRICE</th>
                        <th style="font-size: 11px;">BUY</th>
                    </tr>
                </thead>
                <tbody id="productsTbody">
                    @foreach ($cards as $card)
                    <tr>
                        <td>{{ $card->card_type }}</td>
                        <td>{{ $card->bin }}</td>
                        <td>{{ $card->exp }}</td>
                        <td>{{ $card->holder }}</td>
                        <td>{{ $card->country }}</td>
                        <td>{{ $card->address }}</td>
                        <td>{{ $card->state }}</td>
                        <td>{{ $card->city }}</td>
                        <td>{{ $card->dob }}</td>
                        <td>{{ $card->ssn }}</td>
                        <td>{{ $card->zip }}</td>
                        <td>{{ $card->base }}</td>
                        <td>{{ $card->price }}</td>
                        <td>
                            <a href="#" style="font-size:10px; margin:0!important;" class="btn btn-xs btn-primary buy_btn" data-card_id="{{$card->id}}"><i class="fa fa-shopping-cart"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('extra_script')
    <script>
        $(function(){
            $("#cardsDataTable").DataTable({});
        });
    </script>
@endsection
